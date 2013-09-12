<?php

namespace SocialSdkPhp\Twitter\Client;

use SocialSdkPhp\HttpClient;
use SocialSdkPhp\Twitter\Client;
use SocialSdkPhp\Twitter\Account\Settings;

class Account
{
    const TWITTER_ACCOUNT_VERIFY_CREDENTIALS = '/account/verify_credentials.json';
    const TWITTER_ACCOUNT_SETTINGS = '/account/settings.json';

    /**
     * @var \SocialSdkPhp\HttpClient
     */
    protected $_httpClient;

    /**
     * @var array
     */
    protected $_config;

    /**
     * Constructor for this class
     *
     * @param $config
     * @param HttpClient $httpClient
     */
    public function __construct($config, HttpClient $httpClient)
    {
        $this->setHttpClient($httpClient)
            ->setConfig($config);
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
        $url = Client::TWITTER_API_URI . self::TWITTER_ACCOUNT_VERIFY_CREDENTIALS;
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
            ->setMethod(Client::METHOD_GET);

        $result = $httpClient->request();
        if (200 !== $result->getStatus()) {
            return false;
        }
        return true;
    }

    public function getAccountSettings()
    {
        $url = Client::TWITTER_API_URI . self::TWITTER_ACCOUNT_SETTINGS;

        $httpClient = $this->getHttpClient();
        $httpClient->setUrl($url)
            ->setConfig($this->getConfig())
            ->setMethod(Client::METHOD_GET);

        $result = $httpClient->request();

        $settings = new Settings($result->getBody());
        return $settings;
    }

    public function updateAccountSettings(Settings $settings)
    {
        $url = Client::TWITTER_API_URI . self::TWITTER_ACCOUNT_SETTINGS;
        $httpClient = $this->getHttpClient();
        $httpClient->setUrl($url)
            ->setConfig($this->getConfig())
            ->setMethod(Client::METHOD_POST)
            ->setData($settings->toPost());
        $result = $httpClient->request();
        $settings = new Settings($result->getBody());
        return $settings;
    }
}