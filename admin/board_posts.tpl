<?
echo <<<DATA

<h1>$lang[Param_setup]</h1>

<form action="setvariables.php" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
  <input type=hidden name="action" value="posts">
  <input type=hidden name="save" value="1">
  <input type=hidden name="ch_files" value="$ch_files">
  <input type=hidden name="ch_dirs" value="$ch_dirs">
	<tr>
	  <th class="thHead" colspan="2">$lang[Param_setup]</th>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Topics_per_page]</td>
		<td class="row2"><input class="post" type="text" size="3" maxlength="4" name="topics_per_page" value="$new_exbb[topics_per_page]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Posts_per_page]</td>
		<td class="row2"><input class="post" type="text" size="3" maxlength="4" name="posts_per_page" value="$new_exbb[posts_per_page]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Hot_topic]</td>
		<td class="row2"><input class="post" type="text" size="3" maxlength="4" name="hot_topic" value="$new_exbb[hot_topic]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Show_location]</td>
		<td class="row2"><input type="radio" name="location" value="1" $loc_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="location" value="0" $loc_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Max_post_size]</td>
		<td class="row2"><input class="post" type="text" size="15" maxlength="8" name="max_posts" value="$new_exbb[max_posts]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Mail_from_posts]</td>
		<td class="row2"><input type="radio" name="mail_posts" value="1" $mpost_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="mail_posts" value="0" $mpost_no /> $lang[no]</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="$lang[Save]" class="mainoption" /></td>
	</tr>
</table></form>
<br clear="all" />
DATA;
?>