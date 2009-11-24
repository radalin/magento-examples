<?php
class Kartaca_Pos_Block_Pos extends Mage_Core_Block_Template
{
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getPos()
    {
        if (!$this->hasData('pos')) {
            $this->setData('pos', Mage::registry('pos'));
        }
        return $this->getData('pos');

    }
}