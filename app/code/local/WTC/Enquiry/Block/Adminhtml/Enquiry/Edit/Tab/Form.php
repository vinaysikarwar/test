<?php

class WTC_Enquiry_Block_Adminhtml_Enquiry_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('tracking_form', array('legend'=>Mage::helper('enquiry')->__('Tracking information')));
	  $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('enquiry')->__('Name'),
          'required'  => true,
          'name'      => 'name',
      ));
	  
	  $fieldset->addField('email', 'text', array(
          'label'     => Mage::helper('enquiry')->__('Email'),
          'required'  => true,
          'name'      => 'email',
      ));
	  
	  $fieldset->addField('comment', 'editor', array(
          'label'     => Mage::helper('enquiry')->__('Comment'),
          'name'      => 'comment',
		  'style' => 'height:15em;',
          'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
      ));
	  
	  $fieldset->addField('reply', 'editor', array(
          'label'     => Mage::helper('enquiry')->__('Reply Message'),
          'name'      => 'reply',
		  'style' => 'height:15em;',
          'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
      ));
		
	  
		$Id = $this->getRequest()->getParam('id');
		$trackingModel  = Mage::getModel('enquiry/enquiry')->load($Id);
		if ($trackingModel->getId()) 
		{
			//Mage::register('tracking_data', $trackingModel);
			$form->setValues(Mage::registry('enquiry_data')->getData());
		}
		return parent::_prepareForm();
  }
	protected function _prepareLayout()
    {
        $return = parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        return $return;
    }
}