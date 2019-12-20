<?php
use CRM_Accessmanagement_ExtensionUtil as E;

class CRM_Accessmanagement_BAO_GroupAcls extends CRM_Accessmanagement_DAO_GroupAcls {

  /**
   * Create a new GroupAcls based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Accessmanagement_DAO_GroupAcls|NULL
   *
  public static function create($params) {
    $className = 'CRM_Accessmanagement_DAO_GroupAcls';
    $entityName = 'GroupAcls';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } */

  public static function create($params) {
    $className = 'CRM_Accessmanagement_DAO_GroupAcls';
    $entityName = 'GroupAcls';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } 

    static function getGroupAclsCount() {
      // Get count of all user acls for contact
      $groupAclCount = civicrm_api3('GroupAcls', 'getcount');

      return $groupAclCount;
     }
		  
		 
  static function getGroupAclsList($params) {

    $GroupAclsList = civicrm_api3('GroupAcls', 'get', [
      'sequential' => 1,
    ]);
    
    $DT['data'] = array(); // Datatables requires the data element even if no data

    foreach ($GroupAclsList['values'] as $groupAcl) {
    
      $groupAcl['civigroup_name']= civicrm_api3('Group', 'getvalue', [
        'return' => "title",
        'id' => $groupAcl['group_id'],
      ]);

      $groupAcl['aco_name']= civicrm_api3('AccessPoints', 'getvalue', [
        'return' => "ap_name",
        'id' => $groupAcl['aco'],
      ]);

      $groupAcl['status']= civicrm_api3('OptionValue', 'getvalue', [
        'return' => "label",
        'option_group_id' => "accessmanagement_status_type",
        'value' => $groupAcl['status_id'],
      ]);
       
      
      // Add links
      $links = self::actionLinks();
      $groupAcl['edit'] = CRM_Core_Action::formLink(
        $links,
        CRM_Core_Action::UPDATE,
        array(
         'gaid' => $groupAcl['id'],
        ),
        ts('more')
      );
       
      $groupAcl['delete'] = CRM_Core_Action::formLink(
        $links,
        CRM_Core_Action::DELETE,
        array(
         'gaid' => $groupAcl['id'],
        ),
        ts('more')
      );
       
      $DT['data'][] = $groupAcl;
    };
    $DT['recordsTotal'] = self::getGroupAclsCount();
    $DT['recordsFiltered'] = $DT['recordsTotal'];
    
    return $DT;
  }

  static function actionLinks() {
    $links = array(
      CRM_Core_Action::UPDATE => array(
        'name' => ts('Edit'),
        'url' => 'civicrm/mstk/groupacls/view',
        'qs' => 'reset=1&action=update&gaid=%%gaid%%',
        'title' => ts('VIEW ACL Item'),
        'class' => 'crm-popup',
      ),
      CRM_Core_Action::DELETE => array(
        'name' => ts('Delete'),
        'url' => 'civicrm/mstk/groupacls/view',
        'qs' => 'reset=1&action=delete&gaid=%%gaid%%',
        'title' => ts('Delete ACL Item'),
        'class' => 'crm-popup',
      ),
    );
    return $links;
  }
 
} 
