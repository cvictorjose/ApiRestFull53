<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for ExpiryStatisticsType StructType
 * Meta informations extracted from the WSDL
 * - documentation: Statistics of points that already in expired in the past.
 * @subpackage Structs
 */
class ExpiryStatisticsType extends AbstractStructBase
{
    /**
     * The ExpiredPointsAmount
     * Meta informations extracted from the WSDL
     * - documentation: The number of points that already expired since a certain point in the past. | Type for representing amounts of loyalty currency (i.e. points)
     * - fractionDigits: 3
     * - totalDigits: 21
     * @var float
     */
    public $ExpiredPointsAmount;
    /**
     * The ExpiredSinceDate
     * Meta informations extracted from the WSDL
     * - documentation: The begin of the expiration interval that was taken into account. | Type to describe expiry dates (as dateTime with time zone). | PAYBACK standard date-time-stamps format (incl. time zone information). Represents instances identified
     * by the combination of a date and a time. Its value space is described as a combination of date and time of day in Chapter 5.4 of ISO 8601. Its lexical space is the extended format: [-]CCYY-MM-DDThh:mm:ss[Z|(+|-)hh:mm]
     * - minOccurs: 0
     * @var string
     */
    public $ExpiredSinceDate;
    /**
     * Constructor method for ExpiryStatisticsType
     * @uses ExpiryStatisticsType::setExpiredPointsAmount()
     * @uses ExpiryStatisticsType::setExpiredSinceDate()
     * @param float $expiredPointsAmount
     * @param string $expiredSinceDate
     */
    public function __construct($expiredPointsAmount = null, $expiredSinceDate = null)
    {
        $this
            ->setExpiredPointsAmount($expiredPointsAmount)
            ->setExpiredSinceDate($expiredSinceDate);
    }
    /**
     * Get ExpiredPointsAmount value
     * @return float|null
     */
    public function getExpiredPointsAmount()
    {
        return $this->ExpiredPointsAmount;
    }
    /**
     * Set ExpiredPointsAmount value
     * @param float $expiredPointsAmount
     * @return \StructType\ExpiryStatisticsType
     */
    public function setExpiredPointsAmount($expiredPointsAmount = null)
    {
        // validation for constraint: fractionDigits
        if (is_float($expiredPointsAmount) && strlen(substr($expiredPointsAmount, strpos($expiredPointsAmount, '.'))) !== 3) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 3 fraction digits, "%d" given', strlen(substr($expiredPointsAmount, strpos($expiredPointsAmount, '.')))), __LINE__);
        }
        // validation for constraint: totalDigits
        if (is_float($expiredPointsAmount) && strlen(str_replace(array(' ', '.', ',', '-', '+'), '', $expiredPointsAmount)) !== 21) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 21 digits, "%d" given', strlen(substr($expiredPointsAmount, strpos($expiredPointsAmount, '.')))), __LINE__);
        }
        $this->ExpiredPointsAmount = $expiredPointsAmount;
        return $this;
    }
    /**
     * Get ExpiredSinceDate value
     * @return string|null
     */
    public function getExpiredSinceDate()
    {
        return $this->ExpiredSinceDate;
    }
    /**
     * Set ExpiredSinceDate value
     * @param string $expiredSinceDate
     * @return \StructType\ExpiryStatisticsType
     */
    public function setExpiredSinceDate($expiredSinceDate = null)
    {
        // validation for constraint: string
        if (!is_null($expiredSinceDate) && !is_string($expiredSinceDate)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($expiredSinceDate)), __LINE__);
        }
        $this->ExpiredSinceDate = $expiredSinceDate;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\ExpiryStatisticsType
     */
    public static function __set_state(array $array)
    {
        return parent::__set_state($array);
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
