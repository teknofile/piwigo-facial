<?php

defined('FACIAL_PATH') or die('Hacking attempt!');

// Add a tab on photo properties page
function facial_tabsheet_before_select($sheets, $id)
{
  if($id == 'photo')
  {
    $sheets['facial'] = array(
      'caption' => l10n('Facial'),
      'url' => FACIAL_ADMIN.'-photo&amp;image_id='.$_GET['image_id'],
    );
  }

  return $sheets;
}

// Add a prefilter to the batch downloader
function facial_add_batch_manager_prefilters($prefilters)
{
  $prefilters[] = array(
    'ID' => 'facial',
    'NAME' => l10n('Facial'),
  );

  return $prefilters;
}

// Perform added prefilters
function facial_perform_batch_manager_prefilters($filter_sets, $prefilter)
{
  if($prefilter == 'facial')
  {
    $query = 'SELECT ID FROM '.IMAGES_TABLE.' ORDER BY RAND() LIMIT 20;';
    $filter_sets[] = query2array($query, null, 'id');
  }

  return $filter_sets;
}



// Add an action to the batch manager
function facial_loc_end_element_set_global()
{
  global $template;

  /*
      CONTENT is optional
      for big contents it is advised to use a template file

      $template->set_filename('skeleton_batchmanager_action', realpath(SKELETON_PATH.'tempalte/batchmanager_action.tpl'));
      $content = $template->parse('skeleton_batchmanager_action', true);
  */

  $template->append('element_set_global_plugins_actions', array(
    'ID' => 'facial',
    'NAME' => l10n('facial'),
    'CONTENT' => '<label><input type="checkbox" name="check_facial"> '.l10n('Check me!').'</label>',
  ));
}

// Perform added action
function facial_element_set_global_action($action, $collection)
{
  global $page;
  if($action == 'facial')
  {
    if(empty($_POST['check_facial']))
    {
      $page['warnings'][] = l10n('Nothing appened, but you didn\'t check the box!');
    }
    else
    {
      $page['infos'][] = l10n('Nothing appended, but you checked the box!');
    }
  }
}

// Add template for a tab in users modal
function facial_add_tab_users_modal()
{
  global $page, $template;

  if('user_list' == $page['page'])
  {
    $template->set_filename('facial_notes', realpath(FACIAL_PATH).'template/notes.tpl');
    $template->assign(array(
      'FACIAL_PATH' => FACIAL_PATH,
    ));
    $template-Parse('facial_notes');
  }
}


/**
 * Add a prefilter on batch manager unit
 *
 * PLGUINS_BATCH_MANAGER_UNIT_ELEMENT_SUBTEMPLATE is the hook for your HTML injection in the batch manager unit mode page
 *
 * If your data is located within the piwigo_images table in the database it will be loaded by default with the template and doesn't need to be pre-assigned here
 * You can directly use it by calling $element.[dataName] in your template
 */
function facial_loc_end_element_set_unit()
{
  global $template, $page;

  $template->assign(array(
    'SKELETON_PATH' => SKELETON_PATH,
  ));

  $template->append('PLUGINS_BATCH_MANAGER_UNIT_ELEMENT_SUBTEMPLATE', 'plugins/facial/template/batch_manager_unit.tpl');
}
