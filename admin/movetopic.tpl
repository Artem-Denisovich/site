<?
echo <<<DATA
<form action="postings.php" method="post" name="postform" onsubmit="return checkForm(this)">
    <input type=hidden name="action" value="movetopic">
    <input type=hidden name="checked" value="yes">
    <input type=hidden name="forum" value="$inforum">
    <input type=hidden name="topic" value="$intopic">
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="left"><span  class="nav"><a href="index.php" class="nav">$exbb[boardname]</a>
		-> $lang[Topic_moving]</span></td>
	</tr>
</table>
<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
		<th class="thHead" colspan="2" height="25"><b>$lang[Topic_moving]</b></th>
	</tr>
	<tr> 
	  <td class="row1" width="22%"><span class="gen"><b>$lang[Move_options]</b></span></td>
	  <td class="row2" width="78%"><span class="gen"> 
		<input name="leavemessage" type="radio" value="yes" checked> $lang[Stay_blocked]<br><input name="leavemessage" type="radio" value="no"> $lang[Top_delete]
		</span></td>
	</tr>
	<tr> 
	  <td class="row1" width="22%"><span class="gen"><b>$lang[Move_in]</b></span></td>
	  <td class="row2" width="78%"><span class="gen"><select name="movetoid">$jumphtml</select></span></td>
	</tr>
	<tr> 
	  <td class="catBottom" colspan="2" align="center" height="28"><input type="submit" tabindex="3" name="Submit" class="mainoption" value="$lang[Sent]" /></td>
	</tr>
  </table>
</form>
DATA;
?>