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
            //FIXME: Make the pos request here...
            $paymentValues = array("cardType" => $payment->getCcCid(),
                                   "expiresMonth" => $payment->getCcExpMonth(),
                                   "expiresYear" => $payment->getCcExpYear(),
                                   "cardHolderName" => $payment->getCcOwner(),
                                   "cardNumber" => $payment->getCcNumber(),
                                   "amount" => $amount,
                                   "orderId" => $orderId
                                  );
            $isPaymentAccepted = true;
        } catch (Exception $e) {
            $payment->setStatus(self::STATUS_ERROR);
            $payment->setAmount($amount);
            $payment->setLastTransId($orderId);
            $this->setStore($payment->getOrder()->getStoreId());
            Mage::throwException($e->getMessage());
        }
        if ($isPaymentAccepted) {
            $this->setStore($payment->getOrder()->getStoreId());
            $payment->setStatus(self::STATUS_APPROVED);
            $payment->setAmount($amount);
            $payment->setLastTransId($orderId);
        } else {
            $this->setStore($payment->getOrder()->getStoreId());
            $payment->setStatus(self::STATUS_DECLINED);
            $payment->setAmount($amount);
            $payment->setLastTransId($orderId);
        }
        return $this;
    }
}

