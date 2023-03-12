<?php
// +-----------------------------------------------------------------------+
// | Photo added by plugin for Piwigo  by TEMMII                           |
// +-----------------------------------------------------------------------+
// | Copyright(C) 2012-2020 ddtddt               http://temmii.com/piwigo/ |
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

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');

class Photo_add_by_maintain extends PluginMaintain{
  private $installed = false;

  function __construct($plugin_id){
    parent::__construct($plugin_id);
  }

  function install($plugin_version, &$errors=array()){
    
  }

  function activate($plugin_version, &$errors=array()){
	global $conf, $template;
    if (!isset($conf['Photo_add_by'])){
        conf_update_param('Photo_add_by', 'Categories',true);
    }
    if (!isset($conf['Photo_add_by_show'])){
        conf_update_param('Photo_add_by_show',0,true);
    }
	$template->delete_compiled_templates(array('picture' => 'picture.tpl'));
  }

  function update($old_version, $new_version, &$errors=array()){
    global $conf;
    if (!isset($conf['Photo_add_by'])){
        conf_update_param('Photo_add_by', 'Categories',true);
    }
    if (!isset($conf['Photo_add_by_show'])){
        conf_update_param('Photo_add_by_show',0,true);
    }
  }
  
  function deactivate(){
	global $template;
	$template->delete_compiled_templates(array('picture' => 'picture.tpl'));
  }

  function uninstall(){
    conf_delete_param('Photo_add_by_show','Photo_add_by');
  }
}
?>
