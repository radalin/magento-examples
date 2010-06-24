<?php

/**
 * Description of Payment
 *
 * @author roysimkes
 */
class Kartaca_Pos_Model_Payment extends Mage_Payment_Model_Method_Cc
{
    protected $_isGateway = true;
    protected $_canAuthorize = true;
    protected $_canUseCheckout = true;

    protected $_code = "pos";
    protected $_formBlockType = 'pos/payment_form_pos';

    public function authorize(Varien_Object $payment, $amount)
    {
        $orderId = $payment->getOrder()->getIncrementId();
        try {
            $paymentValues = array("cardType" => $payment->getCcCid(),
                                               "expiresMonth" => $payment->getCcExpMonth(),
                                               "expiresYear" => $payment->getCcExpYear(),
                                               "cardHolderName" => $payment->getCcOwner(),
                                               "cardNumber" => $payment->getCcNumber(),
                                               "amount" => $amount,
                                               "orderId" => $orderId,
                                               "bankId" => $payment->getOrder()->getPosBankId(), //Notice how I use the get methods?
                                               "installment" => $payment->getOrder()->getPosInstallment(),
                                              );
            //FIXME: Find a way to define this part in the $payment object which is Magento_Sales_Info or something like that.                      
            if ($bankid == 12) { //Different banks...
                $paymentValues['username'] = "my_bank_username";
                $paymentValues['password'] = "my_secret_password_generally_not_that_secret";
                $paymentValues['clientid'] = "my_clientid_given_to_me_by_the_bank";
            } else if ($bankid == 14) { //... can require different values to be sent to them
                $paymentValues['username'] = "my_second_bank_username";
                $paymentValues['password'] = "my_secret_password_generally_not_that_secret";
                $paymentValues['clientid'] = "my_clientid_given_to_me_by_the_bank";
                $paymentValues['additionalSecondBankField'] = "additional_info";
            } else {
                Mage::throwException("Invalid bankid: $bankid");
            }
            //Define the url where I'm making the request...                      
            $urlToPost = "https://my.bank.com/pos/service/address/";
            //Now Create the request which I will send via Post Method...
            //Create a string like: cardType=VI&expiresMonth=12&expiresYear=2011&amount=100.50
            $postData = "";
            foreach ($paymentValues as $key => $val) {
                $posData .= "{$key}=" . urlencode($val) . "&";
            }
            //Let's create a curl request and send the values above to the bank...
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $urlToPost);
            curl_setopt($ch, CURLOPT_TIMEOUT, 180);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); //Put the created string here in use...
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $data = curl_exec($ch); //This value is the string returned from the bank...
            if (!$data) {
                throw new Exception(curl_error($ch));
            }
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpcode && substr($httpcode, 0, 2) != "20") { //Unsuccessful post request...
                Mage::throwException("Returned HTTP CODE: " . $httpcode . " for this URL: " . $urlToPost);
            }
            curl_close($ch);
        } catch (Exception $e) {
            $payment->setStatus(self::STATUS_ERROR);
            $payment->setAmount($amount);
            $payment->setLastTransId($orderId);
            $this->setStore($payment->getOrder()->getStoreId());
            Mage::throwException($e->getMessage());
        }
        /*
         * Data outputted from the curl request
         *  is generally an xml string.
         * Assume that it is something like:
         *
         * <response>
         *   <isPaymentAccepted>1</isPaymentAccepted>
         *   <bankOrderId>1234233241</bankOrderId>
         * </response>
         *
         * However no bank response is never this simple by the way...
         * But this one gives you a general view of the thing.
         */
        $xmlResponse = new SimpleXmlElement($data); //Simple way to parse xml, Magento might have an equivalent class
        $isPaymentAccepted = $xmlResponse->isPaymentAccepted == 1;
        if ($isPaymentAccepted) {
            $this->setStore($payment->getOrder()->getStoreId());
            $payment->setStatus(self::STATUS_APPROVED);
            $payment->setAmount($amount);
            $payment->setLastTransId($orderId);
        } else {
            $this->setStore($payment->getOrder()->getStoreId());
            $payment->setStatus(self::STATUS_ERROR);
            //Throw an exception to fail the current transaction...
            Mage::throwException("Payment is not approved");
        }
        return $this;
    }
}

