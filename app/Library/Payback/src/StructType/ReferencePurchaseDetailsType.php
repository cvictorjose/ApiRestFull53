<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for ReferencePurchaseDetailsType StructType
 * Meta informations extracted from the WSDL
 * - documentation: Details for the reference purchase
 * @subpackage Structs
 */
class ReferencePurchaseDetailsType extends AbstractStructBase
{
    /**
     * The RewardableLegalValue
     * Meta informations extracted from the WSDL
     * - documentation: Monetary value of the purchase that is rewarded
     * @var \StructType\LegalUnitType
     */
    public $RewardableLegalValue;
    /**
     * The ReceiptNumber
     * Meta informations extracted from the WSDL
     * - documentation: Key number of a receipt issued by partner. | Data type to represent object identifiers that is valid 'outside' our system. It is used in certain scenarios when data is inserted into the PAYBACK system that possesses valid unique
     * identifiers in other systems of a partner. Example: A member enrollment request sent by a PAYBACK partner could contain an external reference id for the member (e.g. his customer number at the partner which is not unique in PAYBACK but unique within
     * the partner's organization). The same data format is used for external identifiers that must be loaded during data migration from old systems.
     * - minOccurs: 0
     * - maxLength: 36
     * - minLength: 1
     * @var string
     */
    public $ReceiptNumber;
    /**
     * Constructor method for ReferencePurchaseDetailsType
     * @uses ReferencePurchaseDetailsType::setRewardableLegalValue()
     * @uses ReferencePurchaseDetailsType::setReceiptNumber()
     * @param \StructType\LegalUnitType $rewardableLegalValue
     * @param string $receiptNumber
     */
    public function __construct(\StructType\LegalUnitType $rewardableLegalValue = null, $receiptNumber = null)
    {
        $this
            ->setRewardableLegalValue($rewardableLegalValue)
            ->setReceiptNumber($receiptNumber);
    }
    /**
     * Get RewardableLegalValue value
     * @return \StructType\LegalUnitType|null
     */
    public function getRewardableLegalValue()
    {
        return $this->RewardableLegalValue;
    }
    /**
     * Set RewardableLegalValue value
     * @param \StructType\LegalUnitType $rewardableLegalValue
     * @return \StructType\ReferencePurchaseDetailsType
     */
    public function setRewardableLegalValue(\StructType\LegalUnitType $rewardableLegalValue = null)
    {
        $this->RewardableLegalValue = $rewardableLegalValue;
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
     * @return \StructType\ReferencePurchaseDetailsType
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\ReferencePurchaseDetailsType
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
