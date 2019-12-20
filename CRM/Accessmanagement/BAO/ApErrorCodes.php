<?php
use CRM_Accessmanagement_ExtensionUtil as E;

class CRM_Accessmanagement_BAO_ApErrorCodes extends CRM_Accessmanagement_DAO_ApErrorCodes {

  public static function create($params) {
    $className = 'CRM_Accessmanagement_DAO_ApErrorCodes';
    $entityName = 'ErrorCodes';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } 

    static function getErrorCodesCount() {
      // Get count of all user acls for contact
      $errorCodeCount = civicrm_api3('ApErrorCodes', 'getcount');

      return $errorCodeCount;
     }
		  
		 
  static function getErrorCodesList($params) {
    $params['sequential'] = 1;	  
    $params['aco'] = $params['apid'];
    $errorCodesList = civicrm_api3('ApErrorCodes', 'get', $params);
    
    $DT['data'] = array(); // Datatables requires the data element even if no data

    foreach ($errorCodesList['values'] as $errorCode) {
      
      // Add links
      $links = self::actionLinks();
      // Get mask
      $errorCode['edit'] = CRM_Core_Action::formLink($links,
               CRM_Core_Action::UPDATE,
         array(
            'ecid' => $errorCode['id'],
        ),
        ts('more')
      );	
      $errorCode['delete'] = CRM_Core_Action::formLink($links,
               CRM_Core_Action::DELETE,
         array(
            'ecid' => $errorCode['id'],
        ),
        ts('more')
      );	
      $DT['data'][] = $errorCode;
    }
    $DT['recordsTotal'] = self::getErrorCodesCount();
    $DT['recordsFiltered'] = $DT['recordsTotal'];
    
    return $DT;
  }

  static function actionLinks() {
    $links = array(
      CRM_Core_Action::UPDATE => array(
        'name' => ts('Edit'),
        'url' => 'civicrm/mstk/accesspoints/errorcodes/view',
        'qs' => 'reset=1&action=update&ecid=%%ecid%%',
        'title' => ts('VIEW ErrorCode'),
        'class' => 'crm-popup',
      ),
      CRM_Core_Action::DELETE => array(
        'name' => ts('Delete'),
        'url' => 'civicrm/mstk/accesspoints/errorcodes/view',
        'qs' => 'reset=1&action=delete&ecid=%%ecid%%',
        'title' => ts('Delete Error Code'),
        'class' => 'crm-popup',
      ),
    );
    return $links;
  }
 
} 
