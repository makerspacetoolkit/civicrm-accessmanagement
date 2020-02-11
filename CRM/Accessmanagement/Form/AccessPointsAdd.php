<?php

use CRM_Accessmanagement_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Accessmanagement_Form_AccessPointsAdd extends CRM_Core_Form {

  public function preProcess() {
    CRM_Utils_System::setTitle(ts('Add an Access Point'));
    parent::preProcess();
  }

  public function buildQuickForm() {

    $this->addElement('checkbox',
      'has_acd',
      ts('Is there an access control device associated with the AP?'), NULL,
     ['onclick' => "showAcdOptions()"],FALSE
    );

    $this->addElement('checkbox',
      'is_ap_group',
      ts('Is this s group of APs?'), NULL,
     ['onclick' => "hideStandaloneOptions()"],TRUE
    );

    $this->add('checkbox', 'load_defaults', ts('Load default error messages?'), '   (Recommended tor terminals)');
    $this->add('text', 'ap_name', ts('AP Name'),TRUE);
    $this->add('text', 'ap_short_name', ts('AP Short Name'));
    $this->add('text', 'ip_address', ts('IP Address'));
    $this->add('text', 'mac_address', ts('MAC Address'));
    $this->add('text', 'member_rate', ts('Member Rate  (Currency / Minute)'));
    $this->add('text', 'non_member_rate', ts('Non-Member Rate  (Currency / Minute)'));
    $this->add('text', 'non_member_perdiem', ts('Non-Member Perdiem $'));
    $this->add('text', 'idle_timeout', ts('Idle timeout'));
    $this->add('text', 'dev', ts('Access Control Device under /dev/ <b>*</b>'));
    $this->add('text', 'cmd', ts('Command to echo to device <b>*</b>'));

    // Parent  selector
    $this->addEntityRef('parent_id', ts('Parent AP'), [
      'entity' => 'AccessPoints',
      'api' => ['label_field' => 'ap_name'],
      'placeholder' => ts('- Select Parent -'),
      'select' => ['minimumInputLength' => 0]
    ], FALSE);
    
    $this->add('select', 'maintenance_mode', ts('Maintenance Mode'),array('0'=> 'FALSE','1' => 'TRUE'),TRUE);



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

  public function setDefaultValues() {
    list($defaults['scheduled_date'], $defaults['scheduled_date_time']) = CRM_Utils_Date::setDateDefaults(date('Y-m-d'), 'activityDateTime');

    return $defaults;
  }

  public function postProcess() {
    
    $values = $this->exportValues();
    $session = CRM_Core_Session::singleton();
    $params = $values;
    if ($values['load_defaults'] == 1) {
	 $defaultErrors = civicrm_api3('OptionValue', 'get', [
          'sequential' => 1,
        'return' => ["name", "value"],
        'option_group_id' => "accessmanagement_default_error_codes",
          ]);
    }
   // Create AP and optionally default error code messages
    try {
      $status = civicrm_api3('AccessPoints', 'create', $params);
      if ($values['load_defaults'] == 1) {
        foreach ($defaultErrors['values'] as $defaultError) {
          $result = civicrm_api3('ApErrorCodes', 'create', [
           'aco' => $status['id'],
           'error_key' => $defaultError['name'],
           'error_value' => $defaultError['value'],
          ]);
	}
      }
    }
    catch (Exception $e) {
      $status = $e->getMessage();
    }
    CRM_Core_Session::setStatus($status);
    parent::postProcess();

    $session = CRM_Core_Session::singleton();
    $session->replaceUserContext(CRM_Utils_System::url('civicrm/mstk/accesspoints',
      "reset=1&selectedChild=activity"
    ));
  }

}
