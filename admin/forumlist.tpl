<?
echo <<<DATA

<h1>$lang[Set_forums]</h1>
$safe_mode
<p class="genmed">$lang[Edit_notice]</p>
$lang[Stat_up_url]
<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr> 
	  <th class="thHead" colspan="7"><a href="setforums.php?action=addcat&category=$highest" class="nav"><font color="#FFFFFF">$lang[Cat_add_new]</font></a></th>
	</tr> 
    $forum_data
	<tr> 
	  <th class="thHead" colspan="7"><a href="setforums.php?action=addcat&category=$highest" class="nav"><font color="#FFFFFF">$lang[Cat_add_new]</font></a></th>
	</tr> 
</table>
DATA;
?>