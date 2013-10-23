<?php
namespace Prison\Filter;

use Zend\Filter\FilterInterface;

class Slugify implements FilterInterface
{

    protected $_separator = '-';

    protected $_lowercase = true;

    protected $_maxlength = null;

    /**
     * @return string The separator
     */
    public function getSeparator()
    {
        return $this->_separator;
    }

    /**
     * @param string $separator
     * @return string
     */
    public function setSeparator($separator)
    {
        $this->_separator = $separator;

        return $this;
    }

    /**
     * @return bool True if the string must be converted to lowercase
     */
    public function getLowercase()
    {
        return $this->_lowercase;
    }

    /**
     * @param $lowercase
     * @return bool
     */
    public function setLowercase($lowercase)
    {
        $this->_lowercase = (bool) $lowercase;

        return true;
    }

    /**
     * @return int The max length of the slug
     */
    public function getMaxlength()
    {
        return $this->_maxlength;
    }

    /**
     * @param $maxlength
     * @return $this
     */
    public function setMaxlength($maxlength)
    {
        if (is_null($maxlength)) {
            $this->_maxlength = null;
        } else {
            $this->_maxlength = (int) $maxlength;
        }

        return $this;
    }

    public function __construct($options = array())
    {
        if (array_key_exists('separator', $options)) {
            $this->setSeparator($options['separator']);
        }

        if (array_key_exists('lowercase', $options)) {
            $this->setLowercase($options['lowercase']);
        }

        if (array_key_exists('maxlength', $options)) {
            $this->setMaxlength($options['maxlength']);
        }
    }

    public function filter($value)
    {
        $value = preg_replace('/[^\\pL\d]+/u', $this->getSeparator(), $value);
        $value = @iconv('UTF-8', 'US-ASCII//TRANSLIT', $value); // transliterate, silently
        $value = preg_replace('/[^'.$this->getSeparator().'\w]+/', '', $value);

        if (null !== $this->getMaxlength()) {
            $value = substr($value, 0, $this->getMaxlength());
        }
        $value = trim($value, $this->getSeparator());

        if ($this->getLowercase()) {
            $value = strtolower($value);
        }

        if (empty($value)) {
            $value = null; // should we return null or an empty string?
        }

        return $value;
    }
}