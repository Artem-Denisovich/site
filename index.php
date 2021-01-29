<?
/***************************************************************************
 * ExBB v.1.1                                                              *
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
include('common.php');

$vars = parsed_vars();


$allforums = get_file($exbb['home_path'].'data/allforums.php');

if ( isset($vars['action']) && $exbb['reged']) {
    mark_board();
    exit;
}
$news_data = null;
if ($exbb['announcements']) {

    $filetoopen = $exbb['home_path'].'data/news.php';

    if (file_exists($filetoopen)) {

        $news = get_file($filetoopen);

        if (count($news) && is_array($news)) {
            krsort($news);
            reset($news);
            $dateposted = key($news);
            $titlenews = $news[$dateposted]['t'];
            unset($news);
            $dateposted += $exbb['usertime'] * 3600;
            $dateposted = date("d.m.Y",$dateposted);
            include('./templates/'.$exbb['default_style'].'news.tpl');
            unset($titlenews,$dateposted);
        }
    }

} #end announs

if (isset($vars['c'])) {
    $arr_tmp = array();
    foreach ($allforums as $id=>$forum){
             if ($vars['c'] == $forum['catid']) $arr_tmp[$id] = $forum;
    }
    $allforums = array();
    $allforums = $arr_tmp;
    $arr_tmp = array();
}

$l_v = $exbb['last_visit'];
$board_data = '';
$lastcategoryplace = -1;

foreach ($allforums as $id=>$forum){
   if ( !defined('IS_ADMIN') ) {
	   if ( !$inuser['private'][$id] && $forum['private'] )  continue;
   }
   $arr_tmp[$id] = $forum;
}
$allforums = $arr_tmp;
unset($arr_tmp);

foreach ($allforums as $id=>$forum) {

   $threads = $forum['topics'];
   $posts = $forum['posts'];
   $category = $forum['catname'];
   $in_cat = $forum['catid'];

   if ($exbb['reged']) {
       if ($f_readed = (isset($_COOKIE['f'.$id])) ? $_COOKIE['f'.$id] : 0) {
           $exbb['last_visit'] = $f_readed > $exbb['last_visit'] ? $f_readed : $exbb['last_visit'];
       }
   }

   $lang_moder = $modoutput = '';

   if (!empty($forum['moderator'])) moderator($id,$allforums);

   $catrow = ($forum['catid'] != $lastcategoryplace) ? true : false;

   $forumname = '<a href="forums.php?forum='.$id.'">'.stripslashes($forum['name']).'</a>';
   $forumdescription = stripslashes($forum['desc']);

   if (isset($forum['last_time']) && $exbb['reged']) {
     if ($forum['last_time'] > $exbb['last_visit']) {
       $folderpicture = (!empty($forum['icon'])) ? '<img src="./im/images/'.$forum['icon'].'" border="0">' : '<img src="./templates/'.$exbb['default_style'].'im/foldernew.gif" border="0">';
     }
     else { $folderpicture = (!empty($forum['icon'])) ? '<img src="./im/images/no_'.$forum['icon'].'" border="0">' : '<img src="./templates/'.$exbb['default_style'].'im/folder.gif" border="0">'; }
   }
   else {
	   $folderpicture = '<img src="./templates/'.$exbb['default_style'].'im/folder.gif" border="0">';
	   $loginmessage = $lang['Marked_posts'];
   }

   $forumlastpost =  ( !empty($forum['last_time']) ) ? date("d.m.Y - H:i", $forum['last_time'] + $exbb['usertime']*3600) : $lang['NA'];

   $lastposterfilename = $forum['last_poster'];

   $lastpost = '';
   if (isset($forum['last_post'])) {
     $savet = $forum['last_post'];
     if (strlen($savet)>36) {$savet = substr($savet,0,35).'...';}
     $lastpost = '<img src="./templates/'.$exbb['default_style'].'im/lastpost.gif"> <a href="topic.php?forum='.$id.'&topic='.$forum['last_post_id'].'&v=l#'.$forum['last_key'].'" title="'.$forum['last_post'].'">'.$savet.'</a>';
   }

   $private = '<br>'.$lastpost.'<br>'.$lang['Author'].': ';
   $private .= ( $forum['last_poster_id'] ) ? '<a href="profile.php?action=show&member='.$forum['last_poster_id'].'">'.$forum['last_poster'].'</a>' : $lang['Unreg'];

  $lastcategoryplace = $forum['catid'];
  $next = next($allforums);
  $last = ( !$next || $next['catid'] != $forum['catid'] ) ? true : false;

  include ('./templates/'.$exbb['default_style'].'board_data.tpl');
}

if ($exbb['wordcensor']) $board_data = bads_filter($board_data);
include ('./data/boardstats.php');
whosonline($lang['ExBB_main'],true);
$max_users = max_online();
$max_users[0] = intval($max_users[0]);
$total_users = $guests + $members;

$online_last = sprintf($lang['online_data'],$exbb['membergone'],$total_users,$members,$guests) . ' [ <font color=red>'.$lang['Admin'].'</font>, <font color=green>'.$lang['Moderator'].'</font> ]';
$maximum = sprintf($lang['Max_users'],$max_users[1]).date("d.m.Y H:i",$max_users[0]+$exbb['usertime']*3600);

$basetimes = longdate(time() + $exbb['usertime'] * 3600);

$exbb['last_visit'] = $l_v;

$lastvisit = longdate($exbb['last_visit'] + $exbb['usertime'] * 3600);
$link = $newmail = null;
if ($inuser['new_pm']) include('./templates/'.$exbb['default_style'].'newmail.tpl');
$title_page = $exbb['boardname'];
include('./templates/'.$exbb['default_style'].'all_header.tpl');
include('./templates/'.$exbb['default_style'].'logos.tpl');
include('./templates/'.$exbb['default_style'].'board_body.tpl');
include('./templates/'.$exbb['default_style'].'footer.tpl');
include('page_tail.php');
?>