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

define("IN_ADMIN", true);
include('common.php');
$vars = parsed_vars();

if ( defined('IS_ADMIN') ) {

     if ($vars['action'] == 'process' && defined('IS_ADMIN')) {

        $vars['wordarray'] = str_replace('<br>',"\n",$vars['wordarray']);
        $filetomake = $home_path.'data/badwords.php';
        $fp = fopen($filetomake,'w');
		lock_file($fp);
        fwrite($fp,"<? die; ?>\n".$vars['wordarray']);
        fclose($fp);

        if (file_exists($filetomake)) {
                error($lang['Info'],$lang['Badfilter_ok'],'',false);
        }
        else {
                error($lang['Info'],$lang['Badfilter_fail'],'',false);
             }
     } //process

     else {
        # Open the badword file
        $filetoopen = $home_path.'data/badwords.php';
        if (file_exists($filetoopen)) {
          $badwords = file($filetoopen);
          for ($i=1; $i<=count($badwords)-1; $i++) { $bads .= trim($badwords[$i])."\n";}
        }
        else {$bads = "damn=d*amn\nhell=h*ll";}

        $title_page = $lang['Administrating'];
        include('./admin/all_header.tpl');
        include('./admin/badword.tpl');

     }
}
else {
      Header('Location: index.php'); exit;
     }

include('page_tail_admin.php');
?>