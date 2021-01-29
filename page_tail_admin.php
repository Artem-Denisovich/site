<?
/***************************************************************************
 * ExBB v.1.9                                                              *
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
$mtime = microtime();
$mtime = explode(' ',$mtime);
$totaltime = round($mtime[1] + $mtime[0] - $exbb['starttime'],4);

echo <<<DATA
<p align="center">
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
<tr><td align="center"><span class="copyright">$lang[Powered] <a href="http://www.ExBB.revansh.com" class="copyright"  target="_blank">ExBB $exbb[ver]</a><br><font color=#990000 size=1>[ Script Execution time: $totaltime ]</font></td></tr>
</table>
DATA;


if($exbb['do_gzip_compress']) {

	$gzip_contents = ob_get_contents();
	ob_end_clean();
	$gzip_size = strlen($gzip_contents);

	#if ( $gzip_size < 1024 )
	$gzip_contents .= str_repeat('<!-- затравка в 1 б дл€ IE, иначе не работает (глюк IE) --><br>', 50).'</body></html>';
    #ну, если ещЄ это и сжать.....
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
    echo str_repeat('<!-- затравка в 1 б дл€ IE, иначе не работает (глюк IE) -->', 50).'</body></html>';
	ob_end_flush();
}
unset($exbb,$vars,$gzip_contents,$lang);
exit;
?>