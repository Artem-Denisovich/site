<?
echo <<<DATA
<p>
<table width="95%" align="center" cellspacing="0" cellpadding="0" border="0" class="tab">
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="4" border="0">
<tr>
<td valign="middle" class="small"><a href="index.php">$exbb[boardname]</a> &raquo; $lang[Help]</td>
</tr>
</table>
</td>
</tr>
</table>
<br>
<table cellpadding=0 cellspacing=0 border=0 width="95%" class="tab" align=center>
<tr>
<td>
<table cellpadding=3 cellspacing=0 border=0 width=100%>
<tr class="forumline">
<td colspan="2" class="tab_down" align="center" height="29" background="./templates/Original/im/tab_bg1.gif"><span class="frmtit"><b>$helptitle</b></span></td>
</tr>
$help_topics
</table>
</td>
</tr>
</table>
DATA;
?>