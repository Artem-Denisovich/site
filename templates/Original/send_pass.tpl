<?
$perscode = null;
if (!$exbb['anti_bot']) {
$perscode = $_SESSION['reg_code'];
}

echo <<<FORM
<p>
<table cellpadding=0 cellspacing=0 border=0 width=95% align=center>
<form action="profile.php" method="post">
<input type=hidden name="action" value="sendpassword">
<tr>
<td class="formtd">
<table width=100% cellpadding=4 cellspacing=0 border=0 class="tab">
<tr class="forumline">
<td class="tab_down" colspan="2" align=center height="29" background="./templates/Original/im/tab_bg1.gif"><span class="medium"><b>$lang[Pass_req]</b></span></td>
</tr>
<tr class="normal">
<td><b>$lang[Enter_name_for_pass]</b></td>
<td><input class="tab" type=text style="width: 200px" size="35" maxlength="35" name="membername"></td>
</tr>
<tr class='normal'>
<td><b>$lang[Pers_code]</b><br><span class='moder'>$lang[Pers_broken]</span></td>
<td>
<img src='regimage.php?$exbb[sesid]&i=1' border='0' alt='PersCode'>&nbsp;
<img src='regimage.php?$exbb[sesid]&i=2' border='0' alt='PersCode'>&nbsp;
<img src='regimage.php?$exbb[sesid]&i=3' border='0' alt='PersCode'>&nbsp;
<img src='regimage.php?$exbb[sesid]&i=4' border='0' alt='PersCode'>&nbsp;
<img src='regimage.php?$exbb[sesid]&i=5' border='0' alt='PersCode'>&nbsp;
<img src='regimage.php?$exbb[sesid]&i=6' border='0' alt='PersCode'>&nbsp;
</td>
</tr>
<tr class='normal'>
<td><b>$lang[Pers_confirm]</b><br><span class='moder'>$lang[Pers_note]</span></td>
<td><input class="tab" type='text' style='width: 130px' name='reg_code' size=13 maxlength='10' value="$perscode"></td>
</tr>
</table>
<tr>
<td>
<table width=100% cellpadding=2 cellspacing=0 border=0 class="tab_left_right_down">
<tr class="normal">
<td colspan=2 align=center height="22" background="./templates/Original/im/tab_bg.gif"><input class="tab" type=submit value=$lang[Sent] name=submit></td>
</tr>
</table></td></tr></form></table>
FORM;
?>