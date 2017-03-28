<?php

class MonetaWeb{


    private $merchantDomain = null;                               
    private $setefiPaymentGatewayDomain = null;            
    private $setefiPaymentGatewayDomainApi = null;
    private $terminalId = null;
    private $terminalPassword = null;

    public function __construct($config = null){

        if( $config == null){
            $config = array(
                'merchantDomain' => MERCHANT_DOMAIN,                               
                'setefiPaymentGatewayDomain' => SETEFI_PAYMENT_GATEWAY_DOMAIN,            
                'setefiPaymentGatewayDomainApi' => SETEFI_PAYMENT_GATEWAY_API,
                'terminalId' => TERMINAL_ID,
                'terminalPassword' => TERMINAL_PASSWORD 
            ) ;
        }

        $this->merchantDomain =  $config["merchantDomain"] ;
        $this->setefiPaymentGatewayDomain = $config["setefiPaymentGatewayDomain"] ;
        $this->setefiPaymentGatewayDomainApi = $config["setefiPaymentGatewayDomainApi"] ;
        $this->terminalId = $config["terminalId"] ;
        $this->terminalPassword = $config["terminalPassword"] ;
            
    } 


    public function prepare( $merchantOrderId , $amount, $descrizioneProdotto ){

        $parameters = array(
            'id' => $this->terminalId,
            'password' => $this->terminalPassword,
            'operationType' => 'initialize',
            'amount' =>  $amount ,
            'currencyCode' => '978',
            'language' => 'ITA',
            'responseToMerchantUrl' => $this->merchantDomain.'/notify',
            'recoveryUrl' => $this->merchantDomain.'/recovery',
            'merchantOrderId' =>  $merchantOrderId,
            'cardHolderName' => '',
            'cardHolderEmail'  => '',
            'description' => 'Descrizione',
            'customField' => '{"amount":"'. $amount .'","merchantOrderId" : "'. $merchantOrderId .'" }'       
        );   
           
        $response = $this->execute($parameters) ; 
                   
        if( $response !== false && $response !== null ){
            $paymentId = $response->paymentid;
            $paymentUrl = $response->hostedpageurl;   
            $securityToken = $response->securitytoken;  
            $setefiPaymentPageUrl = "$paymentUrl?PaymentID=$paymentId";
            global $payment_url;
            $payment_url = $setefiPaymentPageUrl;
            //header("Location: $setefiPaymentPageUrl");  
        }
    
    } 


    public function confirm($params){
       
        $jsonDataCustomField = json_decode( $params["customField"] ) ;
 
        $parameters = array(
            'id' => $this->terminalId,
            'password' => $this->terminalPassword,
            'operationType' => 'confirm',
            'amount' =>  $jsonDataCustomField->amount ,
            'currencyCode' => '978',        
            'merchantOrderId' =>  $jsonDataCustomField->merchantOrderId ,
            'paymentId' =>  $_GET['paymentid']   
        );
 
        $xmlResponse = $this->execute($parameters) ; 
          
        if( $xmlResponse == null  || $xmlResponse == false || $xmlResponse == "" ){
                
            return "FAILURE" ;  
        } 
        else{
             
            // Salvo Log   
            if( CCW_LOG_ECOMMERCE != '' && CCW_LOG_ECOMMERCE != null && CCW_LOG_ECOMMERCE != false){
            file_put_contents( CCW_LOG_ECOMMERCE .  $_GET['paymentid'] ."-CONFIRM.xml"  ,  $xmlResponse     )   ;    
            }                                                                        
            

            if( isset($xmlResponse->result) && $xmlResponse->result  == "CAPTURED" ){
                return  "SUCCESS" ;    
            }else{
                return "FAILURE" ;               
            }    
        }
 
    } 


    public function execute($parameters){
          
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $this->setefiPaymentGatewayDomain. $this->setefiPaymentGatewayDomainApi );
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_POST, true);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query($parameters));
        //curl_setopt($curlHandle, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
    
        $xmlResponse = curl_exec($curlHandle);
          $info = curl_getinfo($curlHandle);
        curl_close($curlHandle);
         

        if( $xmlResponse == null ||  $xmlResponse == '' ){
            return  false  ;  
        }   else{
            $response = new SimpleXMLElement($xmlResponse);
            return $response ;    
        }
 
    }  
 
}

?>