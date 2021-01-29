<?
echo <<<DATA
<p>
<table width="95%" align="center" cellspacing="0" cellpadding="0" border="0">
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="4" border="0" class="tab">
<tr>
<td valign="middle" class="small"><a href="index.php">$exbb[boardname]</a>  &raquo; <a href="whosonline.php">$lang[Whosonline]</a></td>
</tr>
</table>
</td>
</tr>
</table>
<p>
<table cellpadding=0 cellspacing=0 border=0 width="95%" align=center>
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width=100% class="tab">
<tr class="forumline" style='height:28px'>
<td class="tab_down" colspan=3 align="center" height="29" background="./templates/Original/im/tab_bg1.gif"><span class="catname"><b>$lang[Whosonline]</b></span></td>
</tr>
<tr align="center" class="normal">
<td class="tab_right_down" height="22" background="./templates/Original/im/bg.gif"><b>$lang[Users_names]</b></td>
<td class="tab_right_down" background="./templates/Original/im/bg.gif"><b>$lang[Last_action_time]</b></td>
<td class="tab_down" background="./templates/Original/im/bg.gif"><b>$lang[Last_action]</b></td>
</tr>
$output
</table>
</td>
</tr>
</table>
DATA;
?>
