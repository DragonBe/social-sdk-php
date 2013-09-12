<?php

namespace SocialSdkPhp\Twitter;

use SocialSdkPhp\HttpClient;
use SocialSdkPhp\Twitter\Account\Settings;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    protected $_config  = array(
        'consumerKey' => 'me2bhXb8kJnH6',
        'consumerSecret' => 'd69e7f56a71d42e1d08a6e24e2345a84f467e945',
        'accessToken' => '505593412-IFuSt1lL7h1nKTh1SiSVaL1dY0uRwR0n9',
        'accessSecret' => '45e3dc3574faeb41eec294d1a8213c1b50b42910',
    );
    /**
     * Test verifying user credentials
     *
     * @link https://dev.twitter.com/docs/api/1.1/get/account/verify_credentials
     */
    public function testClientCanVerifyCorrectCredentials()
    {
        $rawResponse = file_get_contents(__DIR__ . '/_files/accountVerifyWithoutParams.txt');
        $mock = new \HTTP_Request2_Adapter_Mock();
        $mock->addResponse($rawResponse);

        $client = new Client($this->_config);
        $client->getHttpClient()->getClient()->setAdapter($mock);
        $result = $client->getAccount()->accountVerifyCredentials();

        $this->assertTrue($result);
    }

    public function testClientCannotVerifyWithWrongKeys()
    {
        $rawResponse = file_get_contents(__DIR__ . '/_files/accountVerifyWithBadCredentials.txt');
        $mock = new \HTTP_Request2_Adapter_Mock();
        $mock->addResponse($rawResponse);

        $client = new Client($this->_config);
        $client->getHttpClient()->getClient()->setAdapter($mock);

        $config = $client->getConfig();
        $config['consumerKey'] = 'blabla';
        $client->setConfig($config);
        $result = $client->getAccount()->accountVerifyCredentials();

        $this->assertFalse($result);
    }

    public function testClientCannotVerifyWhenExceedingRequestRateLimit()
    {
        $rawResponse = file_get_contents(__DIR__ . '/_files/accountVerifyExceedRequestLimit.txt');
        $mock = new \HTTP_Request2_Adapter_Mock();
        $mock->addResponse($rawResponse);

        $client = new Client($this->_config);
        $client->getHttpClient()->getClient()->setAdapter($mock);

        $result = $client->getAccount()->accountVerifyCredentials();

        $this->assertFalse($result);
    }

    public function testClientCanRetrieveAccountSettings()
    {
        $rawResponse = file_get_contents(__DIR__ . '/_files/accountDefaultSettings.txt');
        $mock = new \HTTP_Request2_Adapter_Mock();
        $mock->addResponse($rawResponse);

        $client = new Client($this->_config);
        $client->getHttpClient()->getClient()->setAdapter($mock);

        $result = $client->getAccount()->getAccountSettings();

        $this->assertJsonStringEqualsJsonFile(
            __DIR__ . '/_files/accountSettingsBeforeChange.json',
            $result->toJson(),
            'Received JSON data does not match expected JSON data'
        );
        return $result;
    }

    /**
     * @depends testClientCanRetrieveAccountSettings
     */
    public function testClientCanPostAccountSettingsChanges($settings)
    {
        $rawResponse = file_get_contents(__DIR__ . '/_files/accountSettingsAfterUpdate.txt');

        $mock = new \HTTP_Request2_Adapter_Mock();
        $mock->addResponse($rawResponse);

        $this->assertInstanceOf('\SocialSdkPhp\Twitter\Account\Settings', $settings);

        $settings->setLanguage('nl');
        $client = new Client($this->_config);
        $client->getHttpClient()->getClient()->setAdapter($mock);

        $result = $client->getAccount()->updateAccountSettings($settings);

        $expected = new Settings(
            json_decode(file_get_contents(__DIR__ . '/_files/accountSettingsAfterUpdate.json'))
        );
        $this->assertEquals(
            $expected,
            $result,
            'Received JSON data does not match expected JSON data'
        );
    }
}