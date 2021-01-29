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
    if ($vars['action'] == 'doadd') {

        $title = $vars['title'];
        $min_posts = $vars['min_posts'];
        $rank_image = $vars['rank_image'];
        if (empty($title)) error($lang['Info'],$lang['Rank_not_set'],'',false);
        if (empty($rank_image)) error($lang['Info'],$lang['Rank_noimage'],'',false);
        if (empty($min_posts)) $min_posts = 0;

        $filetomake = $exbb['home_path'].'data/membertitles.php';
        $ranks = get_file($filetomake);
        if (isset($vars['id'])) {
            $id = $vars['id'];
            foreach($ranks as $rang=>$info) if ($info['id'] == $id) {$deltitle = $rang; break;}
            unset($ranks[$deltitle]);}
        else {
            $id = 0;
            foreach($ranks as $rang=>$info) if ($info['id'] > $id) $id = $info['id'];
            $id++;
        }
        $ranks[$title]['posts'] = $min_posts;
        $ranks[$title]['icon'] = $rank_image;
        $ranks[$title]['id'] = $id;
        uasort($ranks,'sort_by_minposts');

        save_file($filetomake,$ranks);
        Header('Location: setmembertitles.php'); exit;

    } #doadd

    elseif ($vars['action'] == 'add' || $vars['action'] == 'edit') {

        if (isset($vars['id'])) {
            $id = $vars['id'];
            $filetomake = $exbb['home_path'].'data/membertitles.php';
            $ranks = get_file($filetomake);
            foreach($ranks as $rang=>$info) if ($info['id'] == $id) {
                                              $title = $rang;
                                              $min_posts = $info['posts'];
                                              $rank_image = $info['icon'];
                                              $hidden = '<input type=hidden name="id" value="'.$id.'">';
                                              break;
                                            }

       }
       $title_page = $exbb['boardname'];
       include('./admin/all_header.tpl');
       include('./admin/ranks_add.tpl');
       include('page_tail_admin.php');

    } #add || edit

    elseif ($vars['action'] == 'delete') {

       $filetomake = $exbb['home_path']."data/membertitles.php";
       $ranks = get_file($filetomake);
       foreach($ranks as $rang=>$info) if ($info['id'] == $vars['id']) {$title = $rang; break;}
       unset($ranks[$title]);
       uasort($ranks,'sort_by_minposts');
       save_file($filetomake,$ranks);
       Header('Location: setmembertitles.php'); exit;
    }

    else {

       $ranks = get_file($exbb['home_path'].'data/membertitles.php');
	   $first = 0;

	   $style = './admin/ranks_data.tpl';

       foreach($ranks as $rang=>$info)  {
           $posts =  (isset($info['posts'])) ? $info['posts'] : '--';
           $back_clr = ($back_clr == 'row1') ? 'row2' : 'row1';
           $id = $info['id'];
           include($style);
       }
       $title_page = $exbb['boardname'];
       include('./admin/all_header.tpl');
       include('./admin/ranks_show.tpl');
       include('page_tail_admin.php');
    } #else
}
else {
      Header('Location: index.php'); exit;
     }


function sort_by_minposts($a, $b) {
    if ($a['posts'] == $b['posts']) return 0;
    return ($a['posts'] < $b['posts']) ? -1 : 1;
}

?>