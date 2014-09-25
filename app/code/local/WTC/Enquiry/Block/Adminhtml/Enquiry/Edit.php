<?php

class WTC_Enquiry_Block_Adminhtml_Enquiry_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                  
        $this->_objectId = 'id';
        $this->_blockGroup = 'enquiry';
        $this->_controller = 'adminhtml_enquiry';
         
        $this->_updateButton('save', 'label', Mage::helper('enquiry')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('enquiry')->__('Delete'));
         
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
		$this->_formScripts[] = " function saveAndContinueEdit(){
            editForm.submit($('edit_form').action+'back/edit/');
        }
    ";
    }

    public function getHeaderText()
    {
        return Mage::helper('enquiry')->__('Enquiry Details');
    }
}