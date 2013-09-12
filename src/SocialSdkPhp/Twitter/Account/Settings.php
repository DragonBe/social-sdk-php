<?php

namespace SocialSdkPhp\Twitter\Account;

use SocialSdkPhp\Interfaces\DataModel;
use SocialSdkPhp\Twitter\Account\Settings\TimeZone;
use SocialSdkPhp\Twitter\Account\Settings\SleepTime;

class Settings implements DataModel
{
    /**
     * @var \SocialSdkPhp\Twitter\Account\Settings\TimeZone Timezone Information
     */
    protected $_timeZone;

    /**
     * @var bool If this account is protected or not
     */
    protected $_protected;

    /**
     * @var string The screen name used by this account
     */
    protected $_screenName;

    /**
     * @var bool If this account needs to always use HTTPS or not
     */
    protected $_alwaysUseHttps;

    /**
     * @var bool If this account is allowed to store info in cookies
     */
    protected $_useCookiePersonalization;

    /**
     * @var \SocialSdkPhp\Twitter\Account\Settings\SleepTime
     */
    protected $_sleepTime;

    /**
     * @var bool If this account allows GEO data to be transmitted
     */
    protected $_geoEnabled;

    /**
     * @var string The preferred language for this account
     */
    protected $_language;

    /**
     * @var bool If this account allows to be found using an email address
     */
    protected $_discoverableByEmail;

    /**
     * @var bool If this account allows to be found using a mobile phone number
     */
    protected $_discoverableByMobilePhone;

    /**
     * @var bool If this account is allowed to display sensitive media
     */
    protected $_displaySensitiveMedia;

    /**
     * Constructor for each DataModel object that allows
     * immediate population of data on construction.
     *
     * @param null|array|\StdClass $data
     */
    public function __construct($data = null)
    {
        if (null !== $data) {
            $this->populate($data);
        }
    }

    /**
     * @param boolean $allwaysUseHttps
     * @return \SocialSdkPhp\Twitter\Account\Settings
     */
    public function setAlwaysUseHttps($allwaysUseHttps)
    {
        $this->_alwaysUseHttps = $allwaysUseHttps;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isAlwaysUseHttps()
    {
        return $this->_alwaysUseHttps;
    }

    /**
     * @param boolean $discoverableByEmail
     * @return \SocialSdkPhp\Twitter\Account\Settings
     */
    public function setDiscoverableByEmail($discoverableByEmail)
    {
        $this->_discoverableByEmail = $discoverableByEmail;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isDiscoverableByEmail()
    {
        return $this->_discoverableByEmail;
    }

    /**
     * @param boolean $discoverableByMobilePhone
     * @return \SocialSdkPhp\Twitter\Account\Settings
     */
    public function setDiscoverableByMobilePhone($discoverableByMobilePhone)
    {
        $this->_discoverableByMobilePhone = $discoverableByMobilePhone;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isDiscoverableByMobilePhone()
    {
        return $this->_discoverableByMobilePhone;
    }

    /**
     * @param boolean $displaySensitiveMedia
     * @return \SocialSdkPhp\Twitter\Account\Settings
     */
    public function setDisplaySensitiveMedia($displaySensitiveMedia)
    {
        $this->_displaySensitiveMedia = $displaySensitiveMedia;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isDisplaySensitiveMedia()
    {
        return $this->_displaySensitiveMedia;
    }

    /**
     * @param boolean $geoEnabled
     * @return \SocialSdkPhp\Twitter\Account\Settings
     */
    public function setGeoEnabled($geoEnabled)
    {
        $this->_geoEnabled = $geoEnabled;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isGeoEnabled()
    {
        return $this->_geoEnabled;
    }

    /**
     * @param string $language
     * @return \SocialSdkPhp\Twitter\Account\Settings
     */
    public function setLanguage($language)
    {
        $this->_language = $language;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->_language;
    }

    /**
     * @param boolean $protected
     * @return \SocialSdkPhp\Twitter\Account\Settings
     */
    public function setProtected($protected)
    {
        $this->_protected = (bool) $protected;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isProtected()
    {
        return $this->_protected;
    }

    /**
     * @param string $screenName
     * @return \SocialSdkPhp\Twitter\Account\Settings
     */
    public function setScreenName($screenName)
    {
        $this->_screenName = $screenName;
        return $this;
    }

    /**
     * @return string
     */
    public function getScreenName()
    {
        return $this->_screenName;
    }

    /**
     * @param \SocialSdkPhp\Twitter\Account\Settings\SleepTime $sleepTime
     * @return \SocialSdkPhp\Twitter\Account\Settings
     */
    public function setSleepTime(SleepTime $sleepTime)
    {
        $this->_sleepTime = $sleepTime;
        return $this;
    }

    /**
     * @return \SocialSdkPhp\Twitter\Account\Settings\SleepTime
     */
    public function getSleepTime()
    {
        if (null === $this->_sleepTime) {
            $this->setSleepTime(new SleepTime());
        }
        return $this->_sleepTime;
    }

    /**
     *
     * @param \SocialSdkPhp\Twitter\Account\Settings\TimeZone $timeZone
     * @return \SocialSdkPhp\Twitter\Account\Settings
     */
    public function setTimeZone(TimeZone $timeZone)
    {
        $this->_timeZone = $timeZone;
        return $this;
    }

    /**
     * @return \SocialSdkPhp\Twitter\Account\Settings\TimeZone
     */
    public function getTimeZone()
    {
        if (null === $this->_timeZone) {
            $this->setTimeZone(new TimeZone());
        }
        return $this->_timeZone;
    }

    /**
     * @param boolean $useCookiePersonalization
     * @return \SocialSdkPhp\Twitter\Account\Settings
     */
    public function setUseCookiePersonalization($useCookiePersonalization)
    {
        $this->_useCookiePersonalization = $useCookiePersonalization;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isUseCookiePersonalization()
    {
        return $this->_useCookiePersonalization;
    }

    /**
     * Populates the data model immediately with a complete
     * series of data, either through an array or through a
     * StdClass object.
     *
     * @param array|\StdClass $data
     * @return \SocialSdkPhp\Twitter\Account\Settings
     */
    public function populate($data)
    {
        if (is_string($data)) {
            $data = json_decode($data);
        }
        if (is_array($data)) {
            $data = new \ArrayObject($data, \ArrayObject::ARRAY_AS_PROPS);
        }
        if (isset ($data->time_zone))
            $this->setTimeZone(new TimeZone($data->time_zone));
        if (isset ($data->protected))
            $this->setProtected($data->protected);
        if (isset ($data->screen_name))
            $this->setScreenName($data->screen_name);
        if (isset ($data->always_use_https))
            $this->setAlwaysUseHttps($data->always_use_https);
        if (isset ($data->use_cookie_personalization))
            $this->setUseCookiePersonalization($data->use_cookie_personalization);
        if (isset ($data->sleep_time))
            $this->setSleepTime(new SleepTime($data->sleep_time));
        if (isset ($data->geo_enabled))
            $this->setGeoEnabled($data->geo_enabled);
        if (isset ($data->language))
            $this->setLanguage($data->language);
        if (isset ($data->discoverable_by_email))
            $this->setDiscoverableByEmail($data->discoverable_by_email);
        if (isset ($data->discoverable_by_mobile_phone))
            $this->setDiscoverableByMobilePhone($data->discoverable_by_mobile_phone);
        if (isset ($data->display_sensitive_media))
            $this->setDisplaySensitiveMedia($data->display_sensitive_media);
        return $this;
    }

    /**
     * Converts this data model into an array
     *
     * @return array
     */
    public function toArray()
    {
        return array (
            'time_zone' => $this->getTimeZone()->toArray(),
            'protected' => $this->isProtected(),
            'screen_name' => $this->getScreenName(),
            'always_use_https' => $this->isAlwaysUseHttps(),
            'use_cookie_personalization' => $this->isUseCookiePersonalization(),
            'sleep_time' => $this->getSleepTime()->toArray(),
            'geo_enabled' => $this->isGeoEnabled(),
            'language' => $this->getLanguage(),
            'discoverable_by_email' => $this->isDiscoverableByEmail(),
            'discoverable_by_mobile_phone' => $this->isDiscoverableByMobilePhone(),
            'display_sensitive_media' => $this->isDisplaySensitiveMedia(),
        );
    }

    /**
     * Converts this data model into JSON data
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function toPost()
    {
        $postData = array ();
        $postData['lang'] = null !== $this->getLanguage() ? $this->getLanguage() : 'en';
        if (null !== $this->getSleepTime() && $this->getSleepTime()->isEnabled()) {
            $postData['sleep_time_enabled'] = $this->getSleepTime()->isEnabled();
            $postData['start_sleep_time'] = $this->getSleepTime()->getStartTime()->format('H');
            $postData['end_sleep_time'] = $this->getSleepTime()->getEndTime()->format('H');
        }
        if (null !== $this->getTimeZone() && null !== $this->getTimeZone()->getTimeZoneName()) {
            $postData['time_zone'] = $this->getTimeZone()->getTimeZoneName();
        }
        return $postData;
    }
}