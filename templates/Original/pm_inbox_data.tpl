<?
$inbox_data .= <<<DATA
<tr class="normal">
<td class="tab_right_down" align=center valign=middle>$from</td>
<td class="tab_right_down" align=center valign=middle><a href="messenger.php?action=read&msg=$date">$messagetitle</a></td>
<td class="tab_right_down" align=center valign=middle>$time</td>
<td class="tab_down" align=center valign=middle><span class="moder">$readstate</span></td>
</tr>
DATA;
?>