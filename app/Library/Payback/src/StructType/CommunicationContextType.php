<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for CommunicationContextType StructType
 * @subpackage Structs
 */
class CommunicationContextType extends AbstractStructBase
{
    /**
     * The CommunicationContextID
     * Meta informations extracted from the WSDL
     * - documentation: Identifier of the communication context (e.g. eKiosk of partner A, eIntegration of partner B, portal, mobile app, mobile portal) | This type describes the communication context of a request
     * - maxInclusive: 9999
     * - totalDigits: 4
     * @var int
     */
    public $CommunicationContextID;
    /**
     * Constructor method for CommunicationContextType
     * @uses CommunicationContextType::setCommunicationContextID()
     * @param int $communicationContextID
     */
    public function __construct($communicationContextID = null)
    {
        $this
            ->setCommunicationContextID($communicationContextID);
    }
    /**
     * Get CommunicationContextID value
     * @return int|null
     */
    public function getCommunicationContextID()
    {
        return $this->CommunicationContextID;
    }
    /**
     * Set CommunicationContextID value
     * @param int $communicationContextID
     * @return \StructType\CommunicationContextType
     */
    public function setCommunicationContextID($communicationContextID = null)
    {
        // validation for constraint: totalDigits
        if (is_float($communicationContextID) && strlen(str_replace(array(' ', '.', ',', '-', '+'), '', $communicationContextID)) !== 4) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 4 digits, "%d" given', strlen(substr($communicationContextID, strpos($communicationContextID, '.')))), __LINE__);
        }
        // validation for constraint: int
        if (!is_null($communicationContextID) && !is_numeric($communicationContextID)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a numeric value, "%s" given', gettype($communicationContextID)), __LINE__);
        }
        $this->CommunicationContextID = $communicationContextID;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\CommunicationContextType
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
