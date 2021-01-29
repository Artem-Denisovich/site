<?
echo <<<DATA

<h1>$lang[Censor]</h1>

<p class="gensmall">$lang[Censor_desc]</p>

<form action="setbadwords.php" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
<input type=hidden name="action" value="process">
	<tr>
	  <th class="thHead">$lang[Censor]</th>
	</tr>
	<tr class="gen">
		<td align="center" class="row2"><textarea class="post" type="text" cols='60' rows='6' wrap='virtual' name="wordarray">$bads</textarea></td>
	</tr>
	<tr>
		<td class="catBottom" align="center"><input type="submit" name="submit" value="$lang[Save]" class="mainoption" /></td>
	</tr>
</table></form>
<br clear="all" />
DATA;
?>