<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for AccountBalanceDetailType StructType
 * @subpackage Structs
 */
class AccountBalanceDetailType extends AbstractStructBase
{
    /**
     * The LoyaltyCurrency
     * Meta informations extracted from the WSDL
     * - documentation: The loyalty currency of all amounts in this account balance record. | Unit of measurement of loyalty currency
     * - maxLength: 3
     * - minLength: 3
     * - pattern: [a-zA-Z0-9]*
     * @var string
     */
    public $LoyaltyCurrency;
    /**
     * The TotalPointsAmount
     * Meta informations extracted from the WSDL
     * - documentation: The total amount of points in this account. | Type for representing amounts of loyalty currency (i.e. points)
     * - fractionDigits: 3
     * - totalDigits: 21
     * @var float
     */
    public $TotalPointsAmount;
    /**
     * The AvailablePointsAmount
     * Meta informations extracted from the WSDL
     * - documentation: The amount of available points in this account. | Type for representing amounts of loyalty currency (i.e. points)
     * - fractionDigits: 3
     * - totalDigits: 21
     * @var float
     */
    public $AvailablePointsAmount;
    /**
     * The BlockedPointsAmount
     * Meta informations extracted from the WSDL
     * - documentation: The amount of blocked points in this account. | Type for representing amounts of loyalty currency (i.e. points)
     * - fractionDigits: 3
     * - totalDigits: 21
     * @var float
     */
    public $BlockedPointsAmount;
    /**
     * The TotalCollectedPointsAmount
     * Meta informations extracted from the WSDL
     * - documentation: The amount of total collected points in this account. | Type for representing amounts of loyalty currency (i.e. points)
     * - fractionDigits: 3
     * - totalDigits: 21
     * @var float
     */
    public $TotalCollectedPointsAmount;
    /**
     * The TotalSpendPointsAmount
     * Meta informations extracted from the WSDL
     * - documentation: The amount of total spend points in this account. | Type for representing amounts of loyalty currency (i.e. points)
     * - fractionDigits: 3
     * - totalDigits: 21
     * @var float
     */
    public $TotalSpendPointsAmount;
    /**
     * The ExpiryAnnouncement
     * Meta informations extracted from the WSDL
     * - documentation: An optional announcement to warn the member that some of his points will expire soon.
     * - minOccurs: 0
     * @var \StructType\ExpiryAnnouncementType
     */
    public $ExpiryAnnouncement;
    /**
     * The ExpiryStatistics
     * Meta informations extracted from the WSDL
     * - documentation: An optional statistics information to inform the member how many point already expired.
     * - minOccurs: 0
     * @var \StructType\ExpiryStatisticsType
     */
    public $ExpiryStatistics;
    /**
     * Constructor method for AccountBalanceDetailType
     * @uses AccountBalanceDetailType::setLoyaltyCurrency()
     * @uses AccountBalanceDetailType::setTotalPointsAmount()
     * @uses AccountBalanceDetailType::setAvailablePointsAmount()
     * @uses AccountBalanceDetailType::setBlockedPointsAmount()
     * @uses AccountBalanceDetailType::setTotalCollectedPointsAmount()
     * @uses AccountBalanceDetailType::setTotalSpendPointsAmount()
     * @uses AccountBalanceDetailType::setExpiryAnnouncement()
     * @uses AccountBalanceDetailType::setExpiryStatistics()
     * @param string $loyaltyCurrency
     * @param float $totalPointsAmount
     * @param float $availablePointsAmount
     * @param float $blockedPointsAmount
     * @param float $totalCollectedPointsAmount
     * @param float $totalSpendPointsAmount
     * @param \StructType\ExpiryAnnouncementType $expiryAnnouncement
     * @param \StructType\ExpiryStatisticsType $expiryStatistics
     */
    public function __construct($loyaltyCurrency = null, $totalPointsAmount = null, $availablePointsAmount = null, $blockedPointsAmount = null, $totalCollectedPointsAmount = null, $totalSpendPointsAmount = null, \StructType\ExpiryAnnouncementType $expiryAnnouncement = null, \StructType\ExpiryStatisticsType $expiryStatistics = null)
    {
        $this
            ->setLoyaltyCurrency($loyaltyCurrency)
            ->setTotalPointsAmount($totalPointsAmount)
            ->setAvailablePointsAmount($availablePointsAmount)
            ->setBlockedPointsAmount($blockedPointsAmount)
            ->setTotalCollectedPointsAmount($totalCollectedPointsAmount)
            ->setTotalSpendPointsAmount($totalSpendPointsAmount)
            ->setExpiryAnnouncement($expiryAnnouncement)
            ->setExpiryStatistics($expiryStatistics);
    }
    /**
     * Get LoyaltyCurrency value
     * @return string|null
     */
    public function getLoyaltyCurrency()
    {
        return $this->LoyaltyCurrency;
    }
    /**
     * Set LoyaltyCurrency value
     * @param string $loyaltyCurrency
     * @return \StructType\AccountBalanceDetailType
     */
    public function setLoyaltyCurrency($loyaltyCurrency = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($loyaltyCurrency) && strlen($loyaltyCurrency) > 3) || (is_array($loyaltyCurrency) && count($loyaltyCurrency) > 3)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 3 element(s) or a scalar of 3 character(s) at most, "%d" length given', is_scalar($loyaltyCurrency) ? strlen($loyaltyCurrency) : count($loyaltyCurrency)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($loyaltyCurrency) && strlen($loyaltyCurrency) < 3) || (is_array($loyaltyCurrency) && count($loyaltyCurrency) < 3)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 3 element(s) or a scalar of 3 character(s) at least', __LINE__);
        }
        // validation for constraint: pattern
        if (is_scalar($loyaltyCurrency) && !preg_match('/[a-zA-Z0-9]*/', $loyaltyCurrency)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a scalar value that matches "[a-zA-Z0-9]*", "%s" given', var_export($loyaltyCurrency, true)), __LINE__);
        }
        // validation for constraint: string
        if (!is_null($loyaltyCurrency) && !is_string($loyaltyCurrency)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($loyaltyCurrency)), __LINE__);
        }
        $this->LoyaltyCurrency = $loyaltyCurrency;
        return $this;
    }
    /**
     * Get TotalPointsAmount value
     * @return float|null
     */
    public function getTotalPointsAmount()
    {
        return $this->TotalPointsAmount;
    }
    /**
     * Set TotalPointsAmount value
     * @param float $totalPointsAmount
     * @return \StructType\AccountBalanceDetailType
     */
    public function setTotalPointsAmount($totalPointsAmount = null)
    {
        // validation for constraint: fractionDigits
        if (is_float($totalPointsAmount) && strlen(substr($totalPointsAmount, strpos($totalPointsAmount, '.'))) !== 3) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 3 fraction digits, "%d" given', strlen(substr($totalPointsAmount, strpos($totalPointsAmount, '.')))), __LINE__);
        }
        // validation for constraint: totalDigits
        if (is_float($totalPointsAmount) && strlen(str_replace(array(' ', '.', ',', '-', '+'), '', $totalPointsAmount)) !== 21) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 21 digits, "%d" given', strlen(substr($totalPointsAmount, strpos($totalPointsAmount, '.')))), __LINE__);
        }
        $this->TotalPointsAmount = $totalPointsAmount;
        return $this;
    }
    /**
     * Get AvailablePointsAmount value
     * @return float|null
     */
    public function getAvailablePointsAmount()
    {
        return $this->AvailablePointsAmount;
    }
    /**
     * Set AvailablePointsAmount value
     * @param float $availablePointsAmount
     * @return \StructType\AccountBalanceDetailType
     */
    public function setAvailablePointsAmount($availablePointsAmount = null)
    {
        // validation for constraint: fractionDigits
        if (is_float($availablePointsAmount) && strlen(substr($availablePointsAmount, strpos($availablePointsAmount, '.'))) !== 3) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 3 fraction digits, "%d" given', strlen(substr($availablePointsAmount, strpos($availablePointsAmount, '.')))), __LINE__);
        }
        // validation for constraint: totalDigits
        if (is_float($availablePointsAmount) && strlen(str_replace(array(' ', '.', ',', '-', '+'), '', $availablePointsAmount)) !== 21) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 21 digits, "%d" given', strlen(substr($availablePointsAmount, strpos($availablePointsAmount, '.')))), __LINE__);
        }
        $this->AvailablePointsAmount = $availablePointsAmount;
        return $this;
    }
    /**
     * Get BlockedPointsAmount value
     * @return float|null
     */
    public function getBlockedPointsAmount()
    {
        return $this->BlockedPointsAmount;
    }
    /**
     * Set BlockedPointsAmount value
     * @param float $blockedPointsAmount
     * @return \StructType\AccountBalanceDetailType
     */
    public function setBlockedPointsAmount($blockedPointsAmount = null)
    {
        // validation for constraint: fractionDigits
        if (is_float($blockedPointsAmount) && strlen(substr($blockedPointsAmount, strpos($blockedPointsAmount, '.'))) !== 3) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 3 fraction digits, "%d" given', strlen(substr($blockedPointsAmount, strpos($blockedPointsAmount, '.')))), __LINE__);
        }
        // validation for constraint: totalDigits
        if (is_float($blockedPointsAmount) && strlen(str_replace(array(' ', '.', ',', '-', '+'), '', $blockedPointsAmount)) !== 21) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 21 digits, "%d" given', strlen(substr($blockedPointsAmount, strpos($blockedPointsAmount, '.')))), __LINE__);
        }
        $this->BlockedPointsAmount = $blockedPointsAmount;
        return $this;
    }
    /**
     * Get TotalCollectedPointsAmount value
     * @return float|null
     */
    public function getTotalCollectedPointsAmount()
    {
        return $this->TotalCollectedPointsAmount;
    }
    /**
     * Set TotalCollectedPointsAmount value
     * @param float $totalCollectedPointsAmount
     * @return \StructType\AccountBalanceDetailType
     */
    public function setTotalCollectedPointsAmount($totalCollectedPointsAmount = null)
    {
        // validation for constraint: fractionDigits
        if (is_float($totalCollectedPointsAmount) && strlen(substr($totalCollectedPointsAmount, strpos($totalCollectedPointsAmount, '.'))) !== 3) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 3 fraction digits, "%d" given', strlen(substr($totalCollectedPointsAmount, strpos($totalCollectedPointsAmount, '.')))), __LINE__);
        }
        // validation for constraint: totalDigits
        if (is_float($totalCollectedPointsAmount) && strlen(str_replace(array(' ', '.', ',', '-', '+'), '', $totalCollectedPointsAmount)) !== 21) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 21 digits, "%d" given', strlen(substr($totalCollectedPointsAmount, strpos($totalCollectedPointsAmount, '.')))), __LINE__);
        }
        $this->TotalCollectedPointsAmount = $totalCollectedPointsAmount;
        return $this;
    }
    /**
     * Get TotalSpendPointsAmount value
     * @return float|null
     */
    public function getTotalSpendPointsAmount()
    {
        return $this->TotalSpendPointsAmount;
    }
    /**
     * Set TotalSpendPointsAmount value
     * @param float $totalSpendPointsAmount
     * @return \StructType\AccountBalanceDetailType
     */
    public function setTotalSpendPointsAmount($totalSpendPointsAmount = null)
    {
        // validation for constraint: fractionDigits
        if (is_float($totalSpendPointsAmount) && strlen(substr($totalSpendPointsAmount, strpos($totalSpendPointsAmount, '.'))) !== 3) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 3 fraction digits, "%d" given', strlen(substr($totalSpendPointsAmount, strpos($totalSpendPointsAmount, '.')))), __LINE__);
        }
        // validation for constraint: totalDigits
        if (is_float($totalSpendPointsAmount) && strlen(str_replace(array(' ', '.', ',', '-', '+'), '', $totalSpendPointsAmount)) !== 21) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 21 digits, "%d" given', strlen(substr($totalSpendPointsAmount, strpos($totalSpendPointsAmount, '.')))), __LINE__);
        }
        $this->TotalSpendPointsAmount = $totalSpendPointsAmount;
        return $this;
    }
    /**
     * Get ExpiryAnnouncement value
     * @return \StructType\ExpiryAnnouncementType|null
     */
    public function getExpiryAnnouncement()
    {
        return $this->ExpiryAnnouncement;
    }
    /**
     * Set ExpiryAnnouncement value
     * @param \StructType\ExpiryAnnouncementType $expiryAnnouncement
     * @return \StructType\AccountBalanceDetailType
     */
    public function setExpiryAnnouncement(\StructType\ExpiryAnnouncementType $expiryAnnouncement = null)
    {
        $this->ExpiryAnnouncement = $expiryAnnouncement;
        return $this;
    }
    /**
     * Get ExpiryStatistics value
     * @return \StructType\ExpiryStatisticsType|null
     */
    public function getExpiryStatistics()
    {
        return $this->ExpiryStatistics;
    }
    /**
     * Set ExpiryStatistics value
     * @param \StructType\ExpiryStatisticsType $expiryStatistics
     * @return \StructType\AccountBalanceDetailType
     */
    public function setExpiryStatistics(\StructType\ExpiryStatisticsType $expiryStatistics = null)
    {
        $this->ExpiryStatistics = $expiryStatistics;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\AccountBalanceDetailType
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
