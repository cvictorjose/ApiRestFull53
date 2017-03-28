<?php

namespace ServiceType;

use \WsdlToPhp\PackageBase\AbstractSoapClientBase;

/**
 * This class stands for Refund ServiceType
 * @subpackage Services
 */
class Refund extends AbstractSoapClientBase
{
    /**
     * Method to call the operation originally named RefundPurchaseEvent
     * @uses AbstractSoapClientBase::getSoapClient()
     * @uses AbstractSoapClientBase::setResult()
     * @uses AbstractSoapClientBase::getResult()
     * @uses AbstractSoapClientBase::saveLastError()
     * @param \StructType\RefundPurchaseEventRequest $body
     * @return \StructType\RefundPurchaseEventResponse|bool
     */
    public function RefundPurchaseEvent(\StructType\RefundPurchaseEventRequest $body)
    {
        try {
            $this->setResult(self::getSoapClient()->RefundPurchaseEvent($body));
            return $this->getResult();
        } catch (\SoapFault $soapFault) {
            $this->saveLastError(__METHOD__, $soapFault);
            return false;
        }
    }
    /**
     * Returns the result
     * @see AbstractSoapClientBase::getResult()
     * @return \StructType\RefundPurchaseEventResponse
     */
    public function getResult()
    {
        return parent::getResult();
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
