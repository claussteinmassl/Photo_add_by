<?php
/*
Plugin Name: Photo added by
Version: 12.0.a
Description: Add who added photo on photo page
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=621
Author: ddtddt
Author URI: http://temmii.com/piwigo/
Has Settings: webmaster
*/

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

global $prefixeTable, $pwg_loaded_plugins;

define('PAB_DIR' , basename(dirname(__FILE__)));
define('PAB_PATH' , PHPWG_PLUGINS_PATH . PAB_DIR . '/');
define('PAB_ADMIN',get_root_url().'admin.php?page=plugin-'.PAB_DIR);

add_event_handler('loading_lang', 'Photo_added_by_loading_lang');	  
function Photo_added_by_loading_lang(){
  load_language('plugin.lang', PAB_ADMIN);
}

 // Plugin on picture page
if (script_basename() == 'picture'){  
  include_once(dirname(__FILE__).'/initpicture.php');
}

// Plugin for admin
if (script_basename() == 'admin') {
    include_once(dirname(__FILE__) . '/initadmin.php');
}

// menu admin
/*
add_event_handler('get_admin_plugin_menu_links', 'PAB_admin_menu');
function PAB_admin_menu($menu){
	global $pwg_loaded_plugins;
  if (is_webmaster()){
	if(isset($pwg_loaded_plugins['manage_properties_photos'])){}else{
		$menu[] = array(
			'NAME' => l10n('Photo added by'),
			'URL' => PAB_ADMIN,
		);
	}
  }
  return $menu;
}
*/
?>