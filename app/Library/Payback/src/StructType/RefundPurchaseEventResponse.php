<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for RefundPurchaseEventResponse StructType
 * Meta informations extracted from the WSDL
 * - documentation: For errors see separate error code document.
 * @subpackage Structs
 */
class RefundPurchaseEventResponse extends MessageResponse
{
    /**
     * The AccountBalanceDetails
     * Meta informations extracted from the WSDL
     * - documentation: New account balances
     * - maxOccurs: unbounded
     * @var \StructType\AccountBalanceDetailType[]
     */
    public $AccountBalanceDetails;
    /**
     * The Transactions
     * Meta informations extracted from the WSDL
     * - documentation: Transactions created as result of the refund rating
     * - maxOccurs: unbounded
     * - minOccurs: 0
     * @var \StructType\TransactionDetails[]
     */
    public $Transactions;
    /**
     * Constructor method for RefundPurchaseEventResponse
     * @uses RefundPurchaseEventResponse::setAccountBalanceDetails()
     * @uses RefundPurchaseEventResponse::setTransactions()
     * @param \StructType\AccountBalanceDetailType[] $accountBalanceDetails
     * @param \StructType\TransactionDetails[] $transactions
     */
    public function __construct(array $accountBalanceDetails = array(), array $transactions = array())
    {
        $this
            ->setAccountBalanceDetails($accountBalanceDetails)
            ->setTransactions($transactions);
    }
    /**
     * Get AccountBalanceDetails value
     * @return \StructType\AccountBalanceDetailType[]|null
     */
    public function getAccountBalanceDetails()
    {
        return $this->AccountBalanceDetails;
    }
    /**
     * Set AccountBalanceDetails value
     * @throws \InvalidArgumentException
     * @param \StructType\AccountBalanceDetailType[] $accountBalanceDetails
     * @return \StructType\RefundPurchaseEventResponse
     */
    public function setAccountBalanceDetails(array $accountBalanceDetails = array())
    {
        foreach ($accountBalanceDetails as $refundPurchaseEventResponseAccountBalanceDetailsItem) {
            // validation for constraint: itemType
            if (!$refundPurchaseEventResponseAccountBalanceDetailsItem instanceof \StructType\AccountBalanceDetailType) {
                throw new \InvalidArgumentException(sprintf('The AccountBalanceDetails property can only contain items of \StructType\AccountBalanceDetailType, "%s" given', is_object($refundPurchaseEventResponseAccountBalanceDetailsItem) ? get_class($refundPurchaseEventResponseAccountBalanceDetailsItem) : gettype($refundPurchaseEventResponseAccountBalanceDetailsItem)), __LINE__);
            }
        }
        $this->AccountBalanceDetails = $accountBalanceDetails;
        return $this;
    }
    /**
     * Add item to AccountBalanceDetails value
     * @throws \InvalidArgumentException
     * @param \StructType\AccountBalanceDetailType $item
     * @return \StructType\RefundPurchaseEventResponse
     */
    public function addToAccountBalanceDetails(\StructType\AccountBalanceDetailType $item)
    {
        // validation for constraint: itemType
        if (!$item instanceof \StructType\AccountBalanceDetailType) {
            throw new \InvalidArgumentException(sprintf('The AccountBalanceDetails property can only contain items of \StructType\AccountBalanceDetailType, "%s" given', is_object($item) ? get_class($item) : gettype($item)), __LINE__);
        }
        $this->AccountBalanceDetails[] = $item;
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
     * @return \StructType\RefundPurchaseEventResponse
     */
    public function setTransactions(array $transactions = array())
    {
        foreach ($transactions as $refundPurchaseEventResponseTransactionsItem) {
            // validation for constraint: itemType
            if (!$refundPurchaseEventResponseTransactionsItem instanceof \StructType\TransactionDetails) {
                throw new \InvalidArgumentException(sprintf('The Transactions property can only contain items of \StructType\TransactionDetails, "%s" given', is_object($refundPurchaseEventResponseTransactionsItem) ? get_class($refundPurchaseEventResponseTransactionsItem) : gettype($refundPurchaseEventResponseTransactionsItem)), __LINE__);
            }
        }
        $this->Transactions = $transactions;
        return $this;
    }
    /**
     * Add item to Transactions value
     * @throws \InvalidArgumentException
     * @param \StructType\TransactionDetails $item
     * @return \StructType\RefundPurchaseEventResponse
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
     * @return \StructType\RefundPurchaseEventResponse
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
