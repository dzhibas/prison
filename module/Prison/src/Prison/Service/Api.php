<?php
namespace Prison\Service;

use Prison\Entity\ProjectKey;
use Prison\Exception\ApiException;
use Prison\Exception\InvalidTimestampException;
use Prison\Model;
use Zend\Log\Logger;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Parameters;

class Api implements ServiceLocatorAwareInterface
{
    protected $service;
    /** @var  \Prison\Model\ApiAuth */
    protected $auth;
    protected $data;

    public function __construct()
    {
    }

    /**
     * @param mixed $auth
     */
    public function setAuth(Model\ApiAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        if (is_array($data)) {
            $this->data = $data;
            return;
        }

        // if its not json try to decompress
        if (substr($data, 0, 1) !== "{")
        {
            try {
                $data = base64_decode($data);
                $data = gzuncompress($data);
            } catch (\Exception $e) {}
        }

        $data = json_decode($data, true);
        if ($data === null)
        {
            /** @var Logger $log */
            $log = $this->getServiceLocator()->get('Log\Prison');
            $log->crit($this->auth . " " . $this->json_last_error_msg());
            $this->data = array();
        } else {
            $this->data = $data;
        }
    }

    public function json_last_error_msg()
    {
        switch (json_last_error()) {
            default:
                return;
            case JSON_ERROR_DEPTH:
                $error = 'Maximum stack depth exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Underflow or the modes mismatch';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Unexpected control character found';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error, malformed JSON';
                break;
            case JSON_ERROR_UTF8:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
        }
        return $error;
    }

    /**
     * @throws ApiException
     * validating incomming data
     */
    public function validateData()
    {
        /** @var Logger $log */
        $log = $this->getServiceLocator()->get('Log\Prison');

        $data = $this->getData();
        if (empty($data)) throw new ApiException("no data provided");

        // message

        if (!array_key_exists('message', $data)) {
            $data['message'] = '<no message value>';
        } else if (!is_string($data['message'])) {
            throw new ApiException("invalid message");
        } else if (strlen($data['message']) > MAX_MESSAGE_LENGTH) {
            // log it
            $log->info("truncating message cause it was too long %d", array(strlen($data['message'])));
            $data['message'] = substr($data['message'], 0, MAX_MESSAGE_LENGTH);
        }

        // culprit

        if (array_key_exists('culprit', $data) && strlen($data['culprit']) > MAX_CULPRIT_LENGTH) {
            $log->info("truncating culprit cause it was too long: %d", array(strlen($data['culprit'])));
            $data['culprit'] = substr($data['culprit'], 0, MAX_CULPRIT_LENGTH);
        }

        // event_id

        if (!array_key_exists('event_id', $data)) {
            $data['event_id'] = ProjectKey::generateKey();
        }

        if (strlen($data['event_id']) > MAX_EVENT_ID_LENGTH) {
            // generate new one
            $log->info("Discarded provided event_id value cause max chars %d", array(strlen($data['event_id'])));
            $data['event_id'] =  ProjectKey::generateKey();
        }

        // timestamp

        if (array_key_exists('timestamp', $data)) {
            try {
                $data['timestamp'] = $this->processDataTimestamp($data['timestamp']);
            } catch (InvalidTimestampException $e) {
                $log->info("Discarded invalid value for timestamp: %s", array($data['timestamp']));
                unset($data['timestamp']);
            }
        }

        // modules

        if (array_key_exists('modules', $data) && !is_array($data['modules'])) {
            $log->info("Discarded invalid modules");
            unset($data['modules']);
        }

        // extra

        if (array_key_exists('extra', $data)
            && $data['extra'] !== null
            && !is_array($data['extra'])) {
            $log->info("Discarded extra field");
            unset($data['extra']);
        }

        // tags

        if (array_key_exists('tags', $data) && !is_array($data['tags'])) {
            $log->info("Discared tags");
            unet($data['tags']);
        }

        // ensure every tag max length

        if (array_key_exists('tags', $data)) {
            $newTags = array();
            foreach($data['tags'] as $tagKey => $tagValue) {
                if (mb_strlen($tagKey) <= MAX_TAG_KEY_LENGTH
                    && mb_strlen($tagValue) <= MAX_TAG_VALUE_LENGTH) {
                    $newTags[$tagKey] = $tagValue;
                } else {
                    $log->info("Discarded tag because of length constrains: %s", array($tagKey));
                }
            }
            $data['tags'] = $newTags;
        }

        // check if all keys in data is known

        $dataKeys = array_keys($data);
        $config = $this->getServiceLocator()->get('config');
        $interfaces = new Parameters($config['prison']['interface_aliases']);

        foreach($dataKeys as $key) {
            if (in_array($key, $config['prison']['reserved_data_fields']))
                continue;

            if (empty($data[$key])) {
                $log->info('Removed empty interface %s', array($key));
                unset($data[$key]);
            }

            // try to map to interface
            $iface_path = $interfaces->get($key, $key);
            if (strpos($iface_path, '.') === false) {
                $log->info("Unknown interface discovered. Skipping this %s", array($iface_path));
                unset($data[$key]);
            }

            // check if interface is in allowed interface list

            if (!in_array($iface_path, $config['prison']['allowed_interfaces'])) {
                $log->info("Intefrace '%s' is not in allowed interfaces list. Discarding it",array($iface_path));
                unset($data[$key]);
            }
        }

        // log level

        $logLevel = array_key_exists('level', $data) ? $data['level'] : DEFAULT_LOG_LEVEL;

        if (is_string($logLevel) && is_numeric($logLevel)) {
            // reverse to const id's
            $reversLogLevels = array_flip($config['prison']['log_levels']);
            $data['level'] = $reversLogLevels[$logLevel];
        }

        return $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->service = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->service;
    }

    /**
     * for given various types of timestamp returns \DateTime
     *
     * @param $timestamp
     * @throws \Prison\Exception\InvalidTimestampException
     * @return \DateTime
     */
    protected function processDataTimestamp($timestamp)
    {
        if ($timestamp instanceof \DateTime) {
            return $timestamp;
        }

        $dt = new \DateTime();
        if (is_numeric($timestamp)) {
            $dt->setTimestamp($timestamp);
        }

        if (is_string($timestamp)) {
            $dt = new \DateTime($timestamp);
        }

        $notFarFuture = new \DateTime('now');
        $notFarFuture->modify('+1 minute');
        if ($dt->getTimestamp() > $notFarFuture->getTimestamp()) {
            throw new InvalidTimestampException();
        }

        return $dt;
    }
}