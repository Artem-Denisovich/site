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

$intopic = $vars['topic'];
$inforum = $vars['forum'];
$instart = isset($vars['start']) ? $vars['start'] : 1;

if (!isset($intopic) || $intopic == 0) die('Hack attempt!');

$forum = get_file($exbb['home_path'].'data/allforums.php');

$category = $forum[$inforum]['catname'];
$forumname = stripslashes($forum[$inforum]['name']);
$catid = $forum[$inforum]['catid'];
$codestate = $forum[$inforum]['codes'];

if ((!$inuser['private'][$inforum]) && ($forum[$inforum]['private'])) { error($lang['Privat_topic'],$lang['Privat_denied']);}
unset($forum);
$filetoopen = $exbb['home_path'].'forum'.$inforum.'/list.php';
$list = get_file($filetoopen);
$cur_topic = array();
$cur_topic[$intopic] = $list[$intopic];
unset($list);

$topictitle = $cur_topic[$intopic]['name'];

if ($privateforum != 'yes') whosonline($lang['Topic_see'].' <a href="topic.php?forum='.$inforum.'&topic='.$intopic.'"><b>'.$topictitle.'</b></a> - <a href="forums.php?forum='.$inforum.'"><b>'.$forumname.'</b></a>');

if ( isset($cur_topic[$intopic]['fls']) ) {

  $extmode = unserialize($cur_topic[$intopic]['ext']);

  $in_end = $cur_topic[$intopic]['fls'];
} else {
  $in_end = 0;
}

$numberofpages = $in_end + 1;
$pagestart = intval($instart);
if ($pagestart < 1 or $pagestart > $numberofpages) $pagestart = 0;

$in_file = ($pagestart <= 1) ? '' : $pagestart - 1;

if ( empty($in_file) ) { $count = 1; }
else { $extmode = array_slice($extmode,0,$in_file); $count = array_sum($extmode) + 1; }

$showmore = ($numberofpages > 1) ? true : false;
$pageshow = 10;

if ($showmore && !isset($vars['action'])) {

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
       if ($pagestart != $i) {$pages .= '<a href="printpage.php?forum='.$inforum.'&topic='.$intopic.'&start='.$i.'">'.$i.'</a> ';}
       else {$pages .= '<span class="moder">['.$i.']</span> ';}
   }
   $prevpage =  ($prevpage) ? '<a href="printpage.php?forum='.$inforum.'&topic='.$intopic.'&show='.$prevpage.'" title="'.$lang['page_prev'].'">&laquo;</a> ' : '';
   $nextpage =  ($pagestart < $numberofpages) ? '<a href="printpage.php?forum='.$inforum.'&topic='.$intopic.'&start='.$nextpage.'" title="'.$lang['page_next'].'">&raquo;</a> ' : '';
   $lastpage = ($limitupper < $numberofpages) ? '<a href="printpage.php?forum='.$inforum.'&topic='.$intopic.'&start='.$numberofpages.'" title="'.$lang['page_last'].'">'.$lang['page_last'].'</a> ' : '';
   $firspage = ($limitlower > 1) ? '<a href="printpage.php?forum='.$inforum.'&topic='.$intopic.'&start=1" title="'.$lang['page_first'].'">'.$lang['page_first'].'</a> ' : '';
   $pages = '<b>'.$lang['Pages'].'</b> ('.$numberofpages.'): '.$firspage.' '.$prevpage.' '.$pages.' '.$nextpage.' '.$lastpage;

   unset($numberofpages,$limitlower,$limitupper,$prevpage,$nextpage,$lastpage,$firspage);
}

$filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd';

if (isset($vars['action'])) {
   $threads = array();
   if (!empty($in_end)) {
     @set_time_limit(600);
     for ($i=0; $i<=$in_end; $i++) {
       $fileid = ($i) ? $i : '';
       if (file_exists($filetoopen.$fileid.'.php')) {
         $thd = get_file($filetoopen.$fileid.'.php');
         $threads += in_topic();
       }
     }
   } else {
     if (file_exists($filetoopen.'.php')) {
       $thd = get_file($filetoopen.$fileid.'.php');
       $threads = in_topic();
     }
   }
   $pages = count($threads);
   if (!$pages) error($lang['srch_intop'],$lang['srch_notfound'],'',0);
   unset($thd);
   $pages = $lang['srch_found'].$pages;
}
else {

  $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd'.$in_file.'.php';
  if (file_exists($filetoopen)) {
     $threads = get_file($filetoopen);
     if (!is_array($threads)) error($lang['Topic_open'],$lang['Topic_miss']);
  } else { error($lang['Topic_open'],$lang['Topic_miss']); }

}
ksort($threads,SORT_NUMERIC);

$names = array();
$names[0] = $lang['Unreg'];

foreach ($threads as $key=>$info) {

  $m_id = isset($threads[$key]['p_id']) ? $threads[$key]['p_id'] : 0;
  if ( !isset($names[$m_id]) ) {
     $info = getmember($m_id);
     $names[$m_id] = ( is_array($info) ) ? $info['name'] : $lang['Unreg'];
  }

  $membername = $names[$m_id];
  $date = ' - '.longDate($key+$exbb['usertime']*3600);
  $showemoticons = $threads[$key]['smiles'];
  $post = $threads[$key]['post'];
  if (isset($threads[$key]['edited'])) $post .= '<p>[s]('.$lang['Edited_by_own'].longDate($threads[$key]['edited']+$exbb['usertime']*3600).')[/s]';
  if (isset($threads[$key]['mo_edited'])) {
    $post .= '<p><font color=green>[s]'.$lang['Edited_by_mo'].$threads[$key]['mo_editor'].', '.longDate($threads[$key]['mo_edited']+$exbb['usertime']*3600).'[/s]</font>';
    if (isset($threads[$key]['mo_text']) && !isset($threads[$key]['ad_edited'])) $post .= '<br>'.$threads[$key]['mo_text'];
  }
  if (isset($threads[$key]['ad_edited'])) {
    $post .= '<p><font color=red>[s]'.$lang['Edited_by_ad'].$threads[$key]['ad_editor'].', '.longDate($threads[$key]['ad_edited']+$exbb['usertime']*3600).'[/s]</font>';
    if (isset($threads[$key]['mo_text'])) $post .= '<br>'.$threads[$key]['mo_text'];
  }

  if ($codestate) $post = ikoncode($post);

  if (($exbb['emoticons']) && ($showemoticons)) $post = setsmiles($post);

  include('./templates/'.$exbb['default_style'].'print_data.tpl');
  $count++;
}
 if (is_array($query_arr) and $query['mode'] == 'post' and isset($vars['color']) ) {
    foreach ($query_arr as $word) $print_data = preg_replace("/$word/i",'<font color=red>'.$word.'</font>',$print_data);
 }
 $title_page = (isset($vars['action'])) ? $lang['srch_intop'] : $lang['print_page'];
 $title_page = $title_page .' :: '. $topictitle . ' - '. $exbb['boardname'];
 if ($pagestart > 1) { $title_page .= " [$pagestart]"; }

 if ($exbb['wordcensor']) $print_data = bads_filter($print_data);

include('./templates/'.$exbb['default_style'].'printpage.tpl');
include('./templates/'.$exbb['default_style'].'footer.tpl');
include('page_tail.php');



function in_topic() {
global $exbb,$vars,$lang,$query,$thd,$query_arr;

  $query_arr = get_query();
  if (count($query_arr) == 0) error($lang['srch_intop'],$lang['srch_noquery'],'',0);
  $res = array();
  $n_queries = count($query_arr);
  if ($query['mode'] == 'post') {
    foreach ($thd as $id=>$infa) {
      $find = false; $finded = 0;
      foreach ($query_arr as $word) {
        if (preg_match("/$word/i",$infa['post'])) { $find = true; $finded++; }
      }
      if ($query['type'] == 'AND') $find = ($n_queries == $finded) ? true : false;

      if ($find) $res[$id] = $infa;
    }
  } else {
      $allusers = get_file($exbb['home_path'].'data/users.php');
      $user = preg_replace ($lang['search'], $lang['replace'], $query['data']);
      $u_id = 0;
      if ($user != 'guest') {
        foreach ($allusers as $id=>$info) {
           if ($info['n'] == $user) {$u_id = $id; break;}
        }
        if (!$u_id) return $res;
      }
      unset($allusers);

      foreach ($thd as $id=>$infa) {
        $find = false; $finded = 0;
        if ($infa['p_id'] == $u_id) {$res[$id] = $infa;}
      }
  }

  return $res;
}

function get_query() {
global $query,$vars;

    $query = array();
    $query['mode'] = 'post';

    if ( empty($vars['post']) && empty($vars['user']) ) { return array(); }

    if ( !empty($vars['post']) ) { $query['data'] = $vars['post']; $query['type'] = $vars['stype'];}
    else {$query['data'] = $vars['user']; $query['mode'] = 'poster';}
    $query_arr_dum = array();
    switch ($query['mode']) {
       case 'post': $query_arr_dum = preg_split("/\s+/",$query['data']);
       case 'poster': $query_arr_dum[] = trim($query['data']);
    }
    foreach($query_arr_dum as $word) {
      if (strlen($word) < 3) { continue; }
        #if (array_key_exists($word,$stop_words_array)) { continue; }
        $query_arr[] = $word;
    }

    unset($query_arr_dum,$word);
    return $query_arr;
}

?>