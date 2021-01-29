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
define('NO_GZIP', true);

include ('./data/boardinfo.php');

$new_exbb = array();
$new_exbb = $exbb;

include('common.php');

$vars = parsed_vars();

if ( defined('IS_ADMIN') ) {

  if (isset($vars['save'])) {
     save_info();
  }
  else {
     $ch_files = '0'.base_convert($new_exbb['ch_files'], 10, 8);
     $ch_dirs = '0'.base_convert($new_exbb['ch_dirs'], 10, 8);
  }

  $title_page = $lang['Administrating'];

   if ($vars['action'] == 'secure') {

        $bot_yes = ( $new_exbb['anti_bot'] ) ? 'checked="checked"' : '';
        $bot_no = ( !$new_exbb['anti_bot'] ) ? 'checked="checked"' : '';

        $passverif_yes = ( !$new_exbb['passwordverification'] ) ? 'checked="checked"' : '';
        $passverif_no = ( $new_exbb['passwordverification'] ) ? 'checked="checked"' : '';

        $newuser_yes = ( $new_exbb['newusernotify']  ) ? 'checked="checked"' : '';
        $newuser_no = ( !$new_exbb['newusernotify']  ) ? 'checked="checked"' : '';

        $img_yes = ( $new_exbb['show_img']  ) ? 'checked="checked"' : '';
        $img_no = ( !$new_exbb['show_img']  ) ? 'checked="checked"' : '';

		$reg_on = ( $new_exbb['reg_on'] ) ? 'checked="checked"' : '';
        $reg_off = ( !$new_exbb['reg_on'] ) ? 'checked="checked"' : '';

        include('./admin/all_header.tpl');
        include('./admin/board_secure.tpl');

   }
   elseif ($vars['action'] == 'posts') {

        $loc_yes = ( $new_exbb['location'] ) ? 'checked="checked"' : '';
        $loc_no = ( !$new_exbb['location'] ) ? 'checked="checked"' : '';

        $mpost_yes = ( $new_exbb['mail_posts'] ) ? 'checked="checked"' : '';
        $mpost_no = ( !$new_exbb['mail_posts'] ) ? 'checked="checked"' : '';

        include('./admin/all_header.tpl');
        include('./admin/board_posts.tpl');

   }
   elseif ($vars['action'] == 'main') {

        if (!isset($new_exbb['home_path'])) {$new_exbb['home_path'] = $_SERVER['PATH_TRANSLATED'].'/';}

        $board_disable_yes = ( $new_exbb['board_closed'] ) ? 'checked="checked"' : '';
        $board_disable_no = ( !$new_exbb['board_closed'] ) ? 'checked="checked"' : '';

        $ru_nicks_yes = ( $new_exbb['ru_nicks'] ) ? 'checked="checked"' : '';
        $ru_nicks_no = ( !$new_exbb['ru_nicks'] ) ? 'checked="checked"' : '';

        $temp_ar = array();

        $dirtoopen = $exbb['home_path'].'language';
        $handle = opendir($dirtoopen);
        while (($file = @readdir($handle))!==false) {
          if (is_dir($exbb['home_path'].'language/'.$file) && $file != '.' && $file != '..') $temp_ar[] = $file;
        }
        closedir($handle);

        $temp_def = $new_exbb['default_lang'];
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

        $temp_def = strtolower($new_exbb['default_style']);
        $style_select = '<select name="default_style">';
        foreach ( $temp_ar as $ln ) {
            $selected = ( strtolower($ln) == $temp_def) ? ' selected="selected"' : '';
            $style_select .= '<option value="' . trim($ln) . '"' . $selected . '>' . $ln . '</option>';
        }
        $style_select .= '</select>';

        unset($temp_ar,$temp_def,$ln,$selected,$file,$dirtoopen);

        $reg_smpl_yes = ( $new_exbb['reg_simple'] ) ? 'checked="checked"' : '';
        $reg_smpl_no = ( !$new_exbb['reg_simple'] ) ? 'checked="checked"' : '';

        $news_yes = ( $new_exbb['announcements'] ) ? 'checked="checked"' : '';
        $news_no = ( !$new_exbb['announcements'] ) ? 'checked="checked"' : '';

        $gzip_yes = ( $new_exbb['gzip_compress'] ) ? 'checked="checked"' : '';
        $gzip_no = ( !$new_exbb['gzip_compress'] ) ? 'checked="checked"' : '';

		$log_yes = ( $new_exbb['log'] ) ? 'checked="checked"' : '';
        $log_no = ( !$new_exbb['log'] ) ? 'checked="checked"' : '';

        $pm_yes = ( $new_exbb['pm'] ) ? 'checked="checked"' : '';
        $pm_no = ( !$new_exbb['pm'] ) ? 'checked="checked"' : '';

        $txtmenu_yes = ( $new_exbb['text_menu'] ) ? 'checked="checked"' : '';
        $txtmenu_no = ( !$new_exbb['text_menu'] ) ? 'checked="checked"' : '';

        $exbbcodes_yes = ( $new_exbb['exbbcodes'] ) ? 'checked="checked"' : '';
        $exbbcodes_no = ( !$new_exbb['exbbcodes'] ) ? 'checked="checked"' : '';

        $emoticons_yes = ( $new_exbb['emoticons'] ) ? 'checked="checked"' : '';
        $emoticons_no = ( !$new_exbb['emoticons'] ) ? 'checked="checked"' : '';

        $ratings_yes = ( $new_exbb['ratings'] ) ? 'checked="checked"' : '';
        $ratings_no = ( !$new_exbb['ratings'] ) ? 'checked="checked"' : '';

        $censoring_yes = ( $new_exbb['wordcensor'] ) ? 'checked="checked"' : '';
        $censoring_no = ( !$new_exbb['wordcensor'] ) ? 'checked="checked"' : '';

		$file_upload_yes = ( $new_exbb['file_upload'] ) ? 'checked="checked"' : '';
        $file_upload_no = ( !$new_exbb['file_upload'] ) ? 'checked="checked"' : '';

        $autoup_yes = ( $new_exbb['autoup'] ) ? 'checked="checked"' : '';
        $autoup_no = ( !$new_exbb['autoup'] ) ? 'checked="checked"' : '';

        $sig_yes = ( $new_exbb['sig'] ) ? 'checked="checked"' : '';
        $sig_no = ( !$new_exbb['sig'] ) ? 'checked="checked"' : '';

        $avatars_yes = ( $new_exbb['avatars'] ) ? 'checked="checked"' : '';
        $avatars_no = ( !$new_exbb['avatars'] ) ? 'checked="checked"' : '';

        $avatars_up_yes = ( $new_exbb['avatar_upload'] ) ? 'checked="checked"' : '';
        $avatars_up_no = ( !$new_exbb['avatar_upload'] ) ? 'checked="checked"' : '';

        $emails_yes = ( $new_exbb['emailfunctions'] ) ? 'checked="checked"' : '';
        $emails_no = ( !$new_exbb['emailfunctions'] ) ? 'checked="checked"' : '';
        $new_exbb['board_closed_mes'] = str_replace('<br>',"\n",$new_exbb['board_closed_mes']);

        include('./admin/all_header.tpl');
        include('./admin/board_config.tpl');
  }

}
else { Header('Location: index.php'); exit; }

include('page_tail_admin.php');

function save_info(){
global $new_exbb,$lang,$vars;

	$search = array ("'\''","'\"'");
	$replace = array ("&#039;", "&quot;");
   
   foreach ($vars as $k=>$v) $new_exbb[$k] = (!empty($v)) ? $v : 0;
   $new_exbb['flood_limit'] = (!empty($new_exbb['flood_limit'])) ? $new_exbb['flood_limit'] : '0';
   
   $new_exbb['board_closed_mes'] = (!empty($new_exbb['board_closed_mes'])) ? preg_replace ($search, $replace, $new_exbb['board_closed_mes']) : '';
   $new_exbb['boarddesc'] = (!empty($new_exbb['boarddesc'])) ? preg_replace ($search, $replace, $new_exbb['boarddesc']) : '';
   $new_exbb['boardname'] = (!empty($new_exbb['boardname'])) ? preg_replace ($search, $replace, $new_exbb['boardname']) : '';
   
   #if ( !isset($new_exbb['avatar_upload']) ) $new_exbb['avatar_upload'] = 0;
   $board_config = '';
   $new_exbb['ch_files'] = !empty($new_exbb['ch_files']) ? strval($new_exbb['ch_files']) : '0777';
   $new_exbb['ch_dirs'] = !empty($new_exbb['ch_dirs']) ? strval($new_exbb['ch_dirs']) : '0777';
   clearstatcache();
   include('./data/board_info.tpl');
   $filetomake = $new_exbb['home_path'].'data/boardinfo.php';
   @chmod($filetomake,0777);
   if (!empty($board_config) && is_writable($filetomake) ) {
      $backup = $new_exbb['home_path'].'data/boardinfo_bak.php';
      @copy($filetomake,$backup);
	  @chmod($backup,0777);
      $fp = fopen($filetomake,'w');
	  lock_file($fp);
      fwrite($fp,$board_config);
      fclose($fp);
	  @chmod($filetomake,0777);
      error($lang['Info'],$lang['Boardinfo_ok'],'',0);
   }
   else { error($lang['Info'],$lang['Boardinfo_fail'],'',0); }
}

?>