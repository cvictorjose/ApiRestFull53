<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for PartnerContextType StructType
 * Meta informations extracted from the WSDL
 * - documentation: This type allows to transfer a description of the partnerorganization and the partner system that participated in the PAYBACK program.Hierarchy to follow is: Partner --> BusinessUnit --> Branch
 * @subpackage Structs
 */
class PartnerContextType extends AbstractStructBase
{
    /**
     * The PartnerShortName
     * Meta informations extracted from the WSDL
     * - documentation: Short name that identifies the partner organization. | A human readable, string-based identifier to name organizations in external interfaces.
     * - maxLength: 10
     * - minLength: 1
     * @var string
     */
    public $PartnerShortName;
    /**
     * The BusinessUnitShortName
     * Meta informations extracted from the WSDL
     * - documentation: Short name that identifies the partner's business unit. | A human readable, string-based identifier to name organizations in external interfaces.
     * - minOccurs: 0
     * - maxLength: 10
     * - minLength: 1
     * @var string
     */
    public $BusinessUnitShortName;
    /**
     * The BranchShortName
     * Meta informations extracted from the WSDL
     * - documentation: Short name that identifies the partner's branch. | A human readable, string-based identifier to name organizations in external interfaces.
     * - minOccurs: 0
     * - maxLength: 10
     * - minLength: 1
     * @var string
     */
    public $BranchShortName;
    /**
     * Constructor method for PartnerContextType
     * @uses PartnerContextType::setPartnerShortName()
     * @uses PartnerContextType::setBusinessUnitShortName()
     * @uses PartnerContextType::setBranchShortName()
     * @param string $partnerShortName
     * @param string $businessUnitShortName
     * @param string $branchShortName
     */
    public function __construct($partnerShortName = null, $businessUnitShortName = null, $branchShortName = null)
    {
        $this
            ->setPartnerShortName($partnerShortName)
            ->setBusinessUnitShortName($businessUnitShortName)
            ->setBranchShortName($branchShortName);
    }
    /**
     * Get PartnerShortName value
     * @return string|null
     */
    public function getPartnerShortName()
    {
        return $this->PartnerShortName;
    }
    /**
     * Set PartnerShortName value
     * @param string $partnerShortName
     * @return \StructType\PartnerContextType
     */
    public function setPartnerShortName($partnerShortName = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($partnerShortName) && strlen($partnerShortName) > 10) || (is_array($partnerShortName) && count($partnerShortName) > 10)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 10 element(s) or a scalar of 10 character(s) at most, "%d" length given', is_scalar($partnerShortName) ? strlen($partnerShortName) : count($partnerShortName)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($partnerShortName) && strlen($partnerShortName) < 1) || (is_array($partnerShortName) && count($partnerShortName) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($partnerShortName) && !is_string($partnerShortName)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($partnerShortName)), __LINE__);
        }
        $this->PartnerShortName = $partnerShortName;
        return $this;
    }
    /**
     * Get BusinessUnitShortName value
     * @return string|null
     */
    public function getBusinessUnitShortName()
    {
        return $this->BusinessUnitShortName;
    }
    /**
     * Set BusinessUnitShortName value
     * @param string $businessUnitShortName
     * @return \StructType\PartnerContextType
     */
    public function setBusinessUnitShortName($businessUnitShortName = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($businessUnitShortName) && strlen($businessUnitShortName) > 10) || (is_array($businessUnitShortName) && count($businessUnitShortName) > 10)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 10 element(s) or a scalar of 10 character(s) at most, "%d" length given', is_scalar($businessUnitShortName) ? strlen($businessUnitShortName) : count($businessUnitShortName)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($businessUnitShortName) && strlen($businessUnitShortName) < 1) || (is_array($businessUnitShortName) && count($businessUnitShortName) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($businessUnitShortName) && !is_string($businessUnitShortName)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($businessUnitShortName)), __LINE__);
        }
        $this->BusinessUnitShortName = $businessUnitShortName;
        return $this;
    }
    /**
     * Get BranchShortName value
     * @return string|null
     */
    public function getBranchShortName()
    {
        return $this->BranchShortName;
    }
    /**
     * Set BranchShortName value
     * @param string $branchShortName
     * @return \StructType\PartnerContextType
     */
    public function setBranchShortName($branchShortName = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($branchShortName) && strlen($branchShortName) > 10) || (is_array($branchShortName) && count($branchShortName) > 10)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 10 element(s) or a scalar of 10 character(s) at most, "%d" length given', is_scalar($branchShortName) ? strlen($branchShortName) : count($branchShortName)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($branchShortName) && strlen($branchShortName) < 1) || (is_array($branchShortName) && count($branchShortName) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($branchShortName) && !is_string($branchShortName)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($branchShortName)), __LINE__);
        }
        $this->BranchShortName = $branchShortName;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\PartnerContextType
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
