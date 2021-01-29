<?
echo <<<DATA
<form action="postings.php" method="post" name="postform" onsubmit="return checkForm(this)">
    <input type=hidden name="action" value="edittopic">
    <input type=hidden name="checked" value="yes">
    <input type=hidden name="forum" value="$inforum">
    <input type=hidden name="topic" value="$intopic">
<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
		<td align="left"><span  class="nav"><a href="index.php" class="nav">$exbb[boardname]</a>
		-> $lang[Edit_title]</span></td>
	</tr>
</table>
<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
	<tr> 
		<th class="thHead" colspan="2" height="25"><b>$lang[Edit_title]</b></th>
	</tr>
	<tr> 
	  <td class="row1" width="22%"><span class="gen"><b>$lang[Topic_name]</b></span></td>
	  <td class="row2" width="78%"> <span class="gen"> 
		<input type="text" name="intopictitle" size="45" maxlength="255" style="width:450px" tabindex="1" class="post" value="$old_topictitle" />
		</span></td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen"><b>$lang[Topic_desc]</b></span></td>
	  <td class="row2"> <span class="gen"> 
		<input type="text" name="intopicdescription" size="45" maxlength="160" style="width:450px" tabindex="2" class="post" value="$old_topicdescription" />
		</span> </td>
	</tr>
	<tr> 
	  <td class="catBottom" colspan="2" align="center" height="28"><input type="submit" tabindex="3" name="Submit" class="mainoption" value="$lang[Sent]" />&nbsp;<input type="reset" tabindex="4" name="$lang[Clear]" class="mainoption" /></td>
	</tr>
  </table>
</form>
DATA;
?>