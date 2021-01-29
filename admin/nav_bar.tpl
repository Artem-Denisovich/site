<?
echo <<<DATA
 
<table width="100%" cellpadding="4" cellspacing="0" border="0" align="center">
  <tr> 
	<td align="center" ><a href="index.php" target="_parent"><img src="./im/logo_ExBB.gif" border="0" /></a></td>
  </tr>
  <tr> 
	<td align="center" > 
	  <table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
		<tr> 
		  <th height="25" class="thHead"><b>$lang[Administrating]</b></th>
		</tr>
		<tr> 
		  <td class="row1"><span class="genmed"><a href="admincenter.php?action=main" target="main" class="genmed">$lang[Admin_Index]</a></span></td>
		</tr>
		<tr> 
		  <td class="row1"><span class="genmed"><a href="index.php" target="_parent" class="genmed">$lang[Forum_index]</a></span></td>
		</tr>
		<tr> 
		  <td height="28" class="catSides"><span class="cattitle">$lang[General]</span></td>
		</tr>
		<tr> 
		  <td class="row1"><span class="genmed"><a href="setvariables.php?action=main"  target="main" class="genmed">$lang[Configuration]</a></span> 
		  </td>
		</tr>
		<tr> 
		  <td class="row1"><span class="genmed"><a href="setvariables.php?action=secure"  target="main" class="genmed">$lang[Secure]</a></span> 
		  </td>
		</tr>
		<tr> 
		  <td class="row1"><span class="genmed"><a href="setvariables.php?action=posts"  target="main" class="genmed">$lang[Posts_setup]</a></span> 
		  </td>
		</tr>
		<tr> 
		  <td class="row1"><span class="genmed"><a href="setbadwords.php"  target="main" class="genmed">$lang[Word_Censor]</a></span> 
		  </td>
		</tr>
		<tr> 
		  <td class="row1"><span class="genmed"><a href="smiles.php"  target="main" class="genmed">$lang[Smilies]</a></span> 
		  </td>
		</tr>
		<tr> 
		  <td height="28" class="catSides"><span class="cattitle">$lang[Forum_admin]</span></td>
		</tr>
		<tr> 
		  <td class="row1"><span class="genmed"><a href="setforums.php"  target="main" class="genmed">$lang[Manage]</a></span> 
		  </td>
		</tr>
		<tr> 
		  <td height="28" class="catSides"><span class="cattitle">$lang[Users]</span></td>
		</tr>
		<tr> 
		  <td class="row1"><span class="genmed"><a href="setmembers.php"  target="main" class="genmed">$lang[Manage]</a></span> 
		  </td>
		</tr>
		<tr> 
		  <td class="row1"><span class="genmed"><a href="setmembers.php?action=updatecount"  target="main" class="genmed">$lang[Users_recount]</a></span> 
		  </td>
		</tr>
		<tr> 
		  <td class="row1"><span class="genmed"><a href="setmembertitles.php"  target="main" class="genmed">$lang[Ranks]</a></span> 
		  </td>
		</tr>
		<tr> 
		  <td class="row1"><span class="genmed"><a href="setmembers.php?action=massmail"  target="main" class="genmed">$lang[Mass_Email]</a></span> 
		  </td>
		</tr>
		<tr> 
		  <td class="row1"><span class="genmed"><a href="setmembers.php?action=log"  target="main" class="genmed">$lang[Log]</a></span> 
		  </td>
		</tr>
	  </table>
	</td>
  </tr>
</table>
<br />
DATA;
?>