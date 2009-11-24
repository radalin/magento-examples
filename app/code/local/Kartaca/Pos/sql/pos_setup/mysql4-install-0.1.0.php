<?php

$installer = $this;

$installer->startSetup();

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

    ");

$installer->endSetup(); 