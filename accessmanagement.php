<?php

require_once 'accessmanagement.civix.php';
use CRM_Accessmanagement_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/ 
 */
function accessmanagement_civicrm_config(&$config) {
  _accessmanagement_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function accessmanagement_civicrm_xmlMenu(&$files) {
  _accessmanagement_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function accessmanagement_civicrm_install() {
  _accessmanagement_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function accessmanagement_civicrm_postInstall() {
  _accessmanagement_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function accessmanagement_civicrm_uninstall() {
  _accessmanagement_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function accessmanagement_civicrm_enable() {
  _accessmanagement_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function accessmanagement_civicrm_disable() {
  _accessmanagement_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function accessmanagement_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _accessmanagement_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function accessmanagement_civicrm_managed(&$entities) {
  _accessmanagement_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function accessmanagement_civicrm_caseTypes(&$caseTypes) {
  _accessmanagement_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function accessmanagement_civicrm_angularModules(&$angularModules) {
  _accessmanagement_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function accessmanagement_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _accessmanagement_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function accessmanagement_civicrm_entityTypes(&$entityTypes) {
  _accessmanagement_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_thems().
 */
function accessmanagement_civicrm_themes(&$themes) {
  _accessmanagement_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *
function accessmanagement_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 *
function accessmanagement_civicrm_navigationMenu(&$menu) {
  _accessmanagement_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _accessmanagement_civix_navigationMenu($menu);
} // */

/**
 * Implementation of hook_civicrm_tabs
 */

function accessmanagement_civicrm_navigationMenu(&$menu) {
  _accessmanagement_civix_insert_navigation_menu($menu, NULL, array(
   'label' => E::ts('Makerspace'),
   'name' => 'accessmanagement_manage',
   'url' => NULL,
   'permission' => NULL,
   'operator' => NULL,
   'separator' => 0,
    ));

  _accessmanagement_civix_insert_navigation_menu($menu, 'accessmanagement_manage', array(
   'label' => E::ts('AccessPoints'),
   'name' => 'accessmanagement_accesspoints',
   'url' => 'civicrm/mstk/accesspoints',
   'permission' => NULL,
   'operator' => NULL,
   'separator' => 0,
    ));

  _accessmanagement_civix_insert_navigation_menu($menu, 'accessmanagement_manage', array(
   'label' => E::ts('Group ACLs'),
   'name' => 'accessmanagement_groupacls',
   'url' => 'civicrm/mstk/groupacls',
   'permission' => NULL,
   'operator' => NULL,
   'separator' => 1,
    ));
}




function accessmanagement_civicrm_tabs( &$tabs, $contactID ) {
  $session = CRM_Core_Session::singleton();

  $is_admin = CRM_Core_Permission::check('administer CiviCRM') && CRM_Core_Permission::check('edit all contacts');
  $is_myself = ($contactID && ($contactID == $session->get('userID')));
  if ($is_admin || $is_myself) {
    $url = CRM_Utils_System::url( 'civicrm/contact/view/useracls', "reset=1&cid={$contactID}" );
    $tabs[] = array(
      'id' => 'useracls',
      'url' => $url,
      'title' => 'User Access Control',
      'weight' => 9998,
    );
  }
}


