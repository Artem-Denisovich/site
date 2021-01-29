<?
/***************************************************************************
 * ExBB v.1.1                                                              *
 * Copyright (c) 2002-20хх by Alexander Subhankulov aka Warlock            *
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
$jumpto = $vars['jumpto'];

if ( !isset($vars['topic']) || $vars['topic'] == 0 ) die('Hack attempt!');

$forum = get_file($exbb['home_path'].'data/allforums.php');

forumjump($forum);

if ($jumpto != '') { Header("Location: $jumpto"); exit; }

$exbb['delim_r'] = $exbb['text_menu'] ? ' : ' : '';

$exbb['icon_eml'] = $exbb['text_menu'] ? 'E-mail' : '<img src="./templates/'.$exbb['default_style'].'im/email.gif" border=0>';
$exbb['icon_www'] = $exbb['text_menu'] ? 'WWW' : '<img src="./templates/'.$exbb['default_style'].'im/homepage.gif" border=0>';
$exbb['icon_aol'] = $exbb['text_menu'] ? 'AOL' : '<img src="./templates/'.$exbb['default_style'].'im/aol.gif" border=0>';
$exbb['icon_pm'] = $exbb['text_menu'] ? $lang['Message'] : '<img src="./templates/'.$exbb['default_style'].'im/'.$exbb['default_lang'].'/message.gif" border=0>';
$exbb['icon_prf'] = $exbb['text_menu'] ? $lang['Profile'] : '<img src="./templates/'.$exbb['default_style'].'im/'.$exbb['default_lang'].'/profile.gif" border=0>';
$exbb['icon_edit'] = $exbb['text_menu'] ? $lang['Editing'] : '<img src="./templates/'.$exbb['default_style'].'im/'.$exbb['default_lang'].'/edit.gif" title='.$lang['Editing'].' alt='.$lang['Editing'].' border=0>';
$exbb['icon_del'] = $exbb['text_menu'] ? $lang['Delete'] : '<img src="./templates/'.$exbb['default_style'].'im/icon_delete.gif" border=0>';

$replygraphic = ($exbb['text_menu']) ? '<a title="'.$lang['java_paste'].'" onmouseover="copyQ();" href="javascript:pasteQ();">'.$lang['Paste_qte'].'</a>' : '<a title="'.$lang['java_paste'].'" onmouseover="copyQ();" href="javascript:pasteQ();"><img src="./templates/'.$exbb['default_style'].'im/'.$exbb['default_lang'].'/reply.gif" border=0></a>';

$category = $forum[$inforum]['catname'];
$forumname = stripslashes($forum[$inforum]['name']);
$catid = $forum[$inforum]['catid'];
$upload = ( isset($forum[$inforum]['upload']) && !empty($forum[$inforum]['upload']) && $exbb['file_upload'] ) ? $forum[$inforum]['upload'] : 0;

if ((!$inuser['private'][$inforum]) && ($forum[$inforum]['private'])) { error($lang['Privat_topic'],$lang['Privat_denied']);}

if ($exbb['reged']) {
    $top_id = $inforum.$intopic;
    $t_visits = (isset($_COOKIE['t_visits'])) ? unserialize($_COOKIE['t_visits']) : array();
    $t_visits[$top_id] = time();
    my_setcookie('t_visits',serialize($t_visits),86400);

}
     $allof = false;
     switch ($forum[$inforum]['status']) {
       case 'reged': if (!$exbb['reged']) {$allof = true;} break;
       default: $allof = false;
     }

$filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd.php';
if ( !file_exists($filetoopen) ) error($lang['Topic_open'],$lang['Topic_miss']);


$filetoopen = $exbb['home_path'].'forum'.$inforum.'/list.php';
$list = get_file($filetoopen);
#$list[$intopic]['views']++;
#save_file($filetoopen,$list);

$cur_topic = array();
$cur_topic[$intopic] = $list[$intopic];
unset($list);

$topictitle = wordwrap($cur_topic[$intopic]['name'], 32, ' &shy; ', 1);
$topicdescr = $cur_topic[$intopic]['desc'];
$threadstate = ( isset($cur_topic[$intopic]['state']) ) ? $cur_topic[$intopic]['state'] : 'closed';
$threadposts = $cur_topic[$intopic]['posts'];
$is_poll = isset($cur_topic[$intopic]['poll']) ? true : false;

#запрет ссылки цитирования
if ($allof || $threadstate == 'closed') {
	$replygraphic = null;
	$lang['MS_paste'] = '';
}

$movedto = null;
if (isset($cur_topic[$intopic]['movedid'])) {
   list($in_f,$in_t) = explode(':',$cur_topic[$intopic]['movedid']);
   $movedto = '<br> <img src="./templates/'.$exbb['default_style'].'im/moved.gif" border="0" alt="moved"><a href="topic.php?forum='.$in_f.'&topic='.$in_t.'" target="_self">'.$lang['Moved_to'].'</a>';
}


$inmembmod = moderator($inforum,$forum);

$newthreadbutton = '<a href="post.php?action=new&forum='.$inforum.'"><img src="./templates/'.$exbb['default_style'].'im/'.$exbb['default_lang'].'/newthread.gif" border="0"></a>';

if ($forum[$inforum]['polls'] && $exbb['reged']) $newthreadbutton .= ' &nbsp; <a href="post.php?action=new&poll=1&forum='.$inforum.'"><img src="./templates/'.$exbb['default_style'].'im/'.$exbb['default_lang'].'/newpoll.gif" border="0"></a>';

if (!$forum[$inforum]['private']) whosonline($lang['Topic_see'].' <a href="topic.php?forum='.$inforum.'&topic='.$intopic.'"><b>'.$topictitle.'</b></a> - <a href="forums.php?forum='.$inforum.'"><b>'.$forumname.'</b></a>');

if ($threadstate == 'open') {
    $replybutton = '<a href="post.php?action=reply&forum='.$inforum.'&topic='.$intopic.'"><img src="./templates/'.$exbb['default_style'].'im/'.$exbb['default_lang'].'/replytothread.gif" border="0"></a>';
}
else { $replybutton = '<img src="./templates/'.$exbb['default_style'].'im/'.$exbb['default_lang'].'/closed.gif" border="0" alt="'.$lang['Topic_closed'].'">'; }


if ( isset($cur_topic[$intopic]['fls']) ) {

  $extmode = unserialize($cur_topic[$intopic]['ext']);

  $in_first = $extmode[0];
  $in_end = $cur_topic[$intopic]['fls'];
} else {
  $in_first = $cur_topic[$intopic]['posts'] + 1;
  $in_end = 0;
}
unset($extmode);

$in_first_page = ceil($in_first/intval($exbb['posts_per_page']));
$numberofpages = $in_first_page + $in_end;

$pagestart = (isset($vars['v'])) ? $numberofpages : intval($instart);

if ($pagestart < 1 or $pagestart > $numberofpages) $pagestart = 1;

$in_file = ($pagestart <= $in_first_page) ? '' : $pagestart - $in_first_page;
if ($numberofpages > 1) {
    $showmore = true;
    $startarray = ($pagestart - 1) * $exbb['posts_per_page'];
    $endarray = intval($exbb['posts_per_page']);
} else {
    $showmore = false;
    $startarray = 0;
    $pages = $lang['Pages'].' ('.$numberofpages.')'.$movedto;
    $endarray = $in_first;
}
unset($in_first,$in_end,$in_first_page);

if ($showmore) {

   $pageshow = 4;

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
       if ($pagestart != $i) {$pages .= '<a href="topic.php?forum='.$inforum.'&topic='.$intopic.'&start='.$i.'">'.$i.'</a> ';}
       else {$pages .= '<span class="moder">['.$i.']</span> ';}
   }
   $prevpage =  ($prevpage) ? '<a href="topic.php?forum='.$inforum.'&topic='.$intopic.'&start='.$prevpage.'" title="'.$lang['page_prev'].'">&laquo;</a> ' : '';
   $nextpage =  ($pagestart < $numberofpages) ? '<a href="topic.php?forum='.$inforum.'&topic='.$intopic.'&start='.$nextpage.'" title="'.$lang['page_next'].'">&raquo;</a> ' : '';
   $lastpage = ($limitupper < $numberofpages) ? '<a href="topic.php?forum='.$inforum.'&topic='.$intopic.'&start='.$numberofpages.'" title="'.$lang['page_last'].'">'.$lang['page_last'].'</a> ' : '';
   $firspage = ($limitlower > 1) ? '<a href="topic.php?forum='.$inforum.'&topic='.$intopic.'&start=1" title="'.$lang['page_first'].'">'.$lang['page_first'].'</a> ' : '';
   $pages = '<b>'.$lang['Pages'].'</b> ('.$numberofpages.'): '.$firspage.' '.$prevpage.' '.$pages.' '.$nextpage.' '.$lastpage.$movedto;

}
unset($numberofpages,$limitlower,$limitupper,$prevpage,$nextpage,$lastpage,$firspage);

$filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd'.$in_file.'.php';
if (file_exists($filetoopen)) {
  $threads = get_file($filetoopen);
  if (!is_array($threads)) error($lang['Topic_open'],$lang['Topic_miss']);
} else { error($lang['Topic_open'],$lang['Topic_miss']); }

$keys = array_keys($threads);
sort($keys,SORT_NUMERIC);

if ( empty($in_file) ) $keys = array_slice($keys,$startarray,$endarray);
elseif ( isset($vars['v']) ) { $keys = array_slice($keys,-$exbb['posts_per_page']); }

$firstkey = reset($keys);
$style = './templates/'.$exbb['default_style'].'topic_data.tpl';

$bot = is_search_bot() ? true : false;

$names = array();
if ($exbb['ratings'] && !$bot) $ranks = get_file($exbb['home_path'].'data/membertitles.php');

$filetoopen = $exbb['home_path'].'forum'.$vars['forum'].'/attaches-'.$vars['topic'].'.php';
$t_attaches = ( file_exists($filetoopen) ) ? get_file($filetoopen) : array();

foreach ($keys as $id=>$key) {

  $member_id = isset($threads[$key]['p_id']) ? $threads[$key]['p_id'] : 0;
  $postipaddress = $threads[$key]['ip'];
  $showemoticons = $threads[$key]['smiles'];
  $post = $threads[$key]['post'];

  #Attach
  if ( isset($threads[$key]['attach_id']) ) {
	  if ( isset($t_attaches[$threads[$key]['attach_id']]['size']) && $exbb['show_img']) {
		  $post .= $lang['img_attach'].'<div align=center><img src="'.$exbb['boardurl'].'/uploads/'.urlencode($threads[$key]['attach_file']).'" alt="'.$threads[$key]['attach_file'].'"></div><br>';
	  }
	  else {
		  $post .= '<br><div align=right>'.$lang['Download_attach'].'<a href="tools.php?action=attach&f='.$inforum.'&t='.$intopic.'&id='.$threads[$key]['attach_id'].'" target="_blank">'.$threads[$key]['attach_file'].'</a><br><span class=moder>'.$lang['Downloads_attach'].$t_attaches[$threads[$key]['attach_id']]['hits'].'</span></div>';
	  }
  }

  if (isset($threads[$key]['edited'])) $post .= '<p>[s]('.$lang['Edited_by_own'].longDate($threads[$key]['edited']+$exbb['usertime']*3600).')[/s]';
  if (isset($threads[$key]['mo_edited'])) {
    $post .= '<p><hr><font color=green>[s]'.$lang['Edited_by_mo'].$threads[$key]['mo_editor'].', '.longDate($threads[$key]['mo_edited']+$exbb['usertime']*3600).'[/s]</font>';
    if (isset($threads[$key]['mo_text']) && !isset($threads[$key]['ad_edited'])) $post .= '<br>'.$threads[$key]['mo_text'];
  }
  if (isset($threads[$key]['ad_edited'])) {
    $post .= '<p><hr><font color=red>[s]'.$lang['Edited_by_ad'].$threads[$key]['ad_editor'].', '.longDate($threads[$key]['ad_edited']+$exbb['usertime']*3600).'[/s]</font>';
    if (isset($threads[$key]['mo_text'])) $post .= '<br>'.$threads[$key]['mo_text'];
  }

  if ($bot) {
      $topic_data .= '<tr><td colspan="2">'.$post.'</td></tr>';
      continue;
  }


  if (!array_key_exists($member_id,$names) ) {
    if (!checkuser($member_id)) { setup_guest($member_id);}
    else { setup_member($member_id); }
  }
  $username = $names[$member_id]['user'];
  $picon = $names[$member_id]['team'];
  $membertitle = $names[$member_id]['membertitle'];
  $signature = $threads[$key]['sig'] ? $names[$member_id]['signature'] : '';
  $useravatar = $names[$member_id]['useravatar'];
  $membergraphic = $names[$member_id]['membergraphic'];
  $location = $names[$member_id]['location'];

  $eml = $names[$member_id]['eml'];
  $www = $names[$member_id]['www'];
  $pm = $names[$member_id]['pm'];
  $prf = $names[$member_id]['prf'];
  $aim = $names[$named]['aim'];

  $edit = sprintf($names[$member_id]['edit'],$inforum,$intopic,$key,$in_file,$pagestart);
  $del = sprintf($names[$member_id]['del'],$inforum,$intopic,$key,$in_file,$pagestart);

  $posts = $names[$member_id]['posts'];
  $joined = $names[$member_id]['jnd'];

  $info = '<a href="topic.php?forum='.$inforum.'&topic='.$intopic.'&start='.$pagestart.'#'.$key.'">'.$lang['Post_date'].'</a> <b>'.longDate($key+$exbb['usertime']*3600).'</b>';
  $icq = $names[$member_id]['icq'];
  $uin = $names[$member_id]['uin'];

  if ($forum[$inforum]['codes']) $post = ikoncode($post);
  if (!empty($signature))  $post .= '<br><br>-----<br>'.$signature;

  $postbackcolor = ( !($id % 2) ) ? 'row1' : 'row2';

  if (($exbb['emoticons']) && ($showemoticons)) $post = setsmiles($post);

  if (defined('IS_ADMIN')) { $info .= ' | '.$postipaddress; }

  include($style);


}
unset($names);

if ($exbb['wordcensor']) $topic_data = bads_filter($topic_data);

if ($is_poll) {
   $poll_html = poll();
}
unset($firstkey);

$options = array();
$options['print'] = '<a href="printpage.php?forum='.$inforum.'&topic='.$intopic.'">'.$lang['print_page'].'</a>';

if ( $exbb['reged'] ) {

  $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-m.php';
  $emailers = ( file_exists($filetoopen) ) ? get_file($filetoopen) : array();
  $options['track'] = (isset($emailers[$exbb['mem_id']]) && $vars['action'] != 'untrack') ? '<a href="topic.php?action=untrack&forum='.$inforum.'&topic='.$intopic.'&start='.$pagestart.'">'.$lang['untrack_topic'].'</a>' : '<a href="topic.php?action=track&forum='.$inforum.'&topic='.$intopic.'&start='.$pagestart.'">'.$lang['track_topic'].'</a>';
  if ($vars['action'] == 'untrack') {
     unset($emailers[$exbb['mem_id']]);
     save_file($filetoopen,$emailers);
     unset($emailers);
  }

}

if ($forum[$inforum]['codes']) {
      $codemap = '<br><script language="JavaScript">ibcodes();</script>';
      $smilesmap = '<br><script language="JavaScript">ibsmiles();</script>';
      $java = '<script language="Javascript" src="smilesmap.js"></script><script language="Javascript" src="codesmap.js"></script>';
}

if ($threadstate != 'closed' && $threadstate != 'moved' && !$allof && !$bot){

    if ($exbb['emoticons']) {
       $emoticonsbutton = '<input type=checkbox name="inshowemoticons" value="yes" checked>'.$lang['Do_smiles'].'<br>';
    }
    if ($exbb['emailfunctions'] && $exbb['reged']) {
       $requestnotify = '<input type=checkbox name="notify" value="yes">'.$lang['Do_email'].'<br>';
    }
    $sig_check = $inuser['sig_on'] ? 'checked' : '';
	$showsig = ($exbb['reged']) ? "<input type=checkbox name='inshowsignature' value='yes' $sig_check>".$lang['Do_sig'] : '';
    $reg = (!$exbb['reged']) ? ' &nbsp; <a href="register.php">'.$lang['You_reged'].'</a>' : '';

    if ($upload && $inuser['upload']) {
      $enctype = ' enctype="multipart/form-data"';
      $hidden = '<input type="hidden" name="MAX_FILE_SIZE" value="'.$upload.'">';
      $filetoup = $lang['File_upload'].$upload.'<br /><input class="input" type="file" size="30" name="FILE_UPLOAD">';
    }
    include('./templates/'.$exbb['default_style'].'post_form.tpl');

    if ($vars['action'] == 'track' and $exbb['reged']) {
      $options['track'] = '<a href="topic.php?action=untrack&forum='.$inforum.'&topic='.$intopic.'&start='.$pagestart.'">'.$lang['untrack_topic'].'</a>';
      $emailers[$exbb['mem_id']] = 1;
      save_file($filetoopen,$emailers);
	  @chmod($filetoopen,$exbb['ch_files']);
      unset($emailers);
    }
}

$options = implode ( ' :: ', $options);

$mod_options = '';
if ($inmembmod) {
    $pinned = get_file($exbb['home_path'].'forum'.$inforum.'/_pinned.php');
    $pin = isset($pinned[$intopic]) ? '<option value="unpin">'.$lang['UnPin'].'</option>' : '<option value="pin">'.$lang['Pin'].'</option>';
    if ($threadstate == 'open') {
        $do = 'lock';
        $lang['Unlock'] = $lang['Blocking'];
    } else {
        $do = 'unlock';
    }
    include('./templates/'.$exbb['default_style'].'topic_options.tpl');
}

$title_page = $exbb['boardname'] .' :: '. $topictitle;
if ($pagestart > 1) { $title_page .= ' ['.$pagestart.']'; }

if ($inuser['new_pm']) include('./templates/'.$exbb['default_style'].'newmail.tpl');
$link = '<LINK rel="Start" title="Первая страница темы - First page" type="text/html" href="'.$exbb['boardurl'].'/topic.php?forum='.$inforum.'&topic='.$intopic.'">';
include('./templates/'.$exbb['default_style'].'all_header.tpl');
include('./templates/'.$exbb['default_style'].'logos.tpl');
include('./templates/'.$exbb['default_style'].'topic_body.tpl');
include('./templates/'.$exbb['default_style'].'footer.tpl');
include('page_tail.php');

function setup_guest($u_id = 0) {
global $names,$lang,$exbb,$inmembmod;
    $names[$u_id]['user'] = $lang['Unreg'];
    $names[$u_id]['membertitle'] = empty($u_id) ? $lang['No_reged'] : $lang['User_deleted'];
    if ($inmembmod) {
      $names[$u_id]['edit'] = '<a href="postings.php?action=edit&forum=%d&topic=%d&id=%d:%s:%d">'.$exbb['icon_edit'].'</a>'.$exbb['delim_r'];
      $names[$u_id]['del'] = '<a href="javascript:del_post(\'postings.php?action=processedit&deletepost=yes&forum=%d&topic=%d&id=%d:%s:%d\')">'.$exbb['icon_del'].'</a>';
    }
}

function setup_member($named) {
global $exbb,$names,$lang,$vars,$ranks,$inmembmod,$modoutput,$threadstate;

    $user = getmember($named);

    if ( ($exbb['mem_id'] == $named && $threadstate != 'closed') || $inmembmod) {
      $names[$named]['edit'] = '<a href="postings.php?action=edit&forum=%d&topic=%d&id=%d:%s:%d">'.$exbb['icon_edit'].'</a>'.$exbb['delim_r'];
   }
    if ($inmembmod) {
      $names[$named]['del'] = '<a href="javascript:del_post(\'postings.php?action=processedit&deletepost=yes&forum=%d&topic=%d&id=%d:%s:%d\')">'.$exbb['icon_del'].'</a>';
   }

    $names[$named]['user'] = $user['name'];
    $names[$named]['id'] = $user['id'];
    $names[$named]['membertitle'] = $user['title'];

    $user['posts'] = (empty($user['posts'])) ? 0 : $user['posts'];
    $names[$named]['posts'] = $lang['User_total_posts'].' <b>'.$user['posts'].'</b> :';

    if ($exbb['location']) {
      if ($user['location'] != '') {
        $names[$named]['location'] = (strlen($user['location']) > 20) ? '<br>'.$lang['From'].': '.substr($user['location'], 0, 20).' ...<br>' : '<br>'.$lang['From'].': '.$user['location'];
      }
    }

    $user['joined'] = ($user['joined']) ? joindate($user['joined']) : $lang['NA'];
    $names[$named]['jnd'] = $lang['User_reg_date'].' <b>'.$user['joined'].'</b> :';

    $names[$named]['signature'] = '';

    if ( $user['sig'] != '' and $exbb['sig'] ) {
      $names[$named]['signature'] = ikoncode($user['sig']);
    }

    if (($exbb['avatars']) && ($user['avatar'] != 'noavatar.gif') && ($user['avatar'] != '')) {
      $names[$named]['useravatar'] = '<br><img src="./im/avatars/'.$user['avatar'].'" border=0>';
    }

    $rang = reset($ranks);

   if ($exbb['ratings']) {
	   $names[$named]['membertitle'] = key($ranks);
	   $names[$named]['membergraphic'] = '<img src="./im/images/'.$rang['icon'].'" border=0>';
     foreach($ranks as $rang=>$info) {
        if ($user['posts'] >= $info['posts']) {
          $names[$named]['membertitle'] = $rang;
          $names[$named]['membergraphic'] = '<img src="./im/images/'.$info['icon'].'" border=0>';
        }
     }
   }

   if ( !empty($user['title']) && $user['title'] != $lang['User'] ) $names[$named]['membertitle'] = $user['title'];
   if ( empty($names[$named]['membertitle']) ) $names[$named]['membertitle'] = $lang['User'];


   if ($user['status'] == 'ad') {
     $names[$named]['team'] = ' <img src="./im/images/team.gif" border=0>';
     $names[$named]['membertitle'] = ( !empty($user['title']) ) ? $user['title'] : $lang['Admin'];
   }
   elseif (strpos($modoutput,$user['name'])) {
     $names[$named]['team'] = ' <img src="./im/images/team.gif" border=0>';
     $names[$named]['membertitle'] = ( !empty($user['title']) ) ? $user['title'] : $lang['moderator'];
   }
   elseif ($user['status'] == 'banned') {
     $names[$named]['membergraphic'] = '';
     $names[$named]['membertitle'] = $lang['User_banned'];
   }

   $names[$named]['eml'] = null;
   if ( $user['showemail'] ) {
      $names[$named]['eml'] = '<a href="mailto:'.$user['mail'].'">'.$exbb['icon_eml'].'</a>'.$exbb['delim_r'];
   }

   $names[$named]['www'] = null;
   if ( !empty($user['www']) && $user['www'] != 'http://') {
     $names[$named]['www'] = '<a href="http://'.str_replace('http://','',$user['www']).'" target="_blank">'.$exbb['icon_www'].'</a>'.$exbb['delim_r'];
   }

   $names[$named]['aim'] = null;
   if ($user['aim'] != '') {
     $names[$named]['aim'] = '<a href="aim:goim?screenname='.$named.'&amp;message=Hello+Are+you+there?">'.$exbb['icon_aol'].'</a>'.$exbb['delim_r'];
   }

   $names[$named]['icq'] = null;
   $names[$named]['uin'] = null;
   if ($user['icq'] !='') {
      $names[$named]['icq'] = ($exbb['text_menu']) ? '<a href="http://wwp.icq.com/scripts/search.dll?to='.$user['icq'].'">ICQ</a>' : '<a href="http://wwp.icq.com/scripts/search.dll?to='.$user['icq'].'"><img src="http://online.mirabilis.com/scripts/online.dll?icq='.$user['icq'].'&img=5" align=abscenter alt="ICQ" width=18 height=18 border=0></a>';
      $names[$named]['uin'] = $user['icq'];
   }

   $names[$named]['pm'] = null;
   if ( $exbb['pm'] ) {
      $names[$named]['pm'] = '<a title="'.$lang['Send_pm'].' '.$user['name'].'" href="messenger.php?action=new&touser='.$named.'" target="_blank">'.$exbb['icon_pm'].'</a>'.$exbb['delim_r'];
   }

   $names[$named]['prf'] = '<a href="profile.php?action=show&member='.$named.'" title="'.$lang['User_profile'].' '.$user['name'].'" target="_blank">'.$exbb['icon_prf'].'</a>'.$exbb['delim_r'];
}

function poll() {
global $lang,$exbb,$inmembmod,$vars,$topictitle,$firstkey;

   $filtoopen = $exbb['home_path'].'forum'.$vars['forum'].'/'.$vars['topic'].'-poll.php';
   if (!file_exists($filtoopen)) return '';

   $poll_data = get_file($filtoopen);

   if ( !$poll_data['pollname'] )  $poll_data['pollname'] = $topictitle;

   $poll_title = $poll_data['pollname'];
   $poll_count = $poll_data['votes'];
   $poll_users = unserialize( $poll_data['ids']);
   $poll_chces = unserialize( $poll_data['choices']);
   $poll_users['0'] = true;

   if ($poll_users[$exbb['mem_id']]) {

      $style = './templates/'.$exbb['default_style'].'poll_data.tpl';

      foreach ($poll_chces as $choice) {

        $pid    = $choice[0];
        $ptext  = $choice[1];
        $votes  = $choice[2];

        if (!$ptext) continue;


        $percent = ($votes == 0) ? 0 : $votes / $poll_count * 100;
        $percent = sprintf( '%.2f' , $percent ).'%';
        $width   = ($percent > 0) ? (int) $percent * 2 : 0;
        include($style);

      }

      $do = '<b>'.$lang['Vote_count'].$poll_count.'</b>';
   }
   else {

       $style = './templates/'.$exbb['default_style'].'poll_view.tpl';


      foreach ($poll_chces as $choice) {

        $pid    = $choice[0];
        $ptext  = $choice[1];

        if (!$ptext) continue;

        include($style);

      }

      $do = '<input type="submit" name="submit" value="'.$lang['Vote'].'" class="button" />';

   }

   $moderlinks = ($inmembmod) ? '<div align=right><font size=1><a href="postings.php?action=edit&forum='.$vars['forum'].'&topic='.$vars['topic'].'&id='.$firstkey.'">[ '.$lang['Editing'].' ]</a> <a href="postings.php?action=poll&delpoll=yes&forum='.$vars['forum'].'&topic='.$vars['topic'].'">[ '.$lang['Delete'].' ]</a></font></div>' : null;

   include('./templates/'.$exbb['default_style'].'poll.tpl');
   unset($poll_data,$pollch);

   return $poll_html;

}
?>