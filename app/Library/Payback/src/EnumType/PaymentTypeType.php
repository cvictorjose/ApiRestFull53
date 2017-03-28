<?php

namespace EnumType;

/**
 * This class stands for PaymentTypeType EnumType
 * Meta informations extracted from the WSDL
 * - documentation: This type describes different methods of payment for legal values.1 - cash2 - credit card3 - debit card4 - voucher5 - fleet card6 - cheque7 - Loyalty currency8 - Collect on Delivery9 - Online payment10 - Food Stamp / EBT99 - others
 * @subpackage Enumerations
 */
class PaymentTypeType
{
    /**
     * Constant for value '1'
     * @return string '1'
     */
    const VALUE_1 = '1';
    /**
     * Constant for value '2'
     * @return string '2'
     */
    const VALUE_2 = '2';
    /**
     * Constant for value '3'
     * @return string '3'
     */
    const VALUE_3 = '3';
    /**
     * Constant for value '4'
     * @return string '4'
     */
    const VALUE_4 = '4';
    /**
     * Constant for value '5'
     * @return string '5'
     */
    const VALUE_5 = '5';
    /**
     * Constant for value '6'
     * @return string '6'
     */
    const VALUE_6 = '6';
    /**
     * Constant for value '7'
     * @return string '7'
     */
    const VALUE_7 = '7';
    /**
     * Constant for value '8'
     * @return string '8'
     */
    const VALUE_8 = '8';
    /**
     * Constant for value '9'
     * @return string '9'
     */
    const VALUE_9 = '9';
    /**
     * Constant for value '10'
     * @return string '10'
     */
    const VALUE_10 = '10';
    /**
     * Constant for value '99'
     * @return string '99'
     */
    const VALUE_99 = '99';
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
     * @uses self::VALUE_1
     * @uses self::VALUE_2
     * @uses self::VALUE_3
     * @uses self::VALUE_4
     * @uses self::VALUE_5
     * @uses self::VALUE_6
     * @uses self::VALUE_7
     * @uses self::VALUE_8
     * @uses self::VALUE_9
     * @uses self::VALUE_10
     * @uses self::VALUE_99
     * @return string[]
     */
    public static function getValidValues()
    {
        return array(
            self::VALUE_1,
            self::VALUE_2,
            self::VALUE_3,
            self::VALUE_4,
            self::VALUE_5,
            self::VALUE_6,
            self::VALUE_7,
            self::VALUE_8,
            self::VALUE_9,
            self::VALUE_10,
            self::VALUE_99,
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
