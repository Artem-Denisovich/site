<?
$enctype = null;

$avatarhtml = '';
if ($exbb['avatars']) {
$avatarhtml = <<<AVATAR
<script language="javascript">
function showimage()
{
  document.images.useravatars.src="./im/avatars/"+document.creator.useravatar.options[document.creator.useravatar.selectedIndex].value;
}
</script>

<tr class="normal">
<td valign=top><b>$lang[Avatar]</b><br><span class="moder">$lang[Your_avatar]</span></td>
<td>
<select name="useravatar" size=6 onChange="showimage()">
$selecthtml
</select>
<img src="./im/avatars/$currentface" name="useravatars" width="64" height="64" border=0 hspace=15><br><input type="checkbox" name="noavatar">$lang[no_avatar]
</td>
</tr>
AVATAR;
if ($exbb['avatar_upload']) {

$avatarhtml .= <<<AVATAR
<tr class="normal">
<td valign=top><b>$lang[avatar_uploads]</b><br><span class="moder">$avatar_info</span></td>
<td>
<input class="input" type="file" size="30" name="FILE_UPLOAD">
</td>
</tr>
AVATAR;
$enctype = ' enctype="multipart/form-data"';
$hidden = '<input type="hidden" name="MAX_FILE_SIZE" value="'.$exbb['avatar_size'].'">';
}
}
echo <<<DATA
<p>
<table width="95%" align="center" cellspacing="0" cellpadding="1" border="0" class="tab">
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="4" border="0">
<tr>
<td valign="middle" class="small"><a href="index.php">$exbb[boardname]</a> &raquo; $lang[Yor_profile]</td>
</tr>
</table>
</td>
</tr>
</table>
<p>
<table cellpadding=0 cellspacing=0 border=0 width="95%" align=center>
<form action="profile.php" method=post name="creator"$enctype>
<input type=hidden name="action" value="process">
$hidden
<tr>
<td>
<table width="100%" cellpadding=4 cellspacing=0 border=0 class="tab">
<tr class="forumline">
<td class="tab_down" colspan=2 align=center height="29" background="./templates/Original/im/tab_bg1.gif"><span class="medium"><b>$lang[Profile_edit_for] <u>$exbb[member]</u></b></span></td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[Password]</b><br><span class="moder">$lang[Pass_enter] $newpassneeded</span></td>
<td class="tab_down"><input class="tab" type=text style="width: 200px" name="newpassword" size="25" maxlength="10"></td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[you_email]</b><br><span class="moder">$lang[you_email_tru] $newpassneededa</span></td>
<td class="tab_down"><input class="tab" type=text name="newemailaddress" style="width: 200px" size=20 maxlength="255" value="$emailaddress"></td>
</tr>
<tr class="medium">
<td class="tab_down" colspan=2 align=center background="./templates/Original/im/bg.gif"><b>$lang[About_self] <span class="moder">($lang[Not_needed])</span></b></td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[icq]</b><br><span class="moder">$lang[icq_desc]</span></td>
<td class="tab_down"><input class="tab" type="text" style="width: 130px" name="newicqnumber" size=13 maxlength="15" value="$icqnumber"></td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[aol]</b><br><span class="moder">$lang[aol_desc]</span></td>
<td class="tab_down"><input class="tab" type=text style="width: 150px" name="newaolname" size=20  maxlength="255" value="$aolname"></td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[www]</b><br><span class="moder">$lang[www_desc]</span></td>
<td class="tab_down"><input class="tab" type=text style="width: 200px"name="newhomepage" size=20 maxlength="255" value="$homepage"></td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[From]</b><br><span class="moder">$lang[From_desc]</span></td>
<td class="tab_down"><input class="tab" type=text style="width: 200px" name="newlocation" size=25 maxlength="100" value="$location"></td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[Interests]</b><br><span class="moder">$lang[Interests_desc]</span></td>
<td class="tab_down"><input class="tab" type=text style="width: 200px" name="newinterests" size=25 maxlength="100" value="$interests"></td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[Signature]</b><br><span class="moder">$lang[Signature_desc]</span></td>
<td class="tab_down"><textarea class="tab" style="width: 300px" name="newsignature" cols="40" rows="5" class="post">$signature</textarea></td>
</tr>
<tr class="medium">
<td class="tab_down" colspan=2 align=center background="./templates/Original/im/bg.gif"><b>$lang[Options]</b></td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[Show_email]</b><br><span class="moder">$lang[Show_email_desc]</span></td>
<td class="tab_down"><input class="tab" type="radio" name="newshowemail" value="yes"$showmyes />$lang[yes]&nbsp;&nbsp;<input class="tab" type="radio" name="newshowemail" value="no"$showmyno />$lang[no]</td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[Default_language]</b></td>
<td class="tab_down">$langs_select</td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[Skin_style]</b></td>
<td class="tab_down">$style_select</td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[timezone]</b><br>$lang[Curr_time] $basetimes<br><span class="moder">$lang[you_zone]</span></td>
<td class="tab_down">$timezones</td>
</tr>
$avatarhtml
</table>
</td>
</tr>
<tr>
<td>
<table width="100%" cellpadding=2 cellspacing=0 border=0 class="tab_left_right_down">
<tr class="normal">
<td colspan=2 align=center height="22" background="./templates/Original/im/tab_bg.gif"><input class="tab" type=submit value=$lang[Sent] name=submit></td>
</tr>
</table></td></tr></form></table>
DATA;
?>