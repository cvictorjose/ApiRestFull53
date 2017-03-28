<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for TransactionDetails StructType
 * Meta informations extracted from the WSDL
 * - documentation: Details of a T-Record of a collect event
 * @subpackage Structs
 */
class TransactionDetails extends AbstractStructBase
{
    /**
     * The TransactionType
     * Meta informations extracted from the WSDL
     * - documentation: Transaction type. Either of:100 = PURCHASE,101 = PURCHASE_REVERSAL,102 = PURCHASE_REFUND,110 = RETROCREDIT,111 = RETROCREDIT_REVERSAL,120 = PROMOTION_PURCHASE_DEPENDENT,121 = PROMOTION_PURCHASE_DEPENDENT_REVERSAL,122 =
     * PROMOTION_PURCHASE_DEPENDENT_REFUND,130 = PROMOTION_PURCHASE_INDEPENDENT,131 = PROMOTION_PURCHASE_INDEPENDENT_REVERSAL,140 = GOODWILL,141 = GOODWILL_REVERSAL,150 = VOUCHER,151 = VOUCHER_REVERSAL,160 = GIFT_REDEMPTION,161 =
     * GIFT_REDEMPTION_REVERSAL,162 = GIFT_REDEMPTION_REFUND,170 = PAYMENT_REDEMPTION,171 = PAYMENT_REDEMPTION_REVERSAL,172 = PAYMENT_REDEMPTION_REFUND,180 = OUTBOUND_CONVERSION,181 = OUTBOUND_CONVERSION_REVERSAL,190 = DONATION,191 = DONATION_REVERSAL,200 =
     * SHOP_ORDER,201 = SHOP_ORDER_REVERSAL,202 = SHOP_ORDER_REFUND,210 = POINTS_DEBIT,220 = POINTS_EXPIRY,230 = POINTS_EXPIRY_CREDIT,240 = INBOUND_CONVERSION,241 = INBOUND_CONVERSION_REVERSAL,250 = NOT SUPPORTED - TRANSPORTATION,251 = NOT SUPPORTED -
     * TRANSPORTATION_REVERSAL,260 = NOT SUPPORTED - PROMOTION_TRANSPORTATION_DEPENDENT,261 = NOT SUPPORTED - PROMOTION_TRANSPORTATION_DEPENDENT_REVERSAL,300 = MIGRATION_TRANSACTION
     * @var string
     */
    public $TransactionType;
    /**
     * The MarketingCode
     * Meta informations extracted from the WSDL
     * - documentation: Marketing code. Unique identifier for marketing campaigns and promotions. | A short, unique name to identify partner defined codes. For gift codes, uniqueness is guaranteed on a 'per partner' base. For marketing codes uniqueness is
     * guaranteed on 'per system' base.
     * - minOccurs: 0
     * - maxLength: 20
     * - minLength: 1
     * - whiteSpace: collapse
     * @var string
     */
    public $MarketingCode;
    /**
     * The TotalPoints
     * Meta informations extracted from the WSDL
     * - documentation: Total points amount and currency. Points credited for this transaction (negative values are allowed)
     * @var \StructType\LoyaltyUnitType
     */
    public $TotalPoints;
    /**
     * The PointsBlockedUntil
     * Meta informations extracted from the WSDL
     * - documentation: Blocked until date. Points are blocked for redemption till the given date | This type describes a date up to which a member's points are blocked for redemption. | PAYBACK standard date-time-stamps format (incl. time zone
     * information). Represents instances identified by the combination of a date and a time. Its value space is described as a combination of date and time of day in Chapter 5.4 of ISO 8601. Its lexical space is the extended format:
     * [-]CCYY-MM-DDThh:mm:ss[Z|(+|-)hh:mm]
     * - minOccurs: 0
     * @var string
     */
    public $PointsBlockedUntil;
    /**
     * The ReferencePurchaseDetails
     * Meta informations extracted from the WSDL
     * - documentation: In case transaction is a promotion transaction, details of the related purchase events that lead to this promotion must be transmitted.Example: After member had bought five times a cup of coffee he receives 100 extra points. Within
     * the according promotion transaction every single purchase event must be listed.
     * - maxOccurs: unbounded
     * - minOccurs: 0
     * @var \StructType\ReferencePurchaseDetailsType[]
     */
    public $ReferencePurchaseDetails;
    /**
     * The LoyaltyProductCategory
     * Meta informations extracted from the WSDL
     * - documentation: The Loyalty Product Category is used to group the partner specific product categories into more informative, partner independent categories. The Loyalty Product Categories support analysis and reporting, and provide transparent
     * information for members and partners. | Basic type for lic-based, customizable enumerations. All enumerations that are customizable (e.g. salutations, channels etc.) are represented by non-negative integer based language independent codes internally.
     * This type is meant to be *abstract*. It must not be used directly but only to derive other lic-based types.
     * - minOccurs: 0
     * - maxInclusive: 9999
     * - totalDigits: 4
     * @var int
     */
    public $LoyaltyProductCategory;
    /**
     * Constructor method for TransactionDetails
     * @uses TransactionDetails::setTransactionType()
     * @uses TransactionDetails::setMarketingCode()
     * @uses TransactionDetails::setTotalPoints()
     * @uses TransactionDetails::setPointsBlockedUntil()
     * @uses TransactionDetails::setReferencePurchaseDetails()
     * @uses TransactionDetails::setLoyaltyProductCategory()
     * @param string $transactionType
     * @param string $marketingCode
     * @param \StructType\LoyaltyUnitType $totalPoints
     * @param string $pointsBlockedUntil
     * @param \StructType\ReferencePurchaseDetailsType[] $referencePurchaseDetails
     * @param int $loyaltyProductCategory
     */
    public function __construct($transactionType = null, $marketingCode = null, \StructType\LoyaltyUnitType $totalPoints = null, $pointsBlockedUntil = null, array $referencePurchaseDetails = array(), $loyaltyProductCategory = null)
    {
        $this
            ->setTransactionType($transactionType)
            ->setMarketingCode($marketingCode)
            ->setTotalPoints($totalPoints)
            ->setPointsBlockedUntil($pointsBlockedUntil)
            ->setReferencePurchaseDetails($referencePurchaseDetails)
            ->setLoyaltyProductCategory($loyaltyProductCategory);
    }
    /**
     * Get TransactionType value
     * @return string|null
     */
    public function getTransactionType()
    {
        return $this->TransactionType;
    }
    /**
     * Set TransactionType value
     * @uses \EnumType\TransactionTypeType::valueIsValid()
     * @uses \EnumType\TransactionTypeType::getValidValues()
     * @throws \InvalidArgumentException
     * @param string $transactionType
     * @return \StructType\TransactionDetails
     */
    public function setTransactionType($transactionType = null)
    {
        // validation for constraint: enumeration
        if (!\EnumType\TransactionTypeType::valueIsValid($transactionType)) {
            throw new \InvalidArgumentException(sprintf('Value "%s" is invalid, please use one of: %s', $transactionType, implode(', ', \EnumType\TransactionTypeType::getValidValues())), __LINE__);
        }
        $this->TransactionType = $transactionType;
        return $this;
    }
    /**
     * Get MarketingCode value
     * @return string|null
     */
    public function getMarketingCode()
    {
        return $this->MarketingCode;
    }
    /**
     * Set MarketingCode value
     * @param string $marketingCode
     * @return \StructType\TransactionDetails
     */
    public function setMarketingCode($marketingCode = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($marketingCode) && strlen($marketingCode) > 20) || (is_array($marketingCode) && count($marketingCode) > 20)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 20 element(s) or a scalar of 20 character(s) at most, "%d" length given', is_scalar($marketingCode) ? strlen($marketingCode) : count($marketingCode)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($marketingCode) && strlen($marketingCode) < 1) || (is_array($marketingCode) && count($marketingCode) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($marketingCode) && !is_string($marketingCode)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($marketingCode)), __LINE__);
        }
        $this->MarketingCode = $marketingCode;
        return $this;
    }
    /**
     * Get TotalPoints value
     * @return \StructType\LoyaltyUnitType|null
     */
    public function getTotalPoints()
    {
        return $this->TotalPoints;
    }
    /**
     * Set TotalPoints value
     * @param \StructType\LoyaltyUnitType $totalPoints
     * @return \StructType\TransactionDetails
     */
    public function setTotalPoints(\StructType\LoyaltyUnitType $totalPoints = null)
    {
        $this->TotalPoints = $totalPoints;
        return $this;
    }
    /**
     * Get PointsBlockedUntil value
     * @return string|null
     */
    public function getPointsBlockedUntil()
    {
        return $this->PointsBlockedUntil;
    }
    /**
     * Set PointsBlockedUntil value
     * @param string $pointsBlockedUntil
     * @return \StructType\TransactionDetails
     */
    public function setPointsBlockedUntil($pointsBlockedUntil = null)
    {
        // validation for constraint: string
        if (!is_null($pointsBlockedUntil) && !is_string($pointsBlockedUntil)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($pointsBlockedUntil)), __LINE__);
        }
        $this->PointsBlockedUntil = $pointsBlockedUntil;
        return $this;
    }
    /**
     * Get ReferencePurchaseDetails value
     * @return \StructType\ReferencePurchaseDetailsType[]|null
     */
    public function getReferencePurchaseDetails()
    {
        return $this->ReferencePurchaseDetails;
    }
    /**
     * Set ReferencePurchaseDetails value
     * @throws \InvalidArgumentException
     * @param \StructType\ReferencePurchaseDetailsType[] $referencePurchaseDetails
     * @return \StructType\TransactionDetails
     */
    public function setReferencePurchaseDetails(array $referencePurchaseDetails = array())
    {
        foreach ($referencePurchaseDetails as $transactionDetailsReferencePurchaseDetailsItem) {
            // validation for constraint: itemType
            if (!$transactionDetailsReferencePurchaseDetailsItem instanceof \StructType\ReferencePurchaseDetailsType) {
                throw new \InvalidArgumentException(sprintf('The ReferencePurchaseDetails property can only contain items of \StructType\ReferencePurchaseDetailsType, "%s" given', is_object($transactionDetailsReferencePurchaseDetailsItem) ? get_class($transactionDetailsReferencePurchaseDetailsItem) : gettype($transactionDetailsReferencePurchaseDetailsItem)), __LINE__);
            }
        }
        $this->ReferencePurchaseDetails = $referencePurchaseDetails;
        return $this;
    }
    /**
     * Add item to ReferencePurchaseDetails value
     * @throws \InvalidArgumentException
     * @param \StructType\ReferencePurchaseDetailsType $item
     * @return \StructType\TransactionDetails
     */
    public function addToReferencePurchaseDetails(\StructType\ReferencePurchaseDetailsType $item)
    {
        // validation for constraint: itemType
        if (!$item instanceof \StructType\ReferencePurchaseDetailsType) {
            throw new \InvalidArgumentException(sprintf('The ReferencePurchaseDetails property can only contain items of \StructType\ReferencePurchaseDetailsType, "%s" given', is_object($item) ? get_class($item) : gettype($item)), __LINE__);
        }
        $this->ReferencePurchaseDetails[] = $item;
        return $this;
    }
    /**
     * Get LoyaltyProductCategory value
     * @return int|null
     */
    public function getLoyaltyProductCategory()
    {
        return $this->LoyaltyProductCategory;
    }
    /**
     * Set LoyaltyProductCategory value
     * @param int $loyaltyProductCategory
     * @return \StructType\TransactionDetails
     */
    public function setLoyaltyProductCategory($loyaltyProductCategory = null)
    {
        // validation for constraint: totalDigits
        if (is_float($loyaltyProductCategory) && strlen(str_replace(array(' ', '.', ',', '-', '+'), '', $loyaltyProductCategory)) !== 4) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 4 digits, "%d" given', strlen(substr($loyaltyProductCategory, strpos($loyaltyProductCategory, '.')))), __LINE__);
        }
        // validation for constraint: int
        if (!is_null($loyaltyProductCategory) && !is_numeric($loyaltyProductCategory)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a numeric value, "%s" given', gettype($loyaltyProductCategory)), __LINE__);
        }
        $this->LoyaltyProductCategory = $loyaltyProductCategory;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\TransactionDetails
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
