<?php

use CRM_Accessmanagement_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Accessmanagement_Form_GroupAclsAdd extends CRM_Core_Form {

  public function preProcess() {
    CRM_Utils_System::setTitle(ts('Add Group ACL Item' ));
    parent::preProcess();
  }

  public function buildQuickForm() {

    // Civi Group selector
    $this->addEntityRef('group_id', ts('Civi Group'), [
      'entity' => 'Group',
     'api' => ['label_field' => 'title'],
      'placeholder' => ts('- Select Group -'),
      'select' => ['minimumInputLength' => 0]
    ], TRUE);

    // ACO selector
    $this->addEntityRef('aco', ts('Access Control Object'), [
      'entity' => 'AccessPoints',
      'api' => ['label_field' => 'ap_name'],
      'placeholder' => ts('- Select ACO -'),
      'select' => ['minimumInputLength' => 0]
    ], TRUE);


    $statusOptionValues = civicrm_api3('OptionValue', 'get', [
      'sequential' => 1,
      'return' => ["value", "name"],
      'option_group_id' => "accessmanagement_status_type",
    ]);

    $statusArray = [];
    foreach ($statusOptionValues['values'] as $sov) {
	    $statusArray[$sov['value']] = $sov['name'];
    };

    // Status selector
    $this->add('select', 'status_id', ts('Status'),
      ['' => ts('- select -')] + $statusArray, TRUE);
    

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

    $params['aco'] = $values['aco'];
    $params['status_id'] = $values['status_id'];
    $params['group_id'] = $values['group_id'];
    // Create new group acl 
    try {
      $status = civicrm_api3('GroupAcls', 'create', $params);
    }
    catch (Exception $e) {
      $status = $e->getMessage();
    }
    CRM_Core_Session::setStatus($status);
    //parent::postProcess();


    $session = CRM_Core_Session::singleton();
    $session->replaceUserContext(CRM_Utils_System::url('civicrm/mstk/groupacls',
      "reset=1"
    ));
  }

}
