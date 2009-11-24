<?php

class Kartaca_Pos_Block_Payment_Form_Pos extends Mage_Payment_Block_Form_Cc
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('pos/payment/form/pos.phtml');
    }

    public function getBankAvailableTypes()
    {
        return Mage::getSingleton("pos/bank")->getCollection();
    }
}
