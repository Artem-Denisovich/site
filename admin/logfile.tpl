<?
echo <<<DATA
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead">$lang[Log]</th>
	</tr>
	<tr class="gen">
		<td class="row1" align="center"><textarea name="log" rows="15" cols="35" wrap="virtual" style="width:450px" tabindex="1" class="input">$log</textarea></td>
	</tr>
	<tr class="gen">
		<td class="catBottom" align="center"><a href="setmembers.php?action=log&m=1" class="nav">Очистить историю посещений</a></td>
	</tr>
</table>
DATA;
?>