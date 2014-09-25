<?php

class WTC_Enquiry_Model_Enquiry extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('enquiry/enquiry');
    }
	
	public function saveEnquiryData()
	{
		$model = Mage::getModel('enquiry/enquiry');
		$model->setName($_POST['name']);
		$model->setEmail($_POST['email']);
		$model->setTelephone($_POST['telephone']);
		$model->setComment($_POST['comment']);
		$model->save();
		return;
	}
}