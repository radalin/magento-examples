<?php

class Kartaca_Pos_Model_Mysql4_Pos_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('pos/pos');
    }
}