<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for ReverseCollectEventRequest StructType
 * Meta informations extracted from the WSDL
 * - documentation: INTF#043: Technical Undo of any type of collect event (either purchase, goodwill or promotion). Original event must be referenced
 * @subpackage Structs
 */
class ReverseCollectEventRequest extends AuthorisedRequest
{
    /**
     * The Authentication
     * Meta informations extracted from the WSDL
     * - documentation: Data used to identify and authenticate the member.
     * @var \StructType\MemberAliasIdentificationType
     */
    public $Authentication;
    /**
     * The CollectEventData
     * Meta informations extracted from the WSDL
     * - documentation: General Data for collect events
     * @var \StructType\CollectEventType
     */
    public $CollectEventData;
    /**
     * The ReferenceReceiptNumber
     * Meta informations extracted from the WSDL
     * - documentation: External identifier supplied by partner that references the original collect event that must be reversed within the partner system. | Data type to represent object identifiers that is valid 'outside' our system. It is used in certain
     * scenarios when data is inserted into the PAYBACK system that possesses valid unique identifiers in other systems of a partner. Example: A member enrollment request sent by a PAYBACK partner could contain an external reference id for the member (e.g.
     * his customer number at the partner which is not unique in PAYBACK but unique within the partner's organization). The same data format is used for external identifiers that must be loaded during data migration from old systems.
     * - maxLength: 36
     * - minLength: 1
     * @var string
     */
    public $ReferenceReceiptNumber;
    /**
     * Constructor method for ReverseCollectEventRequest
     * @uses ReverseCollectEventRequest::setAuthentication()
     * @uses ReverseCollectEventRequest::setCollectEventData()
     * @uses ReverseCollectEventRequest::setReferenceReceiptNumber()
     * @param \StructType\MemberAliasIdentificationType $authentication
     * @param \StructType\CollectEventType $collectEventData
     * @param string $referenceReceiptNumber
     */
    public function __construct(\StructType\MemberAliasIdentificationType $authentication = null, \StructType\CollectEventType $collectEventData = null, $referenceReceiptNumber = null)
    {
        $this
            ->setAuthentication($authentication)
            ->setCollectEventData($collectEventData)
            ->setReferenceReceiptNumber($referenceReceiptNumber);
    }
    /**
     * Get Authentication value
     * @return \StructType\MemberAliasIdentificationType|null
     */
    public function getAuthentication()
    {
        return $this->Authentication;
    }
    /**
     * Set Authentication value
     * @param \StructType\MemberAliasIdentificationType $authentication
     * @return \StructType\ReverseCollectEventRequest
     */
    public function setAuthentication(\StructType\MemberAliasIdentificationType $authentication = null)
    {
        $this->Authentication = $authentication;
        return $this;
    }
    /**
     * Get CollectEventData value
     * @return \StructType\CollectEventType|null
     */
    public function getCollectEventData()
    {
        return $this->CollectEventData;
    }
    /**
     * Set CollectEventData value
     * @param \StructType\CollectEventType $collectEventData
     * @return \StructType\ReverseCollectEventRequest
     */
    public function setCollectEventData(\StructType\CollectEventType $collectEventData = null)
    {
        $this->CollectEventData = $collectEventData;
        return $this;
    }
    /**
     * Get ReferenceReceiptNumber value
     * @return string|null
     */
    public function getReferenceReceiptNumber()
    {
        return $this->ReferenceReceiptNumber;
    }
    /**
     * Set ReferenceReceiptNumber value
     * @param string $referenceReceiptNumber
     * @return \StructType\ReverseCollectEventRequest
     */
    public function setReferenceReceiptNumber($referenceReceiptNumber = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($referenceReceiptNumber) && strlen($referenceReceiptNumber) > 36) || (is_array($referenceReceiptNumber) && count($referenceReceiptNumber) > 36)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 36 element(s) or a scalar of 36 character(s) at most, "%d" length given', is_scalar($referenceReceiptNumber) ? strlen($referenceReceiptNumber) : count($referenceReceiptNumber)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($referenceReceiptNumber) && strlen($referenceReceiptNumber) < 1) || (is_array($referenceReceiptNumber) && count($referenceReceiptNumber) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($referenceReceiptNumber) && !is_string($referenceReceiptNumber)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($referenceReceiptNumber)), __LINE__);
        }
        $this->ReferenceReceiptNumber = $referenceReceiptNumber;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\ReverseCollectEventRequest
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
