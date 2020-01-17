<?php

class CRM_Accessmanagement_Page_AJAX {

  public static function getUserAcls() {
    $params = $_GET;
    $requiredParams = array(
      'cid' => 'Integer',
    );
    $optionalParams = array(
      'aco_name' => 'String',
      'cert_by_name' => 'String',
      'certification_date' => 'String',
      'status' => 'String',
      'notes' => 'String',
    );
 //   $params = CRM_Core_Page_AJAX::defaultSortAndPagerParams();
 //   $params += CRM_Core_Page_AJAX::validateParams($requiredParams, $optionalParams);

    // get useracls list
    $userAcls = CRM_Accessmanagement_BAO_UserAcls::getUserAclsList($params);
    CRM_Utils_JSON::output($userAcls);
  }



  public static function getGroupAcls() {
    $params = $_GET;
    $requiredParams = array(
    //  'cid' => 'Integer',
    );
    $optionalParams = array(
      'group_id' => 'String',
      'aco' => 'String',
      'status_id' => 'String',
    );
//    $params = CRM_Core_Page_AJAX::defaultSortAndPagerParams();
 //   $params += CRM_Core_Page_AJAX::validateParams($requiredParams, $optionalParams);

    // get groupacls list
    $groupAcls = CRM_Accessmanagement_BAO_GroupAcls::getGroupAclsList($params);
    CRM_Utils_JSON::output($groupAcls);
  }



  public static function getAccessPoints() {
//    $params = $_GET;
    $requiredParams = array(
      'cid' => 'String',
    );
    $optionalParams = array(
      'ap_name' => 'String',
      'ap_short_name' => 'String',
      'ip_address' => 'String',
      'mac_address' => 'String',
      'member_rate' => 'String',
      'non_member_rate' => 'String',
      'idle_timeout' => 'String',
      'maintenance_mode' => 'Integer',
      'parent_id' => 'String',
    );
 //   try {
//    $params = CRM_Core_Page_AJAX::defaultSortAndPagerParams();
//    $params += CRM_Core_Page_AJAX::validateParams($requiredParams, $optionalParams);
//    }
//    catch (CiviCRM_API3_Exception $e) 
//    { 
//       $params = $e->getMessage();
//    }
    // get accesspoints list
    $accessPoints = CRM_Accessmanagement_BAO_AccessPoints::getAccessPointsList();
    CRM_Utils_JSON::output($accessPoints);
  }

    public static function getErrorCodes() {
    $params = $_GET;
    $requiredParams = array(
      'apid' => 'String',
    );
    $optionalParams = array(
      'error_key' => 'String',
      'error_value' => 'String',
    );
//    try {
//    $params = CRM_Core_Page_AJAX::defaultSortAndPagerParams();
//    $params += CRM_Core_Page_AJAX::validateParams($requiredParams, $optionalParams);
//    }
//    catch (CiviCRM_API3_Exception $e)
//    { echo 'fuck';
//    }
    // get ap errorcodes list
    $errorCodes = CRM_Accessmanagement_BAO_ApErrorCodes::getErrorCodesList($params);
    CRM_Utils_JSON::output($errorCodes);
  }


}
