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

define('IN_ADMIN', true);

include('common.php');
include('./data/boardstats.php');

$vars = parsed_vars();

if ( defined('IS_ADMIN') ) {

   switch ($vars['action']) {
     case 'updatecount' : docount(); break;
     case 'edit_user'   : edit(); break;
     case 'log'         : logfile(); break;
     case 'massmail'        : mass_mail(); break;
     default            : memberoptions(); break;
   }

}
 else {
      Header('Location: index.php'); exit;
      }

#############################################################

function memberoptions() {
global $exbb,$vars,$lang;

   if (empty($vars['action'])) {
       $inputfields = '<input type="text" name="username" maxlength="50" size="20" />
        <input type="hidden" name="action" value="find" />
        <input type="submit" name="usersubmit" value="'.$lang['Find_user'].'"/>';
   } else {
     $filedata = get_file($exbb['home_path'].'data/users.php');
     $data = '';
     $user = preg_replace ($lang['search'], $lang['replace'], $vars['username']);
	 $user = str_replace( "'" , '&#39;', $user);
     foreach ($filedata as $id=>$info) {
       if ( strstr($info['n'],$user) ) $data .= '<option value="'.$id.'">'.$info['n'].'</option>';
     }
     if (empty($data)) error($lang['User_admin'],$lang['User_notfound'],'',0);
$inputfields = <<<DATA
     <select name='userid'>$data</select>
     <input type="hidden" name="action" value="edit_user" />
     <input type="submit" name="usersubmit" value="$lang[Sel_user]"/>
DATA;
   }
    $title_page = $exbb['boardname'];
    include('./admin/all_header.tpl');
    include('./admin/user_select.tpl');
    include('page_tail_admin.php');

}


function edit() {
global $exbb,$vars,$lang;

 $user_id = $vars['userid'];

 $inuser = array();
 $inuser = getmember($user_id);

 if ($vars['checkaction'] == 'yes') {

    if (isset($vars['deleteuser'])) {deletemember();}

	$vars['newname'] = str_replace( "'" , '&#39;', $vars['newname'] );

    $newname = ($inuser['name'] == $vars['newname'] || empty($vars['newname'])) ? false : true;

    $password = (!empty($vars['password'])) ? $vars['password'] : '';
    if (!empty($password)) $inuser['pass'] = $password;
    $laststatus = $inuser['status'];

    $inuser['name']     = ($newname) ? $vars['newname'] : $inuser['name'];
    $inuser['title']    = $_POST['membertitle'];
    $inuser['mail']     = strtolower($vars['emailaddress']);
    $inuser['www']      = $vars['homepage'];
    $inuser['aim']      = $vars['aolname'];
    $inuser['icq']      = $vars['icqnumber'];
    $inuser['location'] = $_POST['location'];
    $inuser['interests']= $_POST['interests'];
    $inuser['sig'] =      soft_clr_value($_POST['signature']);
    $inuser['posts']    = intval($vars['numberofposts']);
    $inuser['timedif']  = (!empty($vars['timedif'])) ? $vars['timedif'] : 0;
    $inuser['status']   = $vars['membercode'];
    $inuser['avatar']   = $vars['avatar'];
    $inuser['upload'] = (isset($vars['doupload'])) ? true : false;

    $filetoopen = $exbb['home_path'].'data/allforums.php';
    $forums = get_file($filetoopen);

    foreach ($forums as $id=>$infa) {
       if ($infa['private']) {
          $namekey = 'allow'.$id;
          $tocheck = ( isset($vars[$namekey]) ) ? $vars[$namekey] : 'no';
          $inuser['private'][$id] = ($tocheck == 'yes') ? true : false;
       }
    }

    # Add to ban lists (if required)
    if ($laststatus == 'banned' && $inuser['status'] != 'banned') { unban($user_id); }

    if ($inuser['status'] == 'banned') {
        $filetoopen = $exbb['home_path'].'data/banlist.php';
        $banlist = get_file($filetoopen);
        if (!is_array($banlist)) $banlist = array();
        $banlist[$user_id]['m'] = $inuser['mail'];
        $banlist[$user_id]['ip'] = $inuser['ip'];
        save_file($filetoopen,$banlist);
        unset($banlist);
    }

    $filetoopen = $exbb['home_path'].'members/'.$user_id.'.php';
    save_file($filetoopen,$inuser);

    if ($newname) {
       $filetoopen = $exbb['home_path'].'data/users.php';
       $allusers = get_file($filetoopen);
       $allusers[$user_id]['n'] = preg_replace ($lang['search'], $lang['replace'], $inuser['name']);
       $allusers[$user_id]['m'] = $inuser['mail'];
       save_file($filetoopen,$allusers);
       unset($allusers);
    }

    if (!empty($password) || $newname) {
         $time = date("d-m-Y H:i:s",time());
		 $inuser['name'] = str_replace( '&#39;', "'" , $inuser['name'] );
		 $inuser['name'] = str_replace( '&quot;', "\"" , $inuser['name'] );
         include('./admin/email_newpass.tpl');
         sendmail($exbb['boardname'],$exbb['adminemail'],$email,$lang['Notify_by_email'],$inuser['mail']);
    }

    error($lang['Info'],$lang['Updated_ok'],'',0);
 }

  else {

         include($exbb['home_path'] . 'language/' . $exbb['default_lang'] . '/lang_reg.php');
         $privateoutput = '';
         $filetoopen = $exbb['home_path']."data/allforums.php";
         $forums = get_file($filetoopen);
         foreach ($forums as $id=>$infa) {
            if ($infa['private']) {
               $checked = $inuser['private'][$id] ? 'checked' : '';
               $privateoutput .= '<input type="checkbox" name="allow'.$id.'" value="yes" '.$checked.'>'.$infa['name'].'<br>';
            }
         }
         if (empty($privateoutput)) $privateoutput = $lang['No_private_forums'];
         $inuser['sig'] = str_replace('<br>',"\n",$inuser['sig']);
         $checked = ($inuser['upload']) ? 'checked' : '';
         $dataout = '<select name="membercode"><option value="me">'.$lang['User'].'<option value="banned">'.$lang['Banned_user'].'<option value="ad">'.$lang['Admin'].'</select>';
         $dataout = str_replace("value=\"$inuser[status]\"","value=\"$inuser[status]\" selected",$dataout);
         $title_page = $exbb['boardname'];
         include('./admin/all_header.tpl');
         include('./admin/edit_user.tpl');
         include('page_tail_admin.php');

    } # end else

} # endroute

function deletemember() {
global $exbb,$vars,$lang;

    $filetounlink = $exbb['home_path'].'members/'.$vars['userid'].'.php';

    if (@unlink($filetounlink)) {

      # Delete the database for the member
      $filetomake = $exbb['home_path'].'data/users.php';
      $users = get_file($filetomake);
      $usr = fopen($filetomake,'w');
	  lock_file($usr);
      unset($users[$vars['userid']]);
      save_opened_file($usr,$users);
      $exbb['totalmembers']--;
      save_statfile();
      error($lang['Info'],$lang['User_deleted'],'',0);
    } else { error($lang['Info'],$lang['User_notdeleted'],'',0); }

} # end routine

function unban($user) {
global $exbb;

 # Remove from ban lists
 $filetoopen = $exbb['home_path'].'data/banlist.php';
 $banlist = get_file($filetoopen);
 unset($banlist[$user]);
 save_file($filetoopen,$banlist);
 unset($filetoopen,$banlist);
}

function docount() {
global $exbb,$lang;

   $filedata = array();
   $dirtoopen = $exbb['home_path'].'members';
   @set_time_limit(60);
    
   if ( !($filedata = get_dir($dirtoopen,'*.php') ) ) {

	   $handle=opendir($dirtoopen);
	   while (false !== ($file = readdir($handle))) {
		   if (strstr($file,'.php')) $filedata[]=$file;
	   }
	   closedir($handle);
   }
   ###
   $users = array();
   foreach ($filedata as $user) {

	 $userinfo = getmember( substr($user,0,-4) );
     if ($userinfo) {
       $users[$userinfo['id']]['n'] = preg_replace ($lang['search'], $lang['replace'], $userinfo['name']);
       $users[$userinfo['id']]['m'] = $userinfo['mail'];
     }
     else { continue; }
   }
   save_file($exbb['home_path'].'data/users.php',$users);
   $total = count($users);
   unset($filedata,$userinfo,$users);
   $exbb['totalmembers'] = $total;
   save_statfile();

   error($lang['User_count_upd'],$lang['User_count'].$total,'',0);
}

function logfile() {
global $exbb,$lang,$vars;
  $filetoopen = $exbb['home_path'].'data/access_log.php';
  if (isset($vars['m'])) {
    $fp = fopen($filetoopen,'w');
	lock_file($fp);
    fwrite($fp,'<?die;?>'."\n");
    fclose($fp);
  }
  $log = file($filetoopen);
  unset($log[0]);
  $log = @array_reverse($log);
  $log = $exbb['log'] ? implode("",$log) : $lang['Forum_log_off'].implode("",$log);
  include('./admin/all_header.tpl');
  include('.//admin/logfile.tpl');
  include('page_tail_admin.php');

return;

}

function mass_mail() {
	global $exbb,$lang,$vars;

	$filetoopen = $exbb['home_path'].'data/users.php';

	if (isset($vars['mode'])) {

		$users = get_file($filetoopen);
		if (is_array($users) && sizeof($users) > 0) {
			$message = $lang['From_admin'].$exbb['boardname'].' ('.$exbb['boardurl'].")\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n".stripslashes(trim($_POST['message']));
			$bcc_list = array();
			foreach($users as $id=>$info) $bcc_list[$id] = 1;
			sendmail($exbb['boardname'],$exbb['adminemail'],$message,$vars['subject'],$bcc_list);
			unset($users,$bcc_list);
		} else {
			error($lang['Info'],$lang['Email_error'],'',0);
		}
		error($lang['Info'],$lang['Message_sent'],'',0);

     }
	 else {

		 $script = 'setmembers.php';
		 $title_page = $exbb['boardname'];
		 include('./admin/all_header.tpl');
		 include('./admin/mass_mail.tpl');
		 include('page_tail_admin.php');
	 }
}

?>