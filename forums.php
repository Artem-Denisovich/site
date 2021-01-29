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

$inforum = $vars['forum'];

if ($exbb['reged']) {

    if ($vars['action'] == 'markall') mark_forum();
    $t_visits = (isset($_COOKIE['t_visits'])) ? unserialize($_COOKIE['t_visits']) : array();
    if ($f_readed = (isset($_COOKIE['f'.$inforum])) ? $_COOKIE['f'.$inforum] : 0) {
       $exbb['last_visit'] = $f_readed > $exbb['last_visit'] ? $f_readed : $exbb['last_visit'];
    }
    $markforum = '<a href="forums.php?action=markall&forum='.$inforum.'">'.$lang['Forum_mark'].'</a>';
}

$forum = get_file($exbb['home_path'].'data/allforums.php');
$allowed = false;

if ( ($exbb['reged']) && ($inuser['private'][$inforum]) ) {
    $allowed = true;
}

forumjump($forum);
if ($jumpto != '') { Header("Location: $jumpto"); exit; }

if (!isset($forum[$inforum])) error($lang['Main_msg'],$lang['Dont_chg_url']);

$category = $forum[$inforum]['catname'];
$forumname = stripslashes($forum[$inforum]['name']);
$catid = $forum[$inforum]['catid'];

 # Check if it's a private forum, and is the member cleared?
 if (defined('IS_ADMIN')) $allowed = true;
 if (($forum[$inforum]['private']) && (!$allowed)) error($lang['Privat_enter'],$lang['Privat_login'].$lang['Privat_rule']);

 if (!$forum[$inforum]['private']) { whosonline($lang['View_forum']." <a href=\"forums.php?forum=$inforum\"><b>".$forum[$inforum]['name'].'</b></a>'); }

 if (isset($forum[$inforum]['moderator'])) {
    moderator($inforum,$forum);
 }

 # Open up the forum threads list

    $filetoopen = $exbb['home_path'].'forum'.$inforum.'/list.php';
    if (file_exists($filetoopen)) {
        $topics = get_file($filetoopen);
    } else {$topics = array();}
    $to_page = '';
    if (isset($vars['filterby']) and $vars['word'] != '') {
       $word = $vars['word'];
	   $topics = filtered($word);
	   $resetfiltr = '<a href="forums.php?forum='.$inforum.'">'.$lang['Reset_filter'].'</a>';
       $to_page = '&filterby='.$vars['filterby'].'&word='.$vars['word'];
    }
    # Limit the total topics to a span
    $pagestart = isset($vars['show']) ? intval($vars['show']) : 1;
    $numberofitems = count($topics);
    $numberofpages = ceil($numberofitems/$exbb['topics_per_page']);
    if (!isset($pagestart) || $pagestart < 1 || $pagestart > $numberofpages) $pagestart = 1;

    if ($numberofitems > $exbb['topics_per_page']) {
        $showmore = true;
        $startarray = ($pagestart - 1) * $exbb['topics_per_page'];
        $endarray = $exbb['topics_per_page'];
    }
    else {
           $showmore = false;
           $startarray = 0;
           $topicpages = $lang['Pages'].' ('.$numberofpages.')';
           $endarray = $numberofitems;
         }

    # if we have multiple pages, print them
        $pageshow = 8;
        if ($showmore) { #1
           if ($pagestart > 1) $prevpage = $pagestart - 1;
           if ($pagestart < $numberofpages) $nextpage = $pagestart + 1;

          $limitlower = $pagestart - $pageshow + 1;
          $limitupper = $pagestart + $pageshow - 1;
          if ($limitupper > $numberofpages) {
              $limitupper = $numberofpages;
              if ($limitlower > $numberofpages) $limitlower = $numberofpages - $pageshow;
          }
          if ($limitlower <= 0) $limitlower = 1;
          for($i=$limitlower;$i<=$limitupper;$i++){
             if ($pagestart != $i) {$pages .= '<a href="forums.php?forum='.$inforum.'&show='.$i.$to_page."\">$i</a> ";}
             else {$pages .= '<span class="moder">['.$i.']</span> ';}
          }
          $prevpage =  ($prevpage) ? '<a href="forums.php?forum='.$inforum.'&show='.$prevpage.'"'.$to_page.'" title="'.$lang['page_prev'].'">&laquo;</a> ' : '';
          $nextpage =  ($pagestart < $numberofpages) ? '<a href="forums.php?forum='.$inforum.'&show='.$nextpage.'"'.$to_page.'" title="'.$lang['page_next'].'">&raquo;</a> ' : '';
          $lastpage = ($limitupper < $numberofpages) ? '<a href="forums.php?forum='.$inforum.'&show='.$numberofpages.'"'.$to_page.'" title="'.$lang['page_last'].'">'.$lang['page_last'].'</a> ' : '';
          $firspage = ($limitlower > 1) ? '<a href="forums.php?forum='.$inforum.'&show=1'.$to_page.'" title="'.$lang['page_first'].'">'.$lang['page_first'].'</a> ' : '';
          $topicpages = $lang['Pages'].' ('.$numberofpages.'): '.$firspage.' '.$prevpage.' '.$pages.' '.$nextpage.' '.$lastpage;
        } #1

     switch ($forum[$inforum]['status']) {
       case 'all': $who = $lang['All_users_can']; break;
       case 'reged': $who = $lang['Reg_users_can']; break;
       default: $who = $lang['Admins_only'];
     }

    $keys = array_keys($topics);
    $keys = array_slice($keys,$startarray,$endarray);

    $pinned = isset($vars['filterby']) ? array() : get_file($exbb['home_path'].'forum'.$inforum.'/_pinned.php');
    if ( count($pinned) ) {
       foreach ($pinned as $pin=>$id) array_unshift($keys,$pin);
       $keys = array_unique($keys);
    }

    foreach ($keys as $id=>$topicid) {

      if (!isset( $topics[$topicid]['name'] ) || empty($topics[$topicid]['name']) ) $topics[$topicid]['name'] = $topics[$topicid]['author'].date(" d.m.Y H:i",$topics[$topicid]['date']);

      $topictitle = wordwrap($topics[$topicid]['name'], 32, ' &shy; ', 1);
      $topicdescription = wordwrap($topics[$topicid]['desc'], 32, ' &shy; ', 1);
      $threadposts = $topics[$topicid]['posts'];
      $startedby = $topics[$topicid]['author'] ? $topics[$topicid]['author'] : $lang['Unreg'];
      $startedpostdate = $topics[$topicid]['date'];
      $lastposter = $topics[$topicid]['poster'] ? $topics[$topicid]['poster'] : $lang['Unreg'];
      $lastpostdate = $topics[$topicid]['postdate'];

      $startedby = $topics[$topicid]['a_id'] ? '<a href="profile.php?action=show&member='.$topics[$topicid]['a_id'].'"><b>'.$startedby.'</b>' : $startedby;

      if ( isset($topics[$topicid]['fls']) ) {

        $extmode = unserialize($topics[$topicid]['ext']);

        $in_first = $extmode[0];
        $in_end = $topics[$topicid]['fls'];
        unset($extmode);

      } else {
        $in_first =  $topics[$topicid]['posts'] + 1;
        $in_end = 0;
      }

      $numberofpages = ceil($in_first/intval($exbb['posts_per_page'])) + $in_end;
      $threadpages = '';
      $pagestoshow = '&nbsp;[ <a href="printpage.php?forum='.$inforum.'&topic='.$topicid.'" title="'.$lang['print_page'].'">#</a>';
      if ($numberofpages > 1) {
        $limitupper = ($numberofpages < $pageshow) ? $numberofpages : $pageshow;
        for ($p=2;$p<=$limitupper;$p++){
           $threadpages .= '<a href="topic.php?forum='.$inforum.'&topic='.$topicid.'&start='.$p.'">'.$p.'</a> ';
        }
        $middlepage = ($numberofpages > $pageshow * 2) ? ceil($numberofpages/2) : 0;
        $lastpage = ($numberofpages > $pageshow) ? $numberofpages : 0;
        $middlepage = ($middlepage) ? '<a href="topic.php?forum='.$inforum.'&topic='.$topicid.'&start='.$middlepage.'">...</a> ' : '';
        $lastpage = ($lastpage) ? '<a href="topic.php?forum='.$inforum.'&topic='.$topicid.'&start='.$lastpage.'" title="'.$lang['page_last'].'">'.$lang['page_last'].'</a>' : '';
        $pagestoshow .= '&nbsp;'.$lang['Page'].'&nbsp;'.$threadpages.' '.$middlepage.' '.$lastpage;
      }
      $pagestoshow .= ' ]';

      if ($exbb['reged']) {
        if ( isset($pinned[$topicid]) ) $topics[$topicid]['state'] = 'pinned';
        $top_id = $inforum.$topicid;
        $topicicon = topic_icon($topics[$topicid],$t_visits[$top_id]);
      }

      $lastpostdate = ( !empty($lastpostdate) ) ? longdate($lastpostdate + $exbb['usertime'] * 3600) : $lang['NA'];

      $startedpostdate = $startedpostdate + ($exbb['usertime'] * 3600);
      $startedlongdate = date("d.m.Y",$startedpostdate);

      $topictitle = '<a href="topic.php?forum='.$inforum.'&topic='.$topicid.'">'.$topictitle.'</a>';
      if ( isset($topics[$topicid]['poll']) ) $topictitle .= ' <img src="./im/images/stats.gif" width=20 height=20 border="0" alt="'.$lang['Poll'].'">';
      $lastposter = $topics[$topicid]['p_id'] ? '<a href="profile.php?action=show&member='.$topics[$topicid]['p_id'].'">'.$lastposter.'</a>' : $lastposter;

      $topicdescription = (!empty($topicdescription)) ? '<br>&nbsp;&nbsp;&raquo;'.$topicdescription : '';

      include('./templates/'.$exbb['default_style'].'forum_data.tpl');

} # end topic foreach
if ($exbb['wordcensor']) $forum_data = bads_filter($forum_data);

if ( $exbb['reged'] ) {

  $filetoopen = $exbb['home_path'].'forum'.$inforum.'/_f_track.php';
  $emailers = ( file_exists($filetoopen) ) ? get_file($filetoopen) : array();
  $options = (isset($emailers[$exbb['mem_id']]) && $vars['action'] != 'untrack') ? '<a href="forums.php?action=untrack&forum='.$inforum.'&show='.$pagestart.'">'.$lang['untrack_forum'].'</a>' : '<a href="forums.php?action=track&forum='.$inforum.'&show='.$pagestart.'" title="'.$lang['track_forum_mes'].'">'.$lang['track_forum'].'</a>';
  if ($vars['action'] == 'untrack') {
     unset($emailers[$exbb['mem_id']]);
     save_file($filetoopen,$emailers);
  }
  if ($vars['action'] == 'track') {
     $options = '<a href="forums.php?action=untrack&forum='.$inforum.'&show='.$pagestart.'">'.$lang['untrack_forum'].'</a>';
      $emailers[$exbb['mem_id']] = 1;
      save_file($filetoopen,$emailers);
  }
  unset($emailers,$filetoopen);
}

$newthreadbutton = '<a href="post.php?action=new&forum='.$inforum.'"><img src="./templates/'.$exbb['default_style'].'im/'.$exbb['default_lang'].'/newthread.gif" border="0"></a>';

if ($forum[$inforum]['polls'] && $exbb['reged']) $newthreadbutton .= '&nbsp;<a href="post.php?action=new&poll=1&forum='.$inforum.'"><img src="./templates/'.$exbb['default_style'].'im/'.$exbb['default_lang'].'/newpoll.gif" border="0"></a>';

if ($inuser['new_pm']) include('./templates/'.$exbb['default_style'].'newmail.tpl');
$icon_path = './templates/'.$exbb['default_style'].'im';

$title_page = $exbb['boardname'].' :: '.$category.' :: '.strip_tags($forumname);
include('./templates/'.$exbb['default_style'].'all_header.tpl');
include('./templates/'.$exbb['default_style'].'logos.tpl');
include('./templates/'.$exbb['default_style'].'forum_body.tpl');
include('./templates/'.$exbb['default_style'].'footer.tpl');
include('page_tail.php');

function filtered($word) {
global $lang,$vars,$topics;
  $res = array();
  switch ($vars['filterby']) {
     case 'topdesc': $field = 'desc'; break;
     case 'author': $field = 'author'; break;
	 default: $field = 'name'; break;
  }
  if (preg_match("/\b$word\b/i",$lang['Unreg'])) {
	  foreach ($topics as $id=>$info) {
		  if (!$info['author']) $res[$id] = $info;
	  }
  }
  else {
	  foreach ($topics as $id=>$info) {
		  if (preg_match("/$word/i",$info[$field])) $res[$id] = $info;
	  }
  }
  #myprint($res);
  return $res;
}
?>