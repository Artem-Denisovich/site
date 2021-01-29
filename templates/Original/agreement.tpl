<?
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
<br>
<table cellpadding=0 cellspacing=0 border=0 width="95%" align=center>
<form action="register.php?$exbb[sesid]" method="post">
<input name="action" type="hidden" value="agreed">
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 class="tab">
<tr class="forumline">
<td class="tab_down" colspan=2 align=center height="29" background="./templates/Original/im/tab_bg1.gif"><span class="big"><b>$lang[Agr_terms]</b></span></td>
</tr>
<tr class="normal">
<td>$lang[Reg_agreement]</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="2" border="0" class="tab_left_right_down">
<tr class="normal">
<td align=center height="22" background="./templates/Original/im/tab_bg.gif"><input class="tab" type="submit" value="$lang[I_agreed]"></b></td>
</tr>
</table>
</td>
</tr>
</form>
</table>
DATA;
?>