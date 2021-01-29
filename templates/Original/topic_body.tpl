<?
$newthreadnoico ='<a href="post.php?action=new&forum='.$inforum.'">'.$lang['newthread'].'</a>';
if ($forum[$inforum]['polls'] && $exbb['reged']) $newthreadnoico .= '&nbsp;| <a href="post.php?action=new&poll=1&forum='.$inforum.'">'.$lang['newpoll'].'</a>';
if ($threadstate == 'open') {
    $replynoico = '<a href="post.php?action=reply&forum='.$inforum.'&topic='.$intopic.'">'.$lang['reply'].'</a> |';
}
else { $replynoico = $lang['Topic_closed'].' |'; }
echo <<<DATA
<script language='javascript'>
<!--
function del_post(ID) {
	if (confirm('$lang[Sure]')) {
		window.location.href=ID;
	} else { alert ('$lang[Canceled]');  }
}
//-->
</script>
$java
<p>
<table width="95%" align="center" cellspacing="0" cellpadding="0" border="0">
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="4" border="0" class="tab">
<tr>
<td valign="middle" class="small"><a href="index.php">$exbb[boardname]</a> &raquo; <a href="index.php?c=$catid">$category</a> &raquo; <a href="forums.php?forum=$inforum">$forumname</a> &raquo; $topictitle</td>
<td align="right" class="small">[$pages]</td>
</tr>
</table>
</td>
</tr>
</table>
<br>
<table width="95%" align="center" cellspacing="0" cellpadding="0" border="0">
<tr>
<td>
$mod_options
</td>
</tr>
</table>
<table cellpadding=0 cellspacing=0 border=0 width="95%" align=center class="tab">
<tr>
<td colspan="2">
<table cellpadding=4 cellspacing=0 border=0 width=100%>
<tr class="small">
<td class="tab_down" height="22" background="./templates/Original/im/tab_bg.gif">| $newthreadnoico | $replynoico</td>
<td class="tab_down" align="right" height="22" background="./templates/Original/im/tab_bg.gif">| <a href="search.php?action=t&f=$inforum&t=$intopic">$lang[srch_intop]</a> |</td>
</tr>
</table>
</td>
</tr>
<tr>
<td colspan="2">
<table cellpadding=4 cellspacing=0 border=0 width=100%>
<tr class="catname">
<td class="forumline" align="right" valign="middle" height="29" background="./templates/Original/im/tab_bg1.gif">| $options |</td>
</tr>
</table>
</td>
</tr>
$poll_html
$topic_data
<tr>
<td colspan="2">
<table cellpadding=4 cellspacing=0 border=0 width=100%>
<tr class="catname">
<td class="forumline" align="right" valign="middle" height="29" background="./templates/Original/im/tab_bg1.gif">| $options |</td>
</tr>
</table>
</td>
</tr>
<tr>
<td colspan="2">
<table cellpadding=4 cellspacing=0 border=0 width=100%>
<tr class="small">
<td height="22" background="./templates/Original/im/tab_bg.gif">| $newthreadnoico | $replynoico</td>
<td align="right" height="22" background="./templates/Original/im/tab_bg.gif">| <a href="search.php?action=t&f=$inforum&t=$intopic">$lang[srch_intop]</a> |</td>
</tr>
</table>
</td>
</tr>
</table>
<br>
<table cellpadding=0 cellspacing=1 border=0 width="95%" align=center>
<tr>
<td>
<table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr>
<td align=right class="dats">$jumphtml</td>
</tr>
</table>
</td>
</tr>
</table>
<table width="95%" align="center" cellspacing="0" cellpadding="0" border="0">
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="4" border="0" class="tab">
<tr>
<td valign="middle" class="small"><a href="index.php">$exbb[boardname]</a> &raquo; <a href="index.php?c=$catid">$category</a> &raquo; <a href="forums.php?forum=$inforum">$forumname</a> &raquo; $topictitle</td>
<td align="right" class="small">[$pages]</td>
</tr>
</table>
</td>
</tr>
</table>
<p>
$post_form
DATA;
?>