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
<div id="user-acls-page" class="view-content">
<div class="action-link">
  <a accesskey="N" href='{crmURL p="civicrm/useracls/add" q="cid=`$contactId`"}' class="button medium-popup"><span><i class="crm-i fa-comment"></i>_Add ACL Item</span></a>
</div>

<table class="crm-useracls-selector crm-ajax-table" data-order='[[2,"desc"]]'>
  <thead>
  <tr>
    <th data-data="aco_name" cell-class="crm-useracls-aco crmf-title" class='crm-useracls-aco'>{ts}Access Control Object{/ts}</th>
    <th data-data="certification_date" cell-class="crm-useracls-certification_date" class='crm-useracls-certification_date'>{ts}Date Certified{/ts}</th>
    <th data-data="cert_by_name" cell-class="crm-useracls-cert_by_name right" class='crm-useracls-cert_by_name'>{ts}Certified By{/ts}</th>
    <th data-data="notes" cell-class="crm-useracls-notes" class='crm-useracls-notes'>{ts}Notes{/ts}</th>
    <th data-data="status" cell-class="crm-useracls-status" class='crm-useracls-status'>{ts}Status{/ts}</th>
    <th data-data="edit" cell-class="crm-useracls-edit" class='crm-useracls-edit'>{ts}Edit{/ts}</th>
    <th data-data="delete" cell-class="crm-useracls-delete" class='crm-useracls-delete'>{ts}Delete{/ts}</th>
  </tr>
  </thead>
</table>
</div>

{literal}
<script type="text/javascript">
    (function($) {
        var ZeroRecordText = {/literal}'{ts escape="js"}<div class="status messages">No ACL items for this contact.{/ts}</div>'{literal};
        $('table.crm-useracls-selector').data({
            "ajax": {
                "url": {/literal}'{crmURL p="civicrm/ajax/useraclslist" h=0 q="snippet=4&cid=`$contactId`"}'{literal},
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
                $('table.crm-useracls-selector').DataTable().draw();
            });
    })(CRM.$);
</script>
{/literal}

