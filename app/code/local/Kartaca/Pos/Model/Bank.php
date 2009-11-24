<?php

/**
 * Description of Bank
 *
 * @author roysimkes
 */
class Kartaca_Pos_Model_Bank extends Varien_Object
{
    private $_bankList = array(
        101 => "Garanti",
        201 => "YapiKredi",
        202 => "Akbank",
        203 => "HSBC",
        //Add more static banks here...
    );

    public function getCollection()
    {
        return $this->_bankList;
    }

    public function getOptionArray()
    {
        $arr = array();
        foreach ($this->_bankList as $key => $val) {
            $arr[] = array(
                "value" => $key,
                "label" => Mage::helper("pos")->__($val),
            );
        }
        return $arr;
    }
}