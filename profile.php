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

if (($exbb['reged']) and (!isset($vars['action']))) {$vars['action'] = 'modify';}
$action = $vars['action'];

include($exbb['home_path'] . 'language/' . $exbb['default_lang'] . '/lang_reg.php');

if ($action == 'show'){ showprofile(); }
elseif ($action == 'process'){savemodify(); }
elseif ($action == 'lostpassword' or $action == 'lostpass'){
  mt_srand ((double) microtime() * 1000000);
  $_SESSION['reg_code'] = mt_rand(100000,999999);
  $title_page = $exbb['boardname'].' :: '.$lang['User_info'];
  include('./templates/'.$exbb['default_style'].'all_header.tpl');
  include('./templates/'.$exbb['default_style'].'logos.tpl');
  include('./templates/'.$exbb['default_style'].'send_pass.tpl');
  include('./templates/'.$exbb['default_style'].'footer.tpl');

}
elseif ($action == 'sendpassword'){sendpassword();}
elseif ($action == 'modify'){modify(); }
else{ error($lang['Main_msg'],$lang['Auth_need'],'<meta http-equiv="refresh" content="3; url=loginout.php">'); }

include('page_tail.php');

function sendpassword() {
global $exbb,$lang,$vars;

  if (trim(intval($vars['reg_code']) ) != $_SESSION['reg_code']) error($lang['Registration'],$lang['Pers_error']);
  $membername = preg_replace ($lang['search'], $lang['replace'], $vars['membername']);
  $allusers = get_file($exbb['home_path'].'/data/users.php');
  $m_id = 0;
  foreach ($allusers as $id=>$info) {
    if ( $info['n'] == $membername ) { $m_id = $id; break; }
  }
  if (!checkuser($m_id)) error($lang['Pass_req'],$lang['User_unreg']);
  $infa = getmember($m_id);
  $lang['Message_text'] = $lang['You_pass_only']."\r\n";
  $time = date("d-m-Y H:i:s",time());
  include('./templates/'.$exbb['default_style'].'admin/email_newpass.tpl');
  sendmail($exbb['boardname'],$exbb['adminemail'],$email,$lang['Pass_onforum'].$exbb['boardname'],$inuser['mail']);
  unset($_SESSION['reg_code']);
  error($lang['Pass_req'],$lang['Pass_sended'],'<meta http-equiv="refresh" content="3; url=index.php "',0);

} # end routine.


function showprofile() {
global $exbb,$lang,$vars;
   $member = $vars['member'];
   whosonline($lang['Check_profile']);
 if ($inuser = getmember($member)) {
   if (!empty($inuser['title'])) { $membertitle = $inuser['title']; }
   else { switch ($inuser['status']) {
             case 'ad' : $membertitle = $lang['Admin']; break;
             case 'me' : $membertitle = $lang['User']; break;
             case 'banned' : $membertitle = $lang['User_banned']; break;
          }
   }
   $member = $inuser['name'];
   $numberofposts = $inuser['posts'];
   $interests = $inuser['interests'];
   $location = $inuser['location'];
   $email_forum = '<a href="tools.php?mid='.$inuser['id'].'">'.$lang['Forum_eml'].'</a>';
   $emailaddress .= ($inuser['showemail']) ? '-- <a href="mailto:'.$inuser['mail'].'">'.$inuser['mail'].'</a>': '';
   if ($inuser['icq'] == '') { $icqnumber = $lang['no']; $icqlogo = ''; } else { $icqnumber = $inuser['icq']; $icqlogo = "<img src=http://online.mirabilis.com/scripts/online.dll?icq=$inuser[icq]&img=5 align=abscenter width=18 height=18 border=0>"; }
   if ($inuser['status'] == 'banned') { $membertitle = $lang['User_banned']; }
   $homepage = ($inuser['www'] == 'http://' || $inuser['www'] == '') ? $lang['no'] : '<a href="'.$inuser['www'].'" target="_blank">'.$inuser['www'].'</a>';
   $avatar = ( file_exists($exbb['home_path'].'im/avatars/'.$inuser['avatar']) && $inuser['avatar'] != 'noavatar.gif' && !empty($inuser['avatar'])) ? '<img src="'.$exbb['boardurl'].'/im/avatars/'.$inuser['avatar'].'">' : $lang['no'];
   $pm = '<a href="messenger.php?action=new&touser='.$inuser['id'].'">'.$lang['Message'].'</a';
   $aim = ( $inuser['aim'] != '' ) ? '<a href="aim:goim?screenname=' . $inuser['aim'] . '&amp;message=Hello+Are+you+there?">' . $lang['aol'] . '</a>' : '&nbsp;';

   $joineddate = longdate($inuser['joined'] + $exbb['usertime']*3600);
   include ('./data/boardstats.php');

   $days_reged = max( 1, round( ( time() - $inuser['joined'] ) / 86400 ));
   $posts_per_day = $numberofposts / $days_reged;

   $percentage = ( $exbb['totalposts'] ) ? min(100, ($numberofposts / $exbb['totalposts']) * 100) : 0;

   $posts_per_day = sprintf($lang['posts_per_day'], $posts_per_day);
   $percentage = sprintf($lang['Proc_total'], $percentage);

            ## Sort last post, and where
   if (isset($inuser['lastpost'])) {
       $postdate = longdate($inuser['lastpost']['date'] + $exbb['usertime']*3600);
       $lastpostdetails = $lang['Last_post'].': <a href="'.$inuser['lastpost']['link'].'">'.wordwrap($inuser['lastpost']['name'], 32, ' &shy; ', 1).'</a> - '.$postdate;
   } else { $lastpostdetails = $lang['No_posts']; }
}
else {
   $member = $lang['Unreg'];
   $membertitle = 'Guest/Deleted';
   $numberofposts = 'N/A';
   $showemail = 'no';
   $lastpostdetails = 'N/A';
   $emailaddress = '';
   $email_forum = '';
   $pm = '';
}


if (is_array($inuser)) {

  $do_new = true;
  if (isset($inuser['posted'])) {
    $out = array();
    $filetoopen = $exbb['home_path'].'data/allforums.php';
    $forums = get_file($filetoopen);
    $countposts = 0;
    foreach($inuser['posted'] as $inforum=>$posts) $countposts += $posts;

    foreach($inuser['posted'] as $inforum=>$posts){
      $forumname = (!array_key_exists($inforum,$forums)) ? $lang['No_data'] : '<a href="forums.php?forum='.$inforum.'" class=nav>'.stripslashes($forums[$inforum]['name']).'</a>';

      $percent = $posts / $countposts * 100;
      $percent = sprintf( '%.2f' , $percent );

      $color = ($percent >= 10) ? 'row1' : 'row2';
      $out["$percent"] = <<<EOD
<tr class="normal" valign=middle align=center><td class="$color">$forumname</td><td class="$color"><span class=gen><b>$posts</b></<span></td><td class="$color"><span class=gen><b>$percent%</b></<span></td></tr>
EOD;
    }
    krsort($out,SORT_NUMERIC);
    $output = implode("",$out);
  }
}
  $title_page = $exbb['boardname'].' :: '.$lang['User_info'];
  include('./templates/'.$exbb['default_style'].'all_header.tpl');
  include('./templates/'.$exbb['default_style'].'logos.tpl');
  include('./templates/'.$exbb['default_style'].'profile_show.tpl');
  include('./templates/'.$exbb['default_style'].'footer.tpl');

} # end showprofile


function modify() {
global $exbb,$lang,$vars,$inuser;

    if (!$exbb['reged']) { error($lang['Profile_editing'],$lang['Auth_need']);}
    if (($exbb['passwordverification']) && ($exbb['emailfunctions'])) {
            $newpassneeded = $lang['Pass_changed'];
            $newpassneededa = $lang['Email_changed'];
    }
    $membername = $inuser['name'];
    $emailaddress = $inuser['mail'];
    $showemail = $inuser['showemail'];
    $homepage = $inuser['www'];
    $aolname = $inuser['aim'];
    $icqnumber = $inuser['icq'];
    $location = $inuser['location'];
    $interests = $inuser['interests'];
    $timedifference = isset($inuser['timedif']) ? $inuser['timedif'] : 0;
    $signature = $inuser['sig'];
    $useravatar = ( !empty($inuser['avatar']) ) ? $inuser['avatar'] : 'noavatar.gif';
    $currentface = $inuser['avatar'];

    ### Avatar stuff
    if ($exbb['avatars']) {

        $dirtoopen = $exbb['home_path'].'im/avatars';

		if ( !($images = get_dir($dirtoopen,'*.{gif,jpg,bmp,png,jpeg,pjpeg}',GLOB_BRACE)) ) {

			$images=array();

			$handle=opendir($dirtoopen);
			while (  false !== ($file = readdir($handle)) ) if (strstr($file,'.gif') || strstr($file,'.jpg')) $images[]=$file;
			closedir($handle);

		}

        foreach ($images as $file) {
            if ($file == $useravatar) {
                $selecthtml .= '<option value="'.$file.'" selected>'.$file."</option>\n";
                $currentface = $file;
            } else {
                $selecthtml .= '<option value="'.$file.'">'.$file."</option>\n"; }
        } //foreach
		$avatar_info = sprintf($lang['avatar_info'],$exbb['avatar_size'],$exbb['avatar_max_width'],$exbb['avatar_max_height']);
    }

  $temp_ar = array();

  $dirtoopen = $exbb['home_path'].'language';

  if ( !($temp_ar = get_dir($dirtoopen,'*',GLOB_ONLYDIR) ) ) {

	  $handle = opendir($dirtoopen);
	  while (($file = @readdir($handle))!==false) {
		  if (is_dir($exbb['home_path'].'language/'.$file) && $file != '.' && $file != '..') $temp_ar[] = $file;
	  }
	  closedir($handle);
  }

  $temp_def = $inuser['lang'];
  $langs_select = '<select name="default_lang">';
  foreach ( $temp_ar as $ln ) {
     $selected = ( $ln == $temp_def ) ? ' selected="selected"' : '';
     $langs_select .= '<option value="' . trim($ln) . '"' . $selected . '>' . ucfirst ($ln) . '</option>';
  }
  $langs_select .= '</select>';

  $temp_ar = array();

  $dirtoopen = $exbb['home_path'].'templates';

  if ( !($temp_ar = get_dir($dirtoopen,'*',GLOB_ONLYDIR) ) ) {
	  $handle = opendir($dirtoopen);
	  while (($file = @readdir($handle))!==false) {
		  if (is_dir($exbb['home_path'].'templates/'.$file) && $file != '.' && $file != '..') $temp_ar[] = $file;
	  }
  }
		  
  $temp_def = $inuser['skin'];
  $style_select = '<select name="default_style">';
  foreach ( $temp_ar as $ln ) {
     $selected = ( $ln == $temp_def) ? ' selected="selected"' : '';
     $style_select .= '<option value="' . trim($ln) . '"' . $selected . '>' . $ln . '</option>';
  }
  $style_select .= '</select>';

  unset($temp_ar,$temp_def,$ln,$selected,$file,$dirtoopen);

  include($exbb['home_path'] . 'language/'.$exbb['default_lang'].'/lang_tz.php');
  $timezones = '<select name="timedifference">';
  foreach ($tz as $shift=>$zona) {
    if ($shift == $timedifference) { $timezones .= '<option value="'.$shift.'" selected>'.$zona.'</option>'; }
    else { $timezones .= '<option value="'.$shift.'">'.$zona.'</option>'; }
  }
  $timezones .= '</select>';
  $showmyno = (!$inuser['showemail']) ? 'checked' : '';
  $showmyes = ($inuser['showemail']) ? 'checked' : '';
  $signature = str_replace('<br>',"\n",$signature);
  $interests = str_replace('<br>',"\n",$interests);
  $basetimes = date("H:i",time());
  $title_page = $exbb['boardname'].' :: '.$lang['Profile_editing'];
  $basetimes = longdate(time());
  include('./templates/'.$exbb['default_style'].'all_header.tpl');
  include('./templates/'.$exbb['default_style'].'logos.tpl');
  include('./templates/'.$exbb['default_style'].'profile.tpl');
  include('./templates/'.$exbb['default_style'].'footer.tpl');
} # end modify routine

function savemodify() {
global $exbb,$lang,$vars,$inuser;

    if ($vars['request_method'] != 'post') {error($lang['Main_msg'],$lang['Correct_post']);}
    $newpassword = $vars['newpassword'];
    $newemailaddress = $vars['newemailaddress'];
    $newshowemail = $vars['newshowemail'];
    $newhomepage = $vars['newhomepage'];
    $newaolname = $vars['newaolname'];
    $newicqnumber = $vars['newicqnumber'];
    $newlocation = $vars['newlocation'];
    $newinterests = $vars['newinterests'];
    $newsignature = ( defined('IS_ADMIN') ) ? soft_clr_value($_POST['newsignature']) : $vars['newsignature'];
    $useravatar = $vars['useravatar'];

    if (!$exbb['reged'] || !checkuser($exbb['mem_id'])) { error($lang['Profile_editing'],$lang['Auth_need']);}

    $newemailaddress = (!empty($newemailaddress)) ? trim(strip_tags($newemailaddress)) : '';
    $newemailaddress = strtolower($newemailaddress);
    $newhomepage = (!empty($newhomepage)) ? trim(strip_tags($newhomepage)) : '';
    $newaolname = (!empty($newaolname)) ? trim(strip_tags($newaolname)) : '';
    $newicqnumber = (!empty($newicqnumber)) ? trim(strip_tags($newicqnumber)) : '';
    $newlocation =  (!empty($newlocation)) ? trim(strip_tags($newlocation)) : '';
    $newinterests = (!empty($newinterests)) ? trim(strip_tags($newinterests)) : '';
    if (!preg_match("/^[0-9]+$/", $newicqnumber))  $newicqnumber = '';

	if ($exbb['avatar_upload']) {
		
		$exbb['uploadsize'] = $exbb['avatar_size'];
		$attach = attach_upload('',$inuser['avatar'],'avatar');

	}
	if ( !empty($attach['attach_file']) ) {
		$useravatar = $attach['attach_file'];
	}
	elseif ( isset($vars['noavatar']) ) { $useravatar = ''; }
	elseif ( empty($useravatar) ) $useravatar = $inuser['avatar'];

    if ($newsignature != '') {
         ####Check for bad words in signature

        if ($exbb['wordcensor'] && bads_filter($newsignature,0)) {
         error($lang['Profile_editing'],$lang['Profanity'],'',0);
        }
   }

   if (!defined('IS_ADMIN')) {
       $siglines = explode('<br>',$newsignature);
       if ((count($siglines) > $exbb['max_sig_lin']) || (strlen($vars['newsignature']) > $exbb['max_sig_chars'])) {
            error($lang['Profile_editing'],$lang['Sig_lines']);
       }
   }

   if (empty($newemailaddress)) {  error($lang['Profile_editing'],$lang['Check_fields']); }

   if (!vm($newemailaddress)) { error($lang['Profile_editing'],$lang['Wrong_email']); }

 if (empty($newpassword)) { $newpassword = $inuser['pass']; }
 elseif (strlen($newpassword) < 3) {error($lang['Profile_editing'],$lang['Pass_to_small'],'<meta http-equiv="refresh" content="3; url=profile.php"',0);}

 $filetoopen = $exbb['home_path'].'data/users.php';
 $allusers = get_file($filetoopen);
 if ($newemailaddress != $inuser['mail']) {
     foreach ($allusers as $id=>$info) if ($info['m'] == $newemailaddress) error($lang['Profile_editing'],$lang['Email_exist'],'',0);
 }

 if (($exbb['passwordverification']) && ($exbb['emailfunctions']) && ($newemailaddress != $inuser['mail'])) {
     $input = array ('A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','S','T','U','V','W','Y','Z','a','b','c','d','e','f','g','h','j','k','l',
                     'm','n','p','q','r','s','t','u','v','w','y','z','0','1','2','3','4','5','6','7','8','9');
     mt_srand((double) microtime() * 1000000);
     $newpassword = '';
     for ($i=1; $i<=6; $i++) {
         $rand_keys = mt_rand(0,count($input));
         $newpassword .= $input[$rand_keys];
     }
    $allu = fopen($filetoopen,'r+');
    $allusers[$exbb['mem_id']]['m'] = $newemailaddress;
    save_opened_file($allu,$allusers);
    unset($allusers);
    ### send the email

    $subject = $lang['Email_change'].' '.$exbb['boardname'];
    $message .= "\r\n";
    $message .= $exbb['boardurl'].'/index.php'."\n\n\r\n";
    $message .= $lang['New_pass']."\n\n\r\n";
    $message .= $lang['You_name_pass']."\n\r\n";
    $message .= '   '.$lang['Name'].'  '.$exbb['member']."\r\n";
    $message .= '   '.$lang['Password'].'  '.$newpassword."\n\n\r\n";
    $message .= $lang['Sensetives']."\n\r\n";
    sendmail($exbb['boardname'],$exbb['adminemail'],$message,$subject,$newemailaddress);
 } # end new password request
 $inuser['pass'] = $newpassword;
 $inuser['mail'] = $newemailaddress;
 $inuser['showemail'] = ($newshowemail == 'no') ? false : true;
 $inuser['www'] = $newhomepage;
 $inuser['aim'] = $newaolname;
 $inuser['icq'] = $newicqnumber;
 $inuser['location'] = $newlocation;
 $inuser['sig'] = $newsignature;
 $inuser['lang'] = $vars['default_lang'];
 $inuser['skin'] = $vars['default_style'];
 $inuser['timedif'] = (int) $vars['timedifference'];
 $inuser['avatar'] = $useravatar;
 $inuser['interests'] = $newinterests;

 $filetomake = $exbb['home_path'].'members/'.$exbb['mem_id'].'.php';
 save_file($filetomake,$inuser);

 if ($_SESSION['time'] != $vars['timedifference']) $_SESSION['time'] = intval($vars['timedifference']);

 my_setcookie('exbbn',$exbb['mem_id']);
 my_setcookie('exbbp',md5($newpassword));
 $relocurl = 'index.php';
 $title_page = $exbb['boardname'].' :: '.$lang['Profile_updated'];
 $ok_title = $lang['Profile_updated'];
 $url1 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
 $url2 = '<li><a href="profile.php">'.$lang['Profile_editing'].'</a>';
 $url3 = '<li><a href="profile.php?action=show&member='.$exbb['mem_id'].'">'.$lang['Check_profile'].'</a>';
 include('./templates/'.$exbb['default_style'].'all_header.tpl');
 include('./templates/'.$exbb['default_style'].'postok.tpl');
 include('./templates/'.$exbb['default_style'].'footer.tpl');
} # end save details.
?>