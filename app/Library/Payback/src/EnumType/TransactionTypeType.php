<?php

namespace EnumType;

/**
 * This class stands for TransactionTypeType EnumType
 * Meta informations extracted from the WSDL
 * - documentation: This type describes the characteristic of a transaction in more detail.
 * @subpackage Enumerations
 */
class TransactionTypeType
{
    /**
     * Constant for value '100'
     * @return string '100'
     */
    const VALUE_100 = '100';
    /**
     * Constant for value '101'
     * @return string '101'
     */
    const VALUE_101 = '101';
    /**
     * Constant for value '102'
     * @return string '102'
     */
    const VALUE_102 = '102';
    /**
     * Constant for value '120'
     * @return string '120'
     */
    const VALUE_120 = '120';
    /**
     * Constant for value '121'
     * @return string '121'
     */
    const VALUE_121 = '121';
    /**
     * Constant for value '122'
     * @return string '122'
     */
    const VALUE_122 = '122';
    /**
     * Constant for value '130'
     * @return string '130'
     */
    const VALUE_130 = '130';
    /**
     * Constant for value '131'
     * @return string '131'
     */
    const VALUE_131 = '131';
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
     * @uses self::VALUE_100
     * @uses self::VALUE_101
     * @uses self::VALUE_102
     * @uses self::VALUE_120
     * @uses self::VALUE_121
     * @uses self::VALUE_122
     * @uses self::VALUE_130
     * @uses self::VALUE_131
     * @return string[]
     */
    public static function getValidValues()
    {
        return array(
            self::VALUE_100,
            self::VALUE_101,
            self::VALUE_102,
            self::VALUE_120,
            self::VALUE_121,
            self::VALUE_122,
            self::VALUE_130,
            self::VALUE_131,
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
