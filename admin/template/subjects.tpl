{combine_css path=$FACIAL_PATH|@cat:"admin/template/style.css"}

{html_style}
  h4 {
    text-align:left !important;
  }
{/html_style}

<div class="titlePage">
	<h2>Subjects</h2>
</div>
<form method="post" action="" class="properties">
<fieldset>
  <legend>{'Known Subjects'|translate}</legend>
  <ul>{strip}
  {foreach from=$subjects item=link}
    <li>{$link}</li>
  {/foreach}
  {/strip}</ul>
	
  <hr width="75%" />
  <table>
    <tr><td><input type="text" size="25" name="new_subject" /></td><td><input type=submit name="Add Subject" value="Add Subject" /></td></tr>
  </table>
</fieldset>
</form>
