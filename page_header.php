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

$exbb['do_gzip_compress'] = FALSE;

 ob_start();
 ob_implicit_flush(0);

if($exbb['gzip_compress'] && !defined('ATTACH') )
{
   $enc = FALSE;
   if(strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip')) $enc = 'gzip';
   elseif(strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'x-gzip')) $enc = 'x-gzip';
   if ($enc) {
      if(extension_loaded("zlib") && !defined('NO_GZIP')) {
          $exbb['do_gzip_compress'] = $enc;
          header('Content-Encoding: '.$enc);
      }
   }
}
?>