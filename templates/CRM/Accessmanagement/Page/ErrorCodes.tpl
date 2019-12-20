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
<div id="errorcodes-page" class="view-content">
<div class="action-link">
  <a accesskey="N" href='{crmURL p="civicrm/mstk/accesspoints/errorcodes/add" h=0 q="apid=`$accessPointId`"}' class="button medium-popup"><span><i class="crm-i fa-comment"></i>_Add AP Error Code Message for {$accessPointName}</span></a>
</div>

<table class="crm-errorcodes-selector crm-ajax-table" data-order='[[2,"desc"]]'>
  <thead>
  <tr>
    <th data-data="error_key" cell-class="crm-errorcodes-error_key crmf-title" class='crm-errorcodes-error_key'>{ts}Error Message Key{/ts}</th>
    <th data-data="error_value" cell-class="crm-errorcodes-error_value" class='crm-errorcodes-error_value'>{ts}Error Message Value{/ts}</th>
    <th data-data="edit" data-orderable="false" cell-class="crm-errorcodes-edit" class='crm-errorcodes-edit'>&nbsp;</th>
    <th data-data="delete" data-orderable="false" cell-class="crm-errorcodes-delete" class='crm-errorcodes-delete'>&nbsp;</th>
  </tr>
  </thead>
</table>
</div>

{literal}
<script type="text/javascript">
    (function($) {
        var ZeroRecordText = {/literal}'{ts escape="js"}<div class="status messages">No Error Messages have been created yet.{/ts}</div>'{literal};
        $('table.crm-errorcodes-selector').data({
            "ajax": {
                "url": {/literal}'{crmURL p="civicrm/ajax/errorcodeslist" h=0 q="apid=`$accessPointId`"}'{literal},
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
                $('table.crm-errorcodes-selector').DataTable().draw();
            });
    })(CRM.$);
</script>
{/literal}

