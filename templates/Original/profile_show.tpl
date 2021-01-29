<?
echo <<<DATA
<p>
<table width="95%" align="center" cellspacing="0" cellpadding="1" border="0">
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="4" border="0" class="tab">
<tr>
<td valign="middle" class="small"><a href="index.php">$exbb[boardname]</a> &raquo; $lang[Check_profile]</td>
</tr>
</table>
</td>
</tr>
</table>
<br>
<table cellpadding=0 cellspacing=0 border=0 width="95%" align=center>
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width=100% class="tab">
<tr class="forumline">
<td class="tab_down" valign=middle colspan=2 align=center height="29" background="./templates/Original/im/tab_bg1.gif"><span class="catname">$lang[Profile_for] <b>$member</b></span></td>
</tr>
<tr>
<td class="dats" valign=middle width=30%><b>$lang[Reged_date]</b></td>
<td class="dats" valign=middle>$joineddate</td>
</tr>
<tr>
<td class="dats" valign=middle><b>$lang[Status]</b></td>
<td class="dats" valign=middle>$membertitle</td>
</tr>
<tr>
<td class="dats" valign=middle><b>$lang[Updates]:</b></td>
<td class="dats" valign=middle>$lastpostdetails</td>
</tr>
<tr>
<td class="dats" valign=middle><b>$lang[User_total_posts]</b></td>
<td class="dats" valign=middle>$numberofposts<br />[$percentage / $posts_per_day]</td>
</tr>
<tr>
<td class="dats" valign=middle><b>$lang[you_email]</b></td>
<td class="dats" valign=middle>$email_forum $emailaddress</td>
</tr>
<tr>
<td class="dats" valign=middle><b>$lang[www]</b></td>
<td class="dats" valign=middle>$homepage</td>
</tr>
<tr>
<td class="dats" valign=middle><b>$lang[aol]</b></td>
<td class="dats" valign=middle>$aolname</td>
</tr>
<tr>
<td class="dats" valign=middle><b>$lang[icq]</b></td>
<td class="dats" valign=middle>$icqnumber&nbsp; $icqlogo</td>
</tr>
<tr>
<td class="dats" valign=middle><b>$lang[From]:</b></td>
<td class="dats" valign=middle>$location</td>
</tr>
<tr>
<td class="dats" valign=middle><b>$lang[Interests]</b></td>
<td class="dats" valign=middle align=center>$interests</td>
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
<tr class="forumline">
<td class="tab_down" valign=middle colspan=3 align=center height="29" background="./templates/Original/im/tab_bg1.gif"><span class="catname"><b>$lang[User_stats]</b></span></td>
</tr>
<tr class="catname" valign=middle align=center>
<td class="tab_right_down" height="22" background="./templates/Original/im/bg.gif"><b>$lang[Forum]</b></td>
<td class="tab_right_down" background="./templates/Original/im/bg.gif"><b>$lang[Kol_vo]</b></td>
<td class="tab_down" background="./templates/Original/im/bg.gif"><b>$lang[in_proc]</b></td>
</tr>
$output
<tr class="catname" valign=middle align=center>
<td class="tab_right_up" height="22" background="./templates/Original/im/bg.gif"><b>$lang[Total]:</b></td>
<td class="tab_right_up" background="./templates/Original/im/bg.gif"><b>$countposts</b></td>
<td class="tab_right_up" background="./templates/Original/im/bg.gif"><b>100%</b></td>
</tr>
</table>
</td>
</tr>
</table>
DATA;
?>