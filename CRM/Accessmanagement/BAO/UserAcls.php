<?php
use CRM_Accessmanagement_ExtensionUtil as E;

class CRM_Accessmanagement_BAO_UserAcls extends CRM_Accessmanagement_DAO_UserAcls {

  /**
   * Create a new UserAcls based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Accessmanagement_DAO_UserAcls|NULL
   *
   */
  public static function create($params) {
    $className = 'CRM_Accessmanagement_DAO_UserAcls';
    $entityName = 'UserAcls';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } 

    static function getUserAclsCount($contactId) {
      // Get count of all user acls for contact
      $useraclContactCount = civicrm_api3('UserAcls', 'getcount', [
        'contact_id' => $contactId,
      ]);

      return $useraclContactCount;
     }
		  

  static function getUserAclsList($params) {
    $params['sequential'] = 1;
    $params['contact_id'] = $params['cid'];
   // Get Option Group id from name
    $optionGroupId = civicrm_api3('OptionGroup', 'getvalue', [
      'return' => "id",
      'name' => "accessmanagement_status_type",
    ]);

    $userAclsList = civicrm_api3('UserAcls', 'get', [
      'sequential' => 1,
      'contact_id' => $params['contact_id'],
      'api.AccessPoints.getvalue' => ['id' => "\$value.aco", 'return' => "ap_name"],
      'api.Contact.getvalue' => ['id' => "\$value,cert_by_id", 'return' => "display_name"],
    ]);

    $DT['data'] = array(); // Datatables requires the data element even if no data

    foreach ($userAclsList['values'] as $userAcl) {
      $userAcl['aco_name'] = $userAcl['api.AccessPoints.getvalue'];     
      $userAcl['cert_by_name'] = $userAcl['api.Contact.getvalue'];
      $userAcl['formatted_date'] = CRM_Utils_Date::customFormat($userAcl['certification_date']);

      $userAcl['status']= civicrm_api3('OptionValue', 'getvalue', [
        'return' => "label",
        'option_group_id' => "accessmanagement_status_type",
        'value' => $userAcl['status_id'],
      ]);
      if (!array_key_exists('notes', $userAcl)) {
        $userAcl['notes'] = " ";
      }

      $links = self::actionLinks();
      $userAcl['edit'] = CRM_Core_Action::formLink(
        $links,
        CRM_Core_Action::UPDATE,
        array(
          'cid' => $userAcl['contact_id'],
          'uaid' => $userAcl['id'],
        ),
        ts('more')
       );

      $userAcl['delete'] = CRM_Core_Action::formLink(
        $links,
        CRM_Core_Action::DELETE,
        array(
          'cid' => $userAcl['contact_id'],
          'uaid' => $userAcl['id'],
        ),
        ts('more')
      );





      $DT['data'][] = $userAcl;
    }
    $DT['recordsTotal'] = self::getUserAclsCount($params['cid']);
    $DT['recordsFiltered'] = $DT['recordsTotal'];
    return $DT;
  }

  static function actionLinks() {
    $links = array(
      CRM_Core_Action::UPDATE => array(
        'name' => ts('Edit'),
        'url' => 'civicrm/contact/view/useracls/view',
        'qs' => 'reset=1&action=update&cid=%%cid%%&uaid=%%uaid%%',
        'title' => ts('VIEW ACL Item'),
        'class' => 'crm-popup',
      ),
      CRM_Core_Action::DELETE => array(
        'name' => ts('Delete'),
        'url' => 'civicrm/contact/view/useracls/view',
        'qs' => 'reset=1&action=delete&cid=%%cid%%&uaid=%%uaid%%',
        'title' => ts('Delete ACL Item'),
        'class' => 'crm-popup',
      ),
    );
    return $links;
  }
 
} 
