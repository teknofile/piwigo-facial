{combine_css path=$FACIAL_PATH|@cat:"admin/template/style.css"}

{footer_script}
jQuery('input[name="option2"]').change(function() {
  $('.option1').toggle();
});

jQuery(".showInfo").tipTip({
  delay: 0,
  fadeIn: 200,
  fadeOut: 200,
  maxWidth: '300px',
  defaultPosition: 'bottom'
});
{/footer_script}


<div class="titrePage">
	<h2>Facial</h2>
</div>

<form method="post" action="" class="properties">
<fieldset>
  <legend>{'Common configuration'|translate}</legend>

  <table width="90%">
    <tr>
      <td>API URL:</td>
      <td><input type="text" size="75" name="compreface_api_url" value="{$facial.compreface_api_url}" /></td>
    </tr>
    <tr>
      <td>API Key:</td>
      <td><input type="text" size="75" name="compreface_api_key" value="{$facial.compreface_api_key}"/></td>
    </tr>
  </table>
</fieldset>

<p class="formButtons"><input type="submit" name="save_config" value="{'Save Settings'|translate}"></p>

</form>
