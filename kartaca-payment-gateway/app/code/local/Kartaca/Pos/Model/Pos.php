<?php

class Kartaca_Pos_Model_Pos extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('pos/pos');
    }
}