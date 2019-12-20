<?php
use CRM_Accessmanagement_ExtensionUtil as E;

class CRM_Accessmanagement_Page_ErrorCodes extends CRM_Core_Page {

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('ErrorCodes'));

        $this->_accessPointId = CRM_Utils_Request::retrieve('apid', 'Positive', $this, TRUE);
        $this->assign('accessPointId', $this->_accessPointId);
        $result = civicrm_api3('AccessPoints', 'getvalue', [
          'return' => "ap_name",
          'id' => $this->_accessPointId,
        ]);
        $this->assign('accessPointName', $result);

    parent::run();
  }

}
