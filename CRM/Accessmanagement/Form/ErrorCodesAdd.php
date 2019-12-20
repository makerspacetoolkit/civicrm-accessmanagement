<?php

use CRM_Accessmanagement_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Accessmanagement_Form_ErrorCodesAdd extends CRM_Core_Form {
  public function preProcess() {
    CRM_Utils_System::setTitle(ts('Add an Access Point Error Code Message'));
    parent::preProcess();
  }

  public function buildQuickForm() {
    $this->accessPointId = CRM_Utils_Request::retrieve('apid', 'Positive', $this, TRUE);

    $this->add('text', 'error_key', ts('Error Message Key'),TRUE);
    $this->add('textarea', 'error_value', ts('Error Message Value'),TRUE);

    $this->addButtons(array(
      array(
        'type' => 'cancel',
        'name' => ts('Cancel '),
        'isDefault' => TRUE,
      ),
      array(
        'type' => 'submit',
        'name' => ts('Add '),
        'isDefault' => TRUE,
      ),
    ));

    // export form elements
    parent::buildQuickForm();
  }

  public function postProcess() {
    
    $values = $this->exportValues();
    $session = CRM_Core_Session::singleton();
    $params = $values;
    $params['aco'] = $this->accessPointId; 
    try {
      $status = civicrm_api3('ApErrorCodes', 'create', $params);
	}
    catch (Exception $e) {
      $status = $e->getMessage();
    }
    CRM_Core_Session::setStatus($status);
    parent::postProcess();
  }

}
