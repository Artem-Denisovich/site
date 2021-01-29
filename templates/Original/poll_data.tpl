<?
$pollch .= <<<POLL
<tr>
<td><span class="moder">$ptext</span></td>
<td>
<table cellspacing="0" cellpadding="0" border="0">
<tr>
<td><img src="./templates/Original/im/bar_l.gif" width="4" alt="" height="12" /></td>
<td><img src="./templates/Original/im/bar.gif" width="$width" height="12" alt="$percent" /></td>
<td><img src="./templates/Original/im/bar_r.gif" width="4" alt="" height="12" /></td>
</tr>
</table>
</td>
<td align="center"><b><span class="moder">&nbsp;$percent&nbsp;</span></b></td>
<td align="center"><span class="moder">[ $votes ]</span></td>
</tr>
POLL;
?>