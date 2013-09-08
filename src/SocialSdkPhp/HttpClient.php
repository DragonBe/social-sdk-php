<?php
namespace SocialSdkPhp;


class HttpClient
{
    /**
     * @var string The API url
     */
    protected $_url;
    /**
     * @var \ArrayObject The OAuth configuration
     */
    protected $_config;

    /**
     * @var string The request Method POST or GET
     */
    protected $_method;

    /**
     * @var \HTTP_Request2 The HTTP Client to make connections
     */
    protected $_client;

    public function __construct($url = null, $config = null, $method = 'GET')
    {
        if (null !== $url) {
            $this->setUrl($url);
        }
        if (null !== $config) {
            $this->setConfig($config);
        }
        $this->setMethod($method);
    }

    /**
     * @param array|\ArrayObject $config
     * @return \SocialSdkPhp\HttpClient
     */
    public function setConfig($config)
    {
        if (is_array($config)) {
            $config = new \ArrayObject($config, \ArrayObject::ARRAY_AS_PROPS);
        }
        $this->_config = $config;
        return $this;
    }

    /**
     * @return \ArrayObject
     */
    public function getConfig()
    {
        return $this->_config;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function addConfig($key, $value)
    {
        $this->_config[$key] = $value;
        return $this;
    }

    /**
     * @param string $url
     * @return \SocialSdkPhp\HttpClient
     */
    public function setUrl($url)
    {
        $this->_url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * @param string $method
     * @throw \InvalidArgumentException
     */
    public function setMethod($method)
    {
        $accepted = array ('GET','POST');
        if (!in_array(strtoupper($method), $accepted)) {
            throw new \InvalidArgumentException(
                'Only HTTP GET or POST are allowed'
            );
        }
        $this->_method = strtoupper($method);
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->_method;
    }

    /**
     * @param \HTTP_Request2 $client
     * @return HttpClient
     */
    public function setClient(\HTTP_Request2 $client)
    {
        $this->_client = $client;
        return $this;
    }

    /**
     * @return \HTTP_Request2
     */
    public function getClient()
    {
        if (null === $this->_client) {
            $this->setClient(new \HTTP_Request2());
        }
        return $this->_client;
    }

    /**
     * Make a request and return the response
     *
     * @return string The JSON encoded response
     */
    public function request()
    {
        $header = array($this->_createAuthorizationHeader());

        $this->getClient()->setUrl($this->getUrl());
        $this->getClient()->getMethod($this->getMethod());
        $this->getClient()->setHeader($header);
        $response = $this->getClient()->send();
        $json = $response->getBody();
        return $json;
    }

    /**
     * Creates a required authorization header to send with each
     * request.
     *
     * @return string The Authorization header
     * @link https://dev.twitter.com/docs/auth/authorizing-request
     */
    protected function _createAuthorizationHeader()
    {
        $params = $this->_generateHeaderParams();
        $signKey = $this->_createSignatureKey();
        $signatureBase = $this->_createSignatureBase($params);
        $encodedSignature = $this->_createEncodedSignature($signatureBase, $signKey);
        $params['oauth_signature'] = $encodedSignature;
        ksort($params);
        $attribs = array ();
        foreach ($params as $key => $value) {
            $attribs[] = $key . '="' . rawurlencode($value) . '"';
        }
        $header = 'Authorization: OAuth ' . implode(', ', $attribs);
        return $header;
    }

    /**
     * Generates an array with all parameters used for the request
     *
     * @return array The key/value pairs used to generate the header
     * @link https://dev.twitter.com/docs/auth/authorizing-request
     */
    protected function _generateHeaderParams()
    {
        $header = array (
            'oauth_consumer_key' => $this->getConfig()->consumerKey,
            'oauth_nonce' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
            'oauth_token' => $this->getConfig()->accessToken,
            'oauth_version' => '1.0',
        );
        return $header;
    }

    /**
     * Generates the basis for signing a request
     *
     * @param array $params All parameters used in the request
     * @return string The signature basis
     * @link https://dev.twitter.com/docs/auth/creating-signature
     */
    protected function _createSignatureBase($params)
    {
        $attribs = array ();
        foreach ($params as $key => $value) {
            $attribs[] = $key . '=' . rawurlencode($value);
        }
        $signatureBase = $this->getMethod() . '&';
        $signatureBase .= rawurlencode($this->getUrl()) . '&';
        $signatureBase .= rawurlencode(implode('&', $attribs));
        return $signatureBase;
    }

    /**
     * Creating the signature key to sign the request
     *
     * @return string The signature key
     * @link https://dev.twitter.com/docs/auth/creating-signature
     */
    protected function _createSignatureKey()
    {
        $signKey = rawurlencode($this->getConfig()->consumerSecret)
            . '&' . rawurlencode($this->getConfig()->accessSecret);
        return $signKey;
    }

    /**
     * Create the signature used to sign each request
     *
     * @param string $signatureBase The signature base
     * @param string $signKey The signature key
     * @return string The signature
     * @link https://dev.twitter.com/docs/auth/creating-signature
     */
    protected function _createEncodedSignature($signatureBase, $signKey)
    {
        $signature = base64_encode(
            hash_hmac('sha1', $signatureBase, $signKey, true)
        );
        return $signature;
    }

}