{*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.7                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2017                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
*}
<div id="accesspoints-page" class="view-content">
<div class="action-link">
  <a accesskey="N" href='{crmURL p="civicrm/accesspoints/add"}' class="button medium-popup"><span><i class="crm-i fa-comment"></i>_Add Access Point</span></a>
</div>
<table class="crm-accesspoints-selector crm-ajax-table" data-order='[[2,"desc"]]'>
  <thead>
  <tr>
    <th data-data="ap_name" cell-class="crm-accesspoints-ap_name crmf-title" class='crm-accesspoints-ap_name'>{ts}AP Name{/ts}</th>
    <th data-data="ap_short_name" cell-class="crm-accesspoints-ap_short_name" class='crm-accesspoints-ap_short_name'>{ts}AP Short Name{/ts}</th>
    <th data-data="ip_address" cell-class="crm-accesspoints-ip_address right" class='crm-accesspoints-ip_address'>{ts}IP Address{/ts}</th>
    <th data-data="mac_address" cell-class="crm-accesspoints-mac_address" class='crm-accesspoints-mac_address'>{ts}Mac Address{/ts}</th>
    <th data-data="member_rate" cell-class="crm-accesspoints-member_rate" class='crm-accesspoints-member_rate'>{ts}Member Rate{/ts}</th>
    <th data-data="non_member_rate" cell-class="crm-accesspoints-non_member_rate" class='crm-accesspoints-non_member_rate'>{ts}Non-Member Rate{/ts}</th>
    <th data-data="non_member_perdiem" cell-class="crm-accesspoints-non_member_perdeim" class='crm-accesspoints-non_member_perdiem'>{ts}Non-Mem. Perdiem{/ts}</th>
    <th data-data="parent_name" cell-class="crm-accesspoints-parent_name" class='crm-accesspoints-parent_name'>{ts}Parent AP{/ts}</th>
    <th data-data="idle_timeout" cell-class="crm-accesspoints-idle_timeout" class='crm-accesspoints-idle_timeout'>{ts}Idle Timeout{/ts}</th>
    <th data-data="dev_cmd" cell-class="crm-accesspoints-dev_cmd" class='crm-accesspoints-dev_cmd'>{ts}Dev :<br>Cmd{/ts}</th>
    <th data-data="maintenance_mode" cell-class="crm-accesspoints-maintenance_mode" class='crm-accesspoints-maintenance_mode'>{ts}Maint. Mode{/ts}</th>
    <th data-data="error_codes" data-orderable="false" cell-class="crm-accesspoints-error_codes" class='crm-accesspoints-error_codes'>&nbsp;</th>
    <th data-data="edit" data-orderable="false" cell-class="crm-accesspoints-edit" class='crm-accesspoints-edit'>&nbsp;</th>
    <th data-data="delete" data-orderable="false" cell-class="crm-accesspoints-delete" class='crm-accesspoints-delete'>&nbsp;</th>
  </tr>
  </thead>
</table>
</div>

{literal}
<script type="text/javascript">
    (function($) {
        var ZeroRecordText = {/literal}'{ts escape="js"}<div class="status messages">No Access Points have been created yet.{/ts}</div>'{literal};
        $('table.crm-accesspoints-selector').data({
            "ajax": {
                "url": {/literal}'{crmURL p="civicrm/ajax/accesspointslist" h=0"}'{literal},
                "data": function (d) {
                }
            },
            "language": {
                "zeroRecords": ZeroRecordText,
                "emptyTable": ZeroRecordText
            },
            "drawCallback": function(settings) {
                //Add data attributes to cells
                $('thead th', settings.nTable).each( function( index ) {
                    $.each(this.attributes, function() {
                        if(this.name.match("^cell-")) {
                            var cellAttr = this.name.substring(5);
                            var cellValue = this.value;
                            $('tbody tr', settings.nTable).each( function() {
                                $('td:eq('+ index +')', this).attr( cellAttr, cellValue );
                            });
                        }
                    });
                });
                //Reload table after draw
                $(settings.nTable).trigger('crmLoad');
            }
        });
        $('#crm-container')
            .on('click', 'a.button, a.action-item[href*="action=update"], a.action-item[href*="action=delete"]', CRM.popup)
            .on('crmPopupFormSuccess', 'a.button, a.action-item[href*="action=update"], a.action-item[href*="action=delete"]', function() {
                // Refresh datatable when form completes
                $('table.crm-accesspoints-selector').DataTable().draw();
            });
    })(CRM.$);
</script>
{/literal}

