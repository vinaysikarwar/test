<?php
class WTC_Enquiry_Block_Adminhtml_Enquiry extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_enquiry';
		$this->_blockGroup = 'enquiry';
		$this->_headerText = Mage::helper('enquiry')->__('All Enquiries');
		$this->_removeButton('add');
		parent::__construct();
	}
  
	public function getReplyUrl()
	{
		$url = Mage::getBaseUrl().'enquiry/admin_enquiry/reply';
		return $url;
  
	}
}