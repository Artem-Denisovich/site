<?
if ($catrow) {
$forum_data .= <<<DATA
<tr class="genmed">
   <td class="catLeft" colspan="3" height="28"><span class="cattitle"><b><a href="index.php?c=$forum[catid]" class="cattitle">$forum[catname]</a></b></span></td>
   <td class="cat" align="center" valign="middle"><span class="genmed"><a href="setforums.php?action=editcatname&category=$forum[catid]" class="nav">$lang[Change]</a></span></td>
   <td class="cat" align="center" valign="middle"><span class="genmed"><a href="setforums.php?action=delcat&category=$forum[catid]" class="nav">$lang[Delete]</a></span></td>
   <td class="cat" align="center" valign="middle" nowrap="nowrap"><span class="genmed"><a href="setforums.php?action=reorder&amp;move=-1&amp;category=$forum[catid]" class="nav">$lang[Move_up]</a> <a href="setforums.php?action=reorder&amp;move=1&amp;category=$forum[catid]" class="nav">$lang[Move_down]</a></span></td>
   <td class="catRight" align="center" valign="middle"><span class="genmed"><a href="setforums.php?action=addforum&amp;category=$forum[catid]" class="nav">$lang[Forum_addnew]</a></span></td>
</tr>
DATA;
}

$forum_data .= <<<DATA
<tr class="genmed">
   <td class="row2" colspan="3"><span class="gen"><a href="forums.php?forum=$forumid"><b>$forum[name]</b></a><font color=green>$private</font></span><br /><span class="genmed">$forum[desc]<br /><span class="gensmall">$lang_moder $modoutput<br>$lang[asnwers] <b>$forum[posts]</b> | $lang[Topics]: <b>$forum[topics]</b></span></td>
   <td class="row1" align="center" valign="middle"><span class="gen"><a href="setforums.php?action=edit&forum=$forumid">$lang[Change]</a></span></td>
   <td class="row2" align="center" valign="middle"><span class="gen"><a href="setforums.php?action=delete&forum=$forumid">$lang[Delete]</a></span></td>
   <td class="row1" align="center" valign="middle"><span class="gen"><a href="setforums.php?action=forum_order&amp;forum=$forumid&amp;move=-1&amp;category=$forum[catid]">$lang[Move_up]</a> <br> <a href="setforums.php?action=forum_order&amp;forum=$forumid&amp;move=1&amp;category=$forum[catid]">$lang[Move_down]</a></span></td>
   <td class="row2" align="center" valign="middle"><span class="gen"><a href="setforums.php?action=recount&forum=$forumid">$lang[Resync]</a><br><a href="setforums.php?action=restore&forum=$forumid">$lang[_Restoration]</a></span></td>
</tr>
DATA;
?>