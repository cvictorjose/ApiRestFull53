<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for AuthorisedRequest StructType
 * Meta informations extracted from the WSDL
 * - documentation: This is the base type for all web service requests. Its only element is a data type that is used for partner authentication and subsequent authorisation. Concrete web service requests are supposed to extend this type by appending
 * their own elements.
 * @subpackage Structs
 */
class AuthorisedRequest extends AbstractStructBase
{
    /**
     * The ConsumerIdentification
     * Meta informations extracted from the WSDL
     * - documentation: Data used to identify and authenticate the consumer that has submitted the request and provide additional details on the consumer.
     * @var \StructType\ConsumerIdentificationType
     */
    public $ConsumerIdentification;
    /**
     * Constructor method for AuthorisedRequest
     * @uses AuthorisedRequest::setConsumerIdentification()
     * @param \StructType\ConsumerIdentificationType $consumerIdentification
     */
    public function __construct(\StructType\ConsumerIdentificationType $consumerIdentification = null)
    {
        $this
            ->setConsumerIdentification($consumerIdentification);
    }
    /**
     * Get ConsumerIdentification value
     * @return \StructType\ConsumerIdentificationType|null
     */
    public function getConsumerIdentification()
    {
        return $this->ConsumerIdentification;
    }
    /**
     * Set ConsumerIdentification value
     * @param \StructType\ConsumerIdentificationType $consumerIdentification
     * @return \StructType\AuthorisedRequest
     */
    public function setConsumerIdentification(\StructType\ConsumerIdentificationType $consumerIdentification = null)
    {
        $this->ConsumerIdentification = $consumerIdentification;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\AuthorisedRequest
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
