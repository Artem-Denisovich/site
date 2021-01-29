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

session_start();

out_image();

function out_image() {

     $i = intval($_GET['i']) - 1;
     $image = substr( $_SESSION['reg_code'], $i, 1 );
     include('./data/boardinfo.php');
     $filename = $exbb['home_path'].'im/reg/'.$image.'.gif';
     $fp = @fopen($filename,'rb');
     $str = @fread($fp,filesize($filename));
     @fclose($fp);

     flush();

     header('Content-type: image/gif');
     echo $str;
     exit;
}

?>