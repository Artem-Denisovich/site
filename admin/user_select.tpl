<?
echo <<<DATA

<h1>$lang[User_admin]</h1>
<p class="genmed">$lang[User_admin_info]</p>

<form method="post" name="post" action="setmembers.php">
<table width="80%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr> 
	  <th class="thHead">$lang[Select_user]</th>
	</tr> 
    <tr>
        <td class="row1" align="center">$inputfields</td>
    </tr>
</table></form>
DATA;
?>