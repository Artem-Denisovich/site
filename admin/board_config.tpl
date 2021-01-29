<?
echo <<<DATA

<h1>$lang[General_Config]</h1>

<form action="setvariables.php" method="post"><table width="99%" cellpadding="4" cellspacing="1" border="0" align="center" class="forumline">
<input type=hidden name="save" value="1">
	<tr>
	  <th class="thHead" colspan="2">$lang[General_Config]</th>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Server_name]</td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="40" name="boardurl" value="$new_exbb[boardurl]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Full_path]<br /><span class="gensmall">$lang[Full_path_mes]</span></td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="40" name="home_path" value="$new_exbb[home_path]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Forum_name]</td>
		<td class="row2"><input class="post" type="text" size="25" maxlength="100" name="boardname" value="$new_exbb[boardname]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Forum_desc]</td>
		<td class="row2"><input class="post" type="text" size="40" maxlength="255" name="boarddesc" value="$new_exbb[boarddesc]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Allow_news]</td>
		<td class="row2"><input type="radio" name="announcements" value="1" $news_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="announcements" value="0" $news_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Files_perm]</td>
		<td class="row2"><input class="post" type="text" size="8" maxlength="4" name="ch_files" value="$ch_files" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Dirs_perm]</td>
		<td class="row2"><input class="post" type="text" size="8" maxlength="4" name="ch_dirs" value="$ch_dirs" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Ru_nicks]</td>
		<td class="row2"><input type="radio" name="ru_nicks" value="1" $ru_nicks_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="ru_nicks" value="0" $ru_nicks_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[reg_simple]<br /><span class="gensmall">$lang[reg_simple_mes]</span></td>
		<td class="row2"><input type="radio" name="reg_simple" value="1" $reg_smpl_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="reg_simple" value="0" $reg_smpl_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Default_language]</td>
		<td class="row2">$langs_select</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Default_style]</td>
		<td class="row2">$style_select</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Membergone]</td>
		<td class="row2"><input class="post" type="text" size="3" maxlength="3" name="membergone" value="$new_exbb[membergone]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Enable_gzip]<br /><span class="gensmall">$lang[Enable_gzip_mes]</span></td>
		<td class="row2"><input type="radio" name="gzip_compress" value="1" $gzip_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="gzip_compress" value="0" $gzip_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Forum_log]</td>
		<td class="row2"><input type="radio" name="log" value="1" $log_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="log" value="0" $log_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Board_disable]<br /><span class="gensmall">$lang[Board_disable_mes]</span></td>
		<td class="row2"><input type="radio" name="board_closed" value="1" $board_disable_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="board_closed" value="0" $board_disable_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Board_disable_con]</td>
		<td class="row2"><textarea class="post" type="text" cols='60' rows='5' wrap='soft' name="board_closed_mes">$new_exbb[board_closed_mes]</textarea></td>
	</tr>
	<tr>
		<th class="thHead" colspan="2">$lang[Privmsg]</th>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Privmsg]<br /><span class="gensmall">$lang[Privmsg_mes]</span></td>
		<td class="row2"><input type="radio" name="pm" value="1" $pm_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="pm" value="0" $pm_no /> $lang[no]</td>
	</tr>
	<tr>
		<th class="thHead" colspan="2">$lang[Abilities_settings]</th>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Text_menu]</td>
		<td class="row2"><input type="radio" name="text_menu" value="1" $txtmenu_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="text_menu" value="0" $txtmenu_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Allow_Codes]</td>
		<td class="row2"><input type="radio" name="exbbcodes" value="1" $exbbcodes_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="exbbcodes" value="0" $exbbcodes_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Allow_smilies]</td>
		<td class="row2"><input type="radio" name="emoticons" value="1" $emoticons_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="emoticons" value="0" $emoticons_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Show_ratings]</td>
		<td class="row2"><input type="radio" name="ratings" value="1" $ratings_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="ratings" value="0" $ratings_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Censoring]</td>
		<td class="row2"><input type="radio" name="wordcensor" value="1" $censoring_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="wordcensor" value="0" $censoring_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Files_upload]<br /><span class="gensmall">$lang[Files_upload_mes]</span></td>
		<td class="row2"><input type="radio" name="file_upload" value="1" $file_upload_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="file_upload" value="0" $file_upload_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Memb_upload]<br /><span class="gensmall">$lang[Memb_upload_mes]</span></td>
		<td class="row2"><input type="radio" name="autoup" value="1" $autoup_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="autoup" value="0" $autoup_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Allow_sig]</td>
		<td class="row2"><input type="radio" name="sig" value="1" $sig_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="sig" value="0" $sig_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Max_sig_length]<br /><span class="gensmall">$lang[Max_sig_length_mes]</span></td>
		<td class="row2"><input class="post" type="text" maxlength="4" size="5" name="max_sig_chars" value="$new_exbb[max_sig_chars]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Max_sig_lines]</td>
		<td class="row2"><input class="post" type="text" maxlength="2" size="5" name="max_sig_lin" value="$new_exbb[max_sig_lin]" /></td>
	</tr>
	<tr>
		<th class="thHead" colspan="2">$lang[Avatars_settings]</th>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Allow_local]</td>
		<td class="row2"><input type="radio" name="avatars" value="1" $avatars_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="avatars" value="0" $avatars_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[avatar_upload]</td>
		<td class="row2"><input type="radio" name="avatar_upload" value="1" $avatars_up_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="avatar_upload" value="0" $avatars_up_no /> $lang[no]</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[avatar_size]</td>
		<td class="row2"><input class="post" type="text" size="4" maxlength="10" name="avatar_size" value="$new_exbb[avatar_size]" /> Bytes</td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[avatar_pix]</td>
		<td class="row2"><input class="post" type="text" size="3" maxlength="4" name="avatar_max_height" value="$new_exbb[avatar_max_height]"> x <input class="post" type="text" size="3" maxlength="4" name="avatar_max_width" value="$new_exbb[avatar_max_width]" /></td>
	</tr>
	<tr>
		<th class="thHead" colspan="2">$lang[Email_settings]</th>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Admin_email]</td>
		<td class="row2"><input class="post" type="text" maxlength="100" size="55" name="adminemail" value="$new_exbb[adminemail]" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Board_email]<br /><span class="gensmall">$lang[Board_email_mes]</span></td>
		<td class="row2"><input type="radio" name="emailfunctions" value="1" $emails_yes /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="emailfunctions" value="0" $emails_no /> $lang[no]</td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="$lang[Save]" class="mainoption" /></td>
	</tr>
</table></form>
<br clear="all" />
DATA;
?>