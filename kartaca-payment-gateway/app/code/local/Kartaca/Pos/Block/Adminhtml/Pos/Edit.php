<?php

class Kartaca_Pos_Block_Adminhtml_Pos_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'pos';
        $this->_controller = 'adminhtml_pos';
        
        $this->_updateButton('save', 'label', Mage::helper('pos')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('pos')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('pos_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'pos_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'pos_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('pos_data') && Mage::registry('pos_data')->getId() ) {
            return Mage::helper('pos')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('pos_data')->getTitle()));
        } else {
            return Mage::helper('pos')->__('Add Item');
        }
    }
}