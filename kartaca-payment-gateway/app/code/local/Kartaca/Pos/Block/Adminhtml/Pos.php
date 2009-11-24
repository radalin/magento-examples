<?php
class Kartaca_Pos_Block_Adminhtml_Pos extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_pos';
    $this->_blockGroup = 'pos';
    $this->_headerText = Mage::helper('pos')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('pos')->__('Add Item');
    parent::__construct();
  }
}