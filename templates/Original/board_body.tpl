<?
$loginact = ($exbb['reged']) ? '| <a href="search.php?action=newposts" class="small" title="'.$lang['New_posts'].'">'.$lang['New_posts'].'</a>' : '';
$logins = ($exbb['reged']) ? '' : '
<table width="100%" cellpadding=0 cellspacing=1 border=0 align=center>
<form action="loginout.php" method="post">
<input type=hidden name="action" value="login">
<tr><td>
<table cellpadding=4 cellspacing=0 border=0 width=100% class="tab">
<tr class="catname">
<td class="tab_down" valign=middle colspan=2 align=center height=29 background=./templates/Original/im/tab_bg1.gif><b>'.$lang['Enter_info'].'</b></td>
</tr>
<tr class="dats">
<td valign=middle>'.$lang['Enter_name'].'</td>
<td valign=middle><input class="tab" type=text name="imembername" tabindex = "1" value="'.$exbb['member'].'" size="25" maxlength="40"> &nbsp; <a href="register.php" title="'.$lang['You_reged'].'">'.$lang['You_reged'].'</a></td>
</tr>
<tr class="dats">
<td valign=middle>'.$lang['Enter_pass'].'</td>
<td valign=middle><input class="tab" type=password name="ipassword" tabindex = "2" value="" size="25" maxlength="25"> &nbsp; <a href="profile.php?action=lostpass" title="'.$lang['Forgotten_password'].'">'.$lang['Forgotten_password'].'</a></td>
</tr>
</table>
<table cellpadding=2 cellspacing=0 border=0 width=100% class="tab_left_right_down">
<tr class="dats">
<td valign=middle align=center height="22" background="./templates/Original/im/tab_bg.gif"><input class="tab" type=submit name="submit" value="'.$lang['Login'].'"></td>
</tr>
</table>
</td>
</tr>
</form>
</table>
<br>';
echo <<<DATA
<br>
<table width="95%" cellspacing="0" cellpadding="0" border="0" align="center">
<tr><td>
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
<tr>
<td>
<table align="left" cellspacing="0" cellpadding="4" class="tab">
<tr class="small">
<td>$lang[Hello], <b>$exbb[member]</b> $newmail</td>
</tr>	
<tr>
<td align="left" valign="bottom" class="small">$lang[Last_visit] $lastvisit<br>$lang[Current_time] $basetimes</td></tr>
</table>
</td></tr>
</table>
<br>
<table width="100%" align="center" cellspacing="0" cellpadding="0" border="0" class="tab">
<tr>
<td>
<table width="100%" cellpadding="4" cellspacing="0" border="0" class="tab_down">
<tr><td class="mainmenu" background="./templates/Original/im/tab_bg.gif" height="22">
$loginact | <a href="index.php?action=resetall" class="small" title="$lang[Mark_all_forums]">$lang[Mark_all_forums]</a> |</td></tr>
</table></td></tr>
<tr>
<td>
<table width="100%" cellpadding="5" cellspacing="0" border="0" align="center">
<tr class="forumline">
<td class="tab_right" height="29" background="./templates/Original/im/tab_bg1.gif"><span class="catname">&nbsp;</span></td>
<th align="center" class="tab_right" width="70%" background="./templates/Original/im/tab_bg1.gif"><b><span class="catname">$lang[Forum_Info]</span></b></th>
<td align="center" class="tab_right" width="50" background="./templates/Original/im/tab_bg1.gif"><b><span class="catname">$lang[Replies]</span></b></td>
<td align="center" class="tab_right" width="50" background="./templates/Original/im/tab_bg1.gif"><b><span class="catname">$lang[Topics_total]</span></b></td>
<td align="center" width="30%" background="./templates/Original/im/tab_bg1.gif"><b><span class="catname">$lang[Updates]</span></b></td>
</tr>
$news_data
$board_data
<tr><td colspan="5" class="mainmenu" background="./templates/Original/im/tab_bg.gif" height="22">$loginact | <a href="index.php?action=resetall" class="small" title="$lang[Mark_all_forums]">$lang[Mark_all_forums]</a> |</td></tr>
</table>
</td></tr></table>
<br>
<table width="100%" align="center" cellspacing="0" cellpadding="4" border="0" class="tab">
<tr class="catname">
<td background="./templates/Original/im/tab_bg1.gif" height="29" align="left" colspan="2" class="tab_down"><b>$lang[Forum_stat]</b></td></tr>
<tr> 
<td class="tab_right_down"><img src="./templates/Original/im/online.gif"></td>
<td class="tab_down" align="left" width="100%"><span class="small">$online_last [ <a href="whosonline.php" title="$lang[Full_list_users]">$lang[Full_list]</a> ] $maximum<br>$memberoutput</span></td>
</tr>
<tr>
<td class="tab_right"><img src="./templates/Original/im/stats.gif"></td>
<td class="small">$lang[New_user] <a href="profile.php?action=show&member=$exbb[last_id]" title="$exbb[lastreg]">$exbb[lastreg]</a><br>$lang[Users_total] <b>$exbb[totalmembers]</b><br>$lang[Posts_total] <b>$exbb[totalposts]</b><br>$lang[Topics_total]: <b>$exbb[totalthreads]</b></td>
</tr>
</table>
<br>
$logins
<table width="100%"cellpadding=0 cellspacing=4 border=0 align=center>
<tr>
<td align="center">
<table cellpadding=0 cellspacing=4 border=0 align=center>
<tr class="dats"><td align=center><img src="./templates/Original/im/foldernew.gif" border=0></td>
<td align=left>$lang[New_posts_yes]</td></tr>
<tr class="dats"><td align=center><img src="./templates/Original/im/folder.gif" border=0></td>
<td align=left>$lang[New_posts_no]</td></tr></table>
</td></tr></table>
</td></tr></table>
<br>
DATA;
?>