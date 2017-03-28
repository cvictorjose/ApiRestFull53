<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for ExpiryAnnouncementType StructType
 * Meta informations extracted from the WSDL
 * - documentation: Announcement that a certain amount of points will expire soon.
 * @subpackage Structs
 */
class ExpiryAnnouncementType extends AbstractStructBase
{
    /**
     * The PointsToExpireAmount
     * Meta informations extracted from the WSDL
     * - documentation: The amount of points that will expire soon. | Type for representing amounts of loyalty currency (i.e. points)
     * - fractionDigits: 3
     * - totalDigits: 21
     * @var float
     */
    public $PointsToExpireAmount;
    /**
     * The NextExpiryDate
     * Meta informations extracted from the WSDL
     * - documentation: The expected date of expiration. | Type to describe expiry dates (as dateTime with time zone). | PAYBACK standard date-time-stamps format (incl. time zone information). Represents instances identified by the combination of a date and
     * a time. Its value space is described as a combination of date and time of day in Chapter 5.4 of ISO 8601. Its lexical space is the extended format: [-]CCYY-MM-DDThh:mm:ss[Z|(+|-)hh:mm]
     * - minOccurs: 0
     * @var string
     */
    public $NextExpiryDate;
    /**
     * Constructor method for ExpiryAnnouncementType
     * @uses ExpiryAnnouncementType::setPointsToExpireAmount()
     * @uses ExpiryAnnouncementType::setNextExpiryDate()
     * @param float $pointsToExpireAmount
     * @param string $nextExpiryDate
     */
    public function __construct($pointsToExpireAmount = null, $nextExpiryDate = null)
    {
        $this
            ->setPointsToExpireAmount($pointsToExpireAmount)
            ->setNextExpiryDate($nextExpiryDate);
    }
    /**
     * Get PointsToExpireAmount value
     * @return float|null
     */
    public function getPointsToExpireAmount()
    {
        return $this->PointsToExpireAmount;
    }
    /**
     * Set PointsToExpireAmount value
     * @param float $pointsToExpireAmount
     * @return \StructType\ExpiryAnnouncementType
     */
    public function setPointsToExpireAmount($pointsToExpireAmount = null)
    {
        // validation for constraint: fractionDigits
        if (is_float($pointsToExpireAmount) && strlen(substr($pointsToExpireAmount, strpos($pointsToExpireAmount, '.'))) !== 3) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 3 fraction digits, "%d" given', strlen(substr($pointsToExpireAmount, strpos($pointsToExpireAmount, '.')))), __LINE__);
        }
        // validation for constraint: totalDigits
        if (is_float($pointsToExpireAmount) && strlen(str_replace(array(' ', '.', ',', '-', '+'), '', $pointsToExpireAmount)) !== 21) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 21 digits, "%d" given', strlen(substr($pointsToExpireAmount, strpos($pointsToExpireAmount, '.')))), __LINE__);
        }
        $this->PointsToExpireAmount = $pointsToExpireAmount;
        return $this;
    }
    /**
     * Get NextExpiryDate value
     * @return string|null
     */
    public function getNextExpiryDate()
    {
        return $this->NextExpiryDate;
    }
    /**
     * Set NextExpiryDate value
     * @param string $nextExpiryDate
     * @return \StructType\ExpiryAnnouncementType
     */
    public function setNextExpiryDate($nextExpiryDate = null)
    {
        // validation for constraint: string
        if (!is_null($nextExpiryDate) && !is_string($nextExpiryDate)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($nextExpiryDate)), __LINE__);
        }
        $this->NextExpiryDate = $nextExpiryDate;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\ExpiryAnnouncementType
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
