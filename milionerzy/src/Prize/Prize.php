<?php

namespace Sda\Millionaires\Prize;

/**
 * Class Prize
 * @package Sda\Millionaires\Prize
 */
class Prize implements \JsonSerializable {
    private $value = '';

    private $isGuranteed;

    private $isActual;
    
    
    
    public function __construct($value, $isGuranteed = false, $isActual = false) {
        $this->value = $value;
        $this->isGuranteed = $isGuranteed;
        $this->isActual = $isActual;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return boolean
     */
    public function isIsGuranteed()
    {
        return $this->isGuranteed;
    }

    /**
     * @return boolean
     */
    public function isIsActual()
    {
        return $this->isActual;
    }


    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return [
            'value' => $this->value,
            'isGuranteed' => $this->isGuranteed,
            'isActual' => $this->isActual
        ];
    }
}