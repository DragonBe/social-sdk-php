<?php

namespace SocialSdkPhp\Twitter\Account\Settings;

use SocialSdkPhp\Interfaces\DataModel;

class TimeZone implements DataModel
{
    /**
     * @var string The name of the TimeZone
     */
    protected $_name;
    /**
     * @var int The time offset from UTC
     */
    protected $_utcOffset;
    /**
     * @var string The full TimeZone name
     */
    protected $_timeZoneName;

    /**
     * Constructor for this class
     *
     * @param null|array|StdClass $data
     */
    public function __construct($data = null)
    {
        if (null !== $data) {
            $this->populate($data);
        }
    }
    /**
     * @param string $name
     * @return \SocialSdkPhp\Twitter\Account\Settings\TimeZone
     */
    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param string $timeZoneName
     * @return \SocialSdkPhp\Twitter\Account\Settings\TimeZone
     */
    public function setTimeZoneName($timeZoneName)
    {
        $this->_timeZoneName = (string) $timeZoneName;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimeZoneName()
    {
        return $this->_timeZoneName;
    }

    /**
     * @param int $utcOffset
     * @return \SocialSdkPhp\Twitter\Account\Settings\TimeZone
     */
    public function setUtcOffset($utcOffset)
    {
        $this->_utcOffset = (int) $utcOffset;
        return $this;
    }

    /**
     * @return int
     */
    public function getUtcOffset()
    {
        return $this->_utcOffset;
    }

    /**
     * Populates this class with data
     *
     * @param array|StdClass $data
     * @return \SocialSdkPhp\Twitter\Account\Settings\TimeZone
     */
    public function populate($data)
    {
        if (is_array($data)) {
            $data = new \ArrayObject($data, \ArrayObject::ARRAY_AS_PROPS);
        }
        $this->setName($data->name)
            ->setUtcOffset($data->utc_offset)
            ->setTimeZoneName($data->tzinfo_name);
        return $this;
    }

    /**
     * Converts this class to an array
     *
     * @return array
     */
    public function toArray()
    {
        return array (
            'name' => $this->getName(),
            'utc_offset' => $this->getUtcOffset(),
            'tzinfo_name' => $this->getTimeZoneName(),
        );
    }

    /**
     * Converts this class to JSON
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }
}