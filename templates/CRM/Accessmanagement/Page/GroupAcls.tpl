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
<div id="groupacls" class="view-content">
<div class="action-link">
  <a accesskey="N" href='{crmURL p="civicrm/groupacls/add" q="cid=`$contactId`"}' class="button medium-popup"><span><i class="crm-i fa-comment"></i>_Add Group ACL</span></a>
</div>

<table class="crm-groupacls-selector crm-ajax-table" data-order='[[2,"desc"]]'>
  <thead>
  <tr>
    <th data-data="civigroup_name" cell-class="crm-groupacls-civigroup_name crmf-title" class='crm-groupacls-civigroup_name'>{ts}Civi Group{/ts}</th>
    <th data-data="aco_name" cell-class="crm-groupacls-aco_name" class='crm-groupacls-aco_name'>{ts}Access Control Object{/ts}</th>
    <th data-data="status" cell-class="crm-groupacls-status right" class='crm-groupacls-status'>{ts}Status{/ts}</th>
    <th data-data="edit" cell-class="crm-groupacls-edit right" class='crm-groupacls-edit'>{ts}Edit{/ts}</th>
    <th data-data="delete" cell-class="crm-groupacls-delete right" class='crm-groupacls-delete'>{ts}Delete{/ts}</th>
  </tr>
  </thead>
</table>
</div>

{literal}
<script type="text/javascript">
    (function($) {
        var ZeroRecordText = {/literal}'{ts escape="js"}<div class="status messages">No Group ACLs have been created yet.{/ts}</div>'{literal};
        $('table.crm-groupacls-selector').DataTable({
            "ajax": {
                "url": {/literal}'{crmURL p="civicrm/ajax/groupaclslist" h=0}'{literal},
                "data": function (d) {
                }
            },
            columns : [
            { data: "civigroup_name" },
            { data: "aco_name" },
            { data: "status" },
            { data: "edit" },
            { data: "delete" },
              ],
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
                $('table.crm-groupacls-selector').DataTable().draw();
            });
    })(CRM.$);
</script>
{/literal}

