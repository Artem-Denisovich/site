<?
$board_data .= ($catrow) ? '<tr class="catname"><td class="tab_down" colspan="5" height="29" background="./templates/Original/im/bg.gif"><b><a href="index.php?c='.$in_cat.'"><font color=#000000>'.$category.'</font></a></b></td></tr>' : '';
$board_data .= <<<DATA
<tr class="catname">
<td class="tab_right_down" align=center>$folderpicture</td>
<td class="tab_right_down" align="left"><b>$forumname</b><br><span class="dats">$forumdescription</span>
<span class="moder"><br>$lang_moder $modoutput</span></td>
<td class="tab_right_down" align="center" valign=middle>$posts</td>
<td class="tab_right_down" align="center" valign=middle>$threads</td>
<td class="tab_down" align=left valign=middle><span class="dats">$lang[Date] <b>$forumlastpost</b> $private</span>
</td></tr>
DATA;
?>