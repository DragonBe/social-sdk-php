<?php

namespace SocialSdkPhp\Twitter\Account\Settings;

use SocialSdkPhp\Interfaces\DataModel;

class SleepTime implements DataModel
{
    /**
     * @var bool If this feature is enabled
     */
    protected $_enabled;
    /**
     * @var \DateTime The time this feature ends
     */
    protected $_endTime;
    /**
     * @var \DateTime The time this feature starts
     */
    protected $_startTime;

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
     * @param boolean $enabled
     * @return \SocialSdkPhp\Twitter\Account\Settings\SleepTime
     */
    public function setEnabled($enabled)
    {
        $this->_enabled = (bool) $enabled;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->_enabled;
    }

    /**
     * @param \DateTime $endTime
     * @return \SocialSdkPhp\Twitter\Account\Settings\SleepTime
     */
    public function setEndTime($endTime)
    {
        if (!$endTime instanceof \DateTime) {
            $endTime = new \DateTime($endTime);
        }
        $this->_endTime = $endTime;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->_endTime;
    }

    /**
     * @param \DateTime $startTime
     * @return \SocialSdkPhp\Twitter\Account\Settings\SleepTime
     */
    public function setStartTime($startTime)
    {
        if (!$startTime instanceof \DateTime) {
            $startTime = new \DateTime();
        }
        $this->_startTime = $startTime;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->_startTime;
    }

    /**
     * @param array|StdClass $data
     * @return \SocialSdkPhp\Twitter\Account\Settings\SleepTime
     */
    public function populate($data)
    {
        if (is_array($data)) {
            $data = new \ArrayObject($data, \ArrayObject::ARRAY_AS_PROPS);
        }
        $this->setEnabled($data->enabled);
        if (null !== $data->end_time) {
            $this->setEndTime($data->end_time);
        }
        if (null !== $data->start_time) {
            $this->setStartTime($data->start_time);
        }
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
            'enabled' => $this->isEnabled(),
            'end_time' => null === $this->getEndTime() ? null : $this->getEndTime()->format('H'),
            'start_time' => null === $this->getStartTime() ? null : $this->getStartTime()->format('H'),
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
}