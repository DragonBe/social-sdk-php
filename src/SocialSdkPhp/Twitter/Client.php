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

    protected $_httpClient;

    protected $_config = array(
        'consumerKey' => 'nCc7KFrOdARUyN991fdRg',
        'consumerSecret' => 'HS8IL5E5rraZ1GDA8WtOFQj0xqakrgNQZKvLvhJTLo',
        'accessToken' => '209461644-LA5vziIetWLOrHfx1gvYUrZDW4UCIcWlsy5TjJfb',
        'accessSecret' => '3SC7p3Ps8FAdWKTRx1cJlpDbQgooDSlEPF7h3A',
    );

    public function accountVerifyCredentials($includeEntities = false, $skipStatus = false)
    {
        $url = self::TWITTER_API_URI . self::TWITTER_ACCOUNT_VERIFY_CREDENTIALS;
//        $params = array ();
//        if (true === $includeEntities) {
//            $params[] = 'include_entities=true';
//        }
//        if (true === $skipStatus) {
//            $params[] = 'skip_status=true';
//        }
//        $url .= '?' . implode('&', $params);

        $httpClient = new HttpClient($url, $this->_config, 'GET');

        $httpClient->getClient()->setConfig(array (
            'proxy_host' => '127.0.0.1',
            'proxy_port' => 8888,
        ));
        $result = $httpClient->request();
        var_dump($result);
    }
}