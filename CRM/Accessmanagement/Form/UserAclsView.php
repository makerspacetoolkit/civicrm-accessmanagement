<?php

use CRM_Accessmanagement_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Accessmanagement_Form_UserAclsView extends CRM_Core_Form {
  public function buildQuickForm() {
    $this->userAclId = CRM_Utils_Request::retrieve('uaid', 'Positive', $this, TRUE);
    $this->contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, TRUE);
    $this->action = CRM_Utils_Request::retrieve('action', 'String', $this, TRUE);
    $this->assign('action', $this->action);

    $result = civicrm_api3('UserAcls', 'get', ['id' => $this->userAclId, 'sequential' => 1]);
    $userAcl = $result['values'][0];
    $this->aco = $userAcl['aco'];
    $this->statusId = $userAcl['status_id'];
    $this->certificationDate = $userAcl['certification_date'];
    $this->certById = $userAcl['cert_by_id'];
    if (array_key_exists('notes',$userAcl)) { 
      $this->notes = $userAcl['notes'];
    }
    $result['action'] = $this->action;  
    $result['delete'] = CRM_Core_Action::DELETE;  
    $result['update'] = CRM_Core_Action::UPDATE;  

	   
    if ($this->action == CRM_Core_Action::DELETE) {
      CRM_Utils_System::setTitle('Delete User ACL');
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
      CRM_Utils_System::setTitle('Edit User ACL');
    // ACO selector
    $this->addEntityRef('aco', ts('Access Control Object'), [
      'entity' => 'AccessPoints',
      'api' => ['label_field' => 'ap_name'],
      'placeholder' => ts('- Select ACO -'),
      'select' => ['minimumInputLength' => 0]
    ], TRUE);
    // Vert by Contact Selector 
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
      $defaults['aco'] = $this->aco; 
      $defaults['status_id'] = $this->statusId; 
      $defaults['certification_date'] = $this->certificationDate; 
      $defaults['certified_by'] = $this->certById; 
      if (isset($this->notes)) { 
        $defaults['notes'] = $this->notes;
      }
	  return $defaults;
  }

  public function postProcess() {
    $values = $this->exportValues();
    $params = $values;
    $params['id'] = $this->userAclId;
    $params['contact_id'] = $this->contactId;
    if ($this->action == CRM_Core_Action::DELETE) {
      if (!empty($this->userAclId)) {
        $result = civicrm_api3('UserAcls', 'delete', ['id' => $this->userAclId]);
        return;
      }
    }
    else { //if ($this->action == CRM_Core_Action::UPDATE) {
      try {
        $status = civicrm_api3('UserAcls', 'create', $params);
      }
      catch (Exception $e) {
        $status = $e->getMessage();
      } 
    }
    CRM_Core_Session::setStatus($status);
    //parent::postProcess();

    //if ($this->contactId) {
      $this->ajaxResponse['updateTabs']['#tab_activity'] = CRM_Contact_BAO_Contact::getCountComponent('activity', $this->contactId);
   // }
      try {
    $session = CRM_Core_Session::singleton();
    $session->replaceUserContext(CRM_Utils_System::url('civicrm/contact/view/useracls',
      "reset=1&cid={$this->contactId}&selectedChild=activity"
     ));
      }
      catch (Exception $e) {
        $session = $e->getMessage();
      } 
//     $this->ajaxResponse['reloadBlocks'] = array('#crm-useracls-page'); //[updateTabs']['#tab_activity'] = CRM_Accessmanagement_BAO_UserAcls::getUserAclsList($params);	 
  }

}
