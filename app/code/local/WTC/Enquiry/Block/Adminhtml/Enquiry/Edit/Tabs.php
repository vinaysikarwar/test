<?php

class WTC_Enquiry_Block_Adminhtml_Enquiry_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('enquiry_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('enquiry')->__('Enquiry Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('enquiry')->__('Enquiry Information'),
          'title'     => Mage::helper('enquiry')->__('Enquiry Information'),
          'content'   => $this->getLayout()->createBlock('enquiry/adminhtml_enquiry_edit_tab_form')->toHtml(),
      ));
      
      return parent::_beforeToHtml();
  }
}