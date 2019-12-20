<?php

use CRM_Accessmanagement_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Accessmanagement_Form_ErrorCodesView extends CRM_Core_Form {
  public function buildQuickForm() {
    $this->errorCodeId = CRM_Utils_Request::retrieve('ecid', 'Positive', $this, TRUE);
    $this->action = CRM_Utils_Request::retrieve('action', 'String', $this, TRUE);
    $this->assign('action', $this->action);

    $result = civicrm_api3('ApErrorCodes', 'get', ['id' => $this->errorCodeId, 'sequential' => 1]);
    $errorCode = $result['values'][0];
    $this->errorKey = $errorCode['error_key'];
    $this->errorValue = $errorCode['error_value'];
    

    if ($this->action == CRM_Core_Action::DELETE) {
      CRM_Utils_System::setTitle('Delete AP');
      $this->addButtons(array(
        array(
          'type' => 'cancel',
          'name' => ts('Cancel'),
          'isDefault' => TRUE,
        ),
        array(
          'type' => 'submit',
          'name' => ts('Delete'),
          'isDefault' => FALSE,
        ),
      ));
      return;
    }
    elseif ($this->action == CRM_Core_Action::UPDATE) {
      CRM_Utils_System::setTitle('Edit AccessPoint');
      $this->add('text', 'error_key', ts('Error Message Key'),TRUE);
      $this->add('textarea', 'error_value', ts('Error Message Value'));

      $this->addButtons(array(
        array(
          'type' => 'cancel',
          'name' => ts('Cancel'),
          'isDefault' => TRUE,
        ),
        array(
          'type' => 'submit',
          'name' => ts('Update'),
          'isDefault' => FALSE,
        ),
      ));
      return;
    }

    parent::buildQuickForm();
  }

  public function setDefaultValues() {
    $defaults = [];
      $defaults['error_key'] = $this->errorKey; 
      $defaults['error_value'] = $this->errorValue; 
	  return $defaults;
  }

  public function postProcess() {
    $values = $this->exportValues();
    $params = $values;
    $params['id'] = $this->errorCodeId;
    if ($this->action == CRM_Core_Action::DELETE) {
      if (!empty($this->errorCodeId)) {
        $result = civicrm_api3('ApErrorCodes', 'delete', ['id' => $this->errorCodeId]);
        return;
      }
    }
    elseif ($this->action == CRM_Core_Action::UPDATE) {
      try {
        $status = civicrm_api3('ApErrorCodes', 'create', $params);
      }
      catch (Exception $e) {
        $status = $e->getMessage();
      } 
    }
    parent::postProcess();
  }

}
