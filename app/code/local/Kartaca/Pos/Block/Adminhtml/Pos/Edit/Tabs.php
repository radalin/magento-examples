<?php

class Kartaca_Pos_Block_Adminhtml_Pos_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('pos_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('pos')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('pos')->__('Item Information'),
          'title'     => Mage::helper('pos')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('pos/adminhtml_pos_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}