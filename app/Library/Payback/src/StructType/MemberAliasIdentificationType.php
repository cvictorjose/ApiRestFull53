<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for MemberAliasIdentificationType StructType
 * Meta informations extracted from the WSDL
 * - documentation: This data type is used to transfer member identification data to the system. It contains a Principal (and an optional PrincipalVariant) which is automatically mapped to system internal alias identifiers.
 * @subpackage Structs
 */
class MemberAliasIdentificationType extends AbstractStructBase
{
    /**
     * The Identification
     * @var \StructType\MemberIdentificationType
     */
    public $Identification;
    /**
     * Constructor method for MemberAliasIdentificationType
     * @uses MemberAliasIdentificationType::setIdentification()
     * @param \StructType\MemberIdentificationType $identification
     */
    public function __construct(\StructType\MemberIdentificationType $identification = null)
    {
        $this
            ->setIdentification($identification);
    }
    /**
     * Get Identification value
     * @return \StructType\MemberIdentificationType|null
     */
    public function getIdentification()
    {
        return $this->Identification;
    }
    /**
     * Set Identification value
     * @param \StructType\MemberIdentificationType $identification
     * @return \StructType\MemberAliasIdentificationType
     */
    public function setIdentification(\StructType\MemberIdentificationType $identification = null)
    {
        $this->Identification = $identification;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\MemberAliasIdentificationType
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
