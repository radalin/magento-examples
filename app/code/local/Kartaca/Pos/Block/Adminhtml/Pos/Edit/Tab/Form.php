<?php

class Kartaca_Pos_Block_Adminhtml_Pos_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('pos_form', array('legend'=>Mage::helper('pos')->__('Item information')));

        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('pos')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));

        $fieldset->addField('bank_url', 'text', array(
            'label'     => Mage::helper('pos')->__('Url'),
            'required'  => true,
            'name'      => 'bank_url',
        ));

        $fieldset->addField('username', 'text', array(
            'label'     => Mage::helper('pos')->__('Username'),
            'required'  => true,
            'name'      => 'username',
        ));

        $fieldset->addField('password', 'text', array(
            'label'     => Mage::helper('pos')->__('Password'),
            'required'  => true,
            'name'      => 'password',
        ));

        $fieldset->addField('bank_id', 'select', array(
            'label'     => Mage::helper('pos')->__('Bank Identifier'),
            'required'  => true,
            'name'      => 'bank_id',
            'values'    => Mage::getSingleton('pos/bank')->getOptionArray(),
        ));

        $fieldset->addField('currency', 'select', array(
            'label'     => Mage::helper('pos')->__('Currency'),
            'required'  => true,
            'name'      => 'currency',
            'values'    => Mage::getSingleton("pos/currency")->getOptionArray(),
        ));

        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('pos')->__('Status'),
            'name'      => 'status',
            'values'    => Mage::getSingleton("pos/status")->getOptionArray(),
        ));

        if ( Mage::getSingleton('adminhtml/session')->getPosData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getPosData());
            Mage::getSingleton('adminhtml/session')->setPosData(null);
        } elseif ( Mage::registry('pos_data') ) {
            $form->setValues(Mage::registry('pos_data')->getData());
        }
        return parent::_prepareForm();
    }
}