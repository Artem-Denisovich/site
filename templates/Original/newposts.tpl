<?
echo <<<DATA
<br>
<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="4" border="0" class="tab">
<tr>
<td height="22" class="small"><a href="index.php">$exbb[boardname]</a> &raquo; $lang[New_posts]</td>
</tr>
</table>
</td>
</tr>
</table>
<br> 
<table width="95%" cellspacing="0" cellpadding="4" border="0" align="center">
<tr> 
<td align="left" valign="bottom"><span class="normal">$lang[srch_found_top] $found</span><br /></td>
</tr>
</table>
<table cellpadding=0 cellspacing=0 border=0 width="95%" align=center>
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width=100% class="tab">
<tr class="catname">
<td class="tab_right_down" width=5% height="29" background="./templates/Original/im/tab_bg1.gif">&nbsp;</td>
<td class="tab_right_down" align=center width=30% background="./templates/Original/im/tab_bg1.gif"><b>$lang[Topics]</b></td>
<td class="tab_right_down" align=center background="./templates/Original/im/tab_bg1.gif"><b>$lang[Forum]</b></td>
<td class="tab_right_down" align=center background="./templates/Original/im/tab_bg1.gif"><b>$lang[Topic_info]</b></td>
<td class="tab_right_down" align=center background="./templates/Original/im/tab_bg1.gif"><b>$lang[Updates]</b></td>
</tr>
$data
</table>
</td>
</tr>
</table>
<br>
<table align=center width="95%">
<tr>
<td><img src='$icon_path/to_new.gif' border='0'></td>
<td nowrap class='dats'>$lang[Topic_open_new]&nbsp;</td>
<td><img src='$icon_path/to_hot.gif' border='0'></td>
<td nowrap class='dats'>$lang[Topic_hot_new]&nbsp;</td>
<td><img src='$icon_path/moved.gif' border='0'></td>
<td nowrap class='dats'>$lang[Topic_moved]&nbsp;</td>
<td width='100%' rowspan='4' align='right'>
</tr>
<tr>
<td><img src='$icon_path/tc_new.gif' border='0'></td>
<td nowrap class='dats'>$lang[Topic_open_nonew]&nbsp;</td>
<td><img src='$icon_path/tc_hot.gif' border='0'></td>
<td nowrap class='dats'>$lang[Topic_hot_nonew]&nbsp;</td>
<td><img src='$icon_path/locked.gif' border='0'></td>
<td nowrap class='dats'>$lang[Topic_closed]&nbsp;</td>
</tr>
</table>
DATA;
?>