<?php

class Kartaca_Pos_Model_Status extends Varien_Object
{
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 2;

    static public function getCollection()
    {
        return array (self::STATUS_DISABLED => Mage::helper('pos')->__('Disabled'),
                      self::STATUS_ENABLED => Mage::helper('pos')->__('Enabled'),
        );
    }

    static public function getOptionArray()
    {
        return array(
            array(
                'value'     => self::STATUS_ENABLED,
                'label'     => Mage::helper('pos')->__('Enabled'),
            ),
            array(
                'value'     => self::STATUS_DISABLED,
                'label'     => Mage::helper('pos')->__('Disabled'),
            ),
        );
    }
}