<?
echo <<<DATA
<form method="post" action="setmembertitles.php"><table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center">
<input type=hidden name="action" value="doadd">
$hidden
	<tr>
		<th class="thHead" colspan="2">$lang[Ranks_title]</th>
	</tr>
	<tr class="gen">
		<td class="row2">$lang[Rank_title]</td>
		<td class="row2"><input class="post" type="text" name="title" size="25" maxlength="50" value="$title" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Rank_minimum]</td>
		<td class="row1"><input type="text" name="min_posts" size="5" maxlength="10" value="$min_posts" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Rank_image]<br /><span class="gensmall">$lang[Rank_image_mes]</span></td>
		<td class="row2"><input class="post" type="text" maxlength="40" size="60" name="rank_image" value="$rank_image" /></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input class="mainoption" type="submit" value="$lang[Save]" />&nbsp;&nbsp;<input type="reset" value="$lang[Back]" class="liteoption" /></td>
	</tr>
</table></form> 
DATA;
?>