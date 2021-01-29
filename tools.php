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

define('ATTACH',true);
include('common.php');

$vars = parsed_vars();

switch ($vars['action']) {
   case 'smiles'   : showsmiles(); break;
   case 'attach'   : attachment(); break;
   default: massmail(); break;
}

function massmail() {
global $exbb,$vars,$lang;

  include('./language/' . $exbb['default_lang'] . '/lang_admin.php');
  if (!$exbb['reged']) error($lang['Info'],$lang['Guest_mail'],'',0);
  $filetoopen = $exbb['home_path'].'data/users.php';
  if (isset($vars['mode'])) {

     $users = get_file($filetoopen);
     if (isset($vars['mid'])) {
        if ( array_key_exists($vars['mid'],$users) ) {
          if (!defined('IS_ADMIN') ) {
            $lastpost = $_SESSION['lastposttime'] + $exbb['flood_limit'];
            if ( $lastpost > time() ) error($lang['Email_error'],$lang['Flood_limit'].$exbb['flood_limit'].$lang['Flood_mail']);
	        $_SESSION['lastposttime'] = time();
          }
          $member = getmember($vars['mid']);
          $message = $lang['Hello'].', '.$member['name']."\n".$exbb['member'].$lang['Email_from'].$exbb['boardname'].' ('.$exbb['boardurl'].")\n\n";
          $message .= stripslashes(trim($_POST['message']));
          sendmail($exbb['member'],$users[$exbb['mem_id']]['m'],$message,$vars['subject'],$users[$vars['mid']]['m']);
        } else {
           error($lang['Info'],$lang['Email_error'],'',0);
        }
        error($lang['Info'],$lang['Message_sent'],'',0);
     }
     error($lang['Info'],$lang['Message_sent'],'',0);

  }
  else {

    $title_page = $exbb['boardname'];
    include('./templates/'.$exbb['default_style'].'all_header.tpl');

    if (isset($vars['mid'])) {
      $member = getmember($vars['mid']);
      $add = '<tr class="catname" valign=middle align=center><td colspan="2" class="row1"><b>'.$lang['Email_to'].$member['name'].'</b></td></tr>';
      $hidden = '<input type=hidden name="mid" value="'.$vars['mid'].'">';
      include('./templates/'.$exbb['default_style'].'logos.tpl');
    }
	$script = 'tools.php';
    include('./templates/'.$exbb['default_style'].'admin/mass_mail.tpl');
    include('./templates/'.$exbb['default_style'].'footer.tpl');
    include('page_tail.php');
  }
}

function showsmiles() {
global $exbb,$vars,$lang;
   $filetoopen = $exbb['home_path'].'data/smiles.php';
   if (file_exists($filetoopen)) {$smiles_list = get_file($filetoopen); uasort($smiles_list,'sort_by_id');} else {$smiles_list = array();}
   if (count($smiles_list)) {
     foreach ($smiles_list as $code=>$data) include('./templates/'.$exbb['default_style'].'smiles_data.tpl');
   }
   else {$datashow = '<tr><td colspan="3" align="center">No</td></tr>';}

   $title_page = ':-)';
   include('./templates/'.$exbb['default_style'].'all_header.tpl');
   include('./templates/'.$exbb['default_style'].'smiles_show.tpl');
   include('./templates/'.$exbb['default_style'].'footer.tpl');
   include('page_tail.php');

return;

}

function sort_by_id($a, $b) {
    if ($a['id'] == $b['id']) return 0;
    return ($a['id'] < $b['id']) ? -1 : 1;
}

function attachment() {
global $exbb,$vars,$lang;

if ($vars['f'] == '' || $vars['t'] == '' || $vars['id'] == '') error($lang['Main_msg'],$lang['Dont_chg_url'],'',1);

$filetoopen = $exbb['home_path'].'forum'.$vars['f'].'/attaches-'.$vars['t'].'.php';
$t_attaches = ( file_exists($filetoopen) ) ? get_file($filetoopen) : array();
$id = $vars['id'];
if (count($t_attaches)) {
     $filename =  $exbb['home_path'].'uploads/'.$t_attaches[$id]['id'];
     if ( file_exists($filename) ) {
       $t_attaches[$id]['hits']++;
       save_file($filetoopen,$t_attaches);
       $extension = strtolower(substr(strrchr($t_attaches[$id]['file'],'.'),1));
       switch ($extension) {
         case 'gif' : $type = 'image/gif'; break;
         case 'jpg' :
         case 'jpeg' : $type = 'image/pjpeg'; break;
         case 'pdf' : $type = 'application/pdf'; break;
         case 'zip' : $type = 'application/zip'; break;
         case 'pdf' : $type = 'application/pdf'; break;
         default :  $type = 'unknown/unknown'; break;
       }

       @header( "Content-Type: $type\"\nContent-Disposition: inline; filename=\"".$t_attaches[$id]['file']."\"\nContent-Length: ".(string)(filesize( $filename ) ) );

       $fp = fopen( $filename, 'rb' );
       fpassthru( $fp );
       @fclose( $fp );
       exit;
     } else {
       error($lang['Main_msg'],$lang['attach_nofile'],'',1);
     }
} else { error($lang['Main_msg'],$lang['attach_error'],'',1); }

return;

}
?>