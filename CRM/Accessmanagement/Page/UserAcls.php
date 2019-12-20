<?php
use CRM_Accessmanagement_ExtensionUtil as E;

class CRM_Accessmanagement_Page_UserAcls extends CRM_Core_Page {

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('UserAcls'));

    // Example: Assign a variable for use in a template
    $this->assign('currentTime', date('Y-m-d H:i:s'));
        // Get contact Id
    $this->_contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, TRUE);
    $this->assign('contactId', $this->_contactId);
    
   // check logged in url permission
    CRM_Contact_Page_View::checkUserPermission($this);
    
    $this->ajaxResponse['tabCount'] = CRM_Accessmanagement_BAO_UserAcls::getUserAclsCount($this->_contactId);
    

    parent::run();
  }

}
