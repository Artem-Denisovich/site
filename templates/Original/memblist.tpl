<?
echo <<<MEMBERS
<br>
<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="4" border="0" class="tab">
<tr>
<td height="22" class="small"><a href="index.php">$exbb[boardname]</a> &raquo; <a href="search.php?action=members">$lang[Users]</a></td>
</tr>
</table>
</td>
</tr>
</table>
<br>
<table cellpadding=0 cellspacing=1 border=0 width=95% align=center>
<tr>
<td>
<table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr>
<td valign=middle align=left nowrap class="dats">[$pages]</font></td>
<td valign=middle align=right width="100%" nowrap class="dats"><form method="post" action="search.php?action=members">$lang[Sort_by]&nbsp;$sort_mode&nbsp;&nbsp;&nbsp;$sort_order&nbsp;&nbsp;<input type="submit" name="submit" value="$lang[Sorting]" /></form></td>
</tr>
</table>
</td>
</tr>
</table>
<table width=95% border='0' align='center' cellspacing='0' cellpadding='0' class='tab'>
<tr class='catname'>
<td colspan=0 align='center' height="22" background="./templates/Original/im/tab_bg.gif" class="tab_down">
$lang[Memberlist]
</td>
</tr>
<tr class='catname'>
<td>
<table width='100%' border='0' cellspacing='0' cellpadding='4' class='catname'>
<tr>
<td nowrap class='tab_right_down' align="center" width="30%" height="29" background="./templates/Original/im/tab_bg1.gif">$lang[Name]</td>
<td class='tab_right_down' align="center" width="20%" background="./templates/Original/im/tab_bg1.gif">$lang[Status]</td>
<td nowrap class='tab_right_down' align="center" width="10%" background="./templates/Original/im/tab_bg1.gif">$lang[Posts_total]</td>
<td nowrap class='tab_right_down' align="center" width="20%" background="./templates/Original/im/tab_bg1.gif">$lang[Reged_date]</td>
<td nowrap class='tab_right_down' align="center" width="20%" background="./templates/Original/im/tab_bg1.gif">$lang[From]:</td>
<td nowrap class='tab_right_down' align="center" background="./templates/Original/im/tab_bg1.gif">Email</td>
<td nowrap class='tab_right_down' align="center" background="./templates/Original/im/tab_bg1.gif">WWW</td>
<td nowrap class='tab_down' align="center" background="./templates/Original/im/tab_bg1.gif">ICQ</td>
</tr>
$memb_data
</table>
</td>
</tr>
</table>
<br>
<table cellpadding=0 cellspacing=0 border=0 width=95% align=center>
<tr>
<td>
<table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr>
<td valign=middle align=left nowrap class="dats">[$pages]</font></td>
<td valign=middle align=right width="100%" nowrap class="dats"><form method="post" action="search.php?action=members">$lang[Sort_by]&nbsp;$sort_mode&nbsp;&nbsp;&nbsp;$sort_order&nbsp;&nbsp;<input type="submit" name="submit" value="$lang[Sorting]" /></form></td>
</tr>
</table>
</td>
</tr>
</table>
MEMBERS;
?>