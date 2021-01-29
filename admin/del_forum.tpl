<?
echo <<<DATA
<form action="setforums.php" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
  <input type="hidden" name="action" value="$delete">
  <input type="hidden" name="forum" value="$inforum">
	<tr>
	  <th class="thHead" colspan="2">$lang[Forum_delete]</th>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Move_contents]</td>
		<td class="row2"><select name="to_id"><option value="-1">$lang[Delete_all_posts]</option>
</select></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="$lang[Move_and_Delete]" class="mainoption" /></td>
	</tr>
</table></form>
<br clear="all" />
DATA;
?>