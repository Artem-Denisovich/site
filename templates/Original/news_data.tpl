<?
if (defined('IS_ADMIN')) {
  $id = strval($id);
  $adm = '<tr class=moder><td class=forumline align=left><a href="announcements.php?action=delete&number='.$id.'">'.$lang['Delete'].'</a> - <a href="announcements.php?action=edit&number='.$id.'">'.$lang['Editing'].'</a></td></tr>';
}

$datashow .= <<<DATA
<table cellpadding=0 cellspacing=0 border=0 width="95%" class="tab" align=center>
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width=100%>
<tr class="forumline">
<td class="tab_down" align="center" height="29" background="./templates/Original/im/tab_bg1.gif"><span class="catname"><b>$title</b></span></td></tr>
$adm
<tr class="text">
<td class="tab_down">$post<p></td></tr>
<tr>
<td class="dats" height="22" background="./templates/Original/im/tab_bg.gif">$lang[Post_date] <b>$dateposted</b></td></tr>
</table></td></tr>
</table>
<table cellpadding=0 cellspacing=0 border=0 width=100%>
<tr><td height="5"></td></tr></table>
DATA;
?>