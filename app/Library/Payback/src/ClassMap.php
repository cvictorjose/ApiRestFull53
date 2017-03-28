<?php
/**
 * Class which returns the class map definition
 * @package
 */
class ClassMap
{
    /**
     * Returns the mapping between the WSDL Structs and generated Structs' classes
     * This array is sent to the \SoapClient when calling the WS
     * @return string[]
     */
    final public static function get()
    {
        return array(
            'AccountBalanceDetailType' => '\\StructType\\AccountBalanceDetailType',
            'AuthorisedRequest' => '\\StructType\\AuthorisedRequest',
            'CollectEventType' => '\\StructType\\CollectEventType',
            'CommunicationContextType' => '\\StructType\\CommunicationContextType',
            'ConsumerAuthenticationType' => '\\StructType\\ConsumerAuthenticationType',
            'ConsumerIdentificationType' => '\\StructType\\ConsumerIdentificationType',
            'ExpiryAnnouncementType' => '\\StructType\\ExpiryAnnouncementType',
            'ExpiryStatisticsType' => '\\StructType\\ExpiryStatisticsType',
            'FaultDescriptorType' => '\\StructType\\FaultDescriptorType',
            'LegalUnitType' => '\\StructType\\LegalUnitType',
            'LoyaltyUnitType' => '\\StructType\\LoyaltyUnitType',
            'MemberAliasIdentificationType' => '\\StructType\\MemberAliasIdentificationType',
            'MemberIdentificationType' => '\\StructType\\MemberIdentificationType',
            'MessageResponse' => '\\StructType\\MessageResponse',
            'PartnerContextType' => '\\StructType\\PartnerContextType',
            'PurchaseItemDetails' => '\\StructType\\PurchaseItemDetails',
            'ReferencePurchaseDetailsType' => '\\StructType\\ReferencePurchaseDetailsType',
            'TransactionDetails' => '\\StructType\\TransactionDetails',
            'ProcessPurchaseEventRequest' => '\\StructType\\ProcessPurchaseEventRequest',
            'ProcessPurchaseEventResponse' => '\\StructType\\ProcessPurchaseEventResponse',
            'RefundPurchaseEventRequest' => '\\StructType\\RefundPurchaseEventRequest',
            'RefundPurchaseEventResponse' => '\\StructType\\RefundPurchaseEventResponse',
            'ReverseCollectEventRequest' => '\\StructType\\ReverseCollectEventRequest',
            'ReverseCollectEventResponse' => '\\StructType\\ReverseCollectEventResponse',
        );
    }
}
