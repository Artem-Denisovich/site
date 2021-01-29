<?
$requirepass = ($requirepass) ? '<tr class="normal"><td class="tab_down" colspan="2" align=center><b>'.$lang['Reg_email_on'].'</td></tr>' : '<tr class="normal"><td class="tab_down"><b>'.$lang['Password'].'</b><br>'.$lang['Reg_email_off'].'</td><td class="tab_down"><input class="tab" type=text size=20 name="password"></td></tr>';

$avatarhtml = null;
if ($exbb['avatars']) { $avatarhtml = <<<AVATAR
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
   <img src="./im/avatars/$currentface" name="useravatars" width="64" height="64" border=0 hspace=15>
</td>
</tr>
AVATAR;
}
$anti_bot = ($exbb['anti_bot']) ? "<tr class='normal'>
<td class='tab_down'><b>$lang[Pers_code]</b><br><span class='moder'>$lang[Pers_broken]</span></td>
<td class='tab_down'>
<img src='regimage.php?$exbb[sesid]&i=1' border='0' alt='PersCode'>&nbsp;
<img src='regimage.php?$exbb[sesid]&i=2' border='0' alt='PersCode'>&nbsp;
<img src='regimage.php?$exbb[sesid]&i=3' border='0' alt='PersCode'>&nbsp;
<img src='regimage.php?$exbb[sesid]&i=4' border='0' alt='PersCode'>&nbsp;
<img src='regimage.php?$exbb[sesid]&i=5' border='0' alt='PersCode'>&nbsp;
<img src='regimage.php?$exbb[sesid]&i=6' border='0' alt='PersCode'>&nbsp;
</td>
</tr>
<tr class='normal'>
<td class='tab_down'><b>$lang[Pers_confirm]</b><br><span class='moder'>$lang[Pers_note]</span></td>
<td class='tab_down'><input class='tab' type='text' style='width: 130px' name='reg_code' size=13 maxlength='10'></td>
</tr>" : '';

echo <<<DATA
<p>
<table width="95%" align="center" cellspacing="0" cellpadding="0" border="0">
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="4" border="0" class="tab">
<tr>
<td valign="middle" class="small"><a href="index.php">$exbb[boardname]</a> &raquo; $lang[Registration]</td>
</tr>
</table>
</td>
</tr>
</table>
<p>
<table cellpadding=0 cellspacing=0 border=0 width="95%" align=center>
<form action="register.php?$exbb[sesid]" method=post name="creator">
<input type=hidden name=action value=addmember>
<tr>
<td>
<table width=100% cellpadding=4 cellspacing=0 border=0 class="tab">
<tr class="forumline">
<td class="tab_down" colspan="2" align=center height="29" background="./templates/Original/im/tab_bg1.gif"><span class="medium"><b>$lang[Reg_info]</b></span></td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[User_name]<span class="moder">$intern</span></b></td>
<td class="tab_down"><input class="tab" type=text style="width: 200px" size="35" maxlength="20" name="inmembername"></td>
</tr>
$requirepass
<tr class="normal">
<td class="tab_down"><b>$lang[you_email]</b><br><span class="moder">$lang[you_email_tru]</span></td>
<td class="tab_down"><input class="tab" type=text name="emailaddress" style="width: 200px" size=20 maxlength="255"></td>
</tr>
$anti_bot
DATA;
if ($exbb[reg_simple]) {
echo <<<DATA
<tr class="normal">
<td class="forumline" colspan="2" align=center><input type=submit value=$lang[Sent] name=submit></td>
</tr>
</table>
</td>
</tr>
</form>
</table>
DATA;
} else {
echo <<<DATA
<tr class="medium">
<td class="tab_down" colspan=2 align=center background="./templates/Original/im/bg.gif"><b>$lang[About_self] <span class="moder">($lang[Not_needed])</span></b></td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[icq]</b><br><span class="moder">$lang[icq_desc]</span></td>
<td class="tab_down"><input class="tab" type="text" style="width: 130px" name="icqnumber" size=13 maxlength="15"></td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[aol]</b><br><span class="moder">$lang[aol_desc]</span></td>
<td class="tab_down"><input class="tab" type=text style="width: 150px" name="aolname" size=20  maxlength="255"></td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[www] </b><br><span class="moder">$lang[www_desc]</span></td>
<td class="tab_down"><input class="tab" type=text style="width: 200px" name="homepage" size=20 maxlength="255" value="http://"></td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[From]</b><br><span class="moder">$lang[From_desc]</span></td>
<td class="tab_down"><input class="tab" type=text style="width: 200px" name="location" size=25 maxlength="100"></td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[Interests]</b><br><span class="moder">$lang[Interests_desc]</td>
<td class="tab_down"><input class="tab" type=text style="width: 200px" name="interests" size=25 maxlength="100"></td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[Signature]</b><br><span class="moder">$lang[Signature_desc]</span></td>
<td class="tab_down"><textarea class="tab" style="width: 300px" name="signature" cols="40" rows="5"></textarea></td>
</tr>
<tr class="medium">
<td class="tab_down" colspan=2 align=center background="./templates/Original/im/bg.gif"><b>$lang[Options]</b></td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[Show_email]</b><br><span class="moder">$lang[Show_email_desc]</span></td>
<td class="tab_down"><input class="tab" name="showemail" type="radio" value="yes"> $lang[yes] &nbsp; <input class="tab" name="showemail" type="radio" value="no" checked> $lang[no]</td>
</tr>
<tr class="normal">
<td class="tab_down"><b>$lang[Default_language]:</b></td>
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
<table width="100%" cellspacing="0" cellpadding="2" border="0" class="tab_left_right_down">
<tr class="normal">
<td colspan=2 align=center height="22" background="./templates/Original/im/tab_bg.gif"><input class="tab" type=submit value=$lang[Sent] name=submit></td>
</tr>
</table>
</td>
</tr>
</form>
</table>
DATA;
}
?>