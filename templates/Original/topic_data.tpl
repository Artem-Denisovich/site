<?
$topic_data .= <<<DATA
<tr>
<td colspan="2">
<table width=100% cellpadding=0 cellspacing=0 class="tab_down">
<tr>
<td bgcolor="#4A93F9" height="3"></td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<tr>
<td valign="top" width=400 rowspan=2 height="100%">
<table width=100% height="100%" cellpadding=4 cellspacing=0>
<tr>
<td class="top" valign="top">
<a name="$key">
<a href="javascript:pasteN('$username')"><b>$username</b></a>
<br>$useravatar
<br>$membergraphic
<br><span class="dats">$membertitle $location<br>$icq
<br><a href='javascript:scroll(0,0);'>$lang[On_top1]</a></span>
</td>
</tr>
</table>
</td>
<td valign=top width=90% height=100%>
<table width=100% cellpadding=3 cellspacing=0>
<tr>
<td width="100%" valign="middle" class="top"><span class="topc">$www $pm $prf $replygraphic</span></td>
<td valign="top" nowrap="nowrap" class="top"><span class="topc">$edit $del</span></td>
</tr>
<tr>
<td colspan=2 class="top"><hr size=1 width=100% color=#999999>$post</td>
</tr>
</table>
</td>
</tr>
<tr class=topc>
<td>
<table width=100% cellpadding=3 cellspacing=0>
<tr>
<td><hr size=1 width=100% color=#999999><span class="topc">$posts $joined $info</span></td>
</tr>
</table>
</td>
</tr>
</td>
</tr>
DATA;
?>