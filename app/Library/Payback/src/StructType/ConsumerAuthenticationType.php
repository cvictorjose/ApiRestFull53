<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for ConsumerAuthenticationType StructType
 * Meta informations extracted from the WSDL
 * - documentation: This data type is used to transfer an authentication request of a interface consumer tothe system
 * @subpackage Structs
 */
class ConsumerAuthenticationType extends AbstractStructBase
{
    /**
     * The Principal
     * Meta informations extracted from the WSDL
     * - documentation: A valid principal of the consumer who wants to access a WebService method. Thisprincipal is unique for the consumer and will be used to identify the consumer uniquely within the system | Type to transfer the string-based value of the
     * Principal that is used for identification or authentication (e.g. a user name, card number etc.).
     * - maxLength: 60
     * - minLength: 1
     * @var string
     */
    public $Principal;
    /**
     * The Credential
     * Meta informations extracted from the WSDL
     * - documentation: Credential of the consumer who wants to access a WebService method. | Type to transfer (possibly encrypted) passwords (or other credentials like e.g. date of birth) needed for authentication.
     * - maxLength: 255
     * - minLength: 1
     * @var string
     */
    public $Credential;
    /**
     * Constructor method for ConsumerAuthenticationType
     * @uses ConsumerAuthenticationType::setPrincipal()
     * @uses ConsumerAuthenticationType::setCredential()
     * @param string $principal
     * @param string $credential
     */
    public function __construct($principal = null, $credential = null)
    {
        $this
            ->setPrincipal($principal)
            ->setCredential($credential);
    }
    /**
     * Get Principal value
     * @return string|null
     */
    public function getPrincipal()
    {
        return $this->Principal;
    }
    /**
     * Set Principal value
     * @param string $principal
     * @return \StructType\ConsumerAuthenticationType
     */
    public function setPrincipal($principal = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($principal) && strlen($principal) > 60) || (is_array($principal) && count($principal) > 60)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 60 element(s) or a scalar of 60 character(s) at most, "%d" length given', is_scalar($principal) ? strlen($principal) : count($principal)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($principal) && strlen($principal) < 1) || (is_array($principal) && count($principal) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($principal) && !is_string($principal)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($principal)), __LINE__);
        }
        $this->Principal = $principal;
        return $this;
    }
    /**
     * Get Credential value
     * @return string|null
     */
    public function getCredential()
    {
        return $this->Credential;
    }
    /**
     * Set Credential value
     * @param string $credential
     * @return \StructType\ConsumerAuthenticationType
     */
    public function setCredential($credential = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($credential) && strlen($credential) > 255) || (is_array($credential) && count($credential) > 255)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 255 element(s) or a scalar of 255 character(s) at most, "%d" length given', is_scalar($credential) ? strlen($credential) : count($credential)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($credential) && strlen($credential) < 1) || (is_array($credential) && count($credential) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($credential) && !is_string($credential)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($credential)), __LINE__);
        }
        $this->Credential = $credential;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\ConsumerAuthenticationType
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
