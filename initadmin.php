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

if (!defined('PHPWG_ROOT_PATH'))
    die('Hacking attempt!');

//add prefiltre photo
add_event_handler('loc_begin_admin', 'addpayadmin', 55);
add_event_handler('loc_begin_admin_page', 'addpayadminA', 55);

function addpayadmin() {
  global $template;
  $template->set_prefilter('picture_modify', 'addpayadminT');
}

function addpayadminT($content) {
  $search = '#  </div>
  <div id=\'picture-content\'>#';
  $replacement = '	  </div>
 	<div style="writing-mode:vertical-rl; text-orientation:mixed; text-align: center;height:35vw; width:15px;">
     {if $PABA}
	  <strong>{\'Photo added by\'|@translate}</strong> {$PABA}
	 {/if}
	</div>
<div id=\'picture-content\'>	
';

  return preg_replace($search, $replacement, $content);
}

function addpayadminA() {
  if (isset($_GET['image_id'])){
	global $conf, $page, $template;
load_language('plugin.lang', PAB_PATH);
load_language('lang', PHPWG_ROOT_PATH.PWG_LOCAL_DIR, array('no_fallback'=>true, 'local'=>true) );

    $query = 'select added_by FROM ' . IMAGES_TABLE . ' WHERE id = \''.$_GET['image_id'].'\';';
	$result = pwg_query($query);
	$row = pwg_db_fetch_assoc($result);
	$userab=$row['added_by'];
	
	$query = 'select '.$conf['user_fields']['username'].' AS username FROM ' . USERS_TABLE . ' WHERE '.$conf['user_fields']['id'].' = \''.$userab.'\';';
	$result = pwg_query($query);
	$row = pwg_db_fetch_assoc($result);
	$pab=$row['username'];
	
	$template->assign(array('PABA' => $pab,));
  }
}

?>