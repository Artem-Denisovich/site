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

    $filetoopen = $exbb['home_path'].'data/onlinedata.php';
    $onlinedata = get_file($filetoopen);

# show IP
$style = './templates/'.$exbb['default_style'].'wonline_data.tpl';
$output = '';
if (defined('IS_ADMIN')) {
  foreach ($onlinedata as $ip=>$online) {
    $longdate = longDate($online['t'] + $exbb['usertime']*3600);
    $bot = isset($online['b']) ? ' '.$online['b'].' bot гуляет' : '';
	include($style);
  }
}
else {
  $ip = '';
  foreach ($onlinedata as $id=>$online) {
    $longdate = longDate($online['t'] + $exbb['usertime']*3600);
    $bot = isset($online['b']) ? $online['b'].' bot гуляет' : '';
	include($style);
  }

}
$title_page = $exbb['boardname'].' :: '.$lang['Whosonline'];
include('./templates/'.$exbb['default_style'].'all_header.tpl');
include('./templates/'.$exbb['default_style'].'logos.tpl');
include('./templates/'.$exbb['default_style'].'whoisonline.tpl');
include('./templates/'.$exbb['default_style'].'footer.tpl');
include('page_tail.php');
?>