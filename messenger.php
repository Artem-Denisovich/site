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

if ($exbb['pm'] == 0 && !defined('IS_ADMIN') ) error($lang['PM'],$lang['pm_closed'],'',0);

$vars = parsed_vars();

if (!$exbb['reged']) error($lang['PM_tit'],$lang['User_unreg'],'<meta http-equiv="refresh" content="3; url=loginout.php">',true);

if ((isset($vars['msg'])) && ($vars['msg'] == '')) { error($lang['PM'],$lang['Dont_chg_url']);}

include($exbb['home_path'] . 'language/' . $exbb['default_lang'] . '/lang_pm.php');

if ($vars['action'] == 'new' || $vars['action'] == 'reply1') {

   $touser = getmember($vars['touser']);
   $touser['name'] = ($touser) ? $touser['name'] : '???';

   $from = $touser['name'];

   $codemap = '<br><script language="JavaScript">ibcodes();</script>';
   $smilesmap = '<br><script language="JavaScript">ibsmiles();</script>';
   $java = '<script language="Javascript" src="smilesmap.js"></script><script language="Javascript" src="codesmap.js"></script>';

   if ($vars['action'] == 'reply1') {

        $filetoopen = 'messages/'.$exbb['mem_id'].'-msg.php';
        $inboxmessages = get_file($filetoopen);
        if (!isset($inboxmessages[$vars['msg']])) error($lang['PM'],$lang['Correct_post']);

        $from = $inboxmessages[$vars['msg']]['from'];
        $date = $vars['msg'];
        $messagetitle = 'RE:'.$inboxmessages[$vars['msg']]['title'];
        $post = $inboxmessages[$vars['msg']]['msg'];
        $post = str_replace('<br>',"\n",$post);
        $post = str_replace('<p>',"\n\n",$post);
        $post = '[q]'.$post.'[/q]';
   }
   $vars['action'] = 'new';
}
elseif ($vars['action'] == 'outbox') {

        $filetoopen = $exbb['home_path'].'messages/'.$exbb['mem_id'].'-out.php';
        if (file_exists($filetoopen)) {
          $outboxmessages = get_file($filetoopen);
          $totalinboxmessages = count($outboxmessages);
          krsort($outboxmessages);
        } else { $totalinboxmessages = 0; $outboxmessages = array();}

        # Prepare the messages.

        foreach ($outboxmessages as $date=>$ms) {
            $from = $ms['to'];
            $messagetitle = '<a href="messenger.php?action=outread&msg='.$date.'">'.$ms['title'].'</a>';
			$readstate = '&nbsp;';
			$time = date("d.m.Y - H:i", $date + $exbb['usertime']*3600);
            include('./templates/'.$exbb['default_style'].'pm_inbox_data.tpl');
        }
} # end action
elseif ($vars['action'] == 'deleteall') {

        if ($vars['where'] == 'inbox') {
                $filetotrash = $exbb['home_path'].'messages/'.$exbb['mem_id'].'-msg.php';
        }
        elseif ($vars['where'] == 'outbox') {
                $filetotrash = $exbb['home_path'].'messages/'.$exbb['mem_id'].'-out.php';
        }

        if ($filetotrash != '') {
                @unlink($filetotrash);
        }
        else {
                error($lang['PM'],$lang['PM_not_deleted'],'',0);
        }
	  error($lang['PM'],$lang['All_deleted_you'].$vars['where'],'<meta http-equiv="refresh" content="3; url=messenger.php?action='.$vars['where'].'">',false);

} # end action
elseif ($vars['action'] == 'outread') { # start showing messages

        $filetoopen = 'messages/'.$exbb['mem_id'].'-out.php';
        $outboxmessages = get_file($filetoopen);
        if (!isset($outboxmessages[$vars['msg']])) error($lang['PM'],$lang['Correct_post']);

        $to = $outboxmessages[$vars['msg']]['to'];
        $date = $vars['msg'];
        $messagetitle = $outboxmessages[$vars['msg']]['title'];
        $post = $outboxmessages[$vars['msg']]['msg'];

        $date = $date + $exbb['usertime']*3600;
        $date = longDate($date,1);

        # Split the line
        $post = ikoncode($post);
        if ($exbb['emoticons']) {$post = setsmiles($post);}

} # end outread
elseif ($vars['action'] == 'send') {

        $allusers = get_file($exbb['home_path'].'data/users.php');
        $touser = preg_replace ($lang['search'], $lang['replace'], $vars['touser']);
        $u_id = 0;
        foreach ($allusers as $id=>$info) {
           if ($info['n'] == $touser) {$u_id = $id; break;}
        }

        if (empty($u_id)) error($lang['Message_sending'],$lang['User_not_found'],'',0);
        
		$touser = getmember($u_id);

        if (!$touser) {error($lang['Message_sending'],$lang['User_not_found'],'',0);}

        $membername = $touser['name'];

        # Check for blanks

        if (empty($vars['msgtitle']) || empty($vars['inpost']) || empty($vars['touser'])) { error($lang['Message_sending'],$lang['PM_fill']); }

        if (strlen($vars['poslanie']) > $exbb['max_posts']) {error($lang['PM'],$lang['Big_post']);}

        $currenttime = time();

        $touser['new_pm'] = true;
        $filetomake = $exbb['home_path'].'members/'.$u_id.'.php';
        save_file($filetomake,$touser);

        # Send the message to the user's file
        $filetomake = $exbb['home_path'].'messages/'.$u_id.'-msg.php';

        $inboxmessages = (file_exists($filetomake)) ? get_file($filetomake) : array();

        $msg = fopen($filetomake,'w');
		lock_file($msg);
        # Write back to the 'to' users file
        $inboxmessages[$currenttime]['from'] = $exbb['member'];
        $inboxmessages[$currenttime]['title'] = $vars['msgtitle'];
        $inboxmessages[$currenttime]['msg'] = $vars['inpost'];
        $inboxmessages[$currenttime]['status'] = false;
        save_opened_file($msg,$inboxmessages);
		@chmod($filetomake,$exbb['ch_files']);
        unset($inboxmessages);

        # Now, write it to the outbox of the sender

        $filetomake = $exbb['home_path'].'messages/'.$exbb['mem_id'].'-out.php';

        if (file_exists($filetomake)) {
            $outboxmessages = get_file($filetomake);
            $msg = fopen($filetomake,'r+');
        } else {
            $outboxmessages = array();
            $msg = fopen($filetomake,'w');
        }
		lock_file($msg);
        $outboxmessages[$currenttime]['to'] = $vars['touser'];
        $outboxmessages[$currenttime]['title'] = $vars['msgtitle'];
        $outboxmessages[$currenttime]['msg'] = $vars['inpost'];
        save_opened_file($msg,$outboxmessages);
		@chmod($filetomake,$exbb['ch_files']);

		error($lang['Message_sending'],"<b>$lang[Message_text] $lang[PM_for] $membername $lang[was_sent]</b><br>$lang[PM_stored]",'<meta http-equiv="refresh" content="3; url=messenger.php">',false);

} # end action
elseif ($vars['action'] == 'inbox') {

        $inuser = getmember($exbb['mem_id']);
        if (!$inuser) {error($lang['Message_sending'],$lang['User_not_found'],'',0);}
        $inuser['new_pm'] = false;
        $filetomake = $exbb['home_path'].'members/'.$exbb['mem_id'].'.php';
        save_file($filetomake,$inuser);
        # Pick up the messages (inbox)

        $filetomake = $exbb['home_path'].'messages/'.$exbb['mem_id'].'-msg.php';
        if (file_exists($filetomake)) {
           $inboxmessages = get_file($filetomake);
           $totalinboxmessages = count($inboxmessages);
           krsort($inboxmessages);
        } else {
           $inboxmessages = array();
           $totalinboxmessages = 0;
        }

        # Display the messages.

        foreach ($inboxmessages as $date=>$ms) {
            $from = $ms['from'];
            $messagetitle = '<a href="messenger.php?action=read&msg='.$date.'">'.$ms['title'].'</a>';
            $readstate = (!$ms['status']) ? '<b>'.$lang['no'].'</b>' : $lang['yes'];
			$time = date("d.m.Y - H:i", $date + $exbb['usertime']*3600);
            include('./templates/'.$exbb['default_style'].'pm_inbox_data.tpl');
        }
}
elseif ($vars['action'] == 'read') { # start showing messages

        $filetoopen = $exbb['home_path'].'messages/'.$exbb['mem_id'].'-msg.php';
        $inboxmessages = get_file($filetoopen);
        if (!isset($inboxmessages[$vars['msg']])) error($lang['PM'],$lang['Dont_chg_url']);
        if (!$inboxmessages[$vars['msg']]['status']) {
             $msg = fopen($filetoopen,'r+');
			 lock_file($msg);
             #flock($msg,2);
             $inboxmessages[$vars['msg']]['status'] = true;
             save_opened_file($msg,$inboxmessages);
        }
        $from = $inboxmessages[$vars['msg']]['from'];
        $date = $vars['msg'];
        $messagetitle = ($exbb['wordcensor']) ? bads_filter($inboxmessages[$vars['msg']]['title']) : $inboxmessages[$vars['msg']]['title'];
        $post = ($exbb['wordcensor']) ? bads_filter($inboxmessages[$vars['msg']]['msg']) : $inboxmessages[$vars['msg']]['msg'];

        # Write back to as read

        $date = $date + $exbb['usertime']*3600;
        $date = longDate($date,'1');
        $post = ikoncode($post);
        if ($exbb['emoticons']) {$post = setsmiles($post);}

} # end read
elseif ($vars['action'] == 'delete') {

        # Open the user's file
      if ($vars['where'] == 'inbox') {
           $filetoopen = $exbb['home_path'].'messages/'.$exbb['mem_id'].'-msg.php';
      }
      elseif ($vars['where'] == 'outbox') {
           $filetoopen = $exbb['home_path'].'messages/'.$exbb['mem_id'].'-out.php';
      }

      $boxmessages = get_file($filetoopen);
      if (!isset($boxmessages[$vars['msg']])) error($lang['PM'],$lang['Dont_chg_url']);

      # Write back to the 'to' users file
      $msg = fopen($filetoopen,'w');
	  lock_file($msg);
      unset($boxmessages[$vars['msg']]);
      save_opened_file($msg,$boxmessages);
	  error($lang['PM'],$lang['PM_deledet_you'].$vars['where'],'<meta http-equiv="refresh" content="3; url=messenger.php?action='.$vars['where'].'">',false);

} # end action
else {
        # Pick up the messages
        $filetoopen = $exbb['home_path'].'messages/'.$exbb['mem_id'].'-msg.php';

        $unread = 0;
		$totalmessages = 0;
        if (file_exists($filetoopen)) {
            $allmessages =  get_file($filetoopen);
            $totalmessages = count($allmessages);
            foreach ($allmessages as $date=>$ms) if (!$ms['status'])  $unread++;
        }
        $vars['action'] = 'show';
     }


$title_page = $exbb['boardname'].' :: '.$lang['PM'];
include('./templates/'.$exbb['default_style'].'all_header.tpl');
include('./templates/'.$exbb['default_style'].'pm_'.$vars['action'].'.tpl');
include('./templates/'.$exbb['default_style'].'footer.tpl');
include('page_tail.php');
?>