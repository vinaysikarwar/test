<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table wtc_enquiry_details(id int not null auto_increment, name varchar(255), email varchar(255), comment text, primary key(id));
SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 