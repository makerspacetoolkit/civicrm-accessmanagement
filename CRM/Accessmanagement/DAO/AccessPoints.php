<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2019
 *
 * Generated from /home/kahuna/buildkit/build/d519/web/sites/default/files/civicrm/ext/org.makerspacetoolkit.accessmanagement/xml/schema/CRM/Accessmanagement/AccessPoints.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:3980aaa25d8fb9ea85f1037547954880)
 */

/**
 * Database access object for the AccessPoints entity.
 */
class CRM_Accessmanagement_DAO_AccessPoints extends CRM_Core_DAO {

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_mstk_access_points';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Unique AccessPoints ID
   *
   * @var int
   */
  public $id;

  /**
   * @var int
   */
  public $parent_id;

  /**
   * Full name
   *
   * @var string
   */
  public $ap_name;

  /**
   * Concise name for client view.
   *
   * @var string
   */
  public $ap_short_name;

  /**
   * v4 or v6
   *
   * @var string
   */
  public $ip_address;

  /**
   * @var string
   */
  public $mac_address;

  /**
   * @var float
   */
  public $member_rate;

  /**
   * @var float
   */
  public $non_member_rate;

  /**
   * @var int
   */
  public $idle_timeout;

  /**
   * @var bool
   */
  public $maintenance_mode;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_mstk_access_points';
    parent::__construct();
  }

  /**
   * Returns all the column names of this table
   *
   * @return array
   */
  public static function &fields() {
    if (!isset(Civi::$statics[__CLASS__]['fields'])) {
      Civi::$statics[__CLASS__]['fields'] = [
        'id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => CRM_Accessmanagement_ExtensionUtil::ts('Unique AccessPoints ID'),
          'required' => TRUE,
          'where' => 'civicrm_mstk_access_points.id',
          'table_name' => 'civicrm_mstk_access_points',
          'entity' => 'AccessPoints',
          'bao' => 'CRM_Accessmanagement_DAO_AccessPoints',
          'localizable' => 0,
        ],
        'parent_id' => [
          'name' => 'parent_id',
          'type' => CRM_Utils_Type::T_INT,
          'where' => 'civicrm_mstk_access_points.parent_id',
          'default' => 'null',
          'table_name' => 'civicrm_mstk_access_points',
          'entity' => 'AccessPoints',
          'bao' => 'CRM_Accessmanagement_DAO_AccessPoints',
          'localizable' => 0,
        ],
        'ap_name' => [
          'name' => 'ap_name',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => CRM_Accessmanagement_ExtensionUtil::ts('Ap Name'),
          'description' => CRM_Accessmanagement_ExtensionUtil::ts('Full name'),
          'required' => TRUE,
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'where' => 'civicrm_mstk_access_points.ap_name',
          'table_name' => 'civicrm_mstk_access_points',
          'entity' => 'AccessPoints',
          'bao' => 'CRM_Accessmanagement_DAO_AccessPoints',
          'localizable' => 0,
        ],
        'ap_short_name' => [
          'name' => 'ap_short_name',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => CRM_Accessmanagement_ExtensionUtil::ts('Ap Short Name'),
          'description' => CRM_Accessmanagement_ExtensionUtil::ts('Concise name for client view.'),
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'where' => 'civicrm_mstk_access_points.ap_short_name',
          'table_name' => 'civicrm_mstk_access_points',
          'entity' => 'AccessPoints',
          'bao' => 'CRM_Accessmanagement_DAO_AccessPoints',
          'localizable' => 0,
        ],
        'ip_address' => [
          'name' => 'ip_address',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => CRM_Accessmanagement_ExtensionUtil::ts('Ip Address'),
          'description' => CRM_Accessmanagement_ExtensionUtil::ts('v4 or v6'),
          'maxlength' => 39,
          'size' => CRM_Utils_Type::BIG,
          'where' => 'civicrm_mstk_access_points.ip_address',
          'table_name' => 'civicrm_mstk_access_points',
          'entity' => 'AccessPoints',
          'bao' => 'CRM_Accessmanagement_DAO_AccessPoints',
          'localizable' => 0,
        ],
        'mac_address' => [
          'name' => 'mac_address',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => CRM_Accessmanagement_ExtensionUtil::ts('Mac Address'),
          'maxlength' => 17,
          'size' => CRM_Utils_Type::MEDIUM,
          'where' => 'civicrm_mstk_access_points.mac_address',
          'table_name' => 'civicrm_mstk_access_points',
          'entity' => 'AccessPoints',
          'bao' => 'CRM_Accessmanagement_DAO_AccessPoints',
          'localizable' => 0,
        ],
        'member_rate' => [
          'name' => 'member_rate',
          'type' => CRM_Utils_Type::T_MONEY,
          'title' => CRM_Accessmanagement_ExtensionUtil::ts('Member Rate'),
          'precision' => [
            14,
            9,
          ],
          'where' => 'civicrm_mstk_access_points.member_rate',
          'default' => '0',
          'table_name' => 'civicrm_mstk_access_points',
          'entity' => 'AccessPoints',
          'bao' => 'CRM_Accessmanagement_DAO_AccessPoints',
          'localizable' => 0,
        ],
        'non_member_rate' => [
          'name' => 'non_member_rate',
          'type' => CRM_Utils_Type::T_MONEY,
          'title' => CRM_Accessmanagement_ExtensionUtil::ts('Non Member Rate'),
          'precision' => [
            14,
            9,
          ],
          'where' => 'civicrm_mstk_access_points.non_member_rate',
          'default' => '0',
          'table_name' => 'civicrm_mstk_access_points',
          'entity' => 'AccessPoints',
          'bao' => 'CRM_Accessmanagement_DAO_AccessPoints',
          'localizable' => 0,
        ],
        'idle_timeout' => [
          'name' => 'idle_timeout',
          'type' => CRM_Utils_Type::T_INT,
          'title' => CRM_Accessmanagement_ExtensionUtil::ts('Idle Timeout'),
          'where' => 'civicrm_mstk_access_points.idle_timeout',
          'default' => 'null',
          'table_name' => 'civicrm_mstk_access_points',
          'entity' => 'AccessPoints',
          'bao' => 'CRM_Accessmanagement_DAO_AccessPoints',
          'localizable' => 0,
        ],
        'maintenance_mode' => [
          'name' => 'maintenance_mode',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => CRM_Accessmanagement_ExtensionUtil::ts('Maintenance Mode'),
          'required' => TRUE,
          'where' => 'civicrm_mstk_access_points.maintenance_mode',
          'default' => 'false',
          'table_name' => 'civicrm_mstk_access_points',
          'entity' => 'AccessPoints',
          'bao' => 'CRM_Accessmanagement_DAO_AccessPoints',
          'localizable' => 0,
        ],
      ];
      //CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'fields_callback', Civi::$statics[__CLASS__]['fields']);
    }
    return Civi::$statics[__CLASS__]['fields'];
  }

  /**
   * Return a mapping from field-name to the corresponding key (as used in fields()).
   *
   * @return array
   *   Array(string $name => string $uniqueName).
   */
  public static function &fieldKeys() {
    if (!isset(Civi::$statics[__CLASS__]['fieldKeys'])) {
      Civi::$statics[__CLASS__]['fieldKeys'] = array_flip(CRM_Utils_Array::collect('name', self::fields()));
    }
    return Civi::$statics[__CLASS__]['fieldKeys'];
  }

  /**
   * Returns the names of this table
   *
   * @return string
   */
  public static function getTableName() {
    return self::$_tableName;
  }

  /**
   * Returns if this table needs to be logged
   *
   * @return bool
   */
  public function getLog() {
    return self::$_log;
  }

  /**
   * Returns the list of fields that can be imported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &import($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'mstk_access_points', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of fields that can be exported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &export($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'mstk_access_points', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of indices
   *
   * @param bool $localize
   *
   * @return array
   */
  public static function indices($localize = TRUE) {
    $indices = [
      'ap_name' => [
        'name' => 'ap_name',
        'field' => [
          0 => 'ap_name',
        ],
        'localizable' => FALSE,
        'unique' => TRUE,
        'sig' => 'civicrm_mstk_access_points::1::ap_name',
      ],
      'ip_address' => [
        'name' => 'ip_address',
        'field' => [
          0 => 'ip_address',
        ],
        'localizable' => FALSE,
        'unique' => TRUE,
        'sig' => 'civicrm_mstk_access_points::1::ip_address',
      ],
      'mac_address' => [
        'name' => 'mac_address',
        'field' => [
          0 => 'mac_address',
        ],
        'localizable' => FALSE,
        'unique' => TRUE,
        'sig' => 'civicrm_mstk_access_points::1::mac_address',
      ],
    ];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}
