<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for ReverseCollectEventResponse StructType
 * Meta informations extracted from the WSDL
 * - documentation: For errors see separate error code document.
 * @subpackage Structs
 */
class ReverseCollectEventResponse extends MessageResponse
{
    /**
     * The AccountBalanceDetails
     * Meta informations extracted from the WSDL
     * - documentation: New account balance
     * - maxOccurs: unbounded
     * @var \StructType\AccountBalanceDetailType[]
     */
    public $AccountBalanceDetails;
    /**
     * The Transactions
     * Meta informations extracted from the WSDL
     * - documentation: Reversal transactions created
     * - maxOccurs: unbounded
     * - minOccurs: 0
     * @var \StructType\TransactionDetails[]
     */
    public $Transactions;
    /**
     * Constructor method for ReverseCollectEventResponse
     * @uses ReverseCollectEventResponse::setAccountBalanceDetails()
     * @uses ReverseCollectEventResponse::setTransactions()
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
     * @return \StructType\ReverseCollectEventResponse
     */
    public function setAccountBalanceDetails(array $accountBalanceDetails = array())
    {
        foreach ($accountBalanceDetails as $reverseCollectEventResponseAccountBalanceDetailsItem) {
            // validation for constraint: itemType
            if (!$reverseCollectEventResponseAccountBalanceDetailsItem instanceof \StructType\AccountBalanceDetailType) {
                throw new \InvalidArgumentException(sprintf('The AccountBalanceDetails property can only contain items of \StructType\AccountBalanceDetailType, "%s" given', is_object($reverseCollectEventResponseAccountBalanceDetailsItem) ? get_class($reverseCollectEventResponseAccountBalanceDetailsItem) : gettype($reverseCollectEventResponseAccountBalanceDetailsItem)), __LINE__);
            }
        }
        $this->AccountBalanceDetails = $accountBalanceDetails;
        return $this;
    }
    /**
     * Add item to AccountBalanceDetails value
     * @throws \InvalidArgumentException
     * @param \StructType\AccountBalanceDetailType $item
     * @return \StructType\ReverseCollectEventResponse
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
     * @return \StructType\ReverseCollectEventResponse
     */
    public function setTransactions(array $transactions = array())
    {
        foreach ($transactions as $reverseCollectEventResponseTransactionsItem) {
            // validation for constraint: itemType
            if (!$reverseCollectEventResponseTransactionsItem instanceof \StructType\TransactionDetails) {
                throw new \InvalidArgumentException(sprintf('The Transactions property can only contain items of \StructType\TransactionDetails, "%s" given', is_object($reverseCollectEventResponseTransactionsItem) ? get_class($reverseCollectEventResponseTransactionsItem) : gettype($reverseCollectEventResponseTransactionsItem)), __LINE__);
            }
        }
        $this->Transactions = $transactions;
        return $this;
    }
    /**
     * Add item to Transactions value
     * @throws \InvalidArgumentException
     * @param \StructType\TransactionDetails $item
     * @return \StructType\ReverseCollectEventResponse
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
     * @return \StructType\ReverseCollectEventResponse
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
