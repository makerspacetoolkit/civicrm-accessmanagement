<div class="crm-form-block">
  <table class="form-layout">
    <tr>
      <td>{$form.aco.label}</td>
      <td>{$form.aco.html}</td>
    </tr>
    <tr>
      <td>{$form.certification_date.label}</td>
      <td>{$form.certification_date.html}</td>
    </tr>
    <tr>
      <td>{$form.certified_by.label}</td>
      <td>{$form.certified_by.html}</td>
    </tr>
    <tr>
      <td>{$form.status_id.label}</td>
      <td>{$form.status_id.html}</td>
    </tr>
    <tr>
      <td>{$form.notes.label}</td>
      <td>{$form.notes.html}</td>
    </tr>
  </table>
  <div class="crm-submit-buttons">
    {include file="CRM/common/formButtons.tpl" location="bottom"}
  </div>
</div>
