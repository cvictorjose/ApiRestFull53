<?php

namespace EnumType;

/**
 * This class stands for CommunicationChannelType EnumType
 * Meta informations extracted from the WSDL
 * - documentation: This type describes the medium used by the customer to interact with PAYBACK.
 * @subpackage Enumerations
 */
class CommunicationChannelType
{
    /**
     * Constant for value '4'
     * @return string '4'
     */
    const VALUE_4 = '4';
    /**
     * Constant for value '15'
     * @return string '15'
     */
    const VALUE_15 = '15';
    /**
     * Return true if value is allowed
     * @uses self::getValidValues()
     * @param mixed $value value
     * @return bool true|false
     */
    public static function valueIsValid($value)
    {
        return ($value === null) || in_array($value, self::getValidValues(), true);
    }
    /**
     * Return allowed values
     * @uses self::VALUE_4
     * @uses self::VALUE_15
     * @return string[]
     */
    public static function getValidValues()
    {
        return array(
            self::VALUE_4,
            self::VALUE_15,
        );
    }
    /**
     * Method returning the class name
     * @return string __CLASS__
     */
    public function __toString()
    {
        return __CLASS__;
    }
}
