<?php

use CRM_Accessmanagement_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Accessmanagement_Form_AccessPointView extends CRM_Core_Form {
  public function buildQuickForm() {
    $this->accessPointId = CRM_Utils_Request::retrieve('apid', 'Positive', $this, TRUE);
    $this->action = CRM_Utils_Request::retrieve('action', 'String', $this, TRUE);
    $this->assign('action', $this->action);
    $result['action'] = $this->action;
        $result['delete'] = CRM_Core_Action::DELETE;
        $result['update'] = CRM_Core_Action::UPDATE;
    $result = civicrm_api3('AccessPoints', 'get', ['id' => $this->accessPointId, 'sequential' => 1]);
    $accessPoint = $result['values'][0];
    $this->apName = $accessPoint['ap_name'];
    if (array_key_exists('ap_short_name', $accessPoint)) {
      $this->apShortName = $accessPoint['ap_short_name'];
    }
    if (array_key_exists('ip_address', $accessPoint)) {
      $this->ipAddress = $accessPoint['ip_address'];
    }
    if (array_key_exists('mac_address', $accessPoint)) {
      $this->macAddress = $accessPoint['mac_address'];
    }
    if (array_key_exists('member_rate', $accessPoint)) {
    $this->memberRate = $accessPoint['member_rate'];
    }
    if (array_key_exists('non_member_rate', $accessPoint)) {
    $this->nonMemberRate = $accessPoint['non_member_rate'];
    }
    if (array_key_exists('idle_timeout', $accessPoint)) {
    $this->idleTimeout = $accessPoint['idle_timeout'];
    }
    if (array_key_exists('parent_ap', $accessPoint)) {
    $this->parentAp = $accessPoint['parent_ap'];
    }
    $this->maintenanceMode = $accessPoint['maintenance_mode'];
    

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
      $this->add('text', 'ap_name', ts('AP Name'),TRUE);
      $this->add('text', 'ap_short_name', ts('AP Short Name'));
      $this->add('text', 'ip_address', ts('IP Address'));
      $this->add('text', 'mac_address', ts('MAC Address'));
      $this->add('text', 'member_rate', ts('Member Rate'));
      $this->add('text', 'non_member_rate', ts('Non-Member Rate'));
      $this->add('text', 'idle_timeout', ts('Idle Timeout'));

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
    $defaults['ap_name'] = $this->apName;
    if (isset($this->apShortName))  {
      $defaults['ap_short_name'] = $this->apShortName;
    }
    if (isset($this->ipAddress)) {
      $defaults['ip_address'] = $this->ipAddress;
    }
    if (isset($this->macAddress)) {
      $defaults['mac_address'] = $this->macAddress; 
    }
    if (isset($this->memberRate)) {
      $defaults['member_rate'] = $this->memberRate;
    }
    if (isset($this->nonMemberRate)) {
      $defaults['non_member_rate'] = $this->nonMemberRate;
    }
    if (isset($this->idleTimeout))  {
      $defaults['idle_timeout'] = $this->idleTimeout; 
    }
    if (isset($this->parentAp)) {
      $defaults['parent_ap'] = $this->parentAp; 
    }
    $defaults['maintenance_mode'] = $this->maintenanceMode;
	  return $defaults;
  }

  public function postProcess() {
    $values = $this->exportValues();
    $params = $values;
    $params['id'] = $this->accessPointId;
    if ($this->action == CRM_Core_Action::DELETE) {
      if (!empty($this->accessPointId)) {
        $result = civicrm_api3('AccessPoints', 'delete', ['id' => $this->accessPointId]);
        return;
      }
    }
    elseif ($this->action == CRM_Core_Action::UPDATE) {
      try {
        $status = civicrm_api3('AccessPoints', 'create', $params);
      }
      catch (Exception $e) {
        $status = $e->getMessage();
      } 

    }
    parent::postProcess();
  }

}
