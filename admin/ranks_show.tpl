<?
echo <<<DATA
<h1 align=center>$lang[Ranks_title]</h1>

<form method="post" action="setmembertitles.php"><table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
<input type="hidden" name="action" value="add" />
	<tr>
		<th class="thCornerL">$lang[Rank_title]</th>
		<th class="thTop">$lang[Rank_minimum]</th>
		<th class="thTop">$lang[Change]</th>
		<th colspan="2" class="thCornerR">$lang[Delete]</th>
	</tr>
	$ranksdata
	<tr>
		<td class="catBottom" colspan="4" align="center"><input type="submit" name="add" value="$lang[Ranks_new]" class="mainoption" /></td>
	</tr>
</table></form>  
DATA;
?>