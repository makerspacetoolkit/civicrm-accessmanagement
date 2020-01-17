<div class="crm-form-block">
  <table class="form-layout">
    <tr>
      <td>{$form.has_acd.label}</td>
      <td>{$form.has_acd.html}</td>
    </tr>
    <tr>
      <td>{$form.is_ap_group.label}</td>
      <td>{$form.is_ap_group.html}</td>
    </tr>
    <tr>
      <td>{$form.load_defaults.label}</td>
      <td>{$form.load_defaults.html}</td>
    </tr>
    <tr>
      <td>{$form.ap_name.label}</td>
      <td>{$form.ap_name.html}</td>
    </tr>
    <tr>
      <td>{$form.ap_short_name.label}</td>
      <td>{$form.ap_short_name.html}</td>
    </tr>
    <tr class="standalone" style="display:true"> 
      <td>{$form.ip_address.label}</td>
      <td>{$form.ip_address.html}</td>
    </tr>
    <tr class="standalone" style="display:true"> 
      <td>{$form.mac_address.label}</td>
      <td>{$form.mac_address.html}</td>
    </tr>
    <tr>
      <td>{$form.member_rate.label}</td>
      <td>{$form.member_rate.html}</td>
    </tr>
    <tr>
      <td>{$form.non_member_rate.label}</td>
      <td>{$form.non_member_rate.html}</td>
    </tr>
    <tr>
      <td>{$form.non_member_perdiem.label}</td>
      <td>{$form.non_member_perdiem.html}</td>
    </tr>
    <tr>
      <td>{$form.idle_timeout.label}</td>
      <td>{$form.idle_timeout.html}</td>
    </tr>
    <tr>
      <td>{$form.parent_id.label}</td>
      <td>{$form.parent_id.html}</td>
    </tr>
    <tr class="acd" style="display:false">
      <td>{$form.dev.label}</td>
      <td>{$form.dev.html}</td>
    </tr>
    <tr class="acd" style="display:false">
      <td>{$form.cmd.label}</td>
      <td>{$form.cmd.html}</td>
    </tr>
    <tr>
      <td>{$form.maintenance_mode.label}</td>
      <td>{$form.maintenance_mode.html}</td>
    </tr>
  </table>
  <div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="bottom"}
  </div>
</div>
{literal}
    <script type="text/javascript">
      cj('.acd').hide();
      cj('form#AccessPointsAdd').submit(function(e){
      if(cj('#has_acd').prop('checked') && (cj('input#dev')[0].value === '' || cj('input#cmd')[0].value === '')) {
        alert('Both Device and Command are requied with option checked.');
	e.preventDefault();
      }
});
    function hideStandaloneOptions() {

      if (cj('#is_ap_group').prop('checked')) {
        cj('.standalone').hide();
      } else {
        cj('.standalone').show();
      }
    }

    function showAcdOptions() {

      if (cj('#has_acd').prop('checked')) {
        cj('.acd').show();
      } else {
        cj('.acd').hide();
      }
    }
    </script>
{/literal}
