<?php
namespace Prison\Library;

use Zend\Http\Request;

class ApiAuth
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function extractAuthVars()
    {
        $sentryKeys = array();
        if (substr($this->request->getHeader('HTTP_X_SENTRY_AUTH', ''), 0, 6) == "Sentry") {
            return $this->parseHeader($this->request->getHeader('HTTP_X_SENTRY_AUTH'));
        } else if (substr($this->request->getHeader('HTTP_AUTHORIZATION', ''), 0, 6) == "Sentry") {
            return $this->parseHeader($this->request->getHeader('HTTP_AUTHORIZATION'));
        } else {
            foreach ($this->request->getQuery() as $qKey => $qVal) {
                if (substr($qKey, 0, 7) == "sentry_") {
                    $sentryKeys[$qKey] = $qVal;
                }
            }
        }
        return $sentryKeys;
    }

    public function parseHeader($headerValue)
    {
        //  return dict(map(lambda x: x.strip().split('='), header.split(' ', 1)[1].split(',')))
        // @TODO check what raven-php in submiting as header and parse its value
        return "";
    }
}