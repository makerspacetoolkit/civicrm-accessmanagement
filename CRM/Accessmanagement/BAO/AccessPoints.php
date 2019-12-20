<?php
use CRM_Accessmanagement_ExtensionUtil as E;

class CRM_Accessmanagement_BAO_AccessPoints extends CRM_Accessmanagement_DAO_AccessPoints {

  /**
   * Create a new AccessPoints based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Accessmanagement_DAO_AccessPoints|NULL
   *
   */
  public static function create($params) {
    $className = 'CRM_Accessmanagement_DAO_AccessPoints';
    $entityName = 'AccessPoints';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } 

    static function getAccessPointsCount() {
      // Get count of all user acls for contact
      $accessPointCount = civicrm_api3('AccessPoints', 'getcount');

      return $accessPointCount;
     }
		  
		 
  static function getAccessPointsList($params) {

    $AccessPointsList = civicrm_api3('AccessPoints', 'get', [
      'sequential' => 1,
    ]);
    
    $DT['data'] = array(); // Datatables requires the data element even if no data

    foreach ($AccessPointsList['values'] as $accessPoint) {
    if (!array_key_exists('parent_id', $accessPoint)) {
	    $accessPoint['parent_name'] = " ";
    } else {
        $accessPoint['parent_name'] = civicrm_api3('AccessPoints', 'getvalue', [
          'return' => "ap_name",
          'id' => $accessPoint['parent_id'],
		]);
    };
 
    if (!array_key_exists('ap_short_name', $accessPoint)) {
	    $accessPoint['ap_short_name'] = " ";  
    }	 	    

    if (!array_key_exists('ip_address', $accessPoint)) {
	    $accessPoint['ip_address'] = " ";  
    }	 	    

    if (!array_key_exists('mac_address', $accessPoint)) {
	    $accessPoint['mac_address'] = " ";  
    }	 	    

    if (!array_key_exists('idle_timeout', $accessPoint)) {
	    $accessPoint['idle_timeout'] = " ";  
    }	 	    

    if (!array_key_exists('member_rate', $accessPoint)) {
	    $accessPoint['member_rate'] = " ";  
    } elseif  	 	    
     ($accessPoint['member_rate'] == NULL || $accessPoint['member_rate'] == "0.000000000") {
      $accessPoint['member_rate'] = "";
    } 
     	    
     
    if (!array_key_exists('non_member_rate', $accessPoint)) {
      $accessPoint['non_member_rate'] = " ";  
    } elseif 	 	    
     ($accessPoint['non_member_rate'] == NULL || $accessPoint['non_member_rate'] == "0.000000000") {
	    $accessPoint['non_member_rate'] = "";
    }
     
      $accessPoint['status']= civicrm_api3('OptionValue', 'getvalue', [
        'return' => "label",
        'option_group_id' => "accessmanagement_status_type",
        'value' => 1,
      ]);
      // Add links

    $links = self::actionLinks();
    $accessPoint['error_codes'] = CRM_Core_Action::formLink(
	    $links,
               CRM_Core_Action::ADD,
         array(
            'apid' => $accessPoint['id'],
        ),
        ts('more')
      );	

    $accessPoint['edit'] = CRM_Core_Action::formLink(
	    $links,
               CRM_Core_Action::UPDATE,
         array(
            'apid' => $accessPoint['id'],
        ),
        ts('more')
      );	
    
    $accessPoint['delete'] = CRM_Core_Action::formLink(
	    $links,
               CRM_Core_Action::DELETE,
         array(
            'apid' => $accessPoint['id'],
        ),
        ts('more')
      );	
    
    
      $DT['data'][] = $accessPoint;
    }
    $DT['recordsTotal'] = self::getAccessPointsCount();
    $DT['recordsFiltered'] = $DT['recordsTotal'];
    
    return $DT;
  }

  static function actionLinks() {
    $links = array(
      CRM_Core_Action::ADD => array(
        'name' => ts('Er.Codes'),
        'url' => 'civicrm/mstk/accesspoints/errorcodes',
        'qs' => 'reset=1&apid=%%apid%%',
        'title' => ts('Add Error Code Messages'),
        'class' => 'crm-page',
      ),
      CRM_Core_Action::UPDATE => array(
        'name' => ts('Edit'),
        'url' => 'civicrm/mstk/accesspoints/view',
        'qs' => 'reset=1&action=update&apid=%%apid%%',
        'title' => ts('VIEW AP'),
        'class' => 'crm-popup',
      ),
      CRM_Core_Action::DELETE => array(
        'name' => ts('Delete'),
        'url' => 'civicrm/mstk/accesspoints/view',
        'qs' => 'reset=1&action=delete&apid=%%apid%%',
        'title' => ts('Delete AP'),
        'class' => 'crm-popup',
      ),
    );
    return $links;
  }
 
} 
