<?php

class Kartaca_Pos_Block_Adminhtml_Pos_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('posGrid');
        $this->setDefaultSort('pos_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('pos/pos')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('pos_id', array(
            'header'    => Mage::helper('pos')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'pos_id',
        ));

        $this->addColumn('title', array(
            'header'    => Mage::helper('pos')->__('Title'),
            'align'     =>'left',
            'index'     => 'title',
        ));

        $this->addColumn('bank_id', array(
            'header'    => Mage::helper('pos')->__('Bank Identifier'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'bank_id',
            'type'      => 'options',
            'options'   => Mage::getSingleton("pos/bank")->getCollection(),
        ));

        $this->addColumn('currency', array(
            'header'    => Mage::helper('pos')->__('Currency'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'currency',
            'type'      => 'options',
            'options'   => Mage::getSingleton("pos/currency")->getCollection(),
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('pos')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => Mage::getSingleton("pos/status")->getCollection(),
        ));

        $this->addColumn('action',
            array(
            'header'    =>  Mage::helper('pos')->__('Action'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
            array(
            'caption'   => Mage::helper('pos')->__('Edit'),
            'url'       => array('base'=> '*/*/edit'),
            'field'     => 'id'
            )
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('pos')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('pos')->__('XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('pos_id');
        $this->getMassactionBlock()->setFormFieldName('pos');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'    => Mage::helper('pos')->__('Delete'),
            'url'      => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('pos')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('pos/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
            'label'=> Mage::helper('pos')->__('Change status'),
            'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
            'additional' => array(
            'visibility' => array(
            'name' => 'status',
            'type' => 'select',
            'class' => 'required-entry',
            'label' => Mage::helper('pos')->__('Status'),
            'values' => $statuses
            )
            )
        ));

        $this->getMassactionBlock()->addItem('currency', array(
            'label'=> Mage::helper('pos')->__('Change Currency'),
            'url'  => $this->getUrl('*/*/massCurrency', array('_current'=>true)),
            'additional' => array(
            'visibility' => array(
            'name' => 'currency',
            'type' => 'select',
            'class' => 'required-entry',
            'label' => Mage::helper('pos')->__('Currency'),
            'values' => Mage::getSingleton("pos/currency")->getOptionArray(),
            )
            )
        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}