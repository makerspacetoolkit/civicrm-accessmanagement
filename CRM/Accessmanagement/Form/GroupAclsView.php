<?php

use CRM_Accessmanagement_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Accessmanagement_Form_GroupAclsView extends CRM_Core_Form {
  public function buildQuickForm() {
    $this->groupAclId = CRM_Utils_Request::retrieve('gaid', 'Positive', $this, TRUE);
    $this->action = CRM_Utils_Request::retrieve('action', 'String', $this, TRUE);
    $this->assign('action', $this->action);

    $result = civicrm_api3('GroupAcls', 'get', ['id' => $this->groupAclId, 'sequential' => 1]);
    $groupAcl = $result['values'][0];
    $this->groupId = $groupAcl['group_id'];
    $this->aco = $groupAcl['aco'];
    $this->statusId = $groupAcl['status_id'];
    

    if ($this->action == CRM_Core_Action::DELETE) {
      CRM_Utils_System::setTitle('Delete Group ACL');
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
      CRM_Utils_System::setTitle('Edit Group ACL');
      // Civi Group Selector
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
      $defaults['group_id'] = $this->groupId; 
      $defaults['aco'] = $this->aco; 
      $defaults['status_id'] = $this->statusId; 
	  return $defaults;
  }

  public function postProcess() {
    $values = $this->exportValues();
    $params = $values;
    $params['id'] = $this->groupAclId;
    if ($this->action == CRM_Core_Action::DELETE) {
      if (!empty($this->groupAclId)) {
        $result = civicrm_api3('GroupAcls', 'delete', ['id' => $this->groupAclId]);
        return;
      }
    }
    elseif ($this->action == CRM_Core_Action::UPDATE) {
      try {
        $status = civicrm_api3('GroupAcls', 'create', $params);
      }
      catch (Exception $e) {
        $status = $e->getMessage();
      } 
    }
    parent::postProcess();
  }

}
