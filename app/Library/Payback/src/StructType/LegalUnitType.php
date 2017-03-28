<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for LegalUnitType StructType
 * Meta informations extracted from the WSDL
 * - documentation: Amount of legal currency together with its unit of measurement.
 * @subpackage Structs
 */
class LegalUnitType extends AbstractStructBase
{
    /**
     * The LegalAmount
     * Meta informations extracted from the WSDL
     * - documentation: Type for representing amounts of legal currency
     * - fractionDigits: 3
     * - totalDigits: 21
     * @var float
     */
    public $LegalAmount;
    /**
     * Constructor method for LegalUnitType
     * @uses LegalUnitType::setLegalAmount()
     * @param float $legalAmount
     */
    public function __construct($legalAmount = null)
    {
        $this
            ->setLegalAmount($legalAmount);
    }
    /**
     * Get LegalAmount value
     * @return float|null
     */
    public function getLegalAmount()
    {
        return $this->LegalAmount;
    }
    /**
     * Set LegalAmount value
     * @param float $legalAmount
     * @return \StructType\LegalUnitType
     */
    public function setLegalAmount($legalAmount = null)
    {
        // validation for constraint: fractionDigits
        if (is_float($legalAmount) && strlen(substr($legalAmount, strpos($legalAmount, '.'))) !== 3) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 3 fraction digits, "%d" given', strlen(substr($legalAmount, strpos($legalAmount, '.')))), __LINE__);
        }
        // validation for constraint: totalDigits
        if (is_float($legalAmount) && strlen(str_replace(array(' ', '.', ',', '-', '+'), '', $legalAmount)) !== 21) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 21 digits, "%d" given', strlen(substr($legalAmount, strpos($legalAmount, '.')))), __LINE__);
        }
        $this->LegalAmount = $legalAmount;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\LegalUnitType
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
