<?
$ranksdata .= <<<DATA
	<tr class="genmed">
		<td class="$back_clr">$rang</td>
		<td class="$back_clr" align="center">$posts</td>
		<td class="$back_clr"><a href="setmembertitles.php?action=edit&amp;id=$id">$lang[Change]</a></td>
		<td class="$back_clr"><a href="setmembertitles.php?action=delete&amp;id=$id">$lang[Delete]</a></td>
	</tr>
DATA;
?>