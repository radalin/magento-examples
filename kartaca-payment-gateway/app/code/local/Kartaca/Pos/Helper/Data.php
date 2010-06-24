<?php 

class Kartaca_Pos_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function setPosInformations($observer)
    {
        $accId = $this->_getRequest()->getPost("pos_bank_id"); //Name of the form element in the previous parts might have been different, the same. that they are the same.
        $observer->getEvent()->getOrder()->setPosBankId($accId);

        $installment = $this->_getRequest()->getPost("pos_installment");
        $observer->getEvent()->getOrder()->setPosInstallment($installment);
    }
}
