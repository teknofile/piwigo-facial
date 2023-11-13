{combine_css path=$FACIAL_PATH|@cat:"admin/template/style.css"}

{html_style}
  h4 {
    text-align:left !important;
  }
{/html_style}

<div class="titlePage">
	<h2>Facial</h2>
</div>
<form method="post" action="" class="properties">
<fieldset>
  <legend>{'What Facial Can Do For Me?'|translate}</legend>
  {$INTRO_CONTENT}
</fieldset>
</form>
