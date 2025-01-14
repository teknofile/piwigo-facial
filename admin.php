<?php
/**
 * This is the main administration page, if you have only one admin page you can put
 * directly its code here or using the tabsheet system like bellow
 */

defined('FACIAL_PATH') or die('Hacking attempt!');

global $template, $page, $conf;


// get current tab
$page['tab'] = isset($_GET['tab']) ? $_GET['tab'] : $page['tab'] = 'home';

// plugin tabsheet is not present on photo page
if ($page['tab'] != 'photo')
{
  // tabsheet
  include_once(PHPWG_ROOT_PATH.'admin/include/tabsheet.class.php');
  $tabsheet = new tabsheet();
  $tabsheet->set_id('skeleton');

  $tabsheet->add('home', l10n('Welcome'), FACIAL_ADMIN . '-home');
  $tabsheet->add('config', l10n('Configuration'), FACIAL_ADMIN . '-config');
  $tabsheet->select($page['tab']);
  $tabsheet->assign();
}

// include page
include(FACIAL_PATH . 'admin/' . $page['tab'] . '.php');

// template vars
$template->assign(array(
  'FACIAL_PATH'=> FACIAL_PATH, // used for images, scripts, ... access
  'FACIAL_ABS_PATH'=> realpath(FACIAL_PATH), // used for template inclusion (Smarty needs a real path)
  'FACIAL_ADMIN' => FACIAL_ADMIN,
  ));

// send page content
$template->assign_var_from_handle('ADMIN_CONTENT', 'facial_content');
