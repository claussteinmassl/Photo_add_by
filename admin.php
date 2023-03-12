<?php
// +-----------------------------------------------------------------------+
// | Photo added by plugin for Piwigo  by TEMMII                           |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2012-2021 ddtddt               http://temmii.com/piwigo/ |
// +-----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify  |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation                                          |
// |                                                                       |
// | This program is distributed in the hope that it will be useful, but   |
// | WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU      |
// | General Public License for more details.                              |
// |                                                                       |
// | You should have received a copy of the GNU General Public License     |
// | along with this program; if not, write to the Free Software           |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, |
// | USA.                                                                  |
// +-----------------------------------------------------------------------+

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');
global $template, $conf, $user;
include_once(PHPWG_ROOT_PATH .'admin/include/tabsheet.class.php');
load_language('plugin.lang', PAB_PATH);
$my_base_url = get_admin_plugin_menu_link(__FILE__);

// +-----------------------------------------------------------------------+
// | Check Access and exit when user status is not ok                      |
// +-----------------------------------------------------------------------+
check_status(ACCESS_ADMINISTRATOR);

//-------------------------------------------------------- sections definitions

// Gestion des onglets
if (!isset($_GET['tab']))
    $page['tab'] = 'gestion';
else
    $page['tab'] = $_GET['tab'];

$tabsheet = new tabsheet();
  $tabsheet->add('gestion',l10n('Configuration'),PAB_ADMIN.'-gestion');
$tabsheet->select($page['tab']);
$tabsheet->assign();

// Onglet gest
switch ($page['tab'])
{
  case 'gestion':

  global $conf;
  
    $selected = $conf['Photo_add_by'];
	$options['Author'] = l10n('Author');
	$options['datecreate'] = l10n('Created on');
	$options['datepost'] = l10n('Posted on');
	$options['Dimensions'] = l10n('Dimensions');
	$options['File'] = l10n('File');
	$options['Filesize'] = l10n('Filesize');
	$options['Tags'] = l10n('tags');
	$options['Categories'] = l10n('Albums');
	$options['Visits'] = l10n('Visits');
	$options['Average'] = l10n('Rating score');

  $template->assign(
    'gestionA',
    array(
      'OPTIONS' => $options,
      'SELECTED' => $selected,
      ));

$PASPBY = pwg_db_fetch_assoc(pwg_query("SELECT state FROM " . PLUGINS_TABLE . " WHERE id = 'see_photos_by_user';"));
if($PASPBY['state'] == 'active')
{
$PABS2T = array(
    l10n('No'),
    l10n('Yes'),
  );
  
$PABS2 = array(
    '0',
    '1',
  );

  $template->assign(
    'gestionB',
    array(
	  'TOTO' => 'toto',
      ));
	    global $conf;
$template->assign('pabs2', $PABS2);
$template->assign('pabs2t', $PABS2T);
$template->assign('PABS', $conf['Photo_add_by_show']); 
	  
}

if (isset($_POST['submitpab']))
	{
conf_update_param('Photo_add_by', $_POST['infopab']);
if($PASPBY['state'] == 'active')
{
conf_update_param('Photo_add_by_show', $_POST['inspabs2']);
  $template->assign(
    'gestionB',
    array(
	  'TOTO' => 'toto',
      ));
$template->assign('PABS', $_POST['inspabs2']); 
}
$template->delete_compiled_templates();
array_push($page['infos'], l10n('Your configuration settings are saved'));

  $selected = $_POST['infopab'];
  $template->assign(
    'gestionA',
    array(
      'OPTIONS' => $options,
      'SELECTED' => $selected,
      ));
	}
  break;
} 

$template->set_filenames(array('plugin_admin_content' => dirname(__FILE__) . '/admin/admin.tpl')); 
$template->assign_var_from_handle('ADMIN_CONTENT', 'plugin_admin_content');
?>