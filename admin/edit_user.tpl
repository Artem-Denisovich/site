<?
echo <<<DATA

<h1>$lang[User_admin]</h1>
<p class="genmed">$lang[Editing_name] <b>$inuser[name]</b> (ID: $user_id)</p>

<form action="setmembers.php" method="post">
  <input type=hidden name="action" value="edit_user">
  <input type=hidden name="checkaction" value="yes">
  <input type=hidden name="userid" value="$user_id">
<table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
	<tr>
	  <th class="thHead" colspan="2">$lang[General]</th>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[User_title]</td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="50" name="membertitle" value="$inuser[title]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[you_email]</td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="50" name="emailaddress" value="$inuser[mail]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[New_name]<br /><span class="gensmall">$lang[New_name_notice]</span></td>
		<td class="row2"><input class="post" type="text" maxlength="60" size="50" name="newname" value="$inuser[name]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[New_password]<br /><span class="gensmall">$lang[New_pass_notice]</span></td>
		<td class="row2"><input class="post" type="text" maxlength="32" size="35" name="password" value="" /></td>
	</tr>
	<tr>
		<th class="thHead" colspan="2">$lang[Profile]</th>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[www]</td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="50" name="homepage" value="$inuser[www]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[aol]</td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="50" name="aolname" value="$inuser[aim]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[icq]</td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="20" name="icqnumber" value="$inuser[icq]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[From]:</td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="20" name="location" value="$inuser[location]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Interests]</td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="50" name="interests" value="$inuser[interests]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Signature]</td>
		<td class="row2"><textarea style="width: 300px" name="signature" cols="40" rows="5" class="post">$inuser[sig]</textarea></td>
	</tr>
	<tr>
		<th class="thHead" colspan="2">$lang[Board_opt]</th>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Can_upload]</td>
		<td class="row2"><input type="checkbox" name="doupload" $checked>$lang[Can_upload_mes]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Replies]:</td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="50" name="numberofposts" value="$inuser[posts]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Avatar]</td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="50" name="avatar" value="$inuser[avatar]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Private_forums]<br /><span class="gensmall">$lang[Private_notice]</span></td>
		<td class="row2">$privateoutput</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Membsts]</td>
		<td class="row2">$dataout</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Removing]</td>
		<td class="row2"><input type="checkbox" name="deleteuser">$lang[Removing_mes]</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="$lang[Sent]" class="mainoption" /></td>
	</tr>
</table></form>
DATA;
?>