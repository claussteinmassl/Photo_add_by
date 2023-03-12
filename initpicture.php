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

//Ajout du prefiltre
add_event_handler('loc_begin_picture', 'pabI', 55 );
function pabI(){
	global $template;
	$template->set_prefilter('picture', 'pabIT');
}

function pabIT($content){
  global $conf, $pwg_loaded_plugins;
	$search = '#<div id="'.$conf['Photo_add_by'].'" class="imageInfo">#';
  if (isset($pwg_loaded_plugins['manage_properties_photos'])){
	$replacement = '<div id="'.$conf['Photo_add_by'].'" class="imageInfo">';
  }else{
	$replacement = '
  {if $PAB}
  <div id="pab1" class="imageInfo">
    <dt>{\'Photo added by\'|@translate}</dt>
    <dd>{$PAB}</dd>
  </div>
{/if}
<div id="'.$conf['Photo_add_by'].'" class="imageInfo">';
  }
  return preg_replace($search, $replacement, $content);
 }

add_event_handler('loc_begin_picture', 'pab');

function pab(){
global $conf, $page, $template;
load_language('plugin.lang', PAB_PATH);
load_language('lang', PHPWG_ROOT_PATH.PWG_LOCAL_DIR, array('no_fallback'=>true, 'local'=>true) );

  if ( !empty($page['image_id']) ){
    $query = 'select added_by FROM ' . IMAGES_TABLE . ' WHERE id = \''.$page['image_id'].'\';';
	$result = pwg_query($query);
	$row = pwg_db_fetch_assoc($result);
	$userab=$row['added_by'];
	
	$query = 'select '.$conf['user_fields']['username'].' AS username FROM ' . USERS_TABLE . ' WHERE '.$conf['user_fields']['id'].' = \''.$userab.'\';';
	$result = pwg_query($query);
	$row = pwg_db_fetch_assoc($result);
	$pab=$row['username'];
	
	$PASPBY = pwg_db_fetch_assoc(pwg_query("SELECT state FROM " . PLUGINS_TABLE . " WHERE id = 'see_photos_by_user';"));
	$showpab = $conf['Photo_add_by_show'];
	  if($showpab == 1 and $PASPBY['state'] == 'active'){
		$query2 = 'SELECT UT.id, UT.username, COUNT(DISTINCT(IT.id)) AS PBU
		  FROM ' . USERS_TABLE . ' as UT
		  INNER JOIN '.IMAGES_TABLE.' AS IT ON IT.added_by = UT.id
		  INNER JOIN '.IMAGE_CATEGORY_TABLE.' AS ic ON IT.id = ic.image_id
		    '.get_sql_condition_FandF
			(
			array
           (
		   'forbidden_categories' => 'category_id',
		   'visible_categories' => 'category_id',
		   'visible_images' => 'id'
		   ),
		   'WHERE'
		   ).'
		   GROUP BY IT.added_by
           HAVING PBU >'.$conf['see_photos_by_user_nbphotos'].'
		   ORDER BY '.$conf['see_photos_by_user_order'].'
		   LIMIT '.$conf['see_photos_by_user_limit'].';';
		$result2 = pwg_query($query2);
		$userok = array();
		while ($row2 = pwg_db_fetch_assoc($result2)){
		  $userok[] = $row2['username'];
		}
		if(in_array($pab, $userok) and $showpab == 1 and $PASPBY['state'] == 'active'){
		  $urlpab = get_root_url().'index.php?/user-'.$userab.'-'.$pab;
		  $pab2 ='<a href="'.$urlpab.'">'.$pab.'</a>';
		}else{
		  $pab2=$pab;
		}
	  }else{
	    $pab2=$pab;
	  }
	$template->assign(array('PAB' => $pab2,));
  }
}

?>
