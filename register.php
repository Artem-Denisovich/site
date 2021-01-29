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

include($exbb['home_path'] . 'language/' . $exbb['default_lang'] . '/lang_reg.php');

if (!$exbb['reg_on']) error($lang['Registration'],$lang['Reg_dinied'],'',false);

if ($vars['action'] == 'addmember') {

   if ($vars['request_method'] != 'post') {error($lang['Main_msg'],$lang['Correct_post']);}

if ($exbb['anti_bot']) {
if (trim( intval($vars['reg_code']) ) != $_SESSION['reg_code']) error($lang['Registration'],$lang['Pers_error']);
}
   $emailaddress = $vars['emailaddress'];
   $homepage = $vars['homepage'];
   $aolname = $vars['aolname'];
   $icqnumber = $vars['icqnumber'];
   $location = $vars['location'];
   $interests = $vars['interests'];
   $signature = $vars['signature'];
   $useravatar = $vars['useravatar'];
   $inmembername = str_replace( "'" , '&#39;', $vars['inmembername'] );
   $ipaddress = $vars['IP_ADDRESS'];


   $emailaddress = (!empty($emailaddress)) ? strtolower($emailaddress) : '';
   $homepage = (!empty($homepage) || $homepage != 'http://') ? trim(strip_tags($homepage)) : '';
   $aolname = (!empty($aolname)) ? trim(strip_tags($aolname)) : '';
   $icqnumber = (!empty($icqnumber)) ? trim(strip_tags($icqnumber)) : '';
   $location =  (!empty($location)) ? trim(strip_tags($location)) : '';
   $interests = (!empty($interests)) ? trim(strip_tags($interests)) : '';
   $inmembername = (!empty($inmembername)) ? trim(strip_tags(str_replace("&nbsp;", " ", $inmembername))) : '';
   $inmembername = preg_replace( "/\s{2,}/", " ", $inmembername );

   $bannedmembers = get_file($exbb['home_path'].'data/banlist.php');
   $bannedmember = 0;
   if (is_array($bannedmembers)) {
   foreach($bannedmembers as $name=>$infa){
       if ($emailaddress == $infa['em']) { $bannedmember = 1; break;}
       if ($inmembername == $name) { $bannedmember = 1; break;}
       if ($ipaddress == $infa['ip']) { $bannedmember = 1; break;}
   }
   }
   unset($bannedmembers);

   if ($bannedmember) {
          error($lang['Registration'],$lang['Registr_denied']);
   }

   if (!empty($signature)) {
         $signature = trim($signature);
         $signature = str_replace('<p>','<br>',$signature);
   }

  validate_items($icqnumber, $aolname, $homepage, $location, $interests, $signature);

  if (!$exbb['passwordverification']) {$password = $vars['password'];}
  else {$password = password();}

  $siglines = explode('<br>',$signature);
  if ((count($siglines) > $exbb['max_sig_lin']) || (strlen($_POST['signature']) > $exbb['max_sig_chars'])) error($lang['Registration'],$lang['Sig_lines']);

  $inmembername = ltrim(trim($inmembername));
  $name = preg_replace ($lang['search'], $lang['replace'], $inmembername);

  $blankfields = 0;

  if ($name == 'guest' || $name == preg_replace ($lang['search'], $lang['replace'], $lang['Unreg']) ) error($lang['Registration'],$inmembername.$lang['Name_exist']);
  if( empty($inmembername) || empty($password) || empty($emailaddress) ) $blankfields = 1;

  if ($blankfields) error($lang['Registration'],$lang['Check_fields']);

  ######check for bad words

  if ($exbb['wordcensor']) {
     if (bads_filter($inmembername,0) || bads_filter($signature,0)) {
         error($lang['Registration'],$lang['No_profanity'],'',0);
     }
  }

  if (empty($exbb['ru_nicks']) && ereg("[à-ÿ|À-ß]{1,}",$inmembername)) {error($lang['Registration'],$lang['Name_wrong_sim'],'',0);}
  if ((ereg("[à-ÿ|À-ß]{1,}",$inmembername)) and (ereg("[a-z|A-Z]{1,}",$inmembername))) {error($lang['Registration'],$lang['int_name'],'',0);}
  if (ereg("([ ]{2,})|([<|>]{1,}|([|]{1,})|([[|]]{1,})|([\/|\\]{1,})|([*|?]{1,})|([\|]{1,}))",$inmembername)) error($lang['Registration'],$lang['Name_wrong_sim'],'',0);

  $emailaddress = vm($emailaddress);

  if ( !$emailaddress ) error($lang['Registration'],$lang['Wrong_email']);

  $filetoopen = $exbb['home_path'].'data/users.php';

  include ('./data/boardstats.php');

  if (file_exists($filetoopen)) {

    $allusers = get_file($filetoopen);
    foreach ($allusers as $u_id=>$info) {
      if ($info['n'] == $name) error($lang['Registration'],$inmembername.$lang['Name_exist']);
      if ($info['m'] == $emailaddress) error($lang['Registration'],$lang['Email_exist'],'',false);
    }

    $ids = array();
    $ids = array_keys($allusers);
    $id = max($ids) + 1;

    while (isset($allusers[$id])) $id++;
    unset($ids);

  } else {$allusers = array(); $id = 2;}

  if ( intval($exbb['last_id']) == $id ) $id++;

  $usr = fopen($filetoopen,'w');
  lock_file($usr);
  $allusers[$id]['n'] = $name;
  $allusers[$id]['m'] = $emailaddress;
  save_opened_file($usr,$allusers);
  unset($allusers);

  $user = array();

  $user['status'] = 'me';
  $user['title'] = '';
  $user['posts'] = 0;
  $user['joined'] = time();

  $user['ip'] = $vars['IP_ADDRESS'];
  $user['name'] = $inmembername;
  $user['id'] = $id;
  $user['pass'] = $password;
  #$user['gender'] = 'Male';
  $user['mail'] = $emailaddress;
  $user['showemail'] = ($vars['showemail'] == 'yes') ? true : false;
  if (!empty($homepage)) $user['www'] = $homepage;
  $user['aim'] = $aolname;
  $user['icq'] = $icqnumber;
  $user['location'] = $location;
  $user['interests'] = $interests;
  $user['sig'] = $signature;
  $user['lang'] = $vars['default_lang'];
  $user['skin'] = $vars['default_style'];
  $user['timedif'] = $vars['timedifference'];
  $user['avatar'] = $useravatar;
  $user['upload'] = ($exbb['autoup']) ? true : false;

  $filetomake = $exbb['home_path'].'members/'.$id.'.php';
  save_file($filetomake,$user);
  @chmod($filetomake,$exbb['ch_files']);

  if ( !$exbb['passwordverification'] || !$exbb['emailfunctions'] ) {
	  $_SESSION['mid'] = $id;
	  $_SESSION['sts'] = 'me';
	  $_SESSION['time'] = intval($vars['timedifference']);
	  $_SESSION['iden'] = md5($user['name'].$user['pass']);
	  unset($_SESSION['reg_code']);

	  my_setcookie('exbbn',$id);
	  my_setcookie('exbbp',md5($inpassword));
  }

  $exbb['mem_id'] = $id;
  ### update statistic

  $exbb['totalmembers']++;
  $exbb['lastreg'] = $inmembername;
  $exbb['last_id'] = $id;
  save_statfile();

  if ($exbb['emailfunctions']) {
     $subject = $lang['Reg_thanks'].$exbb['boardname'];
     include('./templates/'.$exbb['default_style'].'email_newreg.tpl');
     sendmail($exbb['boardname'],$exbb['adminemail'],$email,$subject,$emailaddress);

     if ($exbb['newusernotify']) {
        $subject = $lang['New_reged'];
        include('./templates/'.$exbb['default_style'].'email_adminreg.tpl');
        sendmail($exbb['boardname'],$exbb['adminemail'],$email,$subject,$exbb['adminemail']);
     }
  }


  if (($exbb['passwordverification']) && ($exbb['emailfunctions'])) {
           $url1 = '<li><b>'.$lang['Pass_sended'].'</b>';
  } else { $url1 = '<li><a href="profile.php">'.$lang['To_chg_pass'].'</a>'; }
  $relocurl = 'index.php';
  $title_page = $exbb['boardname'].' :: '.$lang['Reg_thanks'];
  $ok_title = $lang['Reg_thanks'];
  $url2 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
  $url3 = '<li><a href="profile.php">'.$lang['Profile_editing'].'</a>';
  include('./templates/'.$exbb['default_style'].'all_header.tpl');
  include('./templates/'.$exbb['default_style'].'postok.tpl');
  include('./templates/'.$exbb['default_style'].'footer.tpl');
  include('page_tail.php');

}

elseif ($vars['action'] == 'agreed') {

  if ($vars['request_method'] != 'post') {error($lang['Main_msg'],$lang['Correct_post']);}
  if ($exbb['anti_bot']) {
    mt_srand ((double) microtime() * 1000000);
    $_SESSION['reg_code'] = mt_rand(100000,999999);
  }

  $requirepass = ( $exbb['passwordverification'] && $exbb['emailfunctions'] ) ? true : false;

  $intern = ($exbb['ru_nicks']) ? '<br>'.$lang['ru_yes'] : '<br>'.$lang['ru_no'];

  if (!$exbb['reg_simple']) {  //simple reg form

    if ($exbb['avatars']) {

        $dirtoopen = $exbb['home_path'].'im/avatars';

		if ( !($images = get_dir($dirtoopen,'*.{gif,jpg,bmp,png,jpeg,pjpeg}',GLOB_BRACE)) ) {

			$images=array();

			$handle=opendir($dirtoopen);
			while (  false !== ($file = readdir($handle)) ) if (strstr($file,'.gif') || strstr($file,'.jpg')) $images[]=$file;
			closedir($handle);

		}

        foreach ($images as $file) {
            if ($file == 'noavatar.gif') {
                $selecthtml .= '<option value="'.$file.'" selected>'.$file."</option>\n";
                $currentface = $file;
            } else {
                $selecthtml .= '<option value="'.$file.'">'.$file."</option>\n"; }
        } //foreach
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

  $temp_def = $exbb['default_lang'];
  $langs_select = '<select name="default_lang">';
  foreach ( $temp_ar as $ln ) {
     $selected = ( $ln == $temp_def ) ? ' selected="selected"' : '';
     $langs_select .= '<option value="' . trim($ln) . '"' . $selected . '>' . ucfirst ($ln) . '</option>';
  }
  $langs_select .= '</select>';

  $temp_ar = array();

  $dirtoopen = $exbb['home_path'].'templates';
  $handle = opendir($dirtoopen);
  while (($file = @readdir($handle))!==false) {
     if (is_dir($exbb['home_path'].'templates/'.$file) && $file != '.' && $file != '..') $temp_ar[] = $file;
  }


  $temp_def = substr($exbb['default_style'],0,-1);
  $style_select = '<select name="default_style">';
  foreach ( $temp_ar as $ln ) {
     $selected = ( $ln == $temp_def) ? ' selected="selected"' : '';
     $style_select .= '<option value="' . trim($ln) . '"' . $selected . '>' . $ln . '</option>';
  }
  $style_select .= '</select>';

  unset($temp_ar,$temp_def,$ln,$selected,$file,$dirtoopen);


  include($exbb['home_path'] .'language/'.$exbb['default_lang'].'/lang_tz.php');
  $timedifference = '0';
  $timezones = '<select name="timedifference">';
  foreach ($tz as $shift=>$zona) {
    if ($shift == $timedifference) { $timezones .= '<option value="'.$shift.'" selected>'.$zona.'</option>'; }
    else { $timezones .= '<option value="'.$shift.'">'.$zona.'</option>'; }
  }
  $timezones .= '</select>';

  $basetimes = longdate(time());

  } //simple reg form
} #end agree

else {
      $vars['action'] = 'agreement';
}


$title_page = $exbb['boardname'].' :: '.$lang['Registration'];

include('./templates/'.$exbb['default_style'].'all_header.tpl');
include('./templates/'.$exbb['default_style'].'logos.tpl');
@include('./templates/'.$exbb['default_style'].$vars['action'].'.tpl');
include('./templates/'.$exbb['default_style'].'footer.tpl');

include('page_tail.php');

function password() {
$input = array ('A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','S','T','U','V','W','Y','Z','a','b','c','d','e','f','g','h','j','k','l',
                'm','n','p','q','r','s','t','u','v','w','y','z','0','1','2','3','4','5','6','7','8','9');
          $password = '';
          $count = count($input) - 1;
          mt_srand((double) microtime() * 1000000);
          for ($i=1; $i<8; $i++) {
             $password .= $input[mt_rand(0,$count)];
          }
          return($password);
}

function validate_items(&$icqnumber, &$aolname, &$homepage, &$location, &$interests, &$signature) {

        if (!preg_match("/^[0-9]+$/", $icqnumber)) $icqnumber = '';

        if (strlen($aolname) < 2) $aolname = '';

        if ($homepage != '') {
           if ( !preg_match("#^http:\/\/#i", $homepage) ) $homepage = "http://" . $homepage;
           if ( !preg_match("#^http\\:\\/\\/[a-z0-9\-]+\.([a-z0-9\-]+\.)?[a-z]+#i", $homepage) ) $homepage = '';
        }

        if (strlen($location) < 2) $location = '';

        if (strlen($interests) < 2) $interests = '';

        if (strlen($signature) < 2) $sig = '';

        return;
}

?>