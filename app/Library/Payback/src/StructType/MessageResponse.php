<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for MessageResponse StructType
 * Meta informations extracted from the WSDL
 * - documentation: Standard response base type with fault message object.
 * @subpackage Structs
 */
class MessageResponse extends AbstractStructBase
{
    /**
     * The FaultMessage
     * @var \StructType\FaultDescriptorType
     */
    public $FaultMessage;
    /**
     * Constructor method for MessageResponse
     * @uses MessageResponse::setFaultMessage()
     * @param \StructType\FaultDescriptorType $faultMessage
     */
    public function __construct(\StructType\FaultDescriptorType $faultMessage = null)
    {
        $this
            ->setFaultMessage($faultMessage);
    }
    /**
     * Get FaultMessage value
     * @return \StructType\FaultDescriptorType|null
     */
    public function getFaultMessage()
    {
        return $this->FaultMessage;
    }
    /**
     * Set FaultMessage value
     * @param \StructType\FaultDescriptorType $faultMessage
     * @return \StructType\MessageResponse
     */
    public function setFaultMessage(\StructType\FaultDescriptorType $faultMessage = null)
    {
        $this->FaultMessage = $faultMessage;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\MessageResponse
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
