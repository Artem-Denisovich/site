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

include($exbb['home_path'] . 'language/' . $exbb['default_lang'] . '/lang_edit.php');

if (!$exbb['reged']) {error($lang['Message_edit'],$lang['Guest_no_edit']);}

$action = $vars['action'];

if ($action == 'edit') {editform();}
elseif (($action == 'lock') or ($action == 'unlock')) {un_lockthread($action);}
elseif ($action == 'delete') {deletethread();}
elseif ($action == 'movetopic') {movetopic();}
elseif ($action == 'edittopic') {edit_topic_title();}
elseif ($action == 'processedit' && $vars['deletepost'] == 'yes') { deletepost();   }
elseif ($action == 'processedit' && $vars['previewfirst'] == 'no')  { processedit();  }
elseif ($action == 'processedit' && $vars['previewfirst'] == 'yes') { editform();     }
elseif ($action == 'trackers') {del_subscribed();}
elseif ($action == 'poll') {poll_edit();}
elseif ($action == 'top_recount') {top_recount();}
elseif ($action == 'restore') {restore();}
elseif (($action == 'pin') or ($action == 'unpin')) {un_pinthread($action);}
else { error($lang['Main_msg'],$lang['Correct_post']); }

include('page_tail.php');

function edit_topic_title() {
global $exbb,$lang,$vars,$inuser;

    if ($vars['request_method'] != 'post') {error($lang['Main_msg'],$lang['Correct_post']);}
    $forum = get_file($exbb['home_path'].'data/allforums.php');
    $inforum = $vars['forum'];
    $intopic = $vars['topic'];
    $inmembmod = moderator($inforum,$forum);

    if (!$inmembmod) { error($lang['Message_edit'],$lang['Edit_no']);}

    if ($vars['checked'] == 'yes') {

        # Do we have any data?
        if ($vars['intopictitle'] == '') error($lang['Message_edit'],$lang['Title_needed']);

        if ( $forum[$inforum]['last_post_id'] == $intopic ) {
          $lst = fopen($exbb['home_path'].'data/allforums.php','r+');
          lock_file($lst);
          $forum[$inforum]['last_post'] = $vars['intopictitle'];
          save_opened_file($lst,$forum);
        }

        $filetoread = $exbb['home_path'].'forum'.$inforum.'/list.php';
        $list = get_file($filetoread);
        $lst = fopen($filetoread,'r+');
        lock_file($lst);

        $list[$intopic]['name'] = $vars['intopictitle'];
        if (!empty($vars['intopicdescription'])) { $list[$intopic]['desc'] = $vars['intopicdescription']; } else {unset($list[$intopic]['desc']);}
        save_opened_file($lst,$list);


        $title_page = $exbb['boardname'].' :: '.$lang['Edit_complete'];
        $ok_title = $lang['Edit_complete'];
        $relocurl = 'topic.php?forum='.$inforum.'&topic='.$intopic;
        $url1 = '<li><a href="'.$relocurl.'">'.$lang['Return_in_topic'].'</a>';
        $url2 = '<li><a href="forums.php?forum='.$inforum.'">'.$lang['Return_in_forum'].'</a>';
        $url3 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
        include('./templates/'.$exbb['default_style'].'all_header.tpl');
        include('./templates/'.$exbb['default_style'].'postok.tpl');
        include('./templates/'.$exbb['default_style'].'footer.tpl');
    } # end if clear to edit
    else {

        $filetoread = $exbb['home_path'].'forum'.$inforum.'/list.php';
        $list = get_file($filetoread);

        $old_topictitle = $list[$intopic]['name'];
        $old_topicdescription = $list[$intopic]['desc'];
        unset($list);
        $title_page = $exbb['boardname'].' :: '.$lang['Edit_title'];
        include('./templates/'.$exbb['default_style'].'all_header.tpl');
        include('./templates/'.$exbb['default_style'].'admin/edit_topic_title.tpl');
        include('./templates/'.$exbb['default_style'].'footer.tpl');
    }

} # end edit topic

function movetopic() {
global $exbb,$lang,$vars,$inuser;

   if ($vars['request_method'] != 'post') {error($lang['Main_msg'],$lang['Correct_post']);}

    $filetoopen = $exbb['home_path'].'data/allforums.php';
    $forum = get_file($filetoopen);

    $inforum = $vars['forum'];
    $intopic = $vars['topic'];

    $inmembmod = moderator($inforum,$forum);
    $currenttime = time();

    if (!$inmembmod) error($lang['Topic_moving'],$lang['Edit_no']);

if (($vars['checked'] == 'yes') && ($vars['movetoid'] != '')) {

    if ($vars['movetoid'] == $inforum || !isset($forum[$vars['movetoid']])) error($lang['Topic_moving'],$lang['Moving_error']);
    $all = fopen($filetoopen,'r+');
    lock_file($all);

    ### Get a new thread number.

    $fileto_mov = $exbb['home_path'].'forum'.$vars['movetoid'].'/list.php';
    if (file_exists($fileto_mov)) {
        $list_mov = get_file($fileto_mov);
        if (is_array($list_mov)) {$k = array_keys($list_mov);} else {$k[] = 0;}
        $newthreadnumber = (count($k)) ? max($k)+1 : 1;
        unset($k);
        $lst_mov = fopen($fileto_mov,'r+');
    } else {
        $list_mov = array();
        $newthreadnumber = 1;
        $lst_mov = fopen($fileto_mov,'w');
    }
    lock_file($lst_mov);

    $file = $exbb['home_path'].'forum'.$vars['movetoid'].'/'.$newthreadnumber.'-thd.php';
    @copy($exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd.php',$file);
    @chmod($file,$exbb['ch_files']);
    $files = 1;
    $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd'.$files.'.php';
    while ( file_exists($filetoopen) ) {
      @copy($filetoopen,$exbb['home_path'].'forum'.$vars['movetoid'].'/'.$newthreadnumber.'-thd'.$files.'.php');
      if ($vars['leavemessage'] != 'yes') {
        @unlink($filetoopen);
      }
      $files++;
      $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd'.$files.'.php';
    }
    $filetoopen = $exbb['home_path'].'forum'.$inforum.'/attaches-'.$intopic.'.php';
    if (file_exists($filetoopen)) {
      $file = $exbb['home_path'].'forum'.$vars['movetoid'].'/attaches-'.$newthreadnumber.'.php';
      @copy($filetoopen,$file);
      @chmod($file,$exbb['ch_files']);
    }
    $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-m.php';
    if (file_exists($filetoopen)) {
      $file = $exbb['home_path'].'forum'.$vars['movetoid'].'/'.$newthreadnumber.'-m.php';
      @copy($filetoopen,$file);
      @chmod($file,$exbb['ch_files']);
    }
    $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-poll.php';
    if (file_exists($filetoopen)) {
      $file = $exbb['home_path'].'forum'.$vars['movetoid'].'/'.$newthreadnumber.'-poll.php';
      @copy($filetoopen,$file);
      @chmod($file,$exbb['ch_files']);
    }

    $filetoopen = $exbb['home_path'].'forum'.$inforum.'/list.php';
    $list = get_file($filetoopen);
    $lst = fopen($filetoopen,'r+');
    lock_file($lst);

    $list_mov[$newthreadnumber] = $list[$intopic];

    if ($vars['leavemessage'] == 'yes') {

      $list[$intopic]['state'] = 'moved';
      $list[$intopic]['movedid'] = $vars['movetoid'].':'.$newthreadnumber;

      include ('./data/boardstats.php');
      $exbb['totalthreads']++;
	  $exbb['totalposts'] += $list[$intopic]['posts'];
      save_statfile();

   } else {

      $forum[$inforum]['posts'] -= $list[$intopic]['posts'];
      $forum[$inforum]['topics']--;

      $filetounlink = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd.php';
      @unlink($filetounlink);
      $filetounlink = $exbb['home_path'].'forum'.$inforum.'/attaches-'.$intopic.'.php';
      @unlink($filetounlink);
      $filetounlink = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-m.php';
      @unlink($filetounlink);
      $filetounlink = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-poll.php';
      @unlink($filetounlink);

      unset($list[$intopic]);
   }

   uasort ($list, 'sort_by_postdate');
   save_opened_file($lst,$list);

   uasort ($list_mov, 'sort_by_postdate');
   save_opened_file($lst_mov,$list_mov);
   @chmod($fileto_mov,$exbb['ch_files']);

   $forum[$vars['movetoid']]['topics']++;
   $forum[$vars['movetoid']]['posts'] += $list_mov[$newthreadnumber]['posts'];

   reset($list_mov);
   $first_key = key($list_mov);
   $forum[$vars['movetoid']]['last_post'] = $list_mov[$first_key]['name'];
   $forum[$vars['movetoid']]['last_post_id'] = $first_key;
   $forum[$vars['movetoid']]['last_poster'] = $list_mov[$first_key]['poster'];
   $forum[$vars['movetoid']]['last_time'] = $list_mov[$first_key]['postdate'];
   
   reset($list);
   $first_key = key($list);
   $forum[$inforum]['last_post'] = $list[$first_key]['name'];
   $forum[$inforum]['last_post_id'] = $first_key;
   $forum[$inforum]['last_poster'] = $list[$first_key]['poster'];
   $forum[$inforum]['last_time'] = $list[$first_key]['postdate'];

   save_opened_file($all,$forum);

   unset($list_mov,$forum,$list);


   $title_page = $exbb['boardname'].' :: '.$lang['Topic_moved'];
   $ok_title = $lang['Topic_moved'];
   $relocurl = 'forums.php?forum='.$inforum;
   $url1 = '<li><a href="forums.php?forum='.$inforum.'">'.$lang['Go_to_old'].'</a>';
   $url2 = '<li><a href="forums.php?forum='.$vars['movetoid'].'">'.$lang['Go_to_new'].'</a>';
   $url3 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
   include('./templates/'.$exbb['default_style'].'all_header.tpl');
   include('./templates/'.$exbb['default_style'].'postok.tpl');
   include('./templates/'.$exbb['default_style'].'footer.tpl');
} # end clear to move if

else {

     $jumphtml = '<option value="">'.$lang['Choose_forum']."\n";
     unset($forum[$inforum]);
     foreach($forum as $forumid=>$val){
             if ($val['catid'] != $lastcategoryplace) { #start if $categoryplace
                 $jumphtml .= '<option value="">'."\n";
                 $jumphtml .= '<option class=forumline value="">-- &nbsp; '.$val['catname']."\n";
                 $jumphtml .= '<option value="'.$forumid.'"> '.$val['name']."\n";
             } else {
                 $jumphtml .= '<option value="'.$forumid.'"> '.$val['name']."\n";
             }
             $lastcategoryplace = $val['catid'];
     }

     $title_page = $exbb['boardname'].' :: '.$lang['Topic_moving'];
     include('./templates/'.$exbb['default_style'].'all_header.tpl');
     include('./templates/'.$exbb['default_style'].'admin/movetopic.tpl');
     include('./templates/'.$exbb['default_style'].'footer.tpl');

     } # end else

} # end movetopic

function deletethread() {
global $exbb,$lang,$vars,$inuser;

    $filetoopen = $exbb['home_path'].'data/allforums.php';
    $forum = get_file($filetoopen);

    $inforum = $vars['forum'];
    $intopic = $vars['topic'];

    $inmembmod = moderator($inforum,$forum);

    if (!$inmembmod) { error($lang['Topic_deleting'],$lang['Edit_no']);}

    if ($vars['checked']) {

        $all = fopen($filetoopen,'r+');
        lock_file($all);

        $filetoopen = $exbb['home_path'].'forum'.$inforum.'/list.php';
        $list = get_file($filetoopen);

        ### Обновление статистики форума
        include('./data/boardstats.php');

        $filetomake = $exbb['home_path'].'data/boardstats.php';

        $exbb['totalthreads']--;
        $exbb['totalposts'] -= $list[$intopic]['posts'];
        save_statfile();

        $forum[$inforum]['posts'] -= $list[$intopic]['posts'];
        $forum[$inforum]['topics']--;
        ### Удалим топик из list.php

        $lst = fopen($filetoopen,'r+');
        lock_file($lst);
        unset($list[$intopic]);
        save_opened_file($lst,$list);


        ### Проверим был ли удаляемый топик последним в который постили, если да, то переделаем ластпост :)

        if ($forum[$inforum]['last_post_id'] == $intopic) {
           reset($list);
           $last_id = key($list);
           $forum[$inforum]['last_post'] = $list[$last_id]['name'];
           $forum[$inforum]['last_post_id'] = $last_id;
           $forum[$inforum]['last_poster'] = $list[$last_id]['poster'];
           $forum[$inforum]['last_time'] = $list[$last_id]['postdate'];
        }

        # Обновим количество тем и постов в категории, где удалён топик

        save_opened_file($all,$forum);
        unset($list);

        ### Now we have to trash it from the thd's
        @unlink($exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd.php');

        $files = 1;
        $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd'.$files.'.php';
        while ( file_exists($filetoopen) ) {
          @unlink($filetoopen);
          $files++;
          $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd'.$files.'.php';
        }

        $filetoopen = $exbb['home_path'].'forum'.$inforum.'/_pinned.php';
        $sticked = get_file($filetoopen);
        if ( is_array($sticked) && count($sticked) ) {
            unset($sticked[$intopic]);
            save_file($filetoopen,$sticked);
        }

        $filetotrash = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-m.php';
        @unlink($filetotrash);
        $filetounlink = $exbb['home_path'].'forum'.$inforum.'/attaches-'.$intopic.'.php';
        @unlink($filetounlink);
        $filetounlink = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-poll.php';
        @unlink($filetounlink);

        $title_page = $exbb['boardname'].' :: '.$lang['Topic_deleted'];
        $ok_title = $lang['Topic_deleted'];
        $relocurl = 'forums.php?forum='.$inforum;
        $url1 = '<li><a href="forums.php?forum='.$inforum.'">'.$lang['Go_to_old'].'</a>';
        $url2 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
        $url3 = '';
        include('./templates/'.$exbb['default_style'].'all_header.tpl');
        include('./templates/'.$exbb['default_style'].'postok.tpl');
        include('./templates/'.$exbb['default_style'].'footer.tpl');
} # end if clear to edit

else {
        $title_page = $exbb['boardname'].' :: '.$lang['Topic_deleting'];
        include('./templates/'.$exbb['default_style'].'all_header.tpl');
        include('./templates/'.$exbb['default_style'].'admin/deletetopic.tpl');
        include('./templates/'.$exbb['default_style'].'footer.tpl');
}
} # end deletethread

###########################

function un_lockthread($mode) {
global $exbb,$lang,$vars,$inuser;

    $filetoopen = $exbb['home_path'].'data/allforums.php';
    $forum = get_file($filetoopen);

    $inforum = $vars['forum'];
    $intopic = $vars['topic'];

    $inmembmod = moderator($inforum,$forum);

    if ($inmembmod) {

        $filetoopen = $exbb['home_path'].'forum'.$inforum.'/list.php';
        $list = get_file($filetoopen);
        $lst = fopen($filetoopen,'r+');
        lock_file($lst);

        if ($mode == 'lock') {
          $list[$intopic]['state'] = 'closed';
        } else {
          $list[$intopic]['state'] = 'open';
        }
        save_opened_file($lst,$list);

        $res = ($mode == 'lock') ? $lang['Topic_closed'] : $lang['Topic_unlock'];
        $title_page = $exbb['boardname'].' :: '.$res;
        $ok_title = $res;
        $relocurl = 'forums.php?forum='.$inforum;
        $url1 = '<li><a href="forums.php?forum='.$inforum.'">'.$lang['Back_in_forum'].'</a>';
        $url2 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
        $url3 = null;
        include('./templates/'.$exbb['default_style'].'all_header.tpl');
        include('./templates/'.$exbb['default_style'].'postok.tpl');
        include('./templates/'.$exbb['default_style'].'footer.tpl');
   } # end if clear to edit

   else { error($lang['Topic_closing'],$lang['Edit_no']); }

} # end un_lockthread


function deletepost() {
global $exbb,$lang,$vars,$inuser;

    $filetoopen = $exbb['home_path'].'data/allforums.php';
    $forum = get_file($filetoopen);

    $inforum = $vars['forum'];
    $intopic = $vars['topic'];
    $in_file = '';
    list($id,$in_file,$in_page) = explode(':',$vars['id']);

    $inmembmod = moderator($inforum,$forum);

    if (!$inmembmod) { error($lang['Post_deleting'],$lang['Edit_no']);}

        $all = fopen($filetoopen,'r+');
        lock_file($all);

        $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd'.$in_file.'.php';
        $allmessages = get_file($filetoopen);
        $thd = fopen($filetoopen,'w');
        lock_file($thd);

        if (!isset($allmessages[$id])) {fclose($thd); fclose($all); error($lang['Main_msg'],$lang['Dont_chg_url']);}

        ksort($allmessages,SORT_NUMERIC);
        reset($allmessages);
        #First message in topic?
        if (empty($in_file)) {
          $check_key = key($allmessages);
          if ($id == $check_key) {
             fclose($thd); fclose($all);
             error($lang['Post_deleting'],$lang['Post_deleting_first']);
          }
        }
        #Last message in topic?
        $last = false;
        end($allmessages);
        $check_key = key($allmessages);

        if ($id == $check_key) $last = true;

        $poster = isset($allmessages[$id]['p_id']) ? $allmessages[$id]['p_id'] : 0;

        if (isset($allmessages[$id]['attach_id'])) {
          $filetoopen = $exbb['home_path'].'forum'.$inforum.'/attaches-'.$intopic.'.php';
          $t_attaches = get_file($filetoopen);
          $attach_id = $allmessages[$id]['attach_id'];
          $attach_name = $t_attaches[$attach_id]['id'];
          unset($t_attaches[$attach_id]);
          save_file($filetoopen,$t_attaches);
          $filetoopen = $exbb['home_path'].'uploads/'.$attach_name;
          @unlink($filetoopen);
        }
        ### First off, lets delete the post in the thread.
        unset($allmessages[$id]);

        end($allmessages);
        $check_key = key($allmessages);
		$last_post = $allmessages[$check_key];

        save_opened_file($thd,$allmessages);
        unset($allmessages);

        $filetoopen = $exbb['home_path'].'forum'.$inforum.'/list.php';
        $list = get_file($filetoopen);
        $lst = fopen($filetoopen,'r+');
        lock_file($lst);

        if ($last) {

			$last_user = ( checkuser($last_post['p_id']) ) ? get_file($exbb['home_path'].'/members/'.$last_post['p_id'].'.php') : false;
			if (!$last_user) {
				$last_user['name'] = false;
				$last_user['id'] = 0;
			}

			$list[$intopic]['poster'] = $last_user['name'];
			$list[$intopic]['p_id'] = $last_user['id'];
			$list[$intopic]['postdate'] = $check_key;
        }

        $list[$intopic]['posts']--;
        if (!empty($in_file)) {
           $extmode = unserialize($list[$intopic]['ext']);
           $extmode[$in_file]--;

		   $in_file_next = $in_file + 1;
		   $in_file_cur = $in_file;

		   if ( $extmode[$in_file_cur] <= 0 && isset($extmode[$in_file_next]) ) {
			   for ($in_file_cur = $in_file; $in_file_cur <= $list[$intopic]['fls']-1; $in_file_cur++) {
				   $in_file_next = $in_file_cur + 1;
				   $extmode[$in_file_cur] = $extmode[$in_file_next];
				   copy($exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd'.$in_file_next.'.php', $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd'.$in_file_cur.'.php');
				   unlink($exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd'.$in_file_next.'.php');
			   }
			   unset($extmode[$list[$intopic]['fls']]);

			   $list[$intopic]['ext'] = serialize($extmode);
			   $list[$intopic]['fls']--;
		   }
		   elseif ( $extmode[$in_file_cur] <= 0 && $list[$intopic]['fls'] == 1 ) {
			   unset($list[$intopic]['fls'],$list[$intopic]['ext']);
			   unlink($exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd1.php');
			   $in_page = 1;
		   } elseif ( $extmode[$in_file_cur] <= 0 && $list[$intopic]['fls'] == $in_file ) {
			   echo 'last';
			   $list[$intopic]['fls']--;
			   unset($extmode[$in_file]);
			   $list[$intopic]['ext'] = serialize($extmode);
			   unlink($exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd'.$in_file.'.php');
			   $in_page--;
		   }
		   else { $list[$intopic]['ext'] = serialize($extmode); }
		   unset($extmode);
        }
        save_opened_file($lst,$list);

        if ($forum[$inforum]['last_post_id'] == $intopic && $last) {
           $forum[$inforum]['last_poster'] = ($last_user['name']) ? $last_user['name'] : $lang['Unreg'];
           $forum[$inforum]['last_time'] = $check_key;
           $forum[$inforum]['last_poster_id'] = $last_user['id'];
        }
        $forum[$inforum]['posts']--;
        save_opened_file($all,$forum);

		access_log($exbb['member'].' - удалил сообщение из темы - '.$list[$intopic]['name'].' - в форуме '.$forum[$inforum]['name']);

		unset($forum,$list,$last_user);

        # Обновим количество постов у юзера, пост которого удалили
        $filetoopen = $exbb['home_path'].'/members/'.$poster.'.php';
        if (file_exists($filetoopen)) {
            $user = array();
            $user = get_file($filetoopen);
            $fp = fopen($filetoopen,'w');
            lock_file($fp);
            if ($user['posts'] > 0) $user['posts']--;
            if ( $user['posted'][$inforum] >0 ) $user['posted'][$inforum]--;
            save_opened_file($fp,$user);
        }

        include('./data/boardstats.php');

        $exbb['totalposts']--;
        save_statfile();

        $title_page = $exbb['boardname'].' :: '.$lang['Post_deleted'];
        $ok_title = $lang['Post_deleted'];
        $relocurl = 'topic.php?forum='.$inforum.'&topic='.$intopic.'&start='.$in_page;
        $url1 = '<li><a href="'.$relocurl.'">'.$lang['Return_in_topic'].'</a> ';
        $url2 = '<li><a href="forums.php?forum='.$inforum.'">'.$lang['Return_in_forum'].'</a>';
        $url3 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
        include('./templates/'.$exbb['default_style'].'all_header.tpl');
        include('./templates/'.$exbb['default_style'].'postok.tpl');
        include('./templates/'.$exbb['default_style'].'footer.tpl');

} # end subdelete

function editform() {
global $exbb,$lang,$vars,$inuser;

  $filetoopen = $exbb['home_path'].'data/allforums.php';
  $forum = get_file($filetoopen);

  $inforum = $vars['forum'];
  $intopic = $vars['topic'];
  $in_file = '';
  list($id,$in_file,$in_page) = explode(':',$vars['id']);
  $inmembmod = moderator($inforum,$forum);

  if (($forum[$inforum]['private']) && (!$inuser['private'][$inforum])) {error($lang['Message_edit'],$lang['Editing_cant']);}

  $forumname = stripslashes($forum[$inforum]['name']);

if ($forum[$inforum]['codes']) {
   $codemap = '<br><script language="JavaScript">ibcodes();</script>';
   $smilesmap = '<br><script language="JavaScript">ibsmiles();</script>';
   $java = '<script language="Javascript" src="smilesmap.js"></script><script language="Javascript" src="codesmap.js"></script>';
}
### Grab the post to edit

   $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd'.$in_file.'.php';
   $allmessages = get_file($filetoopen);

   if (!isset($allmessages[$id])) error($lang['Message_edit'],$lang['Dont_chg_url']);

   if (!$inmembmod && $allmessages[$id]['p_id'] != $exbb['mem_id']) error($lang['Message_edit'],$lang['Editing_not_author']);

   if (isset($allmessages[$id]['lockedit']) && !$inmembmod) error($lang['Message_edit'],$lang['Editing_blocked']);
   if (isset($allmessages[$id]['ad_edited']) && isset($allmessages[$id]['lockedit']) && !defined('IS_ADMIN')) error($lang['Message_edit'],$lang['Editing_after_ad']);

   $filetoopen = $exbb['home_path'].'forum'.$inforum.'/list.php';
   $list = get_file($filetoopen);

   $topictitle = $list[$intopic]['name'];
   $is_poll = ($list[$intopic]['poll']) ? true : false;

   if (!$inmembmod && $list[$intopic]['state'] == 'closed') error($lang['Message_edit'],$lang['Edit_closed']);

   unset($list);

   if ($vars['previewfirst'] == 'yes') {
     if ( strlen($_POST['inpost']) > $exbb['max_posts']) {error($lang['Message_sending'],$lang['Big_post']);}
     if ( strlen(trim($_POST['inpost'])) < 1) {error($lang['Message_sending'],$lang['Mess_needed']);}
     $preview = str_replace( '$' , '&#036;' , $vars['inpost'] );
     $preview = ikoncode($preview);
     if ($exbb['emoticons']) { $preview = setsmiles($preview); }
     $preview = bads_filter($preview);
     include('./templates/'.$exbb['default_style'].'preview.tpl');
     unset($preview);
     $vars['pollansw'] = $_POST['pollansw'];
     $mo_edit = stripslashes($_POST['mo_edit']);
   }
   else {
     if ($is_poll) {
       $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-poll.php';
       $poll_data = get_file($filetoopen);
       $vars['pollname'] = $poll_data['pollname'];
       $poll_chces = unserialize( $poll_data['choices']);
       $vars['pollansw'] = '';
       foreach ($poll_chces as $choice)  $vars['pollansw'] .= $choice[1]."\n";
       unset($poll_chces,$poll_data,$filetoopen);
     }
   }

   $upload = (isset($forum[$inforum]['upload']) && !empty($forum[$inforum]['upload']) && $exbb['file_upload']) ? $forum[$inforum]['upload'] : 0;
   if ($upload && $inuser['upload']) {
     $enctype = ' enctype="multipart/form-data"';
     $hidden = '<input type="hidden" name="MAX_FILE_SIZE" value="'.$upload.'">';
     $filetoup = $lang['File_upload'].$upload.'<br />';
     if (isset($allmessages[$id]['attach_id'])) {
       $filetoup .= $lang['Keep_attach'].'( '.$allmessages[$id]['attach_file'].' )<br />';
       $filetoup .= $lang['Del_attach'].'<br />';
       $filetoup .= $lang['Replace_attach'].'<br /><input class="input" type="file" size="30" name="FILE_UPLOAD">';
     }
     else {
       $filetoup .= '<input class="input" type="file" size="30" name="FILE_UPLOAD">';
     }
   }
   if (!isset($vars['inpost'])) {
     $rawpost = str_replace('<p>',"\n\n",$allmessages[$id]['post']);
     $rawpost = str_replace('<br>',"\n",$rawpost);
     $rawpost = stripslashes($rawpost);
     $mo_edit = stripslashes($allmessages[$id]['mo_text']);
   } else { $rawpost = stripslashes($_POST['inpost']);}

   $checked = ($allmessages[$id]['sig']) ? ' checked' : '';
   $lockedit = ( isset($vars['lockedit']) ) ? ' checked' : '';
   $sig_show = '<input type=checkbox name="inshowsignature" value="yes"'.$checked.'>'.$lang['Do_sig'].'<br>';

   if ($exbb['emoticons']) {
     $emoticonslink = '<a href="tools.php?action=smiles" target=_blank>'.$lang['Smiles_on'].'</a>';
     $checked = ($allmessages[$id]['smiles']) ? ' checked' : '';
     $emoticonsbutton = '<input type=checkbox name="inshowemoticons" value="yes"'.$checked.'>'.$lang['Do_smiles'].'<br>';
   }

   $title_page = $exbb['boardname'].' :: '.$lang['Message_edit'];
   include('./templates/'.$exbb['default_style'].'all_header.tpl');
   include('./templates/'.$exbb['default_style'].'post_edit.tpl');
   include('./templates/'.$exbb['default_style'].'footer.tpl');

} # end edit form


function processedit() {
global $exbb,$lang,$vars,$inuser,$inmembmod;
  post_size();

  $filetoopen = $exbb['home_path'].'data/allforums.php';
  $forum = get_file($filetoopen);

  $inforum = $vars['forum'];
  $intopic = $vars['topic'];
  $in_file = '';
  list($id,$in_file,$in_page) = explode(':',$vars['id']);

  $inmembmod = moderator($inforum,$forum);

  if (($forum[$inforum]['private']) && (!$inuser['private'][$inforum])) { error($lang['Message_edit'],$lang['Editing_cant']); }

  $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd'.$in_file.'.php';
  $allmessages = get_file($filetoopen);
  $thd = fopen($filetoopen,'r+');
  lock_file($thd);

  if (!isset($allmessages[$id])) { fclose($thd); error($lang['Message_edit'],$lang['Dont_chg_url']); }

  if (!$inmembmod && $allmessages[$id]['p_id'] != $exbb['mem_id']) { fclose($thd); error($lang['Message_edit'],$lang['Editing_not_author']); }

  #unset($top_keys);


  $edit_date = time();

  if ($inmembmod && !defined('IS_ADMIN')) { #edition by moderator but not admin
     if ($allmessages[$id]['p_id'] != $exbb['mem_id']) {
        $allmessages[$id]['mo_editor'] = $exbb['member'];
        if ($vars['mo_edit'] != '') $allmessages[$id]['mo_text'] = soft_clr_value($_POST['mo_edit']);
        $allmessages[$id]['mo_edited'] = $edit_date;
        if (isset($vars['lockedit'])) {$allmessages[$id]['lockedit'] = true;} else {unset($allmessages[$id]['lockedit']);}
     }
   }
   elseif (defined('IS_ADMIN')) { #edition by admin
     if ($allmessages[$id]['p_id'] != $exbb['mem_id']) {
        $allmessages[$id]['ad_editor'] = $exbb['member'];
        if ($vars['mo_edit'] != '') $allmessages[$id]['mo_text'] = soft_clr_value($_POST['mo_edit']);
        $allmessages[$id]['ad_edited'] = $edit_date;
        if (isset($vars['lockedit'])) {$allmessages[$id]['lockedit'] = true;} else {unset($allmessages[$id]['lockedit']);}
        unset($allmessages[$id]['mo_editor'],$allmessages[$id]['mo_edited']);
     }
   }
   else { #and user
        $allmessages[$id]['edited'] = $edit_date;
   }
   if ($inmembmod && $allmessages[$id]['p_id'] == $exbb['mem_id']) $vars['inpost'] = soft_clr_value($_POST['inpost']);

   $allmessages[$id]['post'] = preg_replace( "#(\?|&amp;|;|&)PHPSESSID=([0-9a-zA-Z]){32}#i", "", $vars['inpost'] );
   $allmessages[$id]['smiles'] = ($vars['inshowemoticons'] == 'yes') ? true : false;
   $allmessages[$id]['sig'] = ($vars['inshowsignature'] == 'yes') ? true : false;

   $upload = (isset($forum[$inforum]['upload']) && !empty($forum[$inforum]['upload']) && $exbb['file_upload']) ? $forum[$inforum]['upload'] : 0;

   if (isset($vars['editattach'])) {
     $filetoopen = $exbb['home_path'].'forum'.$inforum.'/attaches-'.$intopic.'.php';
     $t_attaches = get_file($filetoopen);
     $attach_id = $allmessages[$id]['attach_id'];
     $attach_name = $t_attaches[$attach_id]['id'];
     if ($vars['editattach'] == 'del') {
       unset($allmessages[$id]['attach_id'],$allmessages[$id]['attach_file']);
       unset($t_attaches[$attach_id]);
       save_file($filetoopen,$t_attaches);
       $filetoopen = $exbb['home_path'].'uploads/'.$attach_name;
       @unlink($filetoopen);
     }
     elseif ($vars['editattach'] == 'rep' && $upload) {
       $exbb['uploadsize'] = $upload;
       $attach = attach_upload($attach_id,$attach_name);
       $allmessages[$id]['attach_file'] = $attach['attach_file'];
     }
   }
   elseif ($upload && $inuser['upload']) {
       $exbb['uploadsize'] = $upload;
       $attach = attach_upload();
       if (!empty($attach['attach_id']) && !empty($attach['attach_file'])) {
         $allmessages[$id]['attach_id'] = $attach['attach_id'];
         $allmessages[$id]['attach_file'] = $attach['attach_file'];
       }
   }

   save_opened_file($thd,$allmessages);
   unset($allmessages);

   $relocurl = 'topic.php?forum='.$inforum.'&topic='.$intopic.'&start='.$in_page.'#'.$id;

   $title_page = $exbb['boardname'].' :: '.$lang['Edit_complete'];
   $ok_title = $lang['Edit_complete'];
   $url1 = '<li><a href="topic.php?forum='.$inforum.'&topic='.$intopic.'">'.$lang['Return_in_topic'].'</a> ';
   $url2 = '<li><a href="forums.php?forum='.$inforum.'">'.$lang['Return_in_forum'].'</a>';
   $url3 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
   include('./templates/'.$exbb['default_style'].'all_header.tpl');
   include('./templates/'.$exbb['default_style'].'postok.tpl');
   include('./templates/'.$exbb['default_style'].'footer.tpl');

} # end routine

function del_subscribed() {
global $exbb,$lang,$vars,$inuser;

  $inforum = $vars['forum'];
  $intopic = $vars['topic'];
  $inmembmod = moderator($inforum,$forum);

  if ($inmembmod) {
    $unlink_file = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-m.php';
    @unlink($unlink_file);
    $relocurl = 'topic.php?forum='.$inforum.'&topic='.$intopic.'&start=1';
    $title_page = $exbb['boardname'].' :: '.$lang['Unsubscribed'];
    $ok_title = $lang['Unsubscribed'];
    $url1 = '<li><a href="topic.php?forum='.$inforum.'&topic='.$intopic.'">'.$lang['Return_in_topic'].'</a> ';
    $url2 = '<li><a href="forums.php?forum='.$inforum.'">'.$lang['Return_in_forum'].'</a>';
    $url3 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
    include('./templates/'.$exbb['default_style'].'all_header.tpl');
    include('./templates/'.$exbb['default_style'].'postok.tpl');
    include('./templates/'.$exbb['default_style'].'footer.tpl');
  } else {
    error($lang['Message_edit'],$lang['Edit_no']);
  }
}

function poll_edit() {
global $exbb,$lang,$vars,$inuser,$inmembmod;

   if (empty($vars['forum']) || empty($vars['topic'])) error($lang['Poll'],$lang['Dont_chg_url']);

   $forum = get_file($exbb['home_path'].'data/allforums.php');
   if ($inmembmod) { error($lang['Poll'],$lang['Edit_no']);}
   unset($forum);

   if ($vars['delpoll'] == 'yes') {
     if (!isset($vars['check'])) {
       $form = '<p><form action="postings.php" method="post">
            <input type=hidden name="action" value="poll">
            <input type=hidden name="delpoll" value="yes">
            <input type=hidden name="forum" value="'.$vars['forum'].'">
            <input type=hidden name="topic" value="'.$vars['topic'].'">
            <input type=hidden name="check" value="1">'.$lang['Poll_delete'].'
            <input class=button type=submit name=submit value='.$lang['yes'].'>
            </form>';
            error($lang['Poll'],$form,'',false);
     }
     else {
       $filetoopen = $exbb['home_path'].'forum'.$vars['forum'].'/'.$vars['topic'].'-poll.php';
       @unlink($filetoopen);
       $filetoopen = $exbb['home_path'].'forum'.$vars['forum'].'/list.php';
       $list = get_file($filetoopen);
       $lst = fopen($filetoopen,'r+');
       lock_file($lst);
       unset($list[$vars['topic']]['poll']);
       save_opened_file($lst,$list);
       unset($list,$filetoopen);
       $relocurl = 'topic.php?forum='.$vars['forum'].'&topic='.$vars['topic'].'&start=1';
       $title_page = $exbb['boardname'].' :: '.$lang['Poll_deleted'];
       $ok_title = $lang['Poll_deleted'];
       $url1 = '<li><a href="topic.php?forum='.$vars['forum'].'&topic='.$vars['topic'].'">'.$lang['Return_in_topic'].'</a> ';
       $url2 = '<li><a href="forums.php?forum='.$vars['forum'].'">'.$lang['Return_in_forum'].'</a>';
       $url3 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
       include('./templates/'.$exbb['default_style'].'all_header.tpl');
       include('./templates/'.$exbb['default_style'].'postok.tpl');
       include('./templates/'.$exbb['default_style'].'footer.tpl');
     }
  }
  else {

    $filetoopen = $exbb['home_path'].'forum'.$vars['forum'].'/'.$vars['topic'].'-poll.php';
    $poll_data = get_file($filetoopen);
    #$vars['pollname'] = $poll_data['pollname'];
    $poll_chces = unserialize( $poll_data['choices']);

    $polls_new = explode( '<br>', $vars['pollansw'] );

    $vote_count = 0;
    $poll_id = 0;
    if ( (count($polls_new) < count($poll_chces)) || isset($vars['respoll'])) {
      $poll_data['votes'] = 0;
      $poll_data['ids'] = serialize(array());
    }

    foreach ($polls_new as $choice) {
      if ( $choice == '' ) continue;

       $votes = (isset($poll_chces[$poll_id][2])) ? $poll_chces[$poll_id][2] : 0;
       $votes = (isset($vars['respoll'])) ? 0 : $votes;
       $vote_count += $votes;
       $poll_array[] = array( $poll_id , $choice, $votes );
       $poll_id++;
    }

    if ($poll_id > 10 || $poll_id < 2) error($lang['Poll'],$lang['Poll_error']);

    $poll = array();

    $poll_data['pollname'] = $vars['pollname'];
    $poll_data['choices'] = serialize($poll_array);
    $poll_data['votes'] = $vote_count;
    save_file($filetoopen,$poll_data);

    $relocurl = 'topic.php?forum='.$vars['forum'].'&topic='.$vars['topic'].'&start=1';
    $title_page = $exbb['boardname'].' :: '.$lang['Edit_complete'];
    $ok_title = $lang['Edit_complete'];
    $url1 = '<li><a href="topic.php?forum='.$vars['forum'].'&topic='.$vars['topic'].'">'.$lang['Return_in_topic'].'</a> ';
    $url2 = '<li><a href="forums.php?forum='.$vars['forum'].'">'.$lang['Return_in_forum'].'</a>';
    $url3 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
    include('./templates/'.$exbb['default_style'].'all_header.tpl');
    include('./templates/'.$exbb['default_style'].'postok.tpl');
    include('./templates/'.$exbb['default_style'].'footer.tpl');

  }
  return;

}

function top_recount() { #start
global $exbb,$vars,$lang;

  $inforum = $vars['forum'];
  $intopic = $vars['topic'];
  $postscount = 0;
  $fileoopen = $exbb['home_path'].'forum'.$inforum.'/list.php';
  include('./language/' . $exbb['default_lang'] . '/lang_admin.php');
  if (file_exists($fileoopen)) {
    $list = get_file($fileoopen);
    $lst = @fopen($fileoopen,'r+');
    lock_file($lst,2);
    $topiccount = $list[$intopic]['posts'];
    $extmode = ( isset($list[$intopic]['ext']) ) ? unserialize($list[$intopic]['ext']) : array();
    $y = ( count($extmode) ) ? $list[$intopic]['fls'] : false;
    $fileoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd.php';
    $topic = get_file($fileoopen);
    $postscount += count($topic);
    if ($y) {
        $extmode[0] = $postscount;
        $fileoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd';
        for ($i=1; $i<=$y; $i++) {
            $topic = get_file($fileoopen.$i.'.php');
            $extmode[$i] = count($topic);
            $postscount += $extmode[$i];
        }
        $list[$intopic]['ext'] = serialize($extmode);
    }
    $postscount--;
    $list[$intopic]['posts'] = $postscount;
    save_opened_file($lst,$list);
    unset($list,$topic);
    $info = "$lang[Now_stat]<br>$lang[Posts_total] <b>$topiccount</b><p>$lang[After_recount]<br>
               $lang[Posts_total] <b>$postscount</b>";

    error($lang['Counting_complete'],$info,'',0);
  }
  error($lang['Info'],$lang['Stat_error'],'',0);
}

function restore() {
global $exbb,$vars,$lang;

  $inforum = $vars['forum'];
  $intopic = $vars['topic'];

  $filetoopen = $exbb['home_path'].'data/allforums.php';
  $forum = get_file($filetoopen);
  $forumname = $forum[$inforum]['name'];
  unset($forum);

  $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd.php';
  $url = $exbb['boardurl'].'/topic.php?forum='.$inforum.'&topic='.$intopic;
  if ( file_exists($filetoopen) ) {
      $topic = get_file($filetoopen);
      ksort($topic,SORT_NUMERIC);
      reset($topic);
      $t_date = key($topic);
      $t_name = isset($topic[$t_date]['name']) ? $topic[$t_date]['name'] : '';
      $t_desc = isset($topic[$t_date]['desc']) ? $topic[$t_date]['desc'] : '';
      $t_author_id = $topic[$t_date]['p_id'] ? $topic[$t_date]['p_id'] : 0;
      $t_author = getmember($t_author_id);
      $t_author = ($t_author) ? $t_author['name'] : false;
      $t_post = $topic[$t_date]['post'];
      $posts = count($topic) - 1;
      $time = date("d-m-Y H:i:s",$t_date-$exbb['usertime']*3600);
      $files = 1;
      $file = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd';
      while ( file_exists($file.$files.'.php') ) $files++;
      $files--;
      $note = $lang['recover_btn'];
      if ( $files > 0 ) $note .= $lang['recover_note'];

  }

  if (!isset($vars['check'])) {
    unset($topic);
    $title_page = $exbb['boardname'].' :: '.$lang['top_recover'];
    $t_author = ($t_author) ? $t_author : $lang['Unreg'];
    include('./templates/'.$exbb['default_style'].'all_header.tpl');
    include('./templates/'.$exbb['default_style'].'logos.tpl');
    include('./templates/'.$exbb['default_style'].'top_restore.tpl');
    include('./templates/'.$exbb['default_style'].'footer.tpl');
  }
  else {
      $topic[$t_date]['name'] = $vars['name'];
      if (!empty($vars['desc'])) $topic[$t_date]['desc'] = $vars['desc'];
      $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd.php';
      save_file($filetoopen,$topic);
      end($topic);
      $last_key = key($topic);
      $last_id = isset($topic[$last_key]['p_id']) ? $topic[$last_key]['p_id'] : false;
      unset($topic);

      $filetoopen = $exbb['home_path'].'forum'.$inforum.'/list.php';
      $list = get_file($filetoopen);
      $lst = fopen($filetoopen,'r+');
      lock_file($lst);

      if ( $files > 0 ) {
          $extmode = array();
          $extmode[0] = $posts;
          $list[$intopic]['fls'] = $files;
          $list[$intopic]['ext'] = serialize($extmode);
          $filetoopen = $exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-thd'.$files.'.php';
          if ( file_exists($filetoopen) ) {
              $topic = get_file($filetoopen);
              ksort($topic,SORT_NUMERIC);
              end($topic);
              $last_key = key($topic);
              $last_id = isset($topic[$last_key]['p_id']) ? $topic[$last_key]['p_id'] : 0;
          }
      }
      $t_poster = getmember($last_id);
      $t_poster = ($t_poster) ? $t_poster['name'] : false;

      $list[$intopic]['name'] = $vars['name'];
      if (!empty($vars['desc'])) $list[$intopic]['desc'] = $vars['desc'];
      $list[$intopic]['state'] = 'open';
      $list[$intopic]['posts'] = $posts;
      $list[$intopic]['author'] = $t_author;
      $list[$intopic]['a_id'] = $t_author_id;
      $list[$intopic]['date'] = $t_date;
      $list[$intopic]['poster'] = $t_poster;
      $list[$intopic]['p_id'] = $last_id;
      $list[$intopic]['postdate'] = $last_key;
      if ( file_exists($exbb['home_path'].'forum'.$inforum.'/'.$intopic.'-poll.php') ) $list[$intopic]['poll'] = true;
      #uasort ($list, 'sort_by_postdate');
      save_opened_file($lst,$list);
      @chmod($filetoopen,$exbb['ch_files']);
      unset($list);

      $relocurl = ( $files > 0 ) ? 'topic.php?forum='.$inforum.'&topic='.$intopic : 'forums.php?forum='.$inforum;

      $title_page = $exbb['boardname'].' :: '.$lang['top_recover'];
      $ok_title = $lang['top_recovered'];
      $url1 = '<li><a href=topic.php?forum='.$inforum.'&topic='.$intopic.'">'.$lang['Return_in_topic'].'</a>';
      $url2 = '<li><a href="forums.php?forum='.$inforum.'">'.$lang['Return_in_forum'].'</a>';
      $url3 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
      include('./templates/'.$exbb['default_style'].'all_header.tpl');
      include('./templates/'.$exbb['default_style'].'postok.tpl');
      include('./templates/'.$exbb['default_style'].'footer.tpl');
  }


} //func

function un_pinthread($mode) {
global $exbb,$lang,$vars,$inuser;

    $filetoopen = $exbb['home_path'].'data/allforums.php';
    $forum = get_file($filetoopen);

    $inforum = $vars['forum'];
    $intopic = $vars['topic'];

    $inmembmod = moderator($inforum,$forum);

    if ($inmembmod) {

        $filetoopen = $exbb['home_path'].'forum'.$inforum.'/_pinned.php';
        $sticked = get_file($filetoopen);

        if ($mode == 'pin') {
          $sticked[$intopic] = 1;
        } else {
          unset($sticked[$intopic]);
        }
        save_file($filetoopen,$sticked);
        @chmod($filetoopen,$exbb['ch_files']);

        $res = ($mode == 'pin') ? 'Тема прикреплена' : 'Тема откреплена';
        $title_page = $exbb['boardname'].' :: '.$res;
        $ok_title = $res;
        $relocurl = 'forums.php?forum='.$inforum;
        $url1 = '<li><a href="forums.php?forum='.$inforum.'">'.$lang['Back_in_forum'].'</a>';
        $url2 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
        $url3 = null;
        include('./templates/'.$exbb['default_style'].'all_header.tpl');
        include('./templates/'.$exbb['default_style'].'postok.tpl');
        include('./templates/'.$exbb['default_style'].'footer.tpl');
   } # end if clear to edit

   else { error($lang['Topic_pinning'],$lang['Edit_no']); }

} # end un_pinthread

?>
