<?php

class WTC_Enquiry_Block_Adminhtml_Enquiry_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('edit_form', array('legend'=>Mage::helper('enquiry')->__('Enquiry information')));
     
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('enquiry')->__('Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      ));
	  
	  $fieldset->addField('email', 'text', array(
          'label'     => Mage::helper('enquiry')->__('Email'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'email',
      ));
	  
	  $fieldset->addField('city', 'text', array(
          'label'     => Mage::helper('enquiry')->__('City'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'city',
      ));
	  
	  $fieldset->addField('pincode', 'text', array(
          'label'     => Mage::helper('enquiry')->__('Pincode'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'pincode',
      ));
	  

     
      if ( Mage::getSingleton('adminhtml/session')->getEnquiryData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getEnquiryData());
          Mage::getSingleton('adminhtml/session')->setEnquiryData(null);
      } elseif ( Mage::registry('enquiry_data') ) {
          $form->setValues(Mage::registry('enquiry_data')->getData());
      }
      return parent::_prepareForm();
  }
}