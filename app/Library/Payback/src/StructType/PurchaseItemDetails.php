<?php

namespace StructType;

use \WsdlToPhp\PackageBase\AbstractStructBase;

/**
 * This class stands for PurchaseItemDetails StructType
 * Meta informations extracted from the WSDL
 * - documentation: Details of an Item that is part of a collect event
 * @subpackage Structs
 */
class PurchaseItemDetails extends AbstractStructBase
{
    /**
     * The PointsAmount
     * Meta informations extracted from the WSDL
     * - documentation: Points amount. Points credited for a single item | Type for representing amounts of loyalty currency (i.e. points)
     * - minOccurs: 0
     * - fractionDigits: 3
     * - totalDigits: 21
     * @var float
     */
    public $PointsAmount;
    /**
     * The ArticleNumber
     * Meta informations extracted from the WSDL
     * - documentation: Article number. Key number of a product at the partner's site | Data type to represent object identifiers that is valid 'outside' our system. It is used in certain scenarios when data is inserted into the PAYBACK system that
     * possesses valid unique identifiers in other systems of a partner. Example: A member enrollment request sent by a PAYBACK partner could contain an external reference id for the member (e.g. his customer number at the partner which is not unique in
     * PAYBACK but unique within the partner's organization). The same data format is used for external identifiers that must be loaded during data migration from old systems.
     * - minOccurs: 0
     * - maxLength: 36
     * - minLength: 1
     * @var string
     */
    public $ArticleNumber;
    /**
     * The ArticleDescription
     * Meta informations extracted from the WSDL
     * - documentation: Article description | This type gives a description of a product.
     * - minOccurs: 0
     * - maxLength: 60
     * - minLength: 1
     * @var string
     */
    public $ArticleDescription;
    /**
     * The ArticleEanCode
     * Meta informations extracted from the WSDL
     * - documentation: EAN code of an article | This type gives the EAN code of a product.
     * - minOccurs: 0
     * - maxLength: 30
     * - minLength: 1
     * @var string
     */
    public $ArticleEanCode;
    /**
     * The PartnerProductGroupCode
     * Meta informations extracted from the WSDL
     * - documentation: Code of a product group at the partner's site | This type gives the code of a product group.
     * - minOccurs: 0
     * - maxLength: 30
     * @var string
     */
    public $PartnerProductGroupCode;
    /**
     * The PartnerProductGroupName
     * Meta informations extracted from the WSDL
     * - documentation: Name of a product group at the partner's site | This type gives the name of a product group.
     * - minOccurs: 0
     * - maxLength: 30
     * - minLength: 1
     * @var string
     */
    public $PartnerProductGroupName;
    /**
     * The PartnerProductCategoryCode
     * Meta informations extracted from the WSDL
     * - documentation: Code of a product category at the partner's site | This type gives the code of a product category.
     * - minOccurs: 0
     * - maxLength: 30
     * - minLength: 1
     * @var string
     */
    public $PartnerProductCategoryCode;
    /**
     * The PartnerProductCategoryName
     * Meta informations extracted from the WSDL
     * - documentation: Name of a product category at the partner's site | This type gives the name of a product category.
     * - minOccurs: 0
     * - maxLength: 30
     * - minLength: 1
     * @var string
     */
    public $PartnerProductCategoryName;
    /**
     * The DepartmentCode
     * Meta informations extracted from the WSDL
     * - documentation: Department code | This type gives the code of a department.
     * - minOccurs: 0
     * - maxLength: 30
     * - minLength: 1
     * @var string
     */
    public $DepartmentCode;
    /**
     * The DepartmentName
     * Meta informations extracted from the WSDL
     * - documentation: Department name | This type gives the name of a department.
     * - minOccurs: 0
     * - maxLength: 30
     * - minLength: 1
     * @var string
     */
    public $DepartmentName;
    /**
     * The SupplierCode
     * Meta informations extracted from the WSDL
     * - documentation: Supplier code | This type gives the code of a supplier.
     * - minOccurs: 0
     * - maxLength: 30
     * - minLength: 1
     * @var string
     */
    public $SupplierCode;
    /**
     * The SupplierName
     * Meta informations extracted from the WSDL
     * - documentation: Supplier name | This type gives the name of a supplier.
     * - minOccurs: 0
     * - maxLength: 30
     * - minLength: 1
     * @var string
     */
    public $SupplierName;
    /**
     * The SupplierArticleNumber
     * Meta informations extracted from the WSDL
     * - documentation: Supplier article number | Data type to represent object identifiers that is valid 'outside' our system. It is used in certain scenarios when data is inserted into the PAYBACK system that possesses valid unique identifiers in other
     * systems of a partner. Example: A member enrollment request sent by a PAYBACK partner could contain an external reference id for the member (e.g. his customer number at the partner which is not unique in PAYBACK but unique within the partner's
     * organization). The same data format is used for external identifiers that must be loaded during data migration from old systems.
     * - minOccurs: 0
     * - maxLength: 36
     * - minLength: 1
     * @var string
     */
    public $SupplierArticleNumber;
    /**
     * The SingleTurnoverAmount
     * Meta informations extracted from the WSDL
     * - documentation: Single turnover amount including VAT. The article price of a single item | Type for representing amounts of legal currency
     * - minOccurs: 0
     * - fractionDigits: 3
     * - totalDigits: 21
     * @var float
     */
    public $SingleTurnoverAmount;
    /**
     * The Quantity
     * Meta informations extracted from the WSDL
     * - documentation: Quantity of items (negative values are allowed) | This type is used for representing quantities of any units.
     * - minOccurs: 0
     * - fractionDigits: 3
     * - totalDigits: 12
     * @var float
     */
    public $Quantity;
    /**
     * The QuantityUnitCode
     * Meta informations extracted from the WSDL
     * - documentation: Unit code of the given quantity | This type is used for representing units of quantities.
     * - minOccurs: 0
     * - maxLength: 30
     * - minLength: 1
     * - pattern: [a-zA-Z0-9]*
     * @var string
     */
    public $QuantityUnitCode;
    /**
     * The TotalTurnoverAmount
     * Meta informations extracted from the WSDL
     * - documentation: Total turnover amount. The total price of all items (quantity considered) including VAT (negative values are allowed) | Type for representing amounts of legal currency
     * - minOccurs: 0
     * - fractionDigits: 3
     * - totalDigits: 21
     * @var float
     */
    public $TotalTurnoverAmount;
    /**
     * The TotalRewardableAmount
     * Meta informations extracted from the WSDL
     * - documentation: Total rewardable amount. The rewardable amount of all items (quantity considered) including VAT (negative values are allowed) | Type for representing amounts of legal currency
     * - minOccurs: 0
     * - fractionDigits: 3
     * - totalDigits: 21
     * @var float
     */
    public $TotalRewardableAmount;
    /**
     * Constructor method for PurchaseItemDetails
     * @uses PurchaseItemDetails::setPointsAmount()
     * @uses PurchaseItemDetails::setArticleNumber()
     * @uses PurchaseItemDetails::setArticleDescription()
     * @uses PurchaseItemDetails::setArticleEanCode()
     * @uses PurchaseItemDetails::setPartnerProductGroupCode()
     * @uses PurchaseItemDetails::setPartnerProductGroupName()
     * @uses PurchaseItemDetails::setPartnerProductCategoryCode()
     * @uses PurchaseItemDetails::setPartnerProductCategoryName()
     * @uses PurchaseItemDetails::setDepartmentCode()
     * @uses PurchaseItemDetails::setDepartmentName()
     * @uses PurchaseItemDetails::setSupplierCode()
     * @uses PurchaseItemDetails::setSupplierName()
     * @uses PurchaseItemDetails::setSupplierArticleNumber()
     * @uses PurchaseItemDetails::setSingleTurnoverAmount()
     * @uses PurchaseItemDetails::setQuantity()
     * @uses PurchaseItemDetails::setQuantityUnitCode()
     * @uses PurchaseItemDetails::setTotalTurnoverAmount()
     * @uses PurchaseItemDetails::setTotalRewardableAmount()
     * @param float $pointsAmount
     * @param string $articleNumber
     * @param string $articleDescription
     * @param string $articleEanCode
     * @param string $partnerProductGroupCode
     * @param string $partnerProductGroupName
     * @param string $partnerProductCategoryCode
     * @param string $partnerProductCategoryName
     * @param string $departmentCode
     * @param string $departmentName
     * @param string $supplierCode
     * @param string $supplierName
     * @param string $supplierArticleNumber
     * @param float $singleTurnoverAmount
     * @param float $quantity
     * @param string $quantityUnitCode
     * @param float $totalTurnoverAmount
     * @param float $totalRewardableAmount
     */
    public function __construct($pointsAmount = null, $articleNumber = null, $articleDescription = null, $articleEanCode = null, $partnerProductGroupCode = null, $partnerProductGroupName = null, $partnerProductCategoryCode = null, $partnerProductCategoryName = null, $departmentCode = null, $departmentName = null, $supplierCode = null, $supplierName = null, $supplierArticleNumber = null, $singleTurnoverAmount = null, $quantity = null, $quantityUnitCode = null, $totalTurnoverAmount = null, $totalRewardableAmount = null)
    {
        $this
            ->setPointsAmount($pointsAmount)
            ->setArticleNumber($articleNumber)
            ->setArticleDescription($articleDescription)
            ->setArticleEanCode($articleEanCode)
            ->setPartnerProductGroupCode($partnerProductGroupCode)
            ->setPartnerProductGroupName($partnerProductGroupName)
            ->setPartnerProductCategoryCode($partnerProductCategoryCode)
            ->setPartnerProductCategoryName($partnerProductCategoryName)
            ->setDepartmentCode($departmentCode)
            ->setDepartmentName($departmentName)
            ->setSupplierCode($supplierCode)
            ->setSupplierName($supplierName)
            ->setSupplierArticleNumber($supplierArticleNumber)
            ->setSingleTurnoverAmount($singleTurnoverAmount)
            ->setQuantity($quantity)
            ->setQuantityUnitCode($quantityUnitCode)
            ->setTotalTurnoverAmount($totalTurnoverAmount)
            ->setTotalRewardableAmount($totalRewardableAmount);
    }
    /**
     * Get PointsAmount value
     * @return float|null
     */
    public function getPointsAmount()
    {
        return $this->PointsAmount;
    }
    /**
     * Set PointsAmount value
     * @param float $pointsAmount
     * @return \StructType\PurchaseItemDetails
     */
    public function setPointsAmount($pointsAmount = null)
    {
        // validation for constraint: fractionDigits
        if (is_float($pointsAmount) && strlen(substr($pointsAmount, strpos($pointsAmount, '.'))) !== 3) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 3 fraction digits, "%d" given', strlen(substr($pointsAmount, strpos($pointsAmount, '.')))), __LINE__);
        }
        // validation for constraint: totalDigits
        if (is_float($pointsAmount) && strlen(str_replace(array(' ', '.', ',', '-', '+'), '', $pointsAmount)) !== 21) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 21 digits, "%d" given', strlen(substr($pointsAmount, strpos($pointsAmount, '.')))), __LINE__);
        }
        $this->PointsAmount = $pointsAmount;
        return $this;
    }
    /**
     * Get ArticleNumber value
     * @return string|null
     */
    public function getArticleNumber()
    {
        return $this->ArticleNumber;
    }
    /**
     * Set ArticleNumber value
     * @param string $articleNumber
     * @return \StructType\PurchaseItemDetails
     */
    public function setArticleNumber($articleNumber = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($articleNumber) && strlen($articleNumber) > 36) || (is_array($articleNumber) && count($articleNumber) > 36)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 36 element(s) or a scalar of 36 character(s) at most, "%d" length given', is_scalar($articleNumber) ? strlen($articleNumber) : count($articleNumber)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($articleNumber) && strlen($articleNumber) < 1) || (is_array($articleNumber) && count($articleNumber) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($articleNumber) && !is_string($articleNumber)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($articleNumber)), __LINE__);
        }
        $this->ArticleNumber = $articleNumber;
        return $this;
    }
    /**
     * Get ArticleDescription value
     * @return string|null
     */
    public function getArticleDescription()
    {
        return $this->ArticleDescription;
    }
    /**
     * Set ArticleDescription value
     * @param string $articleDescription
     * @return \StructType\PurchaseItemDetails
     */
    public function setArticleDescription($articleDescription = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($articleDescription) && strlen($articleDescription) > 60) || (is_array($articleDescription) && count($articleDescription) > 60)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 60 element(s) or a scalar of 60 character(s) at most, "%d" length given', is_scalar($articleDescription) ? strlen($articleDescription) : count($articleDescription)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($articleDescription) && strlen($articleDescription) < 1) || (is_array($articleDescription) && count($articleDescription) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($articleDescription) && !is_string($articleDescription)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($articleDescription)), __LINE__);
        }
        $this->ArticleDescription = $articleDescription;
        return $this;
    }
    /**
     * Get ArticleEanCode value
     * @return string|null
     */
    public function getArticleEanCode()
    {
        return $this->ArticleEanCode;
    }
    /**
     * Set ArticleEanCode value
     * @param string $articleEanCode
     * @return \StructType\PurchaseItemDetails
     */
    public function setArticleEanCode($articleEanCode = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($articleEanCode) && strlen($articleEanCode) > 30) || (is_array($articleEanCode) && count($articleEanCode) > 30)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 30 element(s) or a scalar of 30 character(s) at most, "%d" length given', is_scalar($articleEanCode) ? strlen($articleEanCode) : count($articleEanCode)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($articleEanCode) && strlen($articleEanCode) < 1) || (is_array($articleEanCode) && count($articleEanCode) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($articleEanCode) && !is_string($articleEanCode)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($articleEanCode)), __LINE__);
        }
        $this->ArticleEanCode = $articleEanCode;
        return $this;
    }
    /**
     * Get PartnerProductGroupCode value
     * @return string|null
     */
    public function getPartnerProductGroupCode()
    {
        return $this->PartnerProductGroupCode;
    }
    /**
     * Set PartnerProductGroupCode value
     * @param string $partnerProductGroupCode
     * @return \StructType\PurchaseItemDetails
     */
    public function setPartnerProductGroupCode($partnerProductGroupCode = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($partnerProductGroupCode) && strlen($partnerProductGroupCode) > 30) || (is_array($partnerProductGroupCode) && count($partnerProductGroupCode) > 30)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 30 element(s) or a scalar of 30 character(s) at most, "%d" length given', is_scalar($partnerProductGroupCode) ? strlen($partnerProductGroupCode) : count($partnerProductGroupCode)), __LINE__);
        }
        // validation for constraint: string
        if (!is_null($partnerProductGroupCode) && !is_string($partnerProductGroupCode)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($partnerProductGroupCode)), __LINE__);
        }
        $this->PartnerProductGroupCode = $partnerProductGroupCode;
        return $this;
    }
    /**
     * Get PartnerProductGroupName value
     * @return string|null
     */
    public function getPartnerProductGroupName()
    {
        return $this->PartnerProductGroupName;
    }
    /**
     * Set PartnerProductGroupName value
     * @param string $partnerProductGroupName
     * @return \StructType\PurchaseItemDetails
     */
    public function setPartnerProductGroupName($partnerProductGroupName = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($partnerProductGroupName) && strlen($partnerProductGroupName) > 30) || (is_array($partnerProductGroupName) && count($partnerProductGroupName) > 30)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 30 element(s) or a scalar of 30 character(s) at most, "%d" length given', is_scalar($partnerProductGroupName) ? strlen($partnerProductGroupName) : count($partnerProductGroupName)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($partnerProductGroupName) && strlen($partnerProductGroupName) < 1) || (is_array($partnerProductGroupName) && count($partnerProductGroupName) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($partnerProductGroupName) && !is_string($partnerProductGroupName)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($partnerProductGroupName)), __LINE__);
        }
        $this->PartnerProductGroupName = $partnerProductGroupName;
        return $this;
    }
    /**
     * Get PartnerProductCategoryCode value
     * @return string|null
     */
    public function getPartnerProductCategoryCode()
    {
        return $this->PartnerProductCategoryCode;
    }
    /**
     * Set PartnerProductCategoryCode value
     * @param string $partnerProductCategoryCode
     * @return \StructType\PurchaseItemDetails
     */
    public function setPartnerProductCategoryCode($partnerProductCategoryCode = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($partnerProductCategoryCode) && strlen($partnerProductCategoryCode) > 30) || (is_array($partnerProductCategoryCode) && count($partnerProductCategoryCode) > 30)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 30 element(s) or a scalar of 30 character(s) at most, "%d" length given', is_scalar($partnerProductCategoryCode) ? strlen($partnerProductCategoryCode) : count($partnerProductCategoryCode)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($partnerProductCategoryCode) && strlen($partnerProductCategoryCode) < 1) || (is_array($partnerProductCategoryCode) && count($partnerProductCategoryCode) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($partnerProductCategoryCode) && !is_string($partnerProductCategoryCode)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($partnerProductCategoryCode)), __LINE__);
        }
        $this->PartnerProductCategoryCode = $partnerProductCategoryCode;
        return $this;
    }
    /**
     * Get PartnerProductCategoryName value
     * @return string|null
     */
    public function getPartnerProductCategoryName()
    {
        return $this->PartnerProductCategoryName;
    }
    /**
     * Set PartnerProductCategoryName value
     * @param string $partnerProductCategoryName
     * @return \StructType\PurchaseItemDetails
     */
    public function setPartnerProductCategoryName($partnerProductCategoryName = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($partnerProductCategoryName) && strlen($partnerProductCategoryName) > 30) || (is_array($partnerProductCategoryName) && count($partnerProductCategoryName) > 30)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 30 element(s) or a scalar of 30 character(s) at most, "%d" length given', is_scalar($partnerProductCategoryName) ? strlen($partnerProductCategoryName) : count($partnerProductCategoryName)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($partnerProductCategoryName) && strlen($partnerProductCategoryName) < 1) || (is_array($partnerProductCategoryName) && count($partnerProductCategoryName) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($partnerProductCategoryName) && !is_string($partnerProductCategoryName)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($partnerProductCategoryName)), __LINE__);
        }
        $this->PartnerProductCategoryName = $partnerProductCategoryName;
        return $this;
    }
    /**
     * Get DepartmentCode value
     * @return string|null
     */
    public function getDepartmentCode()
    {
        return $this->DepartmentCode;
    }
    /**
     * Set DepartmentCode value
     * @param string $departmentCode
     * @return \StructType\PurchaseItemDetails
     */
    public function setDepartmentCode($departmentCode = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($departmentCode) && strlen($departmentCode) > 30) || (is_array($departmentCode) && count($departmentCode) > 30)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 30 element(s) or a scalar of 30 character(s) at most, "%d" length given', is_scalar($departmentCode) ? strlen($departmentCode) : count($departmentCode)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($departmentCode) && strlen($departmentCode) < 1) || (is_array($departmentCode) && count($departmentCode) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($departmentCode) && !is_string($departmentCode)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($departmentCode)), __LINE__);
        }
        $this->DepartmentCode = $departmentCode;
        return $this;
    }
    /**
     * Get DepartmentName value
     * @return string|null
     */
    public function getDepartmentName()
    {
        return $this->DepartmentName;
    }
    /**
     * Set DepartmentName value
     * @param string $departmentName
     * @return \StructType\PurchaseItemDetails
     */
    public function setDepartmentName($departmentName = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($departmentName) && strlen($departmentName) > 30) || (is_array($departmentName) && count($departmentName) > 30)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 30 element(s) or a scalar of 30 character(s) at most, "%d" length given', is_scalar($departmentName) ? strlen($departmentName) : count($departmentName)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($departmentName) && strlen($departmentName) < 1) || (is_array($departmentName) && count($departmentName) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($departmentName) && !is_string($departmentName)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($departmentName)), __LINE__);
        }
        $this->DepartmentName = $departmentName;
        return $this;
    }
    /**
     * Get SupplierCode value
     * @return string|null
     */
    public function getSupplierCode()
    {
        return $this->SupplierCode;
    }
    /**
     * Set SupplierCode value
     * @param string $supplierCode
     * @return \StructType\PurchaseItemDetails
     */
    public function setSupplierCode($supplierCode = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($supplierCode) && strlen($supplierCode) > 30) || (is_array($supplierCode) && count($supplierCode) > 30)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 30 element(s) or a scalar of 30 character(s) at most, "%d" length given', is_scalar($supplierCode) ? strlen($supplierCode) : count($supplierCode)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($supplierCode) && strlen($supplierCode) < 1) || (is_array($supplierCode) && count($supplierCode) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($supplierCode) && !is_string($supplierCode)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($supplierCode)), __LINE__);
        }
        $this->SupplierCode = $supplierCode;
        return $this;
    }
    /**
     * Get SupplierName value
     * @return string|null
     */
    public function getSupplierName()
    {
        return $this->SupplierName;
    }
    /**
     * Set SupplierName value
     * @param string $supplierName
     * @return \StructType\PurchaseItemDetails
     */
    public function setSupplierName($supplierName = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($supplierName) && strlen($supplierName) > 30) || (is_array($supplierName) && count($supplierName) > 30)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 30 element(s) or a scalar of 30 character(s) at most, "%d" length given', is_scalar($supplierName) ? strlen($supplierName) : count($supplierName)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($supplierName) && strlen($supplierName) < 1) || (is_array($supplierName) && count($supplierName) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($supplierName) && !is_string($supplierName)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($supplierName)), __LINE__);
        }
        $this->SupplierName = $supplierName;
        return $this;
    }
    /**
     * Get SupplierArticleNumber value
     * @return string|null
     */
    public function getSupplierArticleNumber()
    {
        return $this->SupplierArticleNumber;
    }
    /**
     * Set SupplierArticleNumber value
     * @param string $supplierArticleNumber
     * @return \StructType\PurchaseItemDetails
     */
    public function setSupplierArticleNumber($supplierArticleNumber = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($supplierArticleNumber) && strlen($supplierArticleNumber) > 36) || (is_array($supplierArticleNumber) && count($supplierArticleNumber) > 36)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 36 element(s) or a scalar of 36 character(s) at most, "%d" length given', is_scalar($supplierArticleNumber) ? strlen($supplierArticleNumber) : count($supplierArticleNumber)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($supplierArticleNumber) && strlen($supplierArticleNumber) < 1) || (is_array($supplierArticleNumber) && count($supplierArticleNumber) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: string
        if (!is_null($supplierArticleNumber) && !is_string($supplierArticleNumber)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($supplierArticleNumber)), __LINE__);
        }
        $this->SupplierArticleNumber = $supplierArticleNumber;
        return $this;
    }
    /**
     * Get SingleTurnoverAmount value
     * @return float|null
     */
    public function getSingleTurnoverAmount()
    {
        return $this->SingleTurnoverAmount;
    }
    /**
     * Set SingleTurnoverAmount value
     * @param float $singleTurnoverAmount
     * @return \StructType\PurchaseItemDetails
     */
    public function setSingleTurnoverAmount($singleTurnoverAmount = null)
    {
        // validation for constraint: fractionDigits
        if (is_float($singleTurnoverAmount) && strlen(substr($singleTurnoverAmount, strpos($singleTurnoverAmount, '.'))) !== 3) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 3 fraction digits, "%d" given', strlen(substr($singleTurnoverAmount, strpos($singleTurnoverAmount, '.')))), __LINE__);
        }
        // validation for constraint: totalDigits
        if (is_float($singleTurnoverAmount) && strlen(str_replace(array(' ', '.', ',', '-', '+'), '', $singleTurnoverAmount)) !== 21) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 21 digits, "%d" given', strlen(substr($singleTurnoverAmount, strpos($singleTurnoverAmount, '.')))), __LINE__);
        }
        $this->SingleTurnoverAmount = $singleTurnoverAmount;
        return $this;
    }
    /**
     * Get Quantity value
     * @return float|null
     */
    public function getQuantity()
    {
        return $this->Quantity;
    }
    /**
     * Set Quantity value
     * @param float $quantity
     * @return \StructType\PurchaseItemDetails
     */
    public function setQuantity($quantity = null)
    {
        // validation for constraint: fractionDigits
        if (is_float($quantity) && strlen(substr($quantity, strpos($quantity, '.'))) !== 3) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 3 fraction digits, "%d" given', strlen(substr($quantity, strpos($quantity, '.')))), __LINE__);
        }
        // validation for constraint: totalDigits
        if (is_float($quantity) && strlen(str_replace(array(' ', '.', ',', '-', '+'), '', $quantity)) !== 12) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 12 digits, "%d" given', strlen(substr($quantity, strpos($quantity, '.')))), __LINE__);
        }
        $this->Quantity = $quantity;
        return $this;
    }
    /**
     * Get QuantityUnitCode value
     * @return string|null
     */
    public function getQuantityUnitCode()
    {
        return $this->QuantityUnitCode;
    }
    /**
     * Set QuantityUnitCode value
     * @param string $quantityUnitCode
     * @return \StructType\PurchaseItemDetails
     */
    public function setQuantityUnitCode($quantityUnitCode = null)
    {
        // validation for constraint: maxLength
        if ((is_scalar($quantityUnitCode) && strlen($quantityUnitCode) > 30) || (is_array($quantityUnitCode) && count($quantityUnitCode) > 30)) {
            throw new \InvalidArgumentException(sprintf('Invalid length, please provide an array with 30 element(s) or a scalar of 30 character(s) at most, "%d" length given', is_scalar($quantityUnitCode) ? strlen($quantityUnitCode) : count($quantityUnitCode)), __LINE__);
        }
        // validation for constraint: minLength
        if ((is_scalar($quantityUnitCode) && strlen($quantityUnitCode) < 1) || (is_array($quantityUnitCode) && count($quantityUnitCode) < 1)) {
            throw new \InvalidArgumentException('Invalid length, please provide an array with 1 element(s) or a scalar of 1 character(s) at least', __LINE__);
        }
        // validation for constraint: pattern
        if (is_scalar($quantityUnitCode) && !preg_match('/[a-zA-Z0-9]*/', $quantityUnitCode)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a scalar value that matches "[a-zA-Z0-9]*", "%s" given', var_export($quantityUnitCode, true)), __LINE__);
        }
        // validation for constraint: string
        if (!is_null($quantityUnitCode) && !is_string($quantityUnitCode)) {
            throw new \InvalidArgumentException(sprintf('Invalid value, please provide a string, "%s" given', gettype($quantityUnitCode)), __LINE__);
        }
        $this->QuantityUnitCode = $quantityUnitCode;
        return $this;
    }
    /**
     * Get TotalTurnoverAmount value
     * @return float|null
     */
    public function getTotalTurnoverAmount()
    {
        return $this->TotalTurnoverAmount;
    }
    /**
     * Set TotalTurnoverAmount value
     * @param float $totalTurnoverAmount
     * @return \StructType\PurchaseItemDetails
     */
    public function setTotalTurnoverAmount($totalTurnoverAmount = null)
    {
        // validation for constraint: fractionDigits
        if (is_float($totalTurnoverAmount) && strlen(substr($totalTurnoverAmount, strpos($totalTurnoverAmount, '.'))) !== 3) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 3 fraction digits, "%d" given', strlen(substr($totalTurnoverAmount, strpos($totalTurnoverAmount, '.')))), __LINE__);
        }
        // validation for constraint: totalDigits
        if (is_float($totalTurnoverAmount) && strlen(str_replace(array(' ', '.', ',', '-', '+'), '', $totalTurnoverAmount)) !== 21) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 21 digits, "%d" given', strlen(substr($totalTurnoverAmount, strpos($totalTurnoverAmount, '.')))), __LINE__);
        }
        $this->TotalTurnoverAmount = $totalTurnoverAmount;
        return $this;
    }
    /**
     * Get TotalRewardableAmount value
     * @return float|null
     */
    public function getTotalRewardableAmount()
    {
        return $this->TotalRewardableAmount;
    }
    /**
     * Set TotalRewardableAmount value
     * @param float $totalRewardableAmount
     * @return \StructType\PurchaseItemDetails
     */
    public function setTotalRewardableAmount($totalRewardableAmount = null)
    {
        // validation for constraint: fractionDigits
        if (is_float($totalRewardableAmount) && strlen(substr($totalRewardableAmount, strpos($totalRewardableAmount, '.'))) !== 3) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 3 fraction digits, "%d" given', strlen(substr($totalRewardableAmount, strpos($totalRewardableAmount, '.')))), __LINE__);
        }
        // validation for constraint: totalDigits
        if (is_float($totalRewardableAmount) && strlen(str_replace(array(' ', '.', ',', '-', '+'), '', $totalRewardableAmount)) !== 21) {
            throw new \InvalidArgumentException(sprintf('Invalid value, the value must at most contain 21 digits, "%d" given', strlen(substr($totalRewardableAmount, strpos($totalRewardableAmount, '.')))), __LINE__);
        }
        $this->TotalRewardableAmount = $totalRewardableAmount;
        return $this;
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see AbstractStructBase::__set_state()
     * @uses AbstractStructBase::__set_state()
     * @param array $array the exported values
     * @return \StructType\PurchaseItemDetails
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
