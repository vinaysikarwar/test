<?php

class WTC_Enquiry_Adminhtml_EnquiryController extends Mage_Adminhtml_Controller_action
{
	
	const XML_PATH_EMAIL_RECIPIENT  = 'contacts/email/recipient_email';
    const XML_PATH_EMAIL_SENDER     = 'contacts/email/sender_email_identity';
    const XML_PATH_EMAIL_TEMPLATE   = 'contacts/email/email_template';
    const XML_PATH_ENABLED          = 'contacts/contacts/enabled';
	
	protected function _initAction() {
		$this->loadLayout()
		->_setActiveMenu('enquiry/items')
		->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

		return $this;
	}

	public function indexAction() {
		$this->_initAction()
		->renderLayout();
	}
	
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('enquiry/enquiry')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('enquiry_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('enquiry/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			//$this->_addContent($this->getLayout()->createBlock('enquiry/adminhtml_enquiry_edit'));
			$this->_addContent($this->getLayout()->createBlock('enquiry/adminhtml_enquiry_edit'))
			->_addLeft($this->getLayout()->createBlock('enquiry/adminhtml_enquiry_edit_tabs'));
			

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('manager')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
	
	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

			$model = Mage::getModel('enquiry/enquiry');
			$model->setData($data)
			->setId($this->getRequest()->getParam('id'));
			$id = $this->getRequest()->getParam('id');
			$reply =  $this->getRequest()->getParam('reply');
			$comment = $model->load($id)->getComment();
			$contactEmail = Mage::getStoreConfig('contacts/email/recipient_email');
			$contactName = Mage::getStoreConfig('contacts/email/sender_email_identity');
			$finalComment = $comment . '<br/>' . '<u><b>Reply By : ' . $contactName .'</b></u><br/>'. $reply;
			$enquiryData = Mage::getModel('enquiry/enquiry')->load($id);
			if($reply)
			{
				$model->setComment($finalComment)
				->setId($this->getRequest()->getParam('id'));
				$this->sendEnquiryEmail($reply,$finalComment,$enquiryData);
			}
 			try {

				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('enquiry')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('enquiry')->__('Unable to find item to save'));
		$this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('enquiry/enquiry');

				$model->setId($this->getRequest()->getParam('id'))
				->delete();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

	public function massDeleteAction() {
		$managerIds = $this->getRequest()->getParam('enquiry');
		if(!is_array($managerIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
		} else {
			try {
				foreach ($managerIds as $managerId) {
					$manager = Mage::getModel('enquiry/enquiry')->load($managerId);
					$manager->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(
				Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($managerIds)
				)
				);
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/index');
	}
	
	 public function exportCsvEnhancedAction()
    {
        $fileName   = 'enquiry-' . gmdate('YmdHis') . '.csv';
        $grid       = $this->getLayout()->createBlock('enquiry/adminhtml_enquiry_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFileEnhanced());
    }
	
	public function sendEnquiryEmail($reply,$finalComment,$enquiryData)
	{
		$contactEmail = Mage::getStoreConfig('contacts/email/recipient_email');
		$contactName = Mage::getStoreConfig('contacts/email/sender_email_identity');
		$mail = Mage::getModel('core/email');
		$mail->setToName($enquiryData->getName());
		$mail->setToEmail($enquiryData->getEmail());
		$mail->setBody($finalComment);
		$mail->setSubject('Shop Magento Extensions');
		$mail->setFromEmail($contactEmail);
		$mail->setFromName($contactName);
		$mail->setType('html');// YOu can use Html or text as Mail format
		try 
		{
			$mail->send();
		}
		catch (Exception $e) 
		{
			Mage::getSingleton('core/session')->addError('Unable to send.');
		}
		return;
	}
}