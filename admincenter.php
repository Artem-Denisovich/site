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

include('common.php');
include('./data/boardstats.php');
$vars = parsed_vars();

$action = $vars['action'];

if ( defined('IS_ADMIN') ) {

  if ( isset($vars['action']) && $vars['action'] == 'navbar' ) {

    $admin_menu = array();

	$admin_menu[0]['t'] = '';
	$admin_menu[0]['l1'] = '<a href="admincenter.php?action=main" target="main" class="genmed">'.$lang['Admin_Index'].'</a>';
	$admin_menu[0]['l2'] = '<a href="index.php" target="_parent" class="genmed">'.$lang['Forum_index'].'</a>';
	$admin_menu[1]['t'] = $lang['General'];
	
	
	$title_page = $exbb['boardname'];
    include('./admin/all_header.tpl');
    include('./admin/nav_bar.tpl');

  }
  elseif( isset($vars['action']) && $vars['action'] == 'main' ) {

    $filetoopen = $exbb['home_path'].'data/allforums.php';
    $files = get_file($filetoopen);

    $boarddays = ( time() - $exbb['boardstart'] ) / 86400;

    $posts_per_day = sprintf("%.2f", $exbb['totalposts'] / $boarddays);
    $topics_per_day = sprintf("%.2f", $exbb['totalthreads'] / $boarddays);
    $users_per_day = sprintf("%.2f", $exbb['totalmembers']  / $boarddays);
    if ($users_per_day > intval($exbb['totalmembers']) ) $users_per_day = $exbb['totalmembers'];
    $boardstart = date("d.m.Y - H:i",$exbb['boardstart']);
    $filetoopen = $exbb['home_path'].'data/onlinedata.php';
    $onlinedata = get_file($filetoopen);
    $onlinedata = count($onlinedata);
    $php_ver = phpversion();
    $gzip = ($exbb['gzip_compress']) ? $lang['On'] : $lang['Off'];

	// Unix-like server load averages
	$server_load = $lang['Server_loads_no'];
	if ( file_exists('/proc/loadavg') ) {
		if ( $fp = @fopen( '/proc/loadavg', 'r' ) ) {
			$data = @fread( $fp, 6 );
			@fclose($fp);

			$loaded = explode(" ", $data);
            $server_load = trim($load_avg[0]);
		}
	}
	else {
		$loaded = @exec('uptime');
		if (preg_match('/averages?: ([0-9\.]+),[\s]+([0-9\.]+),[\s]+([0-9\.]+)/i', $loaded, $srv_load)) {
			$server_load = $srv_load[1].' '.$srv_load[2].' '.$srv_load[3];
		}
	}
			
    $uploads = 0;

    if ($dir = opendir( $exbb['home_path'].'uploads' )) {
      while (false !== ($file = readdir($dir)))  {
             $uploads += @filesize( $exbb['home_path'].'uploads/' . $file );
      }
      closedir( $dir );
    }
    $uploads = round($uploads / 1024);
    $title_page = $exbb['boardname'];
    include('./admin/all_header.tpl');
    include('./admin/index_body.tpl');
  }
  else {
    include('./admin/index_frameset.tpl');
  }
} else { Header('Location: index.php'); exit;}
include('page_tail_admin.php');
?>