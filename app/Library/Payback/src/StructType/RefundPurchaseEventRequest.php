<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for RefundPurchaseEventRequest StructType
 * Meta informations extracted from the WSDL
 * - documentation: INTF#039: (Partly) Refund of a purchase event or retro. Original purchase should be referenced.
 * @subpackage Structs
 */
class RefundPurchaseEventRequest extends AuthorisedRequest
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
     * - documentation: General data for collect events
     * @var \StructType\CollectEventType
     */
    public $CollectEventData;
    /**
     * The PurchaseEventType
     * Meta informations extracted from the WSDL
     * - documentation: Type of the purchase event: 1 - Purchase; 2 - RetroCredit
     * @var string
     */
    public $PurchaseEventType;
    /**
     * The ReferenceReceiptNumber
     * Meta informations extracted from the WSDL
     * - documentation: External identifier supplied by partner that references the original purchase that must be re-versed within the partner system | Data type to represent object identifiers that is valid 'outside' our system. It is used in certain
     * scenarios when data is inserted into the PAYBACK system that possesses valid unique identifiers in other systems of a partner. Example: A member enrollment request sent by a PAYBACK partner could contain an external reference id for the member (e.g.
     * his customer number at the partner which is not unique in PAYBACK but unique within the partner's organization). The same data format is used for external identifiers that must be loaded during data migration from old systems.
     * - minOccurs: 0
     * - maxLength: 36
     * - minLength: 1
     * @var string
     */
    public $ReferenceReceiptNumber;
    /**
     * The RefundLegalValue
     * Meta informations extracted from the WSDL
     * - documentation: Monetary value in legal currency of the refund.
     * - minOccurs: 0
     * @var \StructType\LegalUnitType
     */
    public $RefundLegalValue;
    /**
     * The RefundVatLegalValue
     * Meta informations extracted from the WSDL
     * - documentation: Monetary value in legal currency of vat.
     * - minOccurs: 0
     * @var \StructType\LegalUnitType
     */
    public $RefundVatLegalValue;
    /**
     * The RefundItemDetails
     * Meta informations extracted from the WSDL
     * - documentation: Optional shopping basket of the refunded items
     * - maxOccurs: unbounded
     * - minOccurs: 0
     * @var \StructType\PurchaseItemDetails[]
     */
    public $RefundItemDetails;
    /**
     * The Transactions
     * Meta informations extracted from the WSDL
     * - documentation: Optional pre-rated refund transactions for the event
     * - maxOccurs: unbounded
     * - minOccurs: 0
     * @var \StructType\TransactionDetails[]
     */
    public $Transactions;
    /**
     * Constructor method for RefundPurchaseEventRequest
     * @uses RefundPurchaseEventRequest::setAuthentication()
     * @uses RefundPurchaseEventRequest::setCollectEventData()
     * @uses RefundPurchaseEventRequest::setPurchaseEventType()
     * @uses RefundPurchaseEventRequest::setReferenceReceiptNumber()
     * @uses RefundPurchaseEventRequest::setRefundLegalValue()
     * @uses RefundPurchaseEventRequest::setRefundVatLegalValue()
     * @uses RefundPurchaseEventRequest::setRefundItemDetails()
     * @uses RefundPurchaseEventRequest::setTransactions()
     * @param \StructType\MemberAliasIdentificationType $authentication
     * @param \StructType\CollectEventType $collectEventData
     * @param string $purchaseEventType
     * @param string $referenceReceiptNumber
     * @param \StructType\LegalUnitType $refundLegalValue
     * @param \StructType\LegalUnitType $refundVatLegalValue
     * @param \StructType\PurchaseItemDetails[] $refundItemDetails
     * @param \StructType\TransactionDetails[] $transactions
     */
    public function __construct(\StructType\MemberAliasIdentificationType $authentication = null, \StructType\CollectEventType $collectEventData = null, $purchaseEventType = null, $referenceReceiptNumber = null, \StructType\LegalUnitType $refundLegalValue = null, \StructType\LegalUnitType $refundVatLegalValue = null, array $refundItemDetails = array(), array $transactions = array())
    {
        $this
            ->setAuthentication($authentication)
            ->setCollectEventData($collectEventData)
            ->setPurchaseEventType($purchaseEventType)
            ->setReferenceReceiptNumber($referenceReceiptNumber)
            ->setRefundLegalValue($refundLegalValue)
            ->setRefundVatLegalValue($refundVatLegalValue)
            ->setRefundItemDetails($refundItemDetails)
            ->setTransactions($transactions);
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
     * @return \StructType\RefundPurchaseEventRequest
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
     * @return \StructType\RefundPurchaseEventRequest
     */
    public function setCollectEventData(\StructType\CollectEventType $collectEventData = null)
    {
        $this->CollectEventData = $collectEventData;
        return $this;
    }
    /**
     * Get PurchaseEventType value
     * @return string|null
     */
    public function getPurchaseEventType()
    {
        return $this->PurchaseEventType;
    }
    /**
     * Set PurchaseEventType value
     * @uses \EnumType\PurchaseEventTypeType::valueIsValid()
     * @uses \EnumType\PurchaseEventTypeType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $purchaseEventType
     * @return \StructType\RefundPurchaseEventRequest
     */
    public function setPurchaseEventType($purchaseEventType = null)
    {
        // validation for constraint: enumeration
        if (!\EnumType\PurchaseEventTypeType::valueIsValid($purchaseEventType)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $purchaseEventType, implode(', ', \EnumType\PurchaseEventTypeType::getValidValues())), __LINE__);
        }
        $this->PurchaseEventType = $purchaseEventType;
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
     * @return \StructType\RefundPurchaseEventRequest
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
     * Get RefundLegalValue value
     * @return \StructType\LegalUnitType|null
     */
    public function getRefundLegalValue()
    {
        return $this->RefundLegalValue;
    }
    /**
     * Set RefundLegalValue value
     * @param \StructType\LegalUnitType $refundLegalValue
     * @return \StructType\RefundPurchaseEventRequest
     */
    public function setRefundLegalValue(\StructType\LegalUnitType $refundLegalValue = null)
    {
        $this->RefundLegalValue = $refundLegalValue;
        return $this;
    }
    /**
     * Get RefundVatLegalValue value
     * @return \StructType\LegalUnitType|null
     */
    public function getRefundVatLegalValue()
    {
        return $this->RefundVatLegalValue;
    }
    /**
     * Set RefundVatLegalValue value
     * @param \StructType\LegalUnitType $refundVatLegalValue
     * @return \StructType\RefundPurchaseEventRequest
     */
    public function setRefundVatLegalValue(\StructType\LegalUnitType $refundVatLegalValue = null)
    {
        $this->RefundVatLegalValue = $refundVatLegalValue;
        return $this;
    }
    /**
     * Get RefundItemDetails value
     * @return \StructType\PurchaseItemDetails[]|null
     */
    public function getRefundItemDetails()
    {
        return $this->RefundItemDetails;
    }
    /**
     * Set RefundItemDetails value
     * @throws \InvalidArgumentException
     * @param \StructType\PurchaseItemDetails[] $refundItemDetails
     * @return \StructType\RefundPurchaseEventRequest
     */
    public function setRefundItemDetails(array $refundItemDetails = array())
    {
        foreach ($refundItemDetails as $refundPurchaseEventRequestRefundItemDetailsItem) {
            // validation for constraint: itemType
            if (!$refundPurchaseEventRequestRefundItemDetailsItem instanceof \StructType\PurchaseItemDetails) {
                throw new \InvalidArgumentException(sprintf('The RefundItemDetails property can only contain items of \StructType\PurchaseItemDetails, "%s" given', is_object($refundPurchaseEventRequestRefundItemDetailsItem) ? get_class($refundPurchaseEventRequestRefundItemDetailsItem) : gettype($refundPurchaseEventRequestRefundItemDetailsItem)), __LINE__);
            }
        }
        $this->RefundItemDetails = $refundItemDetails;
        return $this;
    }
    /**
     * Add item to RefundItemDetails value
     * @throws \InvalidArgumentException
     * @param \StructType\PurchaseItemDetails $item
     * @return \StructType\RefundPurchaseEventRequest
     */
    public function addToRefundItemDetails(\StructType\PurchaseItemDetails $item)
    {
        // validation for constraint: itemType
        if (!$item instanceof \StructType\PurchaseItemDetails) {
            throw new \InvalidArgumentException(sprintf('The RefundItemDetails property can only contain items of \StructType\PurchaseItemDetails, "%s" given', is_object($item) ? get_class($item) : gettype($item)), __LINE__);
        }
        $this->RefundItemDetails[] = $item;
        return $this;
    }
    /**
     * Get Transactions value
     * @return \StructType\TransactionDetails[]|null
     */
    public function getTransactions()
    {
        return $this->Transactions;
    }
    /**
     * Set Transactions value
     * @throws \InvalidArgumentException
     * @param \StructType\TransactionDetails[] $transactions
     * @return \StructType\RefundPurchaseEventRequest
     */
    public function setTransactions(array $transactions = array())
    {
        foreach ($transactions as $refundPurchaseEventRequestTransactionsItem) {
            // validation for constraint: itemType
            if (!$refundPurchaseEventRequestTransactionsItem instanceof \StructType\TransactionDetails) {
                throw new \InvalidArgumentException(sprintf('The Transactions property can only contain items of \StructType\TransactionDetails, "%s" given', is_object($refundPurchaseEventRequestTransactionsItem) ? get_class($refundPurchaseEventRequestTransactionsItem) : gettype($refundPurchaseEventRequestTransactionsItem)), __LINE__);
            }
        }
        $this->Transactions = $transactions;
        return $this;
    }
    /**
     * Add item to Transactions value
     * @throws \InvalidArgumentException
     * @param \StructType\TransactionDetails $item
     * @return \StructType\RefundPurchaseEventRequest
     */
    public function addToTransactions(\StructType\TransactionDetails $item)
    {
        // validation for constraint: itemType
        if (!$item instanceof \StructType\TransactionDetails) {
            throw new \InvalidArgumentException(sprintf('The Transactions property can only contain items of \StructType\TransactionDetails, "%s" given', is_object($item) ? get_class($item) : gettype($item)), __LINE__);
        }
        $this->Transactions[] = $item;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\RefundPurchaseEventRequest
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
