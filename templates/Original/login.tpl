<?
echo <<<DATA
<p>
<table width="95%" align="center" cellspacing="0" cellpadding="0" border="0" class="tab">
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="4" border="0">
<tr>
<td valign="middle" class="small">
<a href="index.php">$exbb[boardname]</a> &raquo; $lang[Login]
</td>
</tr>
</table>
</td>
</tr>
</table>
<br>
<table width="95%" cellpadding=0 cellspacing=1 border=0 align=center>
<form action="loginout.php" method="post">
<input type=hidden name="action" value="login">
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width=100% class="tab">
<tr class="catname">
<td class="tab_down" valign=middle colspan=2 align=center height=29 background=./templates/Original/im/tab_bg1.gif><b>$lang[Enter_info]</b></td>
</tr>
<tr class="dats">
<td valign=middle>$lang[Enter_name]</td>
<td valign=middle><input class="tab" type=text name="imembername" tabindex = "1" value="$exbb[member]" size="25" maxlength="40"> &nbsp; <a href="register.php" title="$lang[You_reged]">$lang[You_reged]</a></td>
</tr>
<tr class="dats">
<td valign=middle>$lang[Enter_pass]</td>
<td valign=middle><input class="tab" type=password name="ipassword" tabindex = "2" value="" size="25" maxlength="25"> &nbsp; <a href="profile.php?action=lostpass" title="$lang[Forgotten_password]">$lang[Forgotten_password]</a></td>
</tr>
</table>
<table cellpadding=2 cellspacing=0 border=0 width=100% class="tab_left_right_down">
<tr class="dats">
<td valign=middle align=center height="22" background="./templates/Original/im/tab_bg.gif"><input class="tab" type=submit name="submit" value="$lang[Login]"></td>
</tr>
</table>
</td>
</tr>
</form>
</table>
DATA;
?>