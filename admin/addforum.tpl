<?
echo <<<DATA
<h1>$do</h1>
$safe_mode

<form action="setforums.php" method="post">
$hidden
  <table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr> 
	  <th class="thHead" colspan="2">$lang[Forum_addnew]</th>
	</tr>
	<tr class="gen"> 
	  <td class="row1">$lang[New_forum_incat]</td>
	  <td class="row2">$cathtml</td>
	</tr>
	<tr class="gen"> 
	  <td class="row1">$lang[Forum_name]</td>
	  <td class="row2"><input class="post" type="text" size="25" name="forumname" value="$forumname" class="post" /></td>
	</tr>
	<tr class="gen"> 
	  <td class="row1">$lang[Forum_desc]</td>
	  <td class="row2"><input type="text" size="40" name="forumdescription" value="$forumdescription"></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Forum_moders]<br /><span class="gensmall">$lang[Forum_moders_mes]</span></td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="40" name="forummoderator" value="$forummoderator" /></td>
	</tr>
	<tr class="gen"> 
	  <td class="row1">$lang[Exbb_code]</td>
	  <td class="row2"><select name="codestate">
        <option value="on" $codes_on>$lang[On]<option value="off" $codes_off>$lang[Off]</select></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Poll_enable]</td>
		<td class="row2"><input type="radio" name="polls" value="1" $polls_on /> $lang[yes]&nbsp;&nbsp;<input type="radio" name="polls" value="0" $polls_off /> $lang[no]</td>
	</tr>
	<tr class="gen"> 
	  <td class="row1">$lang[Make_private]</td>
	  <td class="row2"><select class="gen" name="privateforum">
        <option value="yes" $private_on>$lang[yes]<option value="no" $private_off>$lang[no]</select></td>
	</tr>
	<tr class="gen"> 
	  <td class="row1">$lang[Forum_permiss]</td>
	  <td class="row2"><select class="gen" name="startnewthreads">
        <option value="all" $access_all>$lang[All_guests]
        <option value="reged" $access_reged>$lang[All_reged]
        <option value="no" $access_no>$lang[Team_only]
        </select></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Upload_status]<br /><span class="gensmall">$lang[Upload_status_mes]</span></td>
		<td class="row2"><input class="post" type="text" maxlength="8" size="40" name="upsize" value="$upsize" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[Forum_pic]<br /><span class="gensmall">$lang[Forum_pic_mes]</span></td>
		<td class="row2"><input class="post" type="text" maxlength="255" size="40" name="forumgraphic" value="$forumgraphic" /></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input type="submit" name="submit" value="$button" class="mainoption" /></td>
	</tr>
</table></form>
<br clear="all" />
DATA;
?>