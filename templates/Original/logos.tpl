<?
@include('./data/banners.php');
$counters = null;
@include('./data/counters.php');
$loginact = ($exbb['reged']) ? '| <a href="loginout.php?action=logout" title="'.$lang['Logout'].'">'.$lang['Logout'].'</a> | <a href="profile.php" title="'.$lang['Yor_profile'].'">'.$lang['Yor_profile'].'</a> | <a href="messenger.php" target="_blank" title="'.$lang['PM_tit'].'">'.$lang['PM'].'</a> |' : '| <a href="loginout.php" title="'.$lang['Login'].'">'.$lang['Login'].'</a> | <a href="register.php" title="'.$lang['Registration'].'">'.$lang['Registration'].'</a> | <a href="profile.php?action=lostpassword" title="'.$lang['Forgotten_password'].'">'.$lang['Forgotten_password'].'</a> |';
echo <<<DATA
$banner
<a name="top"></a>
<table width="100%" align="center" cellspacing="1" cellpadding="0" border="0">
<tr><td>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
<td align="center">
<table width="95%" cellspacing="0" cellpadding="0" border="0">
<tr> 
<td><a href="index.php"><img src="./im/logo_ExBB.gif" border="0" alt="$lang[Forum_index]" vspace="1" /></a></td>
<td align="center" width="100%" valign="middle"><span class="maintitle">$exbb[boardname]</span><br /><font face="arial" color="#000099"><span class="gentext">$exbb[boarddesc]<br />&nbsp;</span></font></td></tr>
</table>
<br></td></tr>
<tr> 
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr height="22">
<td background="./templates/Original/im/left_up.gif" class="mainmenu" align="right">| <a href="help.php" title="$lang[Help]">$lang[Help]</a> | <a href="search.php" title="$lang[Search]">$lang[Search]</a> | <a href="search.php?action=members" title="$lang[Users]">$lang[Users]</a> |</td></tr>
<tr height="38">
<td background="./templates/Original/im/left_down.gif">&nbsp;</td></tr>
</table></td>
<td width="142" align="center"><img src="./templates/Original/im/center.gif"></td>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr height="38">
<td background="./templates/Original/im/right_up.gif" valign="middle"></td></tr>
<tr height="22">
<td background="./templates/Original/im/right_down.gif"class="mainmenu" align="left">$loginact</td></tr>
</table></td></tr>
</table></td></tr>
</table></td></tr>
</table>
DATA;
?>