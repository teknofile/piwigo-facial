<?php
/*
 * Version: 0.1
 * Plugin Name: Facial
 * Plugin URI: www.teknofile.org
 *             Author: teknofile
 *             Description: A plugin for facial recognition
 *
*/

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

if(basename(dirname(__FILE__)) != 'facial') {
  add_event_handler('init', 'facial_error');
  function facial_error() {
    global $page;
    $page['errors'][] = 'Facial folder name is incorrect, unisntall the plugin and rename it to "facial".';
  }

  return;
}

/*
 * Plugin Constants
*/

global $prefixTable;

define('FACIAL_ID',           basename(dirname(__FILE__)));
define('FACIAL_PATH' ,        PHPWG_PLUGINS_PATH . FACIAL_ID . '/');
define('FACIAL_TABLE',        $prefixTable . 'tkffacial');
define('FACIAL_ADMIN',        get_root_url() . 'admin.php?page=plugin-' . FACIAL_ID);
define('FACIAL_PUBLIC',       get_absolute_root_url() . make_index_url(array('section' => 'facial')) . '/');
define('FACIAL_VERSION',      '0.0.1');
define('FACIAL_DIR',          PHPWG_ROOT_PATH . PWG_LOCAL_DIR . 'facial/');


// +----------------------------------------------------------+
// | Add event handlers                                       |
// +----------------------------------------------------------+

add_event_handler('init', 'facial_init');

if(defined('IN_ADMIN')) {
  // file containing all admin handlers functions
  $admin_file = FACIAL_PATH . 'include/admin_events.inc.php';

  // new tab on photo page
  add_event_handler('tabsheet_before_select', 'facial_tabsheet_before_select', EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);

  // new prefilter in Batch Manager
  add_event_handler('get_batch_manager_prefilters', 'facial_add_batch_manager_prefilters', EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);
  add_event_handler('perform_batch_manager_prefilters', 'facial_perform_batch_manager_prefilters', EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);

  // new action in batch manager
  add_event_handler('loc_end_element_set_global', 'facial_loc_end_element_set_global', EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);
  add_event_handler('element_set_global_action', 'facial_element_set_global_action', EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);

  // new field in Batch Manager unit mode
  add_event_handler('loc_end_element_set_unit', 'facial_loc_end_element_set_unit', EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);

  // new tab in users modal
  add_event_handler('loc_end_admin', 'facial_add_tab_users_modal', EVENT_HANDLER_PRIORITY_NEUTRAL, $admin_file);
}
else
{
  // file containing all public event handlers
  $public_file = FACIAL_PATH . 'include/public_events.inc.php';

  // add a public section
  add_event_handler('loc_end_section_init', 'facial_loc_end_section_init', EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);
  add_event_handler('loc_end_index', 'facial_loc_end_page', EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);

  // add button on album and photos pages
  add_event_handler('loc_end_index', 'facial_add_button', EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);
  add_event_handler('loc_end_picture', 'facial_add_button', EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);

  // prefilter on photo page
  add_event_handler('loc_end_picture', 'facial_loc_end_picture', EVENT_HANDLER_PRIORITY_NEUTRAL, $public_file);
}

// file containing API function
$ws_file = FACIAL_PATH . 'include/ws_functions.inc.php';

// add API function
add_event_handler('ws_add_methods', 'facial_ws_add_methods', EVENT_HANDLER_PRIORITY_NEUTRAL, $ws_file);
add_event_handler('ws_invoke_allowed', 'facial_ws_users_setInfo', EVENT_HANDLER_PRIORITY_NEUTRAL, $ws_file);
add_event_handler('ws_users_getList', 'facial_ws_users_getList', EVENT_HANDLER_PRIORITY_NEUTRAL, $ws_file);
add_event_handler('ws_setInfo', 'facial_ws_setInfo', EVENT_HANDLER_PRIORITY_NEUTRAL, $ws_file);
add_event_handler('ws_add_methods', 'facial_ws_images_setInfo', EVENT_HANDLER_PRIORITY_NEUTRAL, $ws_file);

// event functions can also be invoked in a class
$menu_file = FACIAL_PATH . 'include/menu_events.class.php';

// add item to existing menu (EVENT_HANDLER_PRIORITYU_NEUTRAL+10 is for compatibility with Advanced Menu Manager plugin)
add_event_handler('blockmanager_apply', array('FacialMenu', 'blockmanager_apply1'), EVENT_HANDLER_PRIORITY_NEUTRAL+10, $menu_file);

// add new menu block (the declration must be done every time in order to be able to manage the menu block in "Menus" screen and advanced menu manager
add_event_handler('blockmanager_register_block', array('FacialMenu', 'blockmanager_register_blocks'), EVENT_HANDLER_PRIORITY_NEUTRAL, $menu_file);
add_event_handler('blockmanager_apply', array('FacialMenu', 'blockmanager_apply2'), EVENT_HANDLER_PRIORITY_NEUTRAL, $menu_file);

// NOTE: blockmanager_apply1() and blockmanager_apply2() can (must) be merged

function facial_init()
{
  global $conf;

  load_language('plugin.lang', FACIAL_PATH);

  $conf['facial'] = safe_unserialize($conf['facial']);
}
