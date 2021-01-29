<?
$newthreadnoico ='<a href="post.php?action=new&forum='.$inforum.'">'.$lang['newthread'].'</a>';
if ($forum[$inforum]['polls'] && $exbb['reged']) $newthreadnoico .= '&nbsp;| <a href="post.php?action=new&poll=1&forum='.$inforum.'">'.$lang['newpoll'].'</a>';
echo <<<DATA
<br>
<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="4" border="0" class="tab">
<tr>
<td height="22" class="small"><a href="index.php">$exbb[boardname]</a> &raquo; <a href="index.php?c=$catid">$category</a> &raquo; <a href="forums.php?forum=$inforum">$forumname</a> ($lang_moder <b>$modoutput</b>)</td>
<td align="right" class="small"> [$topicpages]</td>
</tr>
</table>
</td>
</tr>
</table>
<br>
<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
<tr>
<td align="right">
<table cellpadding=0 cellspacing=0 border=0>
<tr>
<td align=right nowrap><form name=postform action="forums.php" method="get" class="gentext" onSubmit="SubmitControl(this)">
<input type="hidden" name="forum" value="$inforum">$lang[Filter_on]
<select name="filterby">
<option value="topnam">$lang[Filter_topic]</option>
<option value="topdesc">$lang[Filter_desc]</option>
<option value="author">$lang[Filter_author]</option>
</select>
<input type="text" name="word" size=10 value="$word">
<input type="submit" value="ok" onClick="return Formchecker(this.form)">
</form>
$resetfiltr
</td>
</tr>
</table>
</td>
</table>
<table cellpadding=0 cellspacing=0 border=0 width="95%" class="tab" align=center>
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width="100%" align=center>
<tr>
<td align="left" class="small" height="22" background="./templates/Original/im/tab_bg.gif">| $newthreadnoico |</td>
<td align="right" class="small" background="./templates/Original/im/tab_bg.gif">| $options | $markforum |</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width=100%>
<tr class="forumline">
<td class="tab_right_down" height="29" background="./templates/Original/im/tab_bg1.gif"><span class="catname">&nbsp;</span></td>
<td class="tab_right_down" align="center" width="60%" background="./templates/Original/im/tab_bg1.gif"><b><span class="catname">$lang[Topics]</span></b></td>
<td class="tab_right_down" align=center width=20% background="./templates/Original/im/tab_bg1.gif"><b><span class="catname">&nbsp;$lang[Topic_info]&nbsp;</span></b></td>
<td class="tab_down" align=center width=20% background="./templates/Original/im/tab_bg1.gif"><b><span class="catname">&nbsp;$lang[Updates]&nbsp;</span></b></td>
</tr>
$forum_data
</table>
</td>
</tr>
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width="100%" align=center>
<tr>
<td align="left" class="small" height="22" background="./templates/Original/im/tab_bg.gif">| $newthreadnoico |</td>
<td align="right" class="small" background="./templates/Original/im/tab_bg.gif">| $options | $markforum |</td>
</tr>
</table>
</td>
</tr>
</table>
<br>
<table cellpadding=0 cellspacing=0 border=0 width="95%" align=center>
<tr>
<td align="right">
<table cellpadding=0 cellspacing=0 border=0>
<tr>
<td valign=top align=right nowrap class="dats">$jumphtml</td>
</tr>
</table>
</td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="4" border="0" class="tab">
<tr>
<td height="22" class="small"><a href="index.php">$exbb[boardname]</a> &raquo; <a href="index.php?c=$catid">$category</a> &raquo; <a href="forums.php?forum=$inforum">$forumname</a> ($lang_moder <b>$modoutput</b>)</td>
<td align="right" class="small">[$topicpages]</td>
</tr>
</table>
</td>
</tr>
</table>
<br>
<table align=center width="95%">
<tr>
<td class="dats">$who</td>
</tr>
</table>
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
<tr>
<td class='dats'><img src='$icon_path/folder_sticky.gif' border='0'></td>
<td nowrap class='dats' colspan="5">$lang[Topic_pinned]&nbsp;</td>
</tr>
</table>
<p>
DATA;
?>