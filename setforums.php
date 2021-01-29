<?
/***************************************************************************
 * ExBB v.1.9                                                              *
 * Copyright (c) 2002-20õõ by Alexander Subhankulov aka Warlock            *
 *                                                                         *
 * http://www.exbb.revansh.com                                             *
 * email: admin@exbb.revansh.com                                           *
 *                                                                         *
 ***************************************************************************/
/***************************************************************************
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/

define("IN_ADMIN", true);
include('common.php');
include('./data/boardstats.php');

$vars = parsed_vars();

if ( defined('IS_ADMIN') ) {
  switch ($vars['action']) {
     case 'addcat':
     case 'addforum': addforum(); break;
     case 'doaddcat':
     case 'processnew': createforum(); break;
     case 'edit': editform(); break;
     case 'doedit': doedit(); break;
     case 'editcatname': editcatname(); break;
     case 'reorder': reordercats(); break;
     case 'forum_order': reorderfrms(); break;
     case 'recount': recount(); break;
     case 'delcat':
     case 'delete': warning(); break;
     case 'dodelforum': deleteforum(); break;
     case 'dodelcat': deletecat(); break;
     case 'stat': statist(); break;
     case 'restore': restore(); break;
     default:
            forumlist(); break;
  }

}
else {
      Header('Location: index.php'); exit;
     }

include('page_tail_admin.php');


function statist() {
global $exbb,$vars,$lang;

    $filetoopen = $exbb['home_path'].'data/allforums.php';
    if (file_exists($filetoopen)) {
      $totalposts = 0;
      $totalthreads = 0;
      $allforums = get_file($filetoopen);

      foreach ($allforums as $id=>$forum) {
        $totalposts += $forum['posts'];
        $totalthreads += $forum['topics'];
      }
      $info = "$lang[Now_stat]<br>$lang[Posts_total] <b>$exbb[totalposts]</b><br>$lang[Topics_total]: <b>$exbb[totalthreads]</b><p>$lang[After_recount]<br>
               $lang[Posts_total] <b>$totalposts</b><br>$lang[Topics_total] <b>$totalthreads</b>";
      $exbb['totalposts'] = $totalposts;
      $exbb['totalthreads'] = $totalthreads;
      save_statfile();

      error($lang['Info'],$info,'',0);

    } else { error($lang['Info'],$lang['Stat_error'],'',0); }
}



function forumlist() {
global $exbb,$lang,$modoutput,$lang_moder;

  $highest = 0;

  if (ini_get('safe_mode')) $safe_mode = '<p>'.$lang['safe_mode_on'].'</p>';

  $filetoopen = $exbb['home_path'].'data/allforums.php';
  if (file_exists($filetoopen)) {
    $forums = get_file($filetoopen);
	$lastcategoryplace = -1;
    foreach ($forums as $forumid=>$forum) {
		moderator($forumid,$forums);
		$catrow = ($forum['catid'] != $lastcategoryplace) ? true : false;
		$private = ( $forum['private'] ) ? $lang['Private'] : '';
		$forum['name'] = stripslashes($forum['name']);
		$forum['desc'] = stripslashes($forum['desc']);
        include('./admin/forumlist_data.tpl');

        $lastcategoryplace = $forum['catid'];
        if ($forum['catid'] > $highest) { $highest = $forum['catid']; }
    }
  }

  $highest++;
  $title_page = $lang['Administrating'];
  include('./admin/all_header.tpl');
  include('./admin/forumlist.tpl');
}


function recount() { #start
global $exbb,$vars,$lang;

  $inforum = $vars['forum'];
  $topics = array();
  $postscount = 0;
  $fileoopen = $exbb['home_path'].'forum'.$inforum.'/list.php';
  if (file_exists($fileoopen)) {
    $topics = get_file($fileoopen);
	$topiccount = is_array($topics) ? count($topics) : 0;
    foreach ($topics as $id=>$topic) $postscount += $topic['posts'];
  }
  $filetoopen = $exbb['home_path'].'data/allforums.php';
  $allforums = get_file($filetoopen);
  $all = fopen($filetoopen,'w');
  lock_file($all);
  $allforums[$inforum]['topics'] = $topiccount;
  $allforums[$inforum]['posts'] = $postscount;

  save_opened_file($all,$allforums);
  $info = $lang['Topics_total'].' '.$topiccount.'<br>'.$lang['Posts_total'].' '.$postscount;
  error($lang['Counting_complete'],$info,'',0);
}


function categories($allfrm,$in) {
  $cathtml = '<select name="tocat">';
  $cates = array();
  foreach($allfrm as $forumid=>$val) $cates[$val['catid']] = $val['catname'];
  foreach($cates as $id=>$name) if ($id == $in) {$cathtml .= '<option value="'.$id.'" selected>'.$name."\n";} else {$cathtml .= '<option value="'.$id.'">'.$name."\n";}
  $cathtml .= '</select>';
  return $cathtml;
}


function addforum() {
global $exbb,$vars,$lang;

   $incategory = $vars['category'];
   $filetoopen = $exbb['home_path'].'data/allforums.php';
   $forums = get_file($filetoopen);
   # Find the category name from the number
   $high = 0;
   foreach ($forums as $id=>$forum) {
       if ($incategory == $forum['catid']) $category = $forum['catname'];
       if ($id > $high) $high = $id;
   }
   $high++;
   $lang['safe_mode_cat'] = sprintf($lang['safe_mode_cat'],$high);
   if (ini_get('safe_mode')) $safe_mode = '<p>'.$lang['safe_mode_cat'].'</p>';

   if ($vars['action'] == 'addcat') {
        $hidden = '<input type=hidden name="action" value="doaddcat">
                   <input type=hidden name="category" value="'.$incategory.'">';
        $cathtml = '<input type=text size=40 name="categoryname" value="">';
        $do = $lang['New_forum_cat'];
   }
   else {
        $cathtml = categories($forums,$incategory);
        $hidden = '<input type=hidden name="action" value="processnew">';
        $do = $lang['New_forum'];
   }
   $codes_on = 'selected';
   $codes_off = '';
   $polls_on = 'checked="checked"';
   $polls_off = '';
   $private_on = '';
   $private_off = 'selected';
   $access_all = 'selected';
   $access_reged = '';
   $access_no = '';
   $upsize = '';
   $button = $lang['Forum_create'];

   $title_page = $lang['Administrating'];
   include('./admin/all_header.tpl');
   include('./admin/addforum.tpl');

} # end route



function createforum() {
global $exbb,$vars,$lang;

  $catid = ($vars['action'] == 'doaddcat') ? $vars['category'] : $vars['tocat'];
  $catid = intval($catid);
  $filetoopen = $exbb['home_path'].'data/allforums.php';
  $allforums = get_file($filetoopen);
  $all = fopen($filetoopen,'r+');
  lock_file($all);
  # Create a new number for the new forum folder, and files.
  $pos = array();
  $high = 0;
  foreach ($allforums as $id=>$forum) {
      if ($id > $high) $high = $id;
      if ($forum['catid'] == $catid) {$pos[] = $forum['position']; $cat_name = $forum['catname']; }
  }
  $catname = ($vars['action'] == 'doaddcat') ? $_POST['categoryname'] : $cat_name;

  $newforumid = $high + 1;
  $new_position = ($vars['action'] == 'doaddcat') ? intval($catid.'01') : max($pos) + 1;
  # Lets create the directory.
  $dirtomake = $exbb['home_path'].'forum'.$newforumid;

  if (!@ini_get('safe_mode')) {
       @mkdir($dirtomake,0777);
       @chmod($dirtomake,$exbb['ch_dirs']);
  } else {
       if (!is_dir($dirtomake)) {fclose($all); error($lang['No_dir'],sprintf($lang['safe_mode_cat'],$newforumid),'',0);}
  }

  # Lets add a file to stop snoops, and to use to see if the forum was created
  @copy($exbb['home_path'].'data/.htaccess',$dirtomake.'/.htaccess');
  @copy($exbb['home_path'].'data/index.html',$dirtomake.'/index.html');

  if (!empty($vars['forummoderator'])) {

    make_moderators();

  }

  $allforums[$newforumid]['catname'] = $catname;
  $allforums[$newforumid]['catid'] = $catid;
  $allforums[$newforumid]['name'] = $_POST['forumname'];
  $allforums[$newforumid]['desc'] = $_POST['forumdescription'];
  $allforums[$newforumid]['posts'] = 0;
  $allforums[$newforumid]['topics'] = 0;
  $allforums[$newforumid]['position'] = $new_position;

  $allforums[$newforumid]['status'] = $vars['startnewthreads'];
  $allforums[$newforumid]['moderator'] = $vars['forummoderator'];;
  $allforums[$newforumid]['private'] = ($vars['privateforum'] == 'no') ? false : true;
  $allforums[$newforumid]['codes'] = ($vars['codestate'] == 'on') ? true : false;
  $allforums[$newforumid]['polls'] = ($vars['polls'] == '1') ? true : false;
  $allforums[$newforumid]['icon'] = $vars['forumgraphic'];

  $vars['upsize'] = ($vars['upsize'] > 0) ? $vars['upsize'] = (int)$vars['upsize'] * 1024 : '';
  if ($vars['upsize']) $allforums[$newforumid]['upload'] = $vars['upsize'];

  uasort($allforums,'sort_by_catid');
  uasort($allforums,'sort_by_position');

  save_opened_file($all,$allforums);

  error($lang['Info'],$lang['Forum_created'],'',0);

}

# Subroutes ( Warning of Delete Forum )

function warning() {
global $exbb,$vars,$lang;

  $inforum = (isset($vars['forum'])) ? $vars['forum'] : $vars['category'];
  $delete = ($vars['action'] == 'delete') ? 'dodelforum' : 'dodelcat';
  $title_page = $lang['Administrating'];
  include('./admin/all_header.tpl');
  include('./admin/del_forum.tpl');

}

function deleteforum($what = '') {
global $exbb,$vars,$lang;

   $inforum = (empty($what)) ? $vars['forum'] : $what;
   $dirtoremove = $exbb['home_path'].'forum'.$inforum;
   $dirdata = array();
   if (is_dir($dirtoremove)) {
	   if ( !($dirdata = get_dir($dirtoremove,'{*,*.*,.h*}',GLOB_BRACE) ) ) {

		   $handle=opendir($dirtoremove);
		   while (false !== ($file = readdir($handle))) {
			   if (($file != '.') and ($file != '..')) {$dirdata[]=$file;}
		   }
		   closedir($handle);
	   }

	   foreach ($dirdata as $file) @unlink($dirtoremove.'/'.$file);

	   if (!ini_get('safe_mode')) { @rmdir($dirtoremove); }
	   else { $needremove = '<br>'.sprintf($lang['Must_remove'],$inforum); }

	   $filetoopen = $exbb['home_path'].'data/allforums.php';
	   $allforums = get_file($filetoopen);
	   $all = fopen($filetoopen,'r+');
	   lock_file($all);

	   $exbb['totalposts'] -= $allforums[$inforum]['posts'];
	   $exbb['totalthreads'] -= $allforums[$inforum]['topics'];
	   save_statfile();

	   unset($allforums[$inforum]);
	   save_opened_file($all,$allforums);
   }

   if (empty($what)) { error($lang['Info'],$lang['Forums_updated'].$needremove,'',0); }
   else { return $needremove; }
}

function deletecat() {
global $exbb,$vars,$lang;

  $incategory = $vars['forum'];
  $filetoopen = $exbb['home_path'].'data/allforums.php';
  $allforums = get_file($filetoopen);
  $todelete = array();
  foreach ($allforums as $id=>$forum) {
     if ($forum['catid'] == $incategory) $todelete[] = $id;
  }
  $needremove = '';
  if (count($todelete) > 0) {
     foreach($todelete as $forum) $needremove .= deleteforum($forum);
  } else { error($lang['EXBB_ERROR'],$lang['Cat_del_error'],'',0); }
  error($lang['Info'],$lang['Forums_updated'].$needremove,'',0);
}

function editform() {
global $exbb,$vars,$lang;

  $inforum = $vars['forum'];
  $filetoopen = $exbb['home_path'].'data/allforums.php';
  $allforums = get_file($filetoopen);

  $forumid = $inforum;
  $cathtml = $allforums[$inforum]['catname'];
  $categoryplace = $allforums[$inforum]['catid'];

  $forummoderator = unserialize($allforums[$inforum]['moderator']);
  $forummoderator = array_values($forummoderator);
  $forummoderator = implode(',', $forummoderator);

  $forumgraphic = $allforums[$inforum]['icon'];

  $hidden = '<input type=hidden name="action" value="doedit">
             <input type=hidden name="forum" value="'.$inforum.'">';

  #$forumname = str_replace('&quot;','"',$allforums[$inforum]['name']);
  $forumname = stripslashes($allforums[$inforum]['name']);
  $forumdescription = htmlspecialchars(stripslashes($allforums[$inforum]['desc']),ENT_QUOTES);
  $do = $lang['Edit_forum'];

  $codes_on = ($allforums[$inforum]['codes']) ? 'selected' : '';
  $codes_off = (!$allforums[$inforum]['codes']) ? 'selected' : '';

  $polls_on = ($allforums[$inforum]['polls']) ? 'checked="checked"' : '';
  $polls_off = (!$allforums[$inforum]['polls']) ? 'checked="checked"' : '';

  $private_on = ($allforums[$inforum]['private']) ? 'selected' : '';
  $private_off = (!$allforums[$inforum]['private']) ? 'selected' : '';

  $access_all = ($allforums[$inforum]['status'] == 'all') ? 'selected' : '';
  $access_reged = ($allforums[$inforum]['status'] == 'reged') ? 'selected' : '';
  $access_no = ($allforums[$inforum]['status'] == 'no') ? 'selected' : '';

  $upsize = (isset($allforums[$inforum]['upload'])) ? $allforums[$inforum]['upload']/1024 : '';
  $button = $lang['Update'];

  $title_page = $lang['Administrating'];
  include('./admin/all_header.tpl');
  include('./admin/addforum.tpl');

}

function doedit() {
global $exbb,$vars,$lang;

  $inforum = $vars['forum'];

  $filetoopen = $exbb['home_path'].'data/allforums.php';
  $allforums = get_file($filetoopen);
  $all = fopen($filetoopen,'r+');
  lock_file($all);

  if (!isset($allforums[$inforum])) {fclose($all); error($lang['Info'],$lang['Forum_edit_error'],'',0);}

  $filetomake = $exbb['home_path'].'data/allforums_bak.php';
  $backup = $exbb['home_path'].'data/allforums.php';
  @copy($backup,$filetomake);
  @chmod($filetomake,$exbb['ch_files']);

  if (!empty($vars['forummoderator'])) {

    make_moderators();

  }

  $allforums[$inforum]['name'] = $_POST['forumname'];;
  $allforums[$inforum]['desc'] = $_POST['forumdescription'];
  $allforums[$inforum]['moderator'] = $vars['forummoderator'];
  $allforums[$inforum]['codes'] = ($vars['codestate'] == 'on') ? true : false;
  $allforums[$inforum]['polls'] = ($vars['polls'] == '1') ? true : false;
  $allforums[$inforum]['private'] = ($vars['privateforum'] == 'yes') ? true : false;
  $allforums[$inforum]['status'] = $vars['startnewthreads'];

  if ( !empty($vars['forumgraphic']) ) {
    $vars['forumgraphic'] = trim($vars['forumgraphic']);
    if ( file_exists($exbb['home_path'].'im/images/'.$vars['forumgraphic']) ) { $allforums[$inforum]['icon'] = $vars['forumgraphic']; }
    else { unset($allforums[$inforum]['icon']); }
  } else {
    unset($allforums[$inforum]['icon']);
  }

  $vars['upsize'] = ($vars['upsize'] > 0) ? (int)$vars['upsize'] * 1024 : '';
  if ($vars['upsize']) {$allforums[$inforum]['upload'] = $vars['upsize'];}
  else { unset($allforums[$inforum]['upload']);}

  save_opened_file($all,$allforums);
  error($lang['Info'],$lang['Forum_edit_ok'],'',0);

}

function make_moderators() {
global $exbb,$vars,$lang;

    $moderators = str_replace(', ',',',$vars['forummoderator']);
    $moders = $moderators;
    $moderators = preg_replace ($lang['search'], $lang['replace'], $moderators);
    $moderators = explode(',',$moderators);
    $moders = explode(',',$moders);
    $allusers = get_file($exbb['home_path'].'data/users.php');
    $mod_id = array();
    $count = count($moderators);
    $i = 0;
    foreach ($allusers as $id=>$info) {
       foreach ($moderators as $pos=>$name) {
          if ($info['n'] == $name ) {
            $mod_id[$id] = $moders[$pos];
            $i++; break;
          }
       }
       if ($i == $count) break;
    }
    $vars['forummoderator'] = serialize($mod_id);
    unset($moderators,$allusers,$mod_id,$count,$i,$moders);

return;

}

function editcatname() {
global $exbb,$vars,$lang;

  $filetoopen = $exbb['home_path'].'data/allforums.php';
  $allforums = get_file($filetoopen);

  if (!isset($vars['doedit'])) {

        $incategory = $vars['category'];
        foreach ($allforums as $id=>$forum) {
          if ($incategory == $forum['catid']) {
            $categoryname = $forum['catname'];
          }
        }

        $title_page = $lang['Administrating'];
        include('./admin/all_header.tpl');
        include('./admin/edit_catname.tpl');
  }
  else{
        $incategory = $vars['category'];

        $all = fopen($filetoopen,'r+');
		lock_file($all);

        foreach ($allforums as $id=>$forum){
           if ($incategory == $forum['catid']) $allforums[$id]['catname'] = $_POST['categoryname'];
        }
        save_opened_file($all,$allforums);

        error($lang['Info'],$lang['New_catname_ok'],'',0);
  }

}

function reordercats() {
global $exbb,$vars;

  $incategory = intval($vars['category']);
  $tomove = intval($vars['move']);

  if ($incategory == 1 && $tomove == -1) { Header('Location: setforums.php'); exit;}

  $filetoopen = $exbb['home_path'].'data/allforums.php';
  $allforums = get_file($filetoopen);
  $all = fopen($filetoopen,'r+');
  lock_file($all);
  $categories = array();
  foreach ($allforums as $id=>$forum) {
    if ($lastid != $forum['catid']) $categories[] = $forum['catid'];
    $lastid = $forum['catid'];
  }

  if (count($categories) == 1) { fclose($all); Header('Location: setforums.php'); exit;}
  if ($incategory == count($categories) && $tomove == 1) { fclose($all); Header('Location: setforums.php'); exit;}

  $newcatid = ($tomove == 1) ? $incategory + 1 : $incategory - 1;

  if (isset($newcatid)) {
      $newallforums = array();
      $inpos = 0;
      $newpos = 0;
      foreach ($allforums as $id=>$forum) {
         if ($forum['catid'] == $incategory) {
            $newallforums[$id] = $forum;
            $newallforums[$id]['catid'] = $newcatid;
            $inpos++;
            if ($inpos < 10) {$newallforums[$id]['position'] = intval($newcatid.'0'.$inpos);}
            else {$newallforums[$id]['position'] = intval($newcatid.$inpos);}
         }
         elseif ($forum['catid'] == $newcatid) {
            $newallforums[$id] = $forum;
            $newallforums[$id]['catid'] = $incategory;
            $newpos++;
            if ($newpos < 10) {$newallforums[$id]['position'] = intval($incategory.'0'.$newpos);}
            else {$newallforums[$id]['position'] = intval($incategory.$newpos);}
         }
         else { $newallforums[$id] = $forum; }
      }
      uasort($newallforums,'sort_by_position');
      save_opened_file($all,$newallforums);
  } else {fclose($all);}
  Header('Location: setforums.php'); exit;
}

function reorderfrms() {
global $exbb,$vars,$lang;

  $inforum = $vars['forum'];
  $incategory = intval($vars['category']);
  $tomove = intval($vars['move']);

  $filetoopen = $exbb['home_path'].'data/allforums.php';
  $allforums = get_file($filetoopen);
  $all = fopen($filetoopen,'r+');
  lock_file($all);

  $allforums = make_positions($allforums);

  $pos = array();
  foreach ($allforums as $id=>$forum) {
    if ($incategory == $forum['catid']) {
        $pos[$id] = $forum['position'];
        $lastid = $id;
    }
  }
  $ids = array_keys($pos);
  if ($tomove == -1 && $allforums[$inforum]['position'] == $pos[$ids[0]]) {fclose($all); Header('Location: setforums.php'); exit;}
  if ($tomove == 1 && $allforums[$inforum]['position'] == $pos[$lastid]) {fclose($all); Header('Location: setforums.php'); exit;}

  $oldpos = $allforums[$inforum]['position'];
  if ($tomove == 1) {$newpos = $oldpos + 1;}
  if ($tomove == -1) {$newpos = $oldpos - 1;}

  foreach ($pos as $inf=>$pstion) {
      if ($pstion == $newpos) {$in = $inf; break;}
  }
  if (isset($in) && isset($newpos)) {
     $allforums[$inforum]['position'] = intval($newpos);
     $allforums[$in]['position'] = intval($oldpos);
     uasort($allforums,'sort_by_position');
     save_opened_file($all,$allforums);
  } else {fclose($all);}
  Header('Location: setforums.php'); exit;
}


function make_positions($all) {
	$pos = array();
	foreach ($all as $id => $data) {

		$lastid = $id;
		if ( !isset($pos[$data['catid']]) ) { $pos[$data['catid']] = $data['catid'] * 100 + 1; }
		$all{$id}['position'] = $pos[$data['catid']]++;

	}
	uasort($all,'sort_by_position');
	return $all;
}


function restore() {
global $exbb,$vars,$lang;

  $inforum = $vars['forum'];
  if ( !isset($vars['step']) ) {
	  
	  $dirtoopen = $exbb['home_path'].'forum'.$inforum;

	  if ( !($topics_files = get_dir($dirtoopen,'*-thd.php') ) ) {

		  if ( $handle = @opendir($dirtoopen) ) {
			  $topics_files = array();
			  while ( ($file = @readdir($handle) ) !== false ) {
				  if ( strstr($file,'-thd.') ) $topics_files[] = $file;
			  }
		  }
		  else { error($lang['System_error'],$lang['Wrong_forum_dir'].$dirtoopen); }
	  }

	  $filetosave = $exbb['home_path'].'forum'.$inforum.'/all_thd.php';
	  save_file($filetosave,$topics_files);
	  @chmod($filetosave,0777);
	  unset($topics_files);
	  error($lang['List_forum_dir'],sprintf($lang['List_forum_rebuild'],$inforum),'',false);
  }
  else {
	  $all_topics = get_file($exbb['home_path'].'forum'.$inforum.'/all_thd.php');

	  if ( !is_array($all_topics) ) error($lang['System_error'],$lang['List_forum_no'],'',false);

	  $filetoopen = $exbb['home_path'].'forum'.$inforum.'/list.php';
	  if ( file_exists($filetoopen) ) $list = get_file($filetoopen);

	  if ( !is_array($list) ) { $lst = fopen($filetoopen,'w'); $list = array(); }
	  else { $lst = fopen($filetoopen,'r+'); }

	  $restored = 0;

	  foreach ($all_topics as $topic_id) {
		  $id = (int)str_replace('-thd.php','',$topic_id);
		  if ( !isset($list[$id]['name']) || empty($list[$id]['name']) ) {
			  $list[$id]['name'] = '';
			  $restored++;
		  }
	  }
/*
	  if ( count($list) <> count($all_topics) ) {
		  //
	  }
*/
	  save_opened_file($lst,$list);
 	  @chmod($filetoopen,$exbb['ch_files']);
	  @unlink($exbb['home_path'].'forum'.$inforum.'/all_thd.php');

	  $mess = ( $restored ) ? sprintf($lang['List_forum_ok'],$restored,$inforum) : $lang['List_forum_done'];

	  error($lang['List_forum_dir'],$mess,'',false);
  }

}

?>