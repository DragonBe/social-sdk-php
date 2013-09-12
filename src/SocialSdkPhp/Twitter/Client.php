<?php

namespace SocialSdkPhp\Twitter;

use SocialSdkPhp\HttpClient;
use SocialSdkPhp\Twitter\Account\Result;
use SocialSdkPhp\Twitter\Account\Settings;
use SocialSdkPhp\Twitter\Client\Account;

/**
 * This is the generic Twitter Client that will be used to consume
 * Twitter's API.
 *
 * @package SocialSdkPhp\Twitter
 */
class Client
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    const TWITTER_API_URI = 'https://api.twitter.com/1.1';


    /**
     * @var \SocialSdkPhp\HttpClient
     */
    protected $_httpClient;

    /**
     * @var array
     */
    protected $_config;

    /**
     * @var \SocialSdkPhp\Twitter\Client\Account;
     */
    protected $_account;

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
     * @param \SocialSdkPhp\Twitter\Client\Account $account
     */
    public function setAccount($account)
    {
        $this->_account = $account;
    }

    /**
     * @return \SocialSdkPhp\Twitter\Client\Account
     */
    public function getAccount()
    {
        if (null === $this->_account) {
            $this->setAccount(new Account($this->getConfig(), $this->getHttpClient()));
        }
        return $this->_account;
    }
}