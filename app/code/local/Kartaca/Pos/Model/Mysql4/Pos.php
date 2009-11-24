<?php

class Kartaca_Pos_Model_Mysql4_Pos extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the pos_id refers to the key field in your database table.
        $this->_init('pos/pos', 'pos_id');
    }
}