<?php

namespace SocialSdkPhp\Twitter;

use SocialSdkPhp\HttpClient;
use SocialSdkPhp\Twitter\Account\Result;

/**
 * This is the generic Twitter Client that will be used to consume
 * Twitter's API.
 *
 * @package SocialSdkPhp\Twitter
 */
class Client
{
    const TWITTER_API_URI = 'https://api.twitter.com/1.1';
    const TWITTER_ACCOUNT_VERIFY_CREDENTIALS = '/account/verify_credentials.json';

    /**
     * @var \SocialSdkPhp\HttpClient
     */
    protected $_httpClient;

    /**
     * @var array
     */
    protected $_config;

    public function __construct($config = null, $httpClient = null)
    {
        if (null !== $config) {
            $this->setConfig($config);
        }
        if (null !== $httpClient) {
            $this->setHttpClient($httpClient);
        }
    }

    /**
     * Sets the configuration for this twitter client
     *
     * @param array $config
     * @return \SocialSdkPhp\Twitter\Client
     */
    public function setConfig($config)
    {
        $this->_config = $config;
        return $this;
    }

    /**
     * Retrieves the configuration from this twitter client
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->_config;
    }

    /**
     * Sets the HTTP client to make requests with
     *
     * @param \SocialSdkPHP\HttpClient $httpClient
     * @return \SocialSdkPhp\Twitter\Client
     */
    public function setHttpClient(\SocialSdkPhp\HttpClient $httpClient)
    {
        $this->_httpClient = $httpClient;
        return $this;
    }

    /**
     * Retrieves the HTTP client which makes requests
     *
     * @return \SocialSdkPhp\HttpClient
     */
    public function getHttpClient()
    {
        if (null === $this->_httpClient) {
            $this->setHttpClient(new HttpClient());
        }
        return $this->_httpClient;
    }

    /**
     * Verifies if the account details are still valid or not
     *
     * @param bool $includeEntities
     * @param bool $skipStatus
     * @return bool
     */
    public function accountVerifyCredentials($includeEntities = false, $skipStatus = false)
    {
        $url = self::TWITTER_API_URI . self::TWITTER_ACCOUNT_VERIFY_CREDENTIALS;
        $params = array ();
        if (true === $includeEntities) {
            $params[] = 'include_entities=true';
        }
        if (true === $skipStatus) {
            $params[] = 'skip_status=true';
        }
        $url .= '?' . implode('&', $params);

        $httpClient = $this->getHttpClient();

        $httpClient->setUrl($url)
            ->setConfig($this->getConfig())
            ->setMethod('GET');

        $result = $httpClient->request();
        if (200 !== $result->getStatus()) {
            return false;
        }
        return true;
    }
}