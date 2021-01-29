<?
$data .= <<<DATA
<tr class="catname">
<td class="tab_right_down" width=5% align=center>$topicicon</td>
<td class="tab_right_down"><b>$t_name</b><br><span class="dats">$t_desc</span></td>
<td class="tab_right_down" align='center'>$f_name</td>
<td class="tab_right_down" align=left valign=middle><span class="dats">$lang[replies] <b>$t_post</b>
<br>$lang[Topic_author] <a href="profile.php?action=show&member=$m_id"><b>$t_strt</b></a></span></td>
<td class="tab_down"><span class="dats">$p_date<br>$lang[Author] <a href="profile.php?action=show&member=$p_id"><b>$poster</b></a></span></td>
</tr>
DATA;
?>