-- +--------------------------------------------------------------------+
-- | CiviCRM version 5                                                  |
-- +--------------------------------------------------------------------+
-- | Copyright CiviCRM LLC (c) 2004-2019                                |
-- +--------------------------------------------------------------------+
-- | This file is a part of CiviCRM.                                    |
-- |                                                                    |
-- | CiviCRM is free software; you can copy, modify, and distribute it  |
-- | under the terms of the GNU Affero General Public License           |
-- | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
-- |                                                                    |
-- | CiviCRM is distributed in the hope that it will be useful, but     |
-- | WITHOUT ANY WARRANTY; without even the implied warranty of         |
-- | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
-- | See the GNU Affero General Public License for more details.        |
-- |                                                                    |
-- | You should have received a copy of the GNU Affero General Public   |
-- | License and the CiviCRM Licensing Exception along                  |
-- | with this program; if not, contact CiviCRM LLC                     |
-- | at info[AT]civicrm[DOT]org. If you have questions about the        |
-- | GNU Affero General Public License or the licensing of CiviCRM,     |
-- | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
-- +--------------------------------------------------------------------+
--
-- Generated from schema.tpl
-- DO NOT EDIT.  Generated by CRM_Core_CodeGen
--


-- +--------------------------------------------------------------------+
-- | CiviCRM version 5                                                  |
-- +--------------------------------------------------------------------+
-- | Copyright CiviCRM LLC (c) 2004-2019                                |
-- +--------------------------------------------------------------------+
-- | This file is a part of CiviCRM.                                    |
-- |                                                                    |
-- | CiviCRM is free software; you can copy, modify, and distribute it  |
-- | under the terms of the GNU Affero General Public License           |
-- | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
-- |                                                                    |
-- | CiviCRM is distributed in the hope that it will be useful, but     |
-- | WITHOUT ANY WARRANTY; without even the implied warranty of         |
-- | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
-- | See the GNU Affero General Public License for more details.        |
-- |                                                                    |
-- | You should have received a copy of the GNU Affero General Public   |
-- | License and the CiviCRM Licensing Exception along                  |
-- | with this program; if not, contact CiviCRM LLC                     |
-- | at info[AT]civicrm[DOT]org. If you have questions about the        |
-- | GNU Affero General Public License or the licensing of CiviCRM,     |
-- | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
-- +--------------------------------------------------------------------+
--
-- Generated from drop.tpl
-- DO NOT EDIT.  Generated by CRM_Core_CodeGen
--
-- /*******************************************************
-- *
-- * Clean up the exisiting tables
-- *
-- *******************************************************/

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `civicrm_mstk_user_acls`;
DROP TABLE IF EXISTS `civicrm_mstk_group_acls`;
DROP TABLE IF EXISTS `civicrm_mstk_ap_error_codes`;
DROP TABLE IF EXISTS `civicrm_mstk_access_points`;

SET FOREIGN_KEY_CHECKS=1;
-- /*******************************************************
-- *
-- * Create new tables
-- *
-- *******************************************************/

-- /*******************************************************
-- *
-- * civicrm_mstk_access_points
-- *
-- * Things you want to control.
-- *
-- *******************************************************/
CREATE TABLE `civicrm_mstk_access_points` (


     `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'Unique AccessPoints ID',
     `parent_id` int unsigned   DEFAULT null ,
     `ap_name` varchar(255) NOT NULL   COMMENT 'Full name',
     `ap_short_name` varchar(255)    COMMENT 'Concise name for client view.',
     `ip_address` varchar(39)    COMMENT 'v4 or v6',
     `mac_address` varchar(17)    ,
     `member_rate` decimal(14,9)   DEFAULT 0 ,
     `non_member_rate` decimal(14,9)   DEFAULT 0 ,
     `idle_timeout` int unsigned   DEFAULT null ,
     `dev` varchar(64)    COMMENT 'Access Control Device in /dev/',
     `cmd` varchar(16)    COMMENT 'ACD command',
     `maintenance_mode` tinyint NOT NULL  DEFAULT false  
,
        PRIMARY KEY (`id`)
 
    ,     UNIQUE INDEX `ap_name`(
        ap_name
  )
  ,     UNIQUE INDEX `ip_address`(
        ip_address
  )
  ,     UNIQUE INDEX `mac_address`(
        mac_address
  )
  
 
)    ;

-- /*******************************************************
-- *
-- * civicrm_mstk_ap_error_codes
-- *
-- * FIXME
-- *
-- *******************************************************/
CREATE TABLE `civicrm_mstk_ap_error_codes` (


     `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'Unique ApErrorCodes ID',
     `aco` int unsigned NOT NULL   COMMENT 'FK to Access Points',
     `error_key` varchar(8) NOT NULL   ,
     `error_value` varchar(255) NOT NULL    
,
        PRIMARY KEY (`id`)
 
 
,          CONSTRAINT FK_civicrm_mstk_ap_error_codes_aco FOREIGN KEY (`aco`) REFERENCES `civicrm_mstk_access_points`(`id`) ON DELETE CASCADE  
)    ;

-- /*******************************************************
-- *
-- * civicrm_mstk_group_acls
-- *
-- * FIXME
-- *
-- *******************************************************/
CREATE TABLE `civicrm_mstk_group_acls` (


     `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'Unique GroupAcls ID',
     `group_id` int unsigned    COMMENT 'FK to Group',
     `aco` int unsigned    COMMENT 'FK to Access Points',
     `status_id` int unsigned NOT NULL    
,
        PRIMARY KEY (`id`)
 
 
,          CONSTRAINT FK_civicrm_mstk_group_acls_group_id FOREIGN KEY (`group_id`) REFERENCES `civicrm_group`(`id`) ON DELETE CASCADE,          CONSTRAINT FK_civicrm_mstk_group_acls_aco FOREIGN KEY (`aco`) REFERENCES `civicrm_mstk_access_points`(`id`) ON DELETE CASCADE  
)    ;

-- /*******************************************************
-- *
-- * civicrm_mstk_user_acls
-- *
-- * FIXME
-- *
-- *******************************************************/
CREATE TABLE `civicrm_mstk_user_acls` (


     `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'Unique User Acl Mapping ID',
     `contact_id` int unsigned    COMMENT 'FK to Contact',
     `aco` int unsigned NOT NULL   COMMENT 'FK to Access Points',
     `status_id` int unsigned NOT NULL   ,
     `certification_date` date NOT NULL   ,
     `cert_by_id` int unsigned    COMMENT 'FK to Contact',
     `notes` varchar(255)   DEFAULT null  
,
        PRIMARY KEY (`id`)
 
 
,          CONSTRAINT FK_civicrm_mstk_user_acls_contact_id FOREIGN KEY (`contact_id`) REFERENCES `civicrm_contact`(`id`) ON DELETE CASCADE,          CONSTRAINT FK_civicrm_mstk_user_acls_aco FOREIGN KEY (`aco`) REFERENCES `civicrm_mstk_access_points`(`id`) ON DELETE CASCADE,          CONSTRAINT FK_civicrm_mstk_user_acls_cert_by_id FOREIGN KEY (`cert_by_id`) REFERENCES `civicrm_contact`(`id`)   
)    ;

 
