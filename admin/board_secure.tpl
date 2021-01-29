<?
echo <<<DATA

<h1>$lang[Secure_setup]</h1>

<form action="setvariables.php" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
  <input type=hidden name="action" value="secure">
  <input type=hidden name="save" value="1">
  <input type=hidden name="ch_files" value="$ch_files">
  <input type=hidden name="ch_dirs" value="$ch_dirs">
	<tr>
	  <th class="thHead" colspan="2">$lang[Secure_setup]</th>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Anti_bot]<br /><span class="gensmall">$lang[Anti_bot_nt]</span></td>
		<td class="row2" nowrap><input type="radio" name="anti_bot" value="1" $bot_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="anti_bot" value="0" $bot_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Registration_off]</td>
		<td class="row2"><input type="radio" name="reg_on" value="0" $reg_off /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="reg_on" value="1" $reg_on /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[User_activation]<br /><span class="gensmall">$lang[User_activation_mes]</span></td>
		<td class="row2"><input type="radio" name="passwordverification" value="0" $passverif_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="passwordverification" value="1" $passverif_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Show_img]<br /><span class="gensmall">$lang[Show_img_mes]</span></td>
		<td class="row2"><input type="radio" name="show_img" value="1" $img_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="show_img" value="0" $img_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[New_reg]</td>
		<td class="row2"><input type="radio" name="newusernotify" value="1" $newuser_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="newusernotify" value="0" $newuser_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Flood_Interval]<br /><span class="gensmall">$lang[Flood_Interval_mes]</span></td>
		<td class="row2"><input class="post" type="text" maxlength="4" size="5" name="flood_limit" value="$new_exbb[flood_limit]" /></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="$lang[Save]" class="mainoption" /></td>
	</tr>
</table></form>
<br clear="all" />
DATA;
?>