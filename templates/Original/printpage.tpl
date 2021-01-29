<?
echo <<<DATA
<html>
<head>
<title>$title_page</title>
<style type="text/css"><!--
.top {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10pt; color : #000000}
.topc {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #333333}
.post  {font-family: Verdana, Arial; font-size: 0.8em; text-align: justify}
.small {font-family: Verdana, Arial; font-size: 0.78em; text-align: justify}
.dats { FONT-SIZE: 8pt; color:#333333; font-family: Verdana, Arial, Helvetica, sans-serif}
.forumline { background-color: #C2CFDF;}
.copyright { font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #444444; letter-spacing: -1px;}
a.copyright { color: #444444; text-decoration: none;}
a.copyright:hover { color: #000000; text-decoration: underline;}
--></style>
</head>
<bgcolor="#FFFFFF" text="#000000" link="#000080" vlink="#000080" marginheight=8 marginwidth=8 topmargin=8 leftmargin=8 rightmargin=8>
<table width='95%' border='0' align='center' cellpadding='6'>
<tr><td class="small"><a href="$exbb[boardurl]">$exbb[boardname]</a> &raquo;<a href="$exbb[boardurl]/index.php?c=$catid">$category</a> &raquo; <a href="$exbb[boardurl]/forums.php?forum=$inforum">$forumname</a> &raquo; <b><a href="$exbb[boardurl]/topic.php?forum=$inforum&topic=$intopic">$topictitle</a></b></td></tr>
<tr><td><span class=dats>$pages</span></td></tr>
</table>
$print_data
DATA;
?>