<?php

// Check wether we are indeed included by Piwigo
if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

// fetch the template
global $template, $page, $conf;

$page['tab'] = isset($_GET['tab']) ? $_GET['tab'] : $page['tab'] = 'home';

// plugin tabsheet is not present on photo page
if($page['tab'] != 'photo')
{
	// tabsheet
	include_once(PHPWG_ROOT_PATH . 'admin/include/tabsheet.class.php');
	$tabsheet = new tabsheet();
	$tabsheet->set_id('facial');

	$tabsheet->add('home', l10n('Welcome'), FACIAL_ADMIN . '-home');
	$tabsheet->add('config', l10n('Configuration'), FACIAL_ADMIN . '-config');
	$tabsheet->add('subjects', l10n('Subjects'), FACIAL_ADMIN . '-subjects');
	$tabsheet->select($page['tab']);
	$tabsheet->assign();
}

// include page
include(FACIAL_PATH . 'admin/' . $page['tab'] . '.php');

// Add our template to the global
$template->assign(array(
	'FACIAL_PATH' => FACIAL_PATH, // used for images, scripts, ... access
	'FACIAL_ABS_PATH' => realpath(FACIAL_PATH), // used for template inclusion
	'FACIAL_ADMIN' => FACIAL_ADMIN,
  ));

$template->assign_var_from_handle('ADMIN_CONTENT', 'facial_content');

?>
