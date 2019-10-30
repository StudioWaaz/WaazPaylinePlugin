<?php

namespace Waaz\PaylinePlugin\Legacy;

use Payline\PaylineSDK;

/**
 * @author Ibes Mongabure <developpement@studiowaaz.com>
 */
class Payline
{

    /**
     * @var array
     */
    private $mandatoryFields = array(
        'merchant_id' => '',
        'access_key' => '',
        'environment' => '',
        'payment' => [
            'amount' => '',
            'currency' => '',
            'action' => '101',
            'mode' => 'CPT',
            'contractNumber' => '',
        ],
        'order' => [
            'amount' => '',
            'currency' => '',
            'date' => '',
        ],
        'version' => '3',
    );

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $token;

    public function __construct($key)
    {
        $this->key = $key;
        $this->mandatoryFields['order']['date'] = gmdate('d/m/Y h:i');
    }

    /**
     * @param $fields
     * @return $this
     */
    public function setFields($fields)
    {

        foreach ($fields as $field => $value){            
            if (is_array($value)){
                foreach ($value as $field2 => $value2){
                    if (empty($this->mandatoryFields[$field2]))
                        $this->mandatoryFields[$field][$field2] = $value2;
                }
            }else{
                if (empty($this->mandatoryFields[$field]))
                    $this->mandatoryFields[$field] = $value;
            }
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getRequest()
    {
        return $this->mandatoryFields;
    }

    public function executeRequest()
    {

        $request = $this->getRequest();
        // create an instance
        $paylineSDK = new PaylineSDK($request['merchant_id'], $request['access_key'], null, null, null, null, $request['environment']);

        // call a web service, for example doWebPayment
        $doWebPaymentRequest = array();
        
        // PAYMENT
        $doWebPaymentRequest['payment']['amount'] = $request['payment']['amount']; // this value has to be an integer amount is sent in cents
        $doWebPaymentRequest['payment']['currency'] = $request['payment']['currency']; // ISO 4217 code for euro
        $doWebPaymentRequest['payment']['action'] = $request['payment']['action']; // 101 stand for "authorization+capture"
        $doWebPaymentRequest['payment']['mode'] = $request['payment']['mode']; // one shot payment

        // ORDER
        $doWebPaymentRequest['order']['ref'] = $request['order']['ref']; // the reference of your order
        $doWebPaymentRequest['order']['amount'] = $request['order']['amount']; // may differ from payment.amount if currency is different
        $doWebPaymentRequest['order']['currency'] = $request['order']['currency']; // ISO 4217 code for euro
        $doWebPaymentRequest['order']['date'] = gmdate('d/m/Y h:i'); // ISO 4217 code for euro

        // CONTRACT NUMBERS
        $doWebPaymentRequest['payment']['contractNumber'] = $request['payment']['contractNumber'];

        // URL 
        $doWebPaymentRequest['cancelURL'] = $request['cancel_url'];
        $doWebPaymentRequest['returnURL'] = $request['return_url'];
        $doWebPaymentRequest['notificationURL'] = $request['notification_url'];

        $doWebPaymentResponse = $paylineSDK->doWebPayment($doWebPaymentRequest);

        $return = "<html><body><a id=\"payment_link\" href=\"".$doWebPaymentResponse['redirectURL']."\">Click here to pay</a>".
            "<script type=\"text/javascript\"> document.getElementById('payment_link').click(); </script>".
            "</body></html>";

        return $return;

        
    }
}
