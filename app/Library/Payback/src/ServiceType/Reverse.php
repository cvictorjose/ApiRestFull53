<?php

namespace ServiceType;

use \WsdlToPhp\PackageBase\AbstractSoapClientBase;

/**
 * This class stands for Reverse ServiceType
 * @subpackage Services
 */
class Reverse extends AbstractSoapClientBase
{
    /**
     * Method to call the operation originally named ReverseCollectEvent
     * @uses AbstractSoapClientBase::getSoapClient()
     * @uses AbstractSoapClientBase::setResult()
     * @uses AbstractSoapClientBase::getResult()
     * @uses AbstractSoapClientBase::saveLastError()
     * @param \StructType\ReverseCollectEventRequest $body
     * @return \StructType\ReverseCollectEventResponse|bool
     */
    public function ReverseCollectEvent(\StructType\ReverseCollectEventRequest $body)
    {
        try {
            $this->setResult(self::getSoapClient()->ReverseCollectEvent($body));
            return $this->getResult();
        } catch (\SoapFault $soapFault) {
            $this->saveLastError(__METHOD__, $soapFault);
            return false;
        }
    }
    /**
     * Returns the result
     * @see AbstractSoapClientBase::getResult()
     * @return \StructType\ReverseCollectEventResponse
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
