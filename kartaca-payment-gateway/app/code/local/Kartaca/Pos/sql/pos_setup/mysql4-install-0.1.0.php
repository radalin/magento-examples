<?php $installer = $this;
/* @var $installer Mage_Sales_Model_Mysql4_Setup */
$installer->startSetup();

// Get ID of the entity model 'sales/order'.
$sql = 'SELECT entity_type_id FROM '.$this->getTable('eav_entity_type').' WHERE entity_type_code="order"';
$row = Mage::getSingleton('core/resource')
         ->getConnection('core_read')
	     ->fetchRow($sql);

// Create EAV-attribute for the order, bank id and installment
//These two fields are new for our setup script.
$c = array (
  'entity_type_id'  => $row['entity_type_id'],
  'attribute_code'  => 'pos_bank_id',
  'backend_type'    => 'decimal',     // MySQL-Datatype
  'frontend_input'  => 'text', // Type of the HTML form element
  'is_global'       => '1',
  'is_visible'      => '1',
  'is_required'     => '0',
  'is_user_defined' => '0',
  'frontend_label'  => 'Bank Id',
);
$attribute = new Mage_Eav_Model_Entity_Attribute();
$attribute->loadByCode($c['entity_type_id'], $c['attribute_code'])
          ->setStoreId(0)
          ->addData($c);
$attribute->save();

$c = array (
  'entity_type_id'  => $row['entity_type_id'],
  'attribute_code'  => 'pos_installment',
  'backend_type'    => 'decimal',     // MySQL-Datatype
  'frontend_input'  => 'text', // Type of the HTML form element
  'is_global'       => '1',
  'is_visible'      => '1',
  'is_required'     => '0',
  'is_user_defined' => '0',
  'frontend_label'  => 'Installment',
);
$attribute = new Mage_Eav_Model_Entity_Attribute();
$attribute->loadByCode($c['entity_type_id'], $c['attribute_code'])
          ->setStoreId(0)
          ->addData($c);
$attribute->save();

//Now create the required table...
//Remember these code block had already been created in the first part.
$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('pos')};
CREATE TABLE {$this->getTable('pos')} (
  `pos_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `bank_url` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `currency` VARCHAR(5) NOT NULL,
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`pos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS {$this->getTable('krtc_pos_drivers')};
CREATE TABLE {$this->getTable('krtc_pos_drivers')} (
  `pos_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `bank_url` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `currency` varchar(5) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `created_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`pos_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

");

$installer->endSetup();
