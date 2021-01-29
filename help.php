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

$helpid = (isset($vars['id'])) ? $vars['id'] : '';

include('./language/' . $exbb['default_lang'] . '/' . 'lang_help.php');

$count = (is_array($help)) ? count($help) : 0;

if ( !empty($helpid) ) {
	if ( !isset($help[$helpid]) ) error($lang['Main_msg'],$lang['Correct_post']);
    $helptitle = $help[$helpid]['help'];
    $helpid = intval($helpid);
    $text = $help[$helpid]['text'];
    include('./templates/'.$exbb['default_style'].'help_show.tpl');
}
elseif ($count) {
    $helptitle = $lang['Help_topic'];
    foreach ($help as $id=>$info) {
       $topic = $info['help'];
       $desc = $info['desc'];
       include('./templates/'.$exbb['default_style'].'help_data.tpl');
       $color = ( !($id % 2) ) ? 'row1' : 'row2';
    }
}
else {
    $topic = $lang['No_help'];
    $text = $lang['No_help_help'];
    include('./templates/'.$exbb['default_style'].'help_show.tpl');
}
$title_page = $exbb['boardname'].' :: '.$lang['Help'];
include('./templates/'.$exbb['default_style'].'all_header.tpl');
include('./templates/'.$exbb['default_style'].'logos.tpl');
include('./templates/'.$exbb['default_style'].'help.tpl');
include('./templates/'.$exbb['default_style'].'footer.tpl');
include('page_tail.php');
?>