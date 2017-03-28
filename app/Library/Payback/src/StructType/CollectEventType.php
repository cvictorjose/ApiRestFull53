<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for CollectEventType StructType
 * @subpackage Structs
 */
class CollectEventType extends AbstractStructBase
{
    /**
     * The Partner
     * Meta informations extracted from the WSDL
     * - documentation: Unique short name of the partner, the partner's business unit and the partner's branch where the event was created
     * @var \StructType\PartnerContextType
     */
    public $Partner;
    /**
     * The EffectiveDate
     * Meta informations extracted from the WSDL
     * - documentation: Effective date. Date of event creation at partner (including time zone information) | An effective date is a date, when the reason of an event or transaction being created (e.g. a purchase), happened. | PAYBACK standard
     * date-time-stamps format (incl. time zone information). Represents instances identified by the combination of a date and a time. Its value space is described as a combination of date and time of day in Chapter 5.4 of ISO 8601. Its lexical space is the
     * extended format: [-]CCYY-MM-DDThh:mm:ss[Z|(+|-)hh:mm]
     * @var string
     */
    public $EffectiveDate;
    /**
     * The ReceiptNumber
     * Meta informations extracted from the WSDL
     * - documentation: Receipt number. Key number of a receipt issued at a partner. Must be unique for a certain partner | Data type to represent object identifiers that is valid 'outside' our system. It is used in certain scenarios when data is inserted
     * into the PAYBACK system that possesses valid unique identifiers in other systems of a partner. Example: A member enrollment request sent by a PAYBACK partner could contain an external reference id for the member (e.g. his customer number at the
     * partner which is not unique in PAYBACK but unique within the partner's organization). The same data format is used for external identifiers that must be loaded during data migration from old systems.
     * - maxLength: 36
     * - minLength: 1
     * @var string
     */
    public $ReceiptNumber;
    /**
     * The CommunicationChannel
     * Meta informations extracted from the WSDL
     * - documentation: Describes the medium used by the customer to interact with PAYBACK
     * @var string
     */
    public $CommunicationChannel;
    /**
     * Constructor method for CollectEventType
     * @uses CollectEventType::setPartner()
     * @uses CollectEventType::setEffectiveDate()
     * @uses CollectEventType::setReceiptNumber()
     * @uses CollectEventType::setCommunicationChannel()
     * @param \StructType\PartnerContextType $partner
     * @param string $effectiveDate
     * @param string $receiptNumber
     * @param string $communicationChannel
     */
    public function __construct(\StructType\PartnerContextType $partner = null, $effectiveDate = null, $receiptNumber = null, $communicationChannel = null)
    {
        $this
            ->setPartner($partner)
            ->setEffectiveDate($effectiveDate)
            ->setReceiptNumber($receiptNumber)
            ->setCommunicationChannel($communicationChannel);
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
     * @return \StructType\CollectEventType
     */
    public function setPartner(\StructType\PartnerContextType $partner = null)
    {
        $this->Partner = $partner;
        return $this;
    }
    /**
     * Get EffectiveDate value
     * @return string|null
     */
    public function getEffectiveDate()
    {
        return $this->EffectiveDate;
    }
    /**
     * Set EffectiveDate value
     * @param string $effectiveDate
     * @return \StructType\CollectEventType
     */
    public function setEffectiveDate($effectiveDate = null)
    {
        // validation for constraint: string
        if (!is_null($effectiveDate) && !is_string($effectiveDate)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($effectiveDate)), __LINE__);
        }
        $this->EffectiveDate = $effectiveDate;
        return $this;
    }
    /**
     * Get ReceiptNumber value
     * @return string|null
     */
    public function getReceiptNumber()
    {
        return $this->ReceiptNumber;
    }
    /**
     * Set ReceiptNumber value
     * @param string $receiptNumber
     * @return \StructType\CollectEventType
     */
    public function setReceiptNumber($receiptNumber = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($receiptNumber) && strlen($receiptNumber) > 36) || (is_array($receiptNumber) && count($receiptNumber) > 36)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 36 element(s) or a scalar of 36 character(s) at most, "%d" length given', is_scalar($receiptNumber) ? strlen($receiptNumber) : count($receiptNumber)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($receiptNumber) && strlen($receiptNumber) < 1) || (is_array($receiptNumber) && count($receiptNumber) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($receiptNumber) && !is_string($receiptNumber)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($receiptNumber)), __LINE__);
        }
        $this->ReceiptNumber = $receiptNumber;
        return $this;
    }
    /**
     * Get CommunicationChannel value
     * @return string|null
     */
    public function getCommunicationChannel()
    {
        return $this->CommunicationChannel;
    }
    /**
     * Set CommunicationChannel value
     * @uses \EnumType\CommunicationChannelType::valueIsValid()
     * @uses \EnumType\CommunicationChannelType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $communicationChannel
     * @return \StructType\CollectEventType
     */
    public function setCommunicationChannel($communicationChannel = null)
    {
        // validation for constraint: enumeration
        if (!\EnumType\CommunicationChannelType::valueIsValid($communicationChannel)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $communicationChannel, implode(', ', \EnumType\CommunicationChannelType::getValidValues())), __LINE__);
        }
        $this->CommunicationChannel = $communicationChannel;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\CollectEventType
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
