<?php

namespace SocialSdkPhp\Twitter\Account;

class Result
{
    /**
     * @var \HTTP_Request2_Response
     */
    protected $_response;

    /**
     * @param null|\HTTP_Request2_Response $response
     */
    public function __construct($response = null)
    {
        if (null !== $response) {
            $this->setResponse($response);
        }
    }
    /**
     * @param \HTTP_Request2_Response $response
     * @return $this
     */
    public function setResponse(\HTTP_Request2_Response $response)
    {
        $this->_response = $response;
        return $this;
    }

    /**
     * @return \HTTP_Request2_Response
     */
    public function getResponse()
    {
        return $this->_response;
    }

}