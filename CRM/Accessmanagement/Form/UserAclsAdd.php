<?php

use CRM_Accessmanagement_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Accessmanagement_Form_UserAclsAdd extends CRM_Core_Form {

  public function preProcess() {
    $this->contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this);
    $contact = civicrm_api3('Contact', 'getsingle', ['id' => $this->contactId]);
    CRM_Utils_System::setTitle(ts('Add an ACL Item for %1', [1 => $contact['display_name']]));
    parent::preProcess();
  }

  public function buildQuickForm() {

    // ACO selector
    $this->addEntityRef('aco', ts('Access Control Object'), [
      'entity' => 'AccessPoints',
      'api' => ['label_field' => 'ap_name'],
      'placeholder' => ts('- Select ACO -'),
      'select' => ['minimumInputLength' => 0]
    ], TRUE);


    // Cert by Contact  selector
    $this->addEntityRef('certified_by', ts('Certified by: '), [
      'entity' => 'Contact',
      'api' => ['label_field' => 'sort_name'],
      'placeholder' => ts('- Select Contact -'),
      'select' => ['minimumInputLength' => 0]
    ], FALSE);

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
    
     $this->add(
       'datepicker',
       'certification_date',
        ts('Certification Date'),
        array('class' => 'some-css-class'),
        TRUE,
        array('time' => FALSE, 'date' => 'mm-dd-yy', 'minDate' => '2000-01-01')
      );

     

    $this->add('text', 'notes', ts('Notes'));


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

    $params['contact_id'] = $this->contactId;
    $params['aco'] = $values['aco'];
    $params['status_id'] = $values['status_id'];
    $params['certification_date'] = CRM_Utils_Date::processDate($values['certification_date']);
    $params['cert_by_id'] = $values['certified_by'];
    $params['notes'] = $values['notes'];
    // Create new useracl for contact
    try {
      $status = civicrm_api3('UserAcls', 'create', $params);
    }
    catch (Exception $e) {
      $status = $e->getMessage();
    }
    CRM_Core_Session::setStatus($status);
    parent::postProcess();

    if ($this->contactId) {
      $this->ajaxResponse['updateTabs']['#tab_activity'] = CRM_Contact_BAO_Contact::getCountComponent('activity', $this->contactId);
    }

    $session = CRM_Core_Session::singleton();
    $session->replaceUserContext(CRM_Utils_System::url('civicrm/contact/view',
      "reset=1&cid={$this->contactId}&selectedChild=activity"
    ));
  }

}
