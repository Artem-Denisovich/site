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
$mtime = microtime();
$mtime = explode(' ',$mtime);
$totaltime = round($mtime[1] + $mtime[0] - $exbb['starttime'],4);

if($exbb['do_gzip_compress']) {

	$gzip_contents = ob_get_contents();
	ob_end_clean();
	$gzip_contents .= '<center><tr class="moder"><td align="center"><font color=#990000 size=1>[ Script Execution time: '.$totaltime.' ] &nbsp; [ Gzipped ]</font></td></tr></center>';
	$gzip_size = strlen($gzip_contents);
	$gzip_crc = crc32($gzip_contents);
	
	$gzip_contents = gzcompress($gzip_contents, 9);
	$gzip_contents = substr($gzip_contents, 0, strlen($gzip_contents) - 4);

	echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
	echo $gzip_contents;
	echo pack("V", $gzip_crc);
	echo pack("V", $gzip_size);
}
else {
	echo '<center><tr><td align="center"><font color=#990000 size=1>[ Script Execution time: '.$totaltime.' ] &nbsp; [ Gzip Disabled ]</font></td></tr></center>';
	ob_end_flush();
}
unset($exbb,$vars,$gzip_contents,$lang);
exit;
?>