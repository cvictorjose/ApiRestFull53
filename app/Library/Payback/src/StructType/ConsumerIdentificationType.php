<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for ConsumerIdentificationType StructType
 * Meta informations extracted from the WSDL
 * - documentation: Type to indentiy a consumer in more detailed information on the concrete device.
 * @subpackage Structs
 */
class ConsumerIdentificationType extends AbstractStructBase
{
    /**
     * The ConsumerAuthentication
     * Meta informations extracted from the WSDL
     * - documentation: ConsumerAuthentication uniquely identifies and authorises the consumer. Only proper consumer authentication authorizes the consumer to access the PAYBACK system.Each consumer requires an interface contract with PAYBACK to receive
     * valid consumer authentication.
     * @var \StructType\ConsumerAuthenticationType
     */
    public $ConsumerAuthentication;
    /**
     * The Partner
     * Meta informations extracted from the WSDL
     * - documentation: PAYBACK Partner that is responsible for the interface contract with PAYBACK and that operates the consumer.
     * - minOccurs: 0
     * @var \StructType\PartnerContextType
     */
    public $Partner;
    /**
     * The DeviceID
     * Meta informations extracted from the WSDL
     * - documentation: Identifier for the individual device within theconsumer network. Examples are terminalIds IP address or the IMEI | ID of the technical device. For terminals this is known as terminalID for other devices this could be the IP address
     * or the IMEI
     * - minOccurs: 0
     * @var string
     */
    public $DeviceID;
    /**
     * The Product
     * Meta informations extracted from the WSDL
     * - documentation: Product relevant for the PAYBACK product stack (e.g.Online Toolbar, iPhoneApp, BackberryApp, full-size terminal, small-size terminal) | Product from the PAYBACK product stack (Online Toolbar, iPhoneApp, BlackberryApp, full-size
     * terminal, small-size terminal)
     * - minOccurs: 0
     * @var string
     */
    public $Product;
    /**
     * The Version
     * Meta informations extracted from the WSDL
     * - documentation: Determines consumer specific service configuration of system's interface (default: 1). | Determines consumer specific configuration of system's interface (default: 1).
     * @var string
     */
    public $Version;
    /**
     * The CommunicationContext
     * Meta informations extracted from the WSDL
     * - documentation: Communication context of the request
     * - minOccurs: 0
     * @var \StructType\CommunicationContextType
     */
    public $CommunicationContext;
    /**
     * Constructor method for ConsumerIdentificationType
     * @uses ConsumerIdentificationType::setConsumerAuthentication()
     * @uses ConsumerIdentificationType::setPartner()
     * @uses ConsumerIdentificationType::setDeviceID()
     * @uses ConsumerIdentificationType::setProduct()
     * @uses ConsumerIdentificationType::setVersion()
     * @uses ConsumerIdentificationType::setCommunicationContext()
     * @param \StructType\ConsumerAuthenticationType $consumerAuthentication
     * @param \StructType\PartnerContextType $partner
     * @param string $deviceID
     * @param string $product
     * @param string $version
     * @param \StructType\CommunicationContextType $communicationContext
     */
    public function __construct(\StructType\ConsumerAuthenticationType $consumerAuthentication = null, \StructType\PartnerContextType $partner = null, $deviceID = null, $product = null, $version = null, \StructType\CommunicationContextType $communicationContext = null)
    {
        $this
            ->setConsumerAuthentication($consumerAuthentication)
            ->setPartner($partner)
            ->setDeviceID($deviceID)
            ->setProduct($product)
            ->setVersion($version)
            ->setCommunicationContext($communicationContext);
    }
    /**
     * Get ConsumerAuthentication value
     * @return \StructType\ConsumerAuthenticationType|null
     */
    public function getConsumerAuthentication()
    {
        return $this->ConsumerAuthentication;
    }
    /**
     * Set ConsumerAuthentication value
     * @param \StructType\ConsumerAuthenticationType $consumerAuthentication
     * @return \StructType\ConsumerIdentificationType
     */
    public function setConsumerAuthentication(\StructType\ConsumerAuthenticationType $consumerAuthentication = null)
    {
        $this->ConsumerAuthentication = $consumerAuthentication;
        return $this;
    }
    /**
     * Get Partner value
     * @return \StructType\PartnerContextType|null
     */
    public function getPartner()
    {
        return $this->Partner;
    }
    /**
     * Set Partner value
     * @param \StructType\PartnerContextType $partner
     * @return \StructType\ConsumerIdentificationType
     */
    public function setPartner(\StructType\PartnerContextType $partner = null)
    {
        $this->Partner = $partner;
        return $this;
    }
    /**
     * Get DeviceID value
     * @return string|null
     */
    public function getDeviceID()
    {
        return $this->DeviceID;
    }
    /**
     * Set DeviceID value
     * @param string $deviceID
     * @return \StructType\ConsumerIdentificationType
     */
    public function setDeviceID($deviceID = null)
    {
        // validation for constraint: string
        if (!is_null($deviceID) && !is_string($deviceID)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($deviceID)), __LINE__);
        }
        $this->DeviceID = $deviceID;
        return $this;
    }
    /**
     * Get Product value
     * @return string|null
     */
    public function getProduct()
    {
        return $this->Product;
    }
    /**
     * Set Product value
     * @param string $product
     * @return \StructType\ConsumerIdentificationType
     */
    public function setProduct($product = null)
    {
        // validation for constraint: string
        if (!is_null($product) && !is_string($product)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($product)), __LINE__);
        }
        $this->Product = $product;
        return $this;
    }
    /**
     * Get Version value
     * @return string|null
     */
    public function getVersion()
    {
        return $this->Version;
    }
    /**
     * Set Version value
     * @param string $version
     * @return \StructType\ConsumerIdentificationType
     */
    public function setVersion($version = null)
    {
        // validation for constraint: string
        if (!is_null($version) && !is_string($version)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($version)), __LINE__);
        }
        $this->Version = $version;
        return $this;
    }
    /**
     * Get CommunicationContext value
     * @return \StructType\CommunicationContextType|null
     */
    public function getCommunicationContext()
    {
        return $this->CommunicationContext;
    }
    /**
     * Set CommunicationContext value
     * @param \StructType\CommunicationContextType $communicationContext
     * @return \StructType\ConsumerIdentificationType
     */
    public function setCommunicationContext(\StructType\CommunicationContextType $communicationContext = null)
    {
        $this->CommunicationContext = $communicationContext;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\ConsumerIdentificationType
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
