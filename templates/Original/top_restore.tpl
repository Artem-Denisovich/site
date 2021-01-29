<?
echo <<<DATA
<p>
<table width="95%" align="center" cellspacing="0" cellpadding="0" border="0">
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="4" border="0" class="tab">
<tr>
<td valign="middle" class="small"><a href="index.php">$exbb[boardname]</a> &raquo; $lang[top_recovery_in] <a href="forums.php?forum=$inforum">'$forumname'</a></td>
</tr>
</table>
</td>
</tr>
</table>
<br>
<table cellpadding=0 cellspacing=0 border=0 width="100%" align=center>
<form action="postings.php" method="post">
<input type=hidden name="action" value="restore">
<input type=hidden name="check" value="1">
<input type='hidden' name='forum' value='$inforum'>
<input type='hidden' name='topic' value='$intopic'>
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width=95% class="tab" align="center">
<tr class="forumline">
<td class="tab_down" valign=middle colspan=2 align=center height="29" background="./templates/Original/im/tab_bg1.gif"><span class="dats"><b>$lang[top_recovery_in]</b></span></td>
</tr>
<tr class="dats">
<td width =30% valign=middle>$lang[recover_name]</td>
<td valign=middle><input class="tab" type=text name="name" tabindex = "1" style="width:450px" value="$t_name" size="40" maxlength="255"></td>
</tr>
<tr class="dats">
<td class="tab_down" valign=middle>$lang[recover_desc]</td>
<td class="tab_down" valign=middle><input class="tab" type=text name="desc" tabindex = "2" style="width:450px" value="$t_desc" size="40" maxlength="160"></td>
</tr>
<tr class="dats">
<td class="tab_down" valign=middle colspan=2 align=center background="./templates/Original/im/bg.gif"><b>$lang[recover_help]</b></td>
</tr>
<tr class="dats">
<td valign=middle>$lang[Topic_author]<br>$lang[topic_misc]</td>
<td valign=middle>$t_author<br>$time ($t_date)<br>$filetoopen<br>$url</td>
</tr>
<tr class="dats">
<td valign=middle>$lang[first_post]</td>
<td valign=middle>$t_post</td>
</tr>
<tr class="dats">
<td valign=middle>$lang[Notice]</td>
<td valign=middle>$note</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<table cellpadding=2 cellspacing=0 border=0 width=95% class="tab_left_right_down" align="center">
<tr class="dats">
<td valign=middle colspan=2 align=center height="22" background="./templates/Original/im/tab_bg.gif"><input class="tab" type=submit name="submit" value="$lang[top_recover]"></td>
</tr>
</table>
</td>
</tr>
</form>
</table>
DATA;
?>