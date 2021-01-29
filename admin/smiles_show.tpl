<?
echo <<<DATA
<h1>$lang[smiley_title]</h1>

<form method="post" action="smiles.php"><table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
<input type="hidden" name="action" value="add" />
	<tr>
		<th class="thCornerL">$lang[code]</th>
		<th class="thTop">$lang[smile]</th>
		<th class="thTop">$lang[smile_desc]</th>
		<th colspan="2" class="thCornerR">$lang[smile_do]</th>
	</tr>
	$datashow
	<tr>
		<td class="catBottom" colspan="5" align="center"><input type="submit" name="add" value="$lang[smile_addnew]" class="mainoption" /></td>
	</tr>
</table></form>  
DATA;
?>