<?
echo <<<DATA

<h1>$lang[Edit_catname]</h1>

<form action="setforums.php" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
  <input type=hidden name="action" value="editcatname">
  <input type=hidden name="category" value="$incategory">
  <input type=hidden name="doedit" value="yes">
	<tr>
	  <th class="thHead" colspan="2">$lang[Edit_cat]</th>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[New_catname]</td>
		<td class="row2"><input class="post" type=text size=40 name="categoryname" value="$categoryname"></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="$lang[Save]" class="mainoption" /></td>
	</tr>
</table></form>
<br clear="all" />
DATA;
?>