<?php

namespace SocialSdkPhp\Twitter;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test verifying user credentials
     *
     * @link https://dev.twitter.com/docs/api/1.1/get/account/verify_credentials
     */
    public function testClientCanVerifyCredentials()
    {
        $client = new Client();
        $result = $client->accountVerifyCredentials(false, false);

        $this->assertInstanceOf('\SocialSdkPhp\Twitter\Account\Result', $result,
            'The result is not a valid Result object');

        $this->assertSame(200, $result->getResponse()->getStatus(),
            $result->getResponse()->getReasonPhrase() . ': ' .
            $result->getResponse()->getEffectiveUrl());

        var_dump($result);
    }
}