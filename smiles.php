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

   $smilesdir = './im/emoticons';

   if ($vars['action'] == 'add' || $vars['action'] == 'edit') {
            $dir = @opendir($smilesdir);
            $smiley_images = array();
            while(false !== ($file = @readdir($dir))) {
                  if( !@is_dir($smilesdir . '/' . $file) ) {
                        $img_size = @getimagesize($smilesdir . '/' . $file);
                        if( $img_size[0] && $img_size[1] ) $smiley_images[] = $file;
                  }
            }

            @closedir($dir);
   }

   if($vars['action'] != '')  {
      switch( $vars['action'] ) {
      case 'add':

            $smiles_list = '';
            sort($smiley_images,SORT_STRING);
            foreach($smiley_images as $smile) $filename_list .= '<option value="' . $smile . '">' . $smile . '</option>';
            $sm_cur_img = $smiley_images[0];
            $sm_emt = '';
            $hidden_field = '<input type="hidden" name="action" value="addnew">';
            $title_page = $lang['Administrating'];
            include('./admin/all_header.tpl');
            include('./admin/smiles_add.tpl');

            break;
      case 'addnew':
            $filetoopen = $exbb['home_path'].'data/smiles.php';
            $edition = ( !empty($vars['edition']) ) ? $vars['edition'] : '';
            if (file_exists($filetoopen)) {$smiles_list = get_file($filetoopen);} else {$smiles_list = array();}
            $sm_code = $vars['sm_code'];
            $sm_img = $vars['sm_img'];
            $sm_emotion = $vars['sm_emotion'];
            if (!empty($edition)) {
                 $id = intval($vars['id']);
                 foreach ($smiles_list as $code=>$data) if ($data['id'] == $id) break;
                 unset($smiles_list[$code]);
            }
            else {
                  $id = 0;
                  if (count($smiles_list)) { foreach ($smiles_list as $code=>$data) { $id++; $smiles_list[$code]['id'] = $id;} }
                  $id++;
            }
            $smiles_list[$sm_code]['img'] = $sm_img;
            $smiles_list[$sm_code]['emt'] = $sm_emotion;
            $smiles_list[$sm_code]['id'] = $id;
            save_file($filetoopen,$smiles_list);
            error($lang['Info'],$lang['smile_added'],'',false);

            break;

      case 'delete':

            $id = $vars['id'];
            $filetoopen = $exbb['home_path'].'data/smiles.php';
            $smiles_list = get_file($filetoopen);
            $ok = 0;
            foreach ($smiles_list as $code=>$data) { if ($smiles_list[$code]['id'] == $id) {$ok = 1; break;}}
            if (!$ok) error($lang['smile_delete'],$lang['smile_not_deleted'],'',false);

            unset($smiles_list[$code]);
            $id = 0;
            foreach ($smiles_list as $code=>$data) { $id++; $smiles_list[$code]['id'] = $id;}
            save_file($filetoopen,$smiles_list);
            error($lang['smile_delete'],$lang['smile_deleted'],'',false);
            break;

      case 'edit':

            $id = $vars['id'];
            $filetoopen = $exbb['home_path'].'data/smiles.php';
            $smiles_list = get_file($filetoopen);

            $ok = 0;
            foreach ($smiles_list as $code=>$data) { if ($smiles_list[$code]['id'] == $id) {$ok = 1; break;}}
            if (!$ok) error($lang['smile_edit'],$lang['smile_noid'],'',false);

            $filename_list = '';
            foreach($smiley_images as $sm) {
               if( $sm == $smiles_list[$code]['img'] ) {
                   $sm_selected = 'selected="selected"';
                   $sm_cur_img = $sm;
                   $sm_emt = $smiles_list[$code]['emt'];
               }
               else { $sm_selected = ''; }
               $filename_list .= '<option value="' . $sm . '"' . $sm_selected . '>' . $sm . '</option>';
            }
            $hidden_field = '<input type="hidden" name="action" value="addnew"><input type="hidden" name="edition" value="yes"><input type="hidden" name="id" value="'.$id.'">';
            $title_page = $lang['Administrating'];
            include('./admin/all_header.tpl');
            include('./admin/smiles_add.tpl');

            break;

      } #switch
}
   else {
         $filetoopen = $exbb['home_path'].'data/smiles.php';
         if (file_exists($filetoopen)) {$smiles_list = get_file($filetoopen); uasort($smiles_list,'sort_by_id');} else {$smiles_list = array();}
         if (count($smiles_list)) {
             foreach ($smiles_list as $code=>$data) {
               $back_clr = ($back_clr == 'row1') ? 'row2' : 'row1';
               include('./templates/'.$exbb['default_style'].'admin/smiles_data.tpl');
             }
         }
         else {$datashow = '<tr><td colspan="5" align="center">'.$lang['Smiles_notset'].'</td></tr>';}

         $title_page = $lang['Administrating'];
         include('./admin/all_header.tpl');
         include('./admin/smiles_show.tpl');
}

}
else {
     Header('Location: index.php'); exit;
     }

include('page_tail_admin.php');

function sort_by_id($a, $b) {
    if ($a['id'] == $b['id']) return 0;
    return ($a['id'] < $b['id']) ? -1 : 1;
}
?>