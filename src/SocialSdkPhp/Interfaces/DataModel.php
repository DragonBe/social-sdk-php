<?php

namespace SocialSdkPhp\Interfaces;

interface DataModel
{
    /**
     * Constructor for each DataModel object that allows
     * immediate population of data on construction.
     *
     * @param null|array|\StdClass $data
     */
    public function __construct($data = null);

    /**
     * Populates the data model immediately with a complete
     * series of data, either through an array or through a
     * StdClass object.
     *
     * @param array|\StdClass $data
     * @return \SocialSdkPhp\Interfaces\DataModel
     */
    public function populate($data);

    /**
     * Converts this data model into an array
     *
     * @return array
     */
    public function toArray();

    /**
     * Converts this data model into JSON data
     *
     * @return string
     */
    public function toJson();
}