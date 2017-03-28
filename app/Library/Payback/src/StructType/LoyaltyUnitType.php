<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for LoyaltyUnitType StructType
 * Meta informations extracted from the WSDL
 * - documentation: Amount of loyalty currency together with its unit of measurement.
 * @subpackage Structs
 */
class LoyaltyUnitType extends AbstractStructBase
{
    /**
     * The LoyaltyAmount
     * Meta informations extracted from the WSDL
     * - documentation: Type for representing amounts of loyalty currency (i.e. points)
     * - fractionDigits: 3
     * - totalDigits: 21
     * @var float
     */
    public $LoyaltyAmount;
    /**
     * Constructor method for LoyaltyUnitType
     * @uses LoyaltyUnitType::setLoyaltyAmount()
     * @param float $loyaltyAmount
     */
    public function __construct($loyaltyAmount = null)
    {
        $this
            ->setLoyaltyAmount($loyaltyAmount);
    }
    /**
     * Get LoyaltyAmount value
     * @return float|null
     */
    public function getLoyaltyAmount()
    {
        return $this->LoyaltyAmount;
    }
    /**
     * Set LoyaltyAmount value
     * @param float $loyaltyAmount
     * @return \StructType\LoyaltyUnitType
     */
    public function setLoyaltyAmount($loyaltyAmount = null)
    {
        // validation for constraint: fractionDigits
        if (is_float($loyaltyAmount) && strlen(substr($loyaltyAmount, strpos($loyaltyAmount, '.'))) !== 3) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 3 fraction digits, "%d" given', strlen(substr($loyaltyAmount, strpos($loyaltyAmount, '.')))), __LINE__);
        }
        // validation for constraint: totalDigits
        if (is_float($loyaltyAmount) && strlen(str_replace(array(' ', '.', ',', '-', '+'), '', $loyaltyAmount)) !== 21) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 21 digits, "%d" given', strlen(substr($loyaltyAmount, strpos($loyaltyAmount, '.')))), __LINE__);
        }
        $this->LoyaltyAmount = $loyaltyAmount;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\LoyaltyUnitType
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
