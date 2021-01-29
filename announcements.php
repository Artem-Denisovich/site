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

include($exbb['home_path'] . 'language/' . $exbb['default_lang'] . '/lang_news.php');

  if ($vars['action'] == 'delete') {

     if (!defined('IS_ADMIN')) {error($lang['Announ'],$lang['Not_admin']);}

     # Get the announcement to delete

     $filetoopen = $exbb['home_path'].'data/news.php';
     $announcements = get_file($filetoopen);

     unset($announcements[$vars['number']]);
     # Write it back minus the one to delete.
     save_file($filetoopen,$announcements);

     $relocurl = 'announcements.php';
     $title_page = $exbb['boardname'].' :: '.$lang['Ann_deleted'];
     $ok_title = $lang['Ann_deleted'];
     $url1 = '<b>'.$ok_title.'</b>';
     $url2 = '<li><a href="'.$relocurl.'">'.$lang['Ann_return'].'</a>';
     $url3 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
     include('./templates/'.$exbb['default_style'].'all_header.tpl');
     include('./templates/'.$exbb['default_style'].'postok.tpl');
     include('./templates/'.$exbb['default_style'].'footer.tpl');
     include('page_tail.php');
  } # end action
  elseif ($vars['action'] == 'delall') {

     if (!defined('IS_ADMIN')) {error($lang['Announ'],$lang['Not_admin']);}

     $filetoopen = $exbb['home_path'].'data/news.php';
     save_file($filetoopen,array());

     $relocurl = 'announcements.php';
     $title_page = $exbb['boardname'].' :: '.$lang['Ann_del_all'];
     $ok_title = $lang['Ann_del_all'];
     $url1 = '<b>'.$ok_title.'</b>';
     $url2 = '<li><a href="'.$relocurl.'">'.$lang['Ann_return'].'</a>';
     $url3 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
     include('./templates/'.$exbb['default_style'].'all_header.tpl');
     include('./templates/'.$exbb['default_style'].'postok.tpl');
     include('./templates/'.$exbb['default_style'].'footer.tpl');
     include('page_tail.php');
  } # end action
  elseif ($vars['action'] == 'add') {

     if (!defined('IS_ADMIN')) {error($lang['Announ'],$lang['Not_admin']);}
     $do = 'doadd';
     $codemap = '<br><script language="JavaScript">ibcodes();</script>';
     $smilesmap = '<br><script language="JavaScript">ibsmiles();</script>';
     $java = '<script language="Javascript" src="smilesmap.js"></script><script language="Javascript" src="codesmap.js"></script>';
     include('./templates/'.$exbb['default_style'].'news_add.tpl');

  } # end action

  elseif ($vars['action'] == 'doadd') {

     if (!defined('IS_ADMIN')) {error($lang['Announ'],$lang['Not_admin']);}
     $currenttime = time();

     # Check for blanks.

     if ($vars['inpost'] == '') { error($lang['Announ'],$lang['Ann_enter_need']);}
     if ($vars['title'] == '') { error($lang['Announ'],$lang['Ann_title_need']);}

     # Get the announcement file and block it

     $filetoopen = $exbb['home_path'].'data/news.php';
     if (file_exists($filetoopen)) {
       $announcements = get_file($filetoopen);
       $news = fopen($filetoopen,'r+');
     }
     else {
       $announcements = array();
       $news = fopen($filetoopen,'w');
     }
     #@flock($news,2);
	 lock_file($news);
     # Write it back with the new announcement at the top
     $announcements[$currenttime]['t'] = soft_clr_value($_POST['title']);
     $announcements[$currenttime]['p'] = soft_clr_value($_POST['inpost']);
     save_opened_file($news,$announcements);
	 @chmod($filetoopen,$exbb['ch_files']);
     $relocurl = 'announcements.php';
     $title_page = $exbb['boardname'].' :: '.$lang['Ann_added'];
     $ok_title = $lang['Ann_added'];
     $url1 = '<li><b>'.$ok_title.'</b>';
     $url2 = '<li><a href="'.$relocurl.'">'.$lang['Ann_return'].'</a>';
     $url3 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
     include('./templates/'.$exbb['default_style'].'all_header.tpl');
     include('./templates/'.$exbb['default_style'].'postok.tpl');
     include('./templates/'.$exbb['default_style'].'footer.tpl');
     include('page_tail.php');
  } # end add announcement

  elseif ($vars['action'] == 'edit') {

         if (!defined('IS_ADMIN')) {error($lang['Announ'],$lang['Not_admin']);}
         # Get the announcement file
         $hidden = '<input type=hidden name="number" value="'.$vars['number'].'">';
         $filetoopen = $exbb['home_path'].'data/news.php';
         $announcements = get_file($filetoopen);

         # Get the announcement to edit

         $title = $announcements[$vars['number']]['t'];
         $post = $announcements[$vars['number']]['p'];

         # Clean the text area

         $post = str_replace('<p>',"\n\n",$post);
         $post = str_replace('<br>',"\n",$post);
         $do = 'doedit';
         $codemap = '<br><script language="JavaScript">ibcodes();</script>';
         $smilesmap = '<br><script language="JavaScript">ibsmiles();</script>';
         $java = '<script language="Javascript" src="smilesmap.js"></script><script language="Javascript" src="codesmap.js"></script>';
         # Present the form
         include('./templates/'.$exbb['default_style'].'news_add.tpl');

  } # end action

  elseif ($vars['action'] == 'doedit') {

         if (!defined('IS_ADMIN')) {error($lang['Announ'],$lang['Not_admin']);}
         $currenttime = time();

         # Check for blanks.

         if ($vars['inpost'] == '') { error($lang['Announ'],$lang['Ann_enter_need']);}
         if ($vars['title'] == '') { error($lang['Announ'],$lang['Ann_title_need']);}

         # Get the announcement file

         $filetoopen = $exbb['home_path'].'data/news.php';
         $announcements = get_file($filetoopen);
         $news = fopen($filetoopen,'r+');
         #@flock($news,2);
		 lock_file($news);

         unset($announcements[$vars['number']]);
         # Write it back with the new announcement at the top

         $announcements[$currenttime]['t'] = soft_clr_value($_POST['title']);
         $announcements[$currenttime]['p'] = soft_clr_value($_POST['inpost']);

         save_opened_file($news,$announcements);
         $relocurl = 'announcements.php';
         $title_page = $exbb['boardname'].' :: '.$lang['Ann_edited'];
         $ok_title = $lang['Ann_edited'];
         $url1 = '<li><a href="'.$relocurl.'">'.$lang['Ann_return'].'</a>';;
         $url2 = '<li><a href="index.php">'.$lang['Forums_return'].'</a>';
         $url3 = null;
         include('./templates/'.$exbb['default_style'].'all_header.tpl');
         include('./templates/'.$exbb['default_style'].'postok.tpl');
         include('./templates/'.$exbb['default_style'].'footer.tpl');
         include('page_tail.php');

  } # end edit announcement

  else { # start last else

         ### start displaying the announcements.

         $filetoopen = $exbb['home_path'].'data/news.php';
         $news = get_file($filetoopen);
         $totals = (is_array($news)) ? count($news) : 0;

         if ($totals == 0) {
            $dateposted = time();
            $news[$dateposted]['t'] = $lang['Ann_no'];
            $news[$dateposted]['p'] = 'Нет новостей';
         }
         $adminadd = (defined('IS_ADMIN')) ?  ' :: <a href="announcements.php?action=delall">'.$lang['Ann_dellall'].'</a> :: <a href="announcements.php?action=add">'.$lang['Ann_add'].'</a>' : '';
         krsort($news);
         foreach ($news as $id=>$info) {
            $dateposted = longDate($id+$exbb['usertime']*3600);
            $title = $info['t'];
            $post = $info['p'];
            $post = ikoncode($post);
            $post = setsmiles($post);

            include('./templates/'.$exbb['default_style'].'news_data.tpl');
         } //foreach
  } // end last else

$title_page = $exbb['boardname'].' :: '.$lang['Announ'];
include('./templates/'.$exbb['default_style'].'all_header.tpl');
include('./templates/'.$exbb['default_style'].'logos.tpl');
include('./templates/'.$exbb['default_style'].'news_show.tpl');
include('./templates/'.$exbb['default_style'].'footer.tpl');
include('page_tail.php');
?>