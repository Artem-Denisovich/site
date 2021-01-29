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

/*
Не изменяйте эту константу, если не знаете зачем она!
Best perfomance (more files) - 20480 (20 kB)
Optimal - 45-50 kB
Maximum - 80 kB
*/
define('MAX_THREAD_SIZE',20480); # 20 kB

include('common.php');

$vars = parsed_vars();

 if ($vars['action'] == 'addnew' && $vars['previewfirst'] == 'no')  { addnewthread(); }
 elseif ($vars['action'] == 'addnew'   && $vars['previewfirst'] == 'yes') { newthread(); }
 elseif ($vars['action'] == 'addreply' && $vars['previewfirst'] == 'no')  { addreply(); }
 elseif ($vars['action'] == 'addreply' && $vars['previewfirst'] == 'yes') { reply(); }
 elseif ($vars['action'] == 'new') { newthread(); }
 elseif ($vars['action'] == 'reply') {  reply(); }
 elseif ($vars['action'] == 'replyquote') {  replyquote(); }
 elseif ($vars['action'] == 'poll') {  poll_vote(); }
 else { error($lang['Main_msg'],$lang['Correct_post']);}

include('page_tail.php');

function newthread() {
global $exbb,$lang,$vars,$inuser;

  $inforum = $vars['forum'];
  $forum = get_file($exbb['home_path'].'data/allforums.php');
  if (!isset($forum[$inforum])) error($lang['Main_msg'],$lang['Dont_chg_url']);

  $inmembmod = moderator($inforum,$forum);
  if ( defined('IS_ADMIN') ) $inuser['private'][$inforum] = true;
  if ( ($forum[$inforum]['private']) && (!$inuser['private'][$inforum]) ) error($lang['Posts_sent'],$lang['Post_no']);

  $allof = false;
  switch ($forum[$inforum]['status']) {
       case 'reged': if (!$exbb['reged']) {$allof = true;} break;
       default: $allof = false;
  }
  if ($allof) error($lang['Enter_error'],$lang['Reg_users_can']);

  $set_poll = isset($vars['poll']) ? true : false;

  $forumname = stripslashes($forum[$inforum]['name']);
  $idmbcodestate = $forum[$inforum]['codes'];
  $privateforum = $forum[$inforum]['private'];
  $startnewthreads = $forum[$inforum]['status'];

  if ($exbb['emoticons']) {
        $emoticonslink = '<a href="tools.php?action=smiles" target="_blank">'.$lang['Smiles_on'].'</a>';
        $emoticonsbutton = '<input type=checkbox name="inshowemoticons" value="yes" checked>'.$lang['Do_smiles'].'<br>';
  }
  if ($idmbcodestate) {
      $codemap = '<br><script language="JavaScript">ibcodes();</script>';
      $smilesmap = '<br><script language="JavaScript">ibsmiles();</script>';
      $java = '<script language="Javascript" src="smilesmap.js"></script><script language="Javascript" src="codesmap.js"></script>';
  }

  $upload = (isset($forum[$inforum]['upload']) && !empty($forum[$inforum]['upload']) && $exbb['file_upload']) ? $forum[$inforum]['upload'] : 0;
  $hidden = '';
  if ($upload && $inuser['upload']) {
    $enctype = ' enctype="multipart/form-data"';
    $hidden = '<input type="hidden" name="MAX_FILE_SIZE" value="'.$upload.'">';
    $filetoup = $lang['File_upload'].$upload.'<br /><input class="input" type="file" size="30" name="FILE_UPLOAD">';
  }

  if ($set_poll) $hidden .= "\n".'<input type="hidden" name="poll" value="1">';
  # Add member to who's online

  if (!$privateforum) whosonline($lang['Topic_create_in'].' <a href="forums.php?forum='.$inforum.'">'.$forumname.'</a>');

  if ($vars['previewfirst'] == 'yes') {
        post_size();
        $preview = str_replace( '$' , '&#036;' , $vars['inpost'] );
        $preview = ikoncode($preview);
        if ($exbb['emoticons']) { $preview = setsmiles($preview); }
        if ($exbb['wordcensor']) $preview = bads_filter($preview);
        include('./templates/'.$exbb['default_style'].'preview.tpl');
        unset($preview);
        $vars['inpost'] = stripslashes($_POST['inpost']);
        $vars['pollansw'] = stripslashes($_POST['pollansw']);
  }

  $startthreads = ($startnewthreads == 'no') ? '<b>'.$lang['Admins_only'].'</b>' : $lang['All_users_can'];

  if (!$exbb['reged']) {$reg = ' &nbsp; <a href="register.php">'.$lang['You_reged'].'</a>';}
  else {
        if ($exbb['emailfunctions']) $requestnotify = ($vars['notify'] == 'yes') ? '<input type=checkbox name="notify" value="yes" checked>'.$lang['Do_email'].'<br>' : '<input type=checkbox name="notify" value="yes">'.$lang['Do_email'].'<br>';
        $sig_show = '<input type=checkbox name="inshowsignature" value="yes" checked>'.$lang['Do_sig'].'<br>';
        $sticked = '';
        if ($inmembmod) $sticked = ($vars['pin'] == 1) ? '<input type=checkbox name="pin" value="1" checked>'.$lang['Pin'].'?<br>' : '<input type=checkbox name="pin" value="1">'.$lang['Pin'].'?<br>';
		$reg = null;
  }
  $title_page = $exbb['boardname'].' :: '.$lang['Topic_create'];
  include('./templates/'.$exbb['default_style'].'all_header.tpl');
  include('./templates/'.$exbb['default_style'].'post_addnew.tpl');
  include('./templates/'.$exbb['default_style'].'footer.tpl');
}


function addreply() {
global $exbb,$lang,$vars,$inuser;

  $inforum = $vars['forum'];
  $currenttime = time();
  post_size();
  if (($exbb['flood_limit']) && !defined('IS_ADMIN') ) {
      $lastpost = $_SESSION['lastposttime'] + $exbb['flood_limit'];
      if ($lastpost > $currenttime) error($lang['Reply_sent'],$lang['Flood_limit'].$exbb['flood_limit'].$lang['Flood_sec']);
  }
  $filetoopen = $exbb['home_path'].'data/allforums.php';
  $allforums = get_file($filetoopen);
  $all = fopen($filetoopen,'r+');
  lock_file($all);

  if (($allforums[$inforum]['private']) && (!$inuser['private'][$inforum])) {fclose($all); error($lang['Posts_sent'],$lang['Post_no']);};
  if (!$exbb['reged'] and $allforums[$inforum]['status'] != 'all') {fclose($all); error($lang['Posts_sent'],$lang['Reg_users_can']);}
  if ($exbb['sts'] == 'banned')  {fclose($all); error($lang['Posts_sent'],$lang['You_deleted']);}
  if ($vars['inpost'] == '') {fclose($all); error($lang['Posts_sent'],$lang['Mess_needed']);}

  else { # start else

       $inmembmod = moderator($inforum,$allforums);

       $forumname = $allforums[$inforum]['name'];
       $intopic = $vars['topic'];

       $filetoopen = $exbb['home_path'].'forum'.$inforum.'/list.php';
       $list = get_file($filetoopen);
       $lst = fopen($filetoopen,'r+');
       lock_file($all);

       $top_name = $list[$intopic]['name'];

       if ( $list[$intopic]['state'] == 'closed' or  $list[$intopic]['state'] == 'moved') {fclose($all); fclose($lst); error($lang['Reply_sent'],$lang['Topic_blocked']);}

       $file_id = (isset($list[$intopic]['fls'])) ? $list[$intopic]['fls'] : '';

       $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd'.$file_id.'.php';

       if ( !file_exists($filetoopen) ) {
         fclose($all); fclose($lst);
         sendmail($exbb['boardname'],$exbb['adminemail'],$lang['Topic_broken']."\n".$filetoopen,$lang['EXBB_ERROR'],$exbb['adminemail']);
         error($lang['EXBB_ERROR'],$lang['Topic_broken']);
       }

       $allmessages = get_file($filetoopen);
       $thd = fopen($filetoopen,'r+');
       lock_file($all);
       ksort($allmessages,SORT_NUMERIC);
       end($allmessages);
       $last_key = key($allmessages);
       $thd_count = count($allmessages);

       #Check double clicking :)
       if ( $allmessages[$last_key]['post'] == $vars['inpost'] ) {fclose($all); fclose($lst); fclose($thd); error($lang['Reply_sent'],$lang['Reply_sent_alrd'],'',false);}

       if ($inmembmod) $vars['inpost'] = soft_clr_value($_POST['inpost']);
       $vars['inpost'] = preg_replace( "#(\?|&amp;|;|&)PHPSESSID=([0-9a-zA-Z]){32}#i", "", $vars['inpost'] );

      $new_att = false;
      if ($allforums[$inforum]['upload'] && $inuser['upload']) {
		  $exbb['uploadsize'] = $allforums[$inforum]['upload'];
          $attach = attach_upload();
          if (!empty($attach['attach_id']) && !empty($attach['attach_file'])) {
             $allmessages[$currenttime]['attach_id'] = $attach['attach_id'];
             $allmessages[$currenttime]['attach_file'] = $attach['attach_file'];
			 $new_att = true;
          }
       }

	   if ($allmessages[$last_key]['p_id'] == $exbb['mem_id'] && $exbb['reged'] && $currenttime - $last_key < 7200 && !$new_att) {

         $allmessages[$last_key]['post'] .= '<p>[s]'.$lang['Adding_from'].'[/s]<br>'.$vars['inpost'];
         $post_added = false;
         $timelimit = $last_key;

       } else {

         include('./data/boardstats.php');
         $post_added = true;
         $exbb['totalposts']++;
         save_statfile();

         ##########################################################################
         clearstatcache();
         if ( filesize($filetoopen) >= MAX_THREAD_SIZE ) {

            $file_id =  ( empty($file_id) ) ? 0 : intval($file_id);

            $extmode = ( isset($list[$intopic]['ext']) ) ? unserialize($list[$intopic]['ext']) : array();

            $extmode[$file_id] = $thd_count;
            $file_id++;
            $extmode[$file_id] = 1;


            $list[$intopic]['ext'] = serialize($extmode);
            $list[$intopic]['fls'] = $file_id;

            fclose($thd);
            $allmessages = array();

            $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd'.$file_id.'.php';
            $thd = fopen($filetoopen,'a+');
            lock_file($thd);

            $thd_count = array_sum($extmode);
            unset($extmode,$file_id,$thdid,$count);

         }
         elseif ( !empty($file_id) ) {

             $extmode = array();
             $extmode = ( isset($list[$intopic]['ext']) ) ? unserialize($list[$intopic]['ext']) : array();
             $extmode[$file_id] = $thd_count + 1;
             $list[$intopic]['ext'] = serialize($extmode);

             $thd_count = array_sum($extmode);
             $page = ceil($extmode[0]/intval($exbb['posts_per_page']))+$list[$intopic]['fls'];
             unset($extmode,$file_id,$thdid,$count);

         } else { $thd_count++; $page = ceil($thd_count/intval($exbb['posts_per_page']));}
         ##########################################################################

         $allmessages[$currenttime]['p_id'] = $exbb['mem_id'];
         $allmessages[$currenttime]['post'] = $vars['inpost'];
         $allmessages[$currenttime]['ip'] = $vars['IP_ADDRESS'];
         $allmessages[$currenttime]['smiles'] = ($vars['inshowemoticons'] == 'yes') ? true : false;
         $allmessages[$currenttime]['sig'] = ($vars['inshowsignature'] == 'yes') ? true : false;

         $timelimit = $currenttime;

      }

       #Сохраняем флокнутые файлы
        save_opened_file($thd,$allmessages);
        @chmod($filetoopen,$exbb['ch_files']);
        $allmessages = array();

        if ($post_added) $allforums[$inforum]['posts']++;
        $allforums[$inforum]['last_poster'] = $exbb['member'];
        $allforums[$inforum]['last_poster_id'] = $exbb['mem_id'];
        $allforums[$inforum]['last_post'] = $list[$intopic]['name'];
        $allforums[$inforum]['last_post_id'] = $intopic;
        $allforums[$inforum]['last_key'] = $timelimit;
        $allforums[$inforum]['last_time'] = $currenttime;
        save_opened_file($all,$allforums);
        unset($attach);

        $list[$intopic]['posts'] = $thd_count - 1;
        $list[$intopic]['poster'] = $exbb['member'];
        $list[$intopic]['p_id'] = $exbb['mem_id'];
        $list[$intopic]['postdate'] = $currenttime;
        uasort ($list, 'sort_by_postdate');
        save_opened_file($lst,$list);

        if ($exbb['reged']) {
            if ($post_added) {
              $inuser['posts']++;
			  $inuser['sig_on'] = ($vars['inshowsignature'] == 'yes') ? true : false;
              if (isset($inuser['posted'][$inforum])) {$inuser['posted'][$inforum]++;} else {$inuser['posted'][$inforum] = 1;}
            }
            if (!$allforums[$inforum]['private']) {
                 $inuser['lastpost']['date'] = $currenttime;
                 $inuser['lastpost']['link'] = 'topic.php?forum='.$inforum.'&topic='.$intopic;
                 $inuser['lastpost']['name'] = $list[$intopic]['name'];
            }
            $filetomake = $exbb['home_path'].'members/'.$exbb['mem_id'].'.php';
            save_file($filetomake,$inuser);
        }

    $_SESSION['lastposttime'] = $currenttime;
    # email functions

    if ($exbb['emailfunctions']) { # start mail

        $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-m.php';
        $emailers = (file_exists($filetoopen)) ? get_file($filetoopen) : array();

        if ($vars['notify'] == 'yes' and $exbb['reged']) {
           if ( !isset($emailers[$exbb['mem_id']]) ) {
             $emailers[$exbb['mem_id']] = 1;
             save_file($filetoopen,$emailers);
             @chmod($filetoopen,$exbb['ch_files']);
           }
        }
        if ($exbb['mail_posts']) {
          if ($exbb['wordcensor']) $vars['inpost'] = bads_filter($_POST['inpost']);
          if (is_array($emailers)) {
            unset($emailers[$exbb['mem_id']]);
            $time = date("d-m-Y H:i:s",$currenttime);
            $vars['inpost'] = str_replace("\n\n","\n",$vars['inpost']);
            $vars['inpost'] = stripslashes($vars['inpost']);
            $vars['inpost'] = preg_replace(array("'\[b\]'i","'\[/b\]'i","'\[i\]'i","'\[/i\]'i"),array("","","","",""), $vars['inpost'] );
            include('./templates/'.$exbb['default_style'].'email_reply.tpl');

            $forumname = strip_tags($forumname);
            sendmail($exbb['boardname'],$exbb['adminemail'],$email,'['.$forumname.'] '.$top_name.' - '.$lang['Notify_by_email'],$emailers);
            unset($emailers);
          }
        }
    } # end email send.

        $relocurl = 'topic.php?forum='.$inforum.'&topic='.$intopic.'&v=l#'.strval($timelimit);
        $title_page = $exbb['boardname'] .' :: '.$lang['Sent_in'].' '.$forumname;
        $ok_title = $lang['Added'];
        $url1 = '<li><a href="'.$relocurl.'">'.$lang['Return_in_topic'].'</a>';
        $url2 = '<li><a href="forums.php?forum='.$inforum.'">'.$lang['Return_in_forum'].'</a>';
        $url3 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
        include('./templates/'.$exbb['default_style'].'all_header.tpl');
        include('./templates/'.$exbb['default_style'].'postok.tpl');
        include('./templates/'.$exbb['default_style'].'footer.tpl');
    }

}


function reply() {
global $exbb,$lang,$vars,$inuser;

  $filetoopen = $exbb['home_path'].'data/allforums.php';
  $allforums = get_file($filetoopen);

  $inforum = $vars['forum'];
  $intopic = $vars['topic'];
  if ($allforums[$inforum]['private'] && !$inuser['private'][$inforum] && !$exbb['reged']) {error($lang['Posts_sent'],$lang['Post_no']);}
  $forumname = stripslashes($allforums[$inforum]['name']);
  $idmbcodestate = $allforums[$inforum]['codes'];
  $privateforum = $allforums[$inforum]['private'];

  if (($allforums[$inforum]['private']) && (!$inuser['private'][$inforum])) error($lang['Posts_sent'],$lang['Post_no']);
  if (!$exbb['reged'] and $allforums[$inforum]['status'] != 'all')  error($lang['Posts_sent'],$lang['Reg_users_can']);

  $filetoopen = $exbb['home_path'].'forum'.$inforum.'/list.php';
  $list = get_file($filetoopen);
  $cur_topic[$intopic] = $list[$intopic];
  unset($list);
  if ( $cur_topic[$intopic]['state'] == 'closed' || $cur_topic[$intopic]['state'] == 'moved') error($lang['Reply_sent'],$lang['Topic_blocked']);

                    //Для превью
  $topic_name = $vars['intopictitle'] = $cur_topic[$intopic]['name'];

  if ($exbb['emoticons']) {
        $emoticonslink = $lang['Smiles_on'];
        $emoticonsbutton = '<input type=checkbox name="inshowemoticons" value="yes" checked>'.$lang['Do_smiles'].'<br>';
  }
  if ($idmbcodestate) {
      $codemap = '<br><script language="JavaScript">ibcodes();</script>';
      $smilesmap = '<br><script language="JavaScript">ibsmiles();</script>';
      $java = '<script language="Javascript" src="smilesmap.js"></script><script language="Javascript" src="codesmap.js"></script>';
  }

  if ($vars['previewfirst'] == 'yes') {
        post_size();
        $preview = str_replace( '$' , '&#036;' , $vars['inpost'] );
        $preview = ikoncode($preview);
        if ($exbb['emoticons']) { $preview = setsmiles($preview); }
        include('./templates/'.$exbb['default_style'].'preview.tpl');
        unset($preview);
  } else {$_SESSION['lastposttime'] = $currenttime;}
  $vars['inpost'] = stripslashes($_POST['inpost']);

  if (!$exbb['reged']) {$reg = ' &nbsp; <a href="register.php">'.$lang['You_reged'].'</a>';}
  else {
        if ($exbb['emailfunctions']) $requestnotify = ($vars['notify'] == 'yes') ? '<input type=checkbox name="notify" value="yes" checked>'.$lang['Do_email'].'<br>' : '<input type=checkbox name="notify" value="yes">'.$lang['Do_email'].'<br>';
        $sig_show = '<input type=checkbox name="inshowsignature" value="yes" checked>'.$lang['Do_sig'].'<br>';
  }

  unset($lang['User_total_posts'],$lang['User_reg_date']);

  $upload = (isset($allforums[$inforum]['upload']) && !empty($allforums[$inforum]['upload']) && $exbb['file_upload']) ? $allforums[$inforum]['upload'] : 0;
  if ($upload && $inuser['upload']) {
    $enctype = ' enctype="multipart/form-data"';
    $hidden = '<input type="hidden" name="MAX_FILE_SIZE" value="'.$upload.'">';
    $filetoup = $lang['File_upload'].$upload.'<br /><input class="input" type="file" size="30" name="FILE_UPLOAD">';
  }

  $in_file = ( isset($cur_topic[$intopic]['fls']) ) ? $cur_topic[$intopic]['fls'] : '';

  $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd'.$in_file.'.php';
  $allmessages = get_file($filetoopen);
  krsort($allmessages,SORT_NUMERIC);

  $preview = 10;
  $viewed = 0;
  $users = array();
  $users[0]['n'] = $lang['Unreg'];
  $users[0]['t'] = $lang['No_reged'];
  $replygraphic = ($exbb['text_menu']) ? '<a title="'.$lang['java_paste'].'" onmouseover="copyQ();" href="javascript:pasteQ();">'.$lang['Paste_qte'].'</a>' : '<a title="'.$lang['java_paste'].'" onmouseover="copyQ();" href="javascript:pasteQ();"><img src="./templates/'.$exbb['default_style'].'im/'.$exbb['default_lang'].'/reply.gif" border=0></a>';

  foreach($allmessages as $key=>$topic) {
      $viewed++;
      $m_id = isset($topic['p_id']) ? $topic['p_id'] : 0;
      if ( !isset($users[$m_id]) ) {
         $info = getmember($m_id);
         $info['name'] = ($info) ? $info['name'] : $lang['Unreg'];
         $users[$m_id]['n'] = ( is_array($info) ) ? $info['name'] : $info;
         $users[$m_id]['t'] = ( is_array($info) ) ? $info['title'] : $lang['No_reged'];
      }
      $username = $users[$m_id]['n'];
      $membertitle = $users[$m_id]['t'];
      $info = $lang['Post_date'].' '.date("H:i - d.m.Y", $key + $exbb['usertime']*3600 );
      $post = ($exbb['emoticons'] && $topic['smiles']) ? setsmiles(ikoncode($topic['post'])): ikoncode($topic['post']);
      $postbackcolor = ( !($viewed % 2) ) ? 'row2' : 'row1';
      include('./templates/'.$exbb['default_style'].'topic_data.tpl');
      if ($viewed == $preview) break;
  }
  unset($users,$info,$allmessages);
  $title_page = strip_tags($forumname).' :: '.$topic_name.' :: '.$lang['add_post'];
  include('./templates/'.$exbb['default_style'].'all_header.tpl');
  include('./templates/'.$exbb['default_style'].'post_reply.tpl');
  include('./templates/'.$exbb['default_style'].'footer.tpl');

} # end add reply routine


function addnewthread() {
global $exbb,$lang,$vars,$inuser;

  $currenttime = time();
  post_size();
  $inforum = $vars['forum'];

  $filetoopen = $exbb['home_path'].'data/allforums.php';
  $forum = get_file($filetoopen);
  $inmembmod = moderator($inforum,$forum);

  if ( ($exbb['flood_limit']) && !$inmembmod ) {
      $lastpost = $_SESSION['lastposttime'] + $exbb['flood_limit'];
      if ($lastpost > $currenttime)  error($lang['Topic_create_new'],$lang['Flood_limit'].$exbb['flood_limit'].$lang['Flood_sec']);
  }

  $all = fopen($filetoopen,'r+');
  lock_file($all);

  if ($forum[$inforum]['status'] == 'no' && !$inmembmod) {
     fclose($all);
     error($lang['Topic_create_new'],$lang['Admins_only']);
  }

  if ( defined('IS_ADMIN') ) $inuser['private'][$inforum] = true;
  if (($forum[$inforum]['private']) && (!$inuser['private'][$inforum])) {fclose($all); error($lang['Posts_sent'],$lang['Post_no']);};

  if ($exbb['sts'] == 'banned') { fclose($all); error($lang['Topic_create_new'],$lang['You_deleted']); }
  elseif ($vars['intopictitle'] == '')  { fclose($all); error($lang['Topic_create_new'],$lang['Title_needed']); }
  elseif ($vars['inpost'] == ''){ fclose($all); error($lang['Topic_create_new'],$lang['Mess_needed']); }
  elseif (preg_match("#^([0-9]|[a-z]|[а-я]|[A-Z]|[А-Я]){1,1}#/is",$vars['intopictitle'])) { fclose($all); error($lang['Topic_create_new'],$lang['Topic_rule'],'',0); }
  else  { # start else
        $forumname = $forum[$inforum]['name'];

        if ($inmembmod) { $vars['inpost'] = soft_clr_value($_POST['inpost']); }
        $vars['inpost'] = trim($vars['inpost']);

        $intopictitle = str_replace('<br>','',$vars['intopictitle']);
        $intopicdescription = str_replace('<br>','',$vars['intopicdescription']);

        if (strlen($intopictitle)>255) { $intopictitle = substr($intopictitle,0,255);}
        if (strlen($intopicdescription)>160) { $intopicdescription = substr($intopicdescription,0,160);}
        $filetoopen = $exbb['home_path'].'forum'.$inforum.'/list.php';
        if (file_exists($filetoopen)) {
           $list = get_file($filetoopen);
           $lst = fopen($filetoopen,'r+');
           lock_file($lst);
           $k = array_keys($list);
           $intopic = max($k) + 1;
           unset($k);
        } else {
           $lst = fopen($filetoopen,'w');
           lock_file($lst);
           $intopic = 1;
        }

        $check_file = $exbb['home_path'].'forum'.$inforum.'/';

        while ( file_exists($check_file.$intopic.'-thd.php') ) $intopic++;

        #Make poll if needed
        if (isset($vars['poll']) && $forum[$inforum]['polls'] && $exbb['reged']) {
           $new_poll = poll_new();
           $add_poll = false;
           if ($new_poll) {
              $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-poll.php';
              save_file($filetoopen,$new_poll);
              @chmod($filetoopen,$exbb['ch_files']);
              $add_poll = true;
           } else {
              fclose($all);
              fclose($lst);
              error($lang['Poll'],$lang['Poll_error']);
           }
        }

        # Обновляем информацию в allforums.php
        $forum[$inforum]['topics'] = count($list) + 1;
        $forum[$inforum]['last_post'] = $intopictitle;
        $forum[$inforum]['last_post_id'] = $intopic;
        $forum[$inforum]['last_key'] = $currenttime;
        $forum[$inforum]['last_poster'] = $exbb['member'];
        $forum[$inforum]['last_poster_id'] = $exbb['mem_id'];
        $forum[$inforum]['last_time'] = $currenttime;
        save_opened_file($all,$forum);

        # Обновляем информацию в соответствующем list.php
        $list[$intopic]['name'] = trim($intopictitle);
        if (!empty($intopicdescription)) $list[$intopic]['desc'] = trim($intopicdescription);
        $list[$intopic]['state'] = 'open';
        $list[$intopic]['posts'] = 0;
        #$list[$intopic]['views'] = 0;
        $list[$intopic]['author'] = $exbb['reged'] ? $exbb['member'] : false;
        $list[$intopic]['a_id'] = $exbb['mem_id'];
        $list[$intopic]['date'] = $currenttime;
        $list[$intopic]['poster'] = $list[$intopic]['author'];
        $list[$intopic]['p_id'] = $exbb['mem_id'];
        $list[$intopic]['postdate'] = $currenttime;
        if ($add_poll) $list[$intopic]['poll'] = true;
        uasort ($list, 'sort_by_postdate');
        save_opened_file($lst,$list);
        @chmod($filetoopen,$exbb['ch_files']);

        # Сохраняем новую тему
        $thd = array();
        $thd[$currenttime]['p_id'] = $exbb['mem_id'];
        $thd[$currenttime]['post'] = preg_replace( "#(\?|&amp;|;|&)PHPSESSID=([0-9a-zA-Z]){32}#i", "", $vars['inpost'] );;
        $thd[$currenttime]['ip'] = $vars['IP_ADDRESS'];
        $thd[$currenttime]['smiles'] = ($vars['inshowemoticons'] == 'yes') ? true : false;
        $thd[$currenttime]['sig'] = ($vars['inshowsignature'] == 'yes') ? true : false;
        $thd[$currenttime]['smiles'] = ($vars['inshowemoticons'] == 'yes') ? true : false;
        $thd[$currenttime]['sig'] = ($vars['inshowsignature'] == 'yes') ? true : false;
        $thd[$currenttime]['name'] = $intopictitle;
        if (!empty($intopicdescription)) $thd[$currenttime]['desc'] = $intopicdescription;

        # Добавляем прикреплённые файлы
        if ($forum[$inforum]['upload'] && $inuser['upload']) {
           $exbb['uploadsize'] = $forum[$inforum]['upload'];
           $vars['topic'] = $intopic;
           $attach = attach_upload();
           if (!empty($attach['attach_id']) && !empty($attach['attach_file'])) {
             $thd[$currenttime]['attach_id'] = $attach['attach_id'];
             $thd[$currenttime]['attach_file'] = $attach['attach_file'];
           }
        }


        $filetomake = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd.php';
        save_file($filetomake,$thd);
        @chmod($filetomake,$exbb['ch_files']);

        if ($vars['pin'] == 1) {
            $filetomake = $exbb['home_path'].'forum'.$inforum.'/_pinned.php';
            $sticked = get_file($filetomake);
            $sticked[$intopic] = 1;
            save_file($filetomake,$sticked);
            @chmod($filetomake,$exbb['ch_files']);
        }


        # Обновляем информацию пользователя
        if ($exbb['reged']) {

            $inuser['posts']++;
            if (!$forum[$inforum]['private']) {
                 $inuser['lastpost']['date'] = $currenttime;
                 $inuser['lastpost']['link'] = 'topic.php?forum='.$inforum.'&topic='.$intopic;
                 $inuser['lastpost']['name'] = $list[$intopic]['name'];
            }
            if (isset($inuser['posted'][$inforum])) {$inuser['posted'][$inforum]++;} else {$inuser['posted'][$inforum] = 1;}
            $filetomake = $exbb['home_path'].'members/'.$exbb['mem_id'].'.php';
            save_file($filetomake,$inuser);
        }

        include('./data/boardstats.php');
        $exbb['totalthreads']++;
        save_statfile();

        # if the user wants email notifications, lets add them.

        if ($exbb['emailfunctions'] && $exbb['mail_posts']) {

          $time = date("d-m-Y H:i:s",$currenttime);
          if ($vars['notify'] == 'yes' && $exbb['reged']) {
            $emailers = array();
            $emailers[$exbb['mem_id']] = 1;

            $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-m.php';
            save_file($filetoopen,$emailers);
            @chmod($filetoopen,$exbb['ch_files']);
            $vars['inpost'] = str_replace('<p>',"\n",$vars['inpost']);
            $vars['inpost'] = str_replace('<br>',"\n",$vars['inpost']);
            $addfield = $lang['New_topic_thks']."\n";
            include('./templates/'.$exbb['default_style'].'email_reply.tpl');
            sendmail($exbb['boardname'],$exbb['adminemail'],$email,"[$forumname] $lang[Notify_by_email]",$inuser['mail']);
          }

          #Send email for forum subscribers
          $filetoopen = $exbb['home_path'].'forum'.$inforum.'/_f_track.php';
          $emailers = ( file_exists($filetoopen) ) ? get_file($filetoopen) : array();
          unset($emailers[$exbb['mem_id']]);
          if (count($emailers)) {
            include('./templates/'.$exbb['default_style'].'email_newtopic.tpl');
            sendmail($exbb['boardname'],$exbb['adminemail'],$email,$lang['New_topic_inforum'].$forumname,$emailers);
          }
        }
        $_SESSION['lastposttime'] = $currenttime;
        $relocurl = 'topic.php?forum='.$inforum.'&topic='.$intopic;

        $title_page = $exbb['boardname'].' :: '.$lang['Topic_created'];
        $ok_title = $lang['Added'];
        $url1 = '<li><a href="'.$relocurl.'">'.$lang['To_newtopic'].'</a>';
        $url2 = '<li><a href="forums.php?forum='.$inforum.'">'.$lang['Return_in_forum'].'</a>';
        $url3 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
        include('./templates/'.$exbb['default_style'].'all_header.tpl');
        include('./templates/'.$exbb['default_style'].'postok.tpl');
        include('./templates/'.$exbb['default_style'].'footer.tpl');
    } # end else

} # end addnewthread

function poll_new() {
global $exbb,$vars;

  $poll_array  = array();
  $poll_id = 0;

  $polls = explode( '<br>', $vars['pollansw'] );

  foreach ($polls as $choice) {

     if ( $choice == '' ) continue;

     $poll_array[] = array( $poll_id , $choice, 0 );
     $poll_id++;
  }

  if ($poll_id > 10 || $poll_id < 2) return '';

  $poll = array();

  $poll['pollname'] = $vars['pollname'];
  $poll['started'] = time();
  $poll['start_id'] = $exbb['mem_id'];
  $poll['choices'] = serialize($poll_array);
  $poll['votes'] = 0;
  $poll['ids'] = serialize(array());

  return $poll;
}

function poll_vote() {
global $exbb,$vars,$lang;

  if ( !isset($vars['topic']) || !isset($vars['forum']) || !$exbb['reged'] ) error($lang['Poll'],$lang['Dont_chg_url']);

  if ( !isset($vars['pid']) ) error($lang['Poll'],$lang['Poll_pid']);

  $filetoopen = $exbb['home_path'].'forum'.$vars['forum'].'/'.$vars['topic'].'-poll.php';

  if (!file_exists($filetoopen)) error($lang['Poll'],$lang['Poll_not_found']);

  $poll_data = get_file($filetoopen);

  $poll_users = unserialize( $poll_data['ids']);
  $poll_users['0'] = true;

  if ( !isset($poll_users[$exbb['mem_id']]) ) {

    $poll_users[$exbb['mem_id']] = true;
    $poll_data['votes']++;

    $poll_chces = unserialize( $poll_data['choices'] );

    $poll_chces[$vars['pid']][2]++;

    unset($poll_users['0']);
    $poll_data['choices'] = serialize( $poll_chces );
    $poll_data['ids'] = serialize( $poll_users );

    save_file($filetoopen,$poll_data);

    unset($poll_chces,$poll_users,$poll_data);

    $filetoopen = $exbb['home_path'].'forum'.$vars['forum'].'/list.php';
    $list = get_file($filetoopen);
    $lst = fopen($filetoopen,'r+');
    lock_file($lst);
    $list[$vars['topic']]['postdate'] = time();
    save_opened_file($lst,$list);


    $relocurl = 'topic.php?forum='.$vars['forum'].'&topic='.$vars['topic'].'&v=l#poll';
    $title_page = $exbb['boardname'] .' :: '.$lang['Sent_in'].' '.$lang['Poll'];
    $ok_title = $lang['Poll_vote'];
    $url1 = '<li><a href="topic.php?forum='.$vars['forum'].'&topic='.$vars['topic'].'&start=1">'.$lang['Return_in_topic'].'</a>';
    $url2 = '<li><a href="forums.php?forum='.$vars['forum'].'">'.$lang['Return_in_forum'].'</a>';
    $url3 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
    include('./templates/'.$exbb['default_style'].'all_header.tpl');
    include('./templates/'.$exbb['default_style'].'postok.tpl');
    include('./templates/'.$exbb['default_style'].'footer.tpl');
  }
  else {  error($lang['Poll'],$lang['Poll_alredy'],'',false); }

  return;

}
?>