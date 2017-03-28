<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for MemberIdentificationType StructType
 * Meta informations extracted from the WSDL
 * - documentation: Alias identify a member within the PAYBACK program. Alias type defines the classification and derived from this the usage of an alias.
 * @subpackage Structs
 */
class MemberIdentificationType extends AbstractStructBase
{
    /**
     * The Alias
     * Meta informations extracted from the WSDL
     * - documentation: Alias identify a member within the PAYBACK program. | Type to transfer the string-based value of the Principal that is used for identification or authentication (e.g. a user name, card number etc.).
     * - maxLength: 60
     * - minLength: 1
     * @var string
     */
    public $Alias;
    /**
     * The AliasType
     * Meta informations extracted from the WSDL
     * - documentation: Required: Alias type defines the classification and derived from this the usage of an alias.
     * @var string
     */
    public $AliasType;
    /**
     * Constructor method for MemberIdentificationType
     * @uses MemberIdentificationType::setAlias()
     * @uses MemberIdentificationType::setAliasType()
     * @param string $alias
     * @param string $aliasType
     */
    public function __construct($alias = null, $aliasType = null)
    {
        $this
            ->setAlias($alias)
            ->setAliasType($aliasType);
    }
    /**
     * Get Alias value
     * @return string|null
     */
    public function getAlias()
    {
        return $this->Alias;
    }
    /**
     * Set Alias value
     * @param string $alias
     * @return \StructType\MemberIdentificationType
     */
    public function setAlias($alias = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($alias) && strlen($alias) > 60) || (is_array($alias) && count($alias) > 60)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 60 element(s) or a scalar of 60 character(s) at most, "%d" length given', is_scalar($alias) ? strlen($alias) : count($alias)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($alias) && strlen($alias) < 1) || (is_array($alias) && count($alias) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($alias) && !is_string($alias)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($alias)), __LINE__);
        }
        $this->Alias = $alias;
        return $this;
    }
    /**
     * Get AliasType value
     * @return string|null
     */
    public function getAliasType()
    {
        return $this->AliasType;
    }
    /**
     * Set AliasType value
     * @uses \EnumType\PrincipalVariantType::valueIsValid()
     * @uses \EnumType\PrincipalVariantType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $aliasType
     * @return \StructType\MemberIdentificationType
     */
    public function setAliasType($aliasType = null)
    {
        // validation for constraint: enumeration
        if (!\EnumType\PrincipalVariantType::valueIsValid($aliasType)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $aliasType, implode(', ', \EnumType\PrincipalVariantType::getValidValues())), __LINE__);
        }
        $this->AliasType = $aliasType;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\MemberIdentificationType
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
