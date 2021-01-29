<?
include('./templates/Original/form_code.tpl');

echo <<<DATA
<script language="Javascript" src="templates/Original/codes.js"></script>
$java
$preview_data
<br>
<table width="95%" align="center" cellspacing="0" cellpadding="0" border="0">
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="4" border="0" class="tab">
<tr> 
<td align="left" class="small"><a href="index.php">$exbb[boardname]</a> &raquo; <a href="forums.php?forum=$vars[forum]">$forumname</a> &raquo; <a href="topic.php?forum=$inforum&topic=$intopic">$topic_name</a></td>
</tr>
</table>
</td>
</tr>
</table>
<br>
<table cellpadding=0 cellspacing=0 border=0 width="95%" align=center>
<form name=postform action="post.php" method="POST" onSubmit="SubmitControl(this)"$enctype>
<input type=hidden name="action" value="addreply">
<input type=hidden name="forum" value="$inforum">
<input type=hidden name="topic" value="$intopic">
$hidden
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width=100% class="tab">
<tr class="forumline">
<td class="tab_down" colspan=2 align="center" valign="middle" height="29" background="./templates/Original/im/tab_bg1.gif"><span class="frmtit"><b>$lang[add_post]</b></span></td>
</tr>
<tr class="dats">
<td valign=middle><b>$lang[Name]</b></td>
<td valign=middle><b>$exbb[member]</b>$reg</td>
</tr>
<tr class="dats">
<td valign=top><b>$lang[Message]</b><p>$emoticonslink<br>$lang[MS_paste]</td>
<td valign="top">
  <table width="450" border="0" cellspacing="0" cellpadding="2">
     $form_code
	 <tr>
        <td colspan="9"><textarea name="inpost" style="width:600px" cols="60" rows="15" wrap="virtual" tabindex=1 class="tab" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">$vars[inpost]</textarea><br>$smilesmap</td>
     </tr>
  </table>
</td>
</tr>
<tr class="dats">
<td valign=middle><b>$lang[Options_msg]</b></td>
<td valign=middle>
$sig_show $requestnotify $emoticonsbutton
<b>$lang[Preview_before]</b><input class="tab" name="previewfirst" type="radio" value="yes"> $lang[yes] &nbsp; <input class="tab" name="previewfirst" type="radio" value="no" checked>$lang[no]<br />$filetoup
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="2" border="0" class="tab_left_right_down">
<tr class="dats">
<td valign=middle colspan=2 align=center height="22" background="./templates/Original/im/tab_bg.gif"><input class=tab type=Submit value=$lang[Sent] name="Submit" tabindex="4" onClick="return Formchecker(this.form)"> &nbsp; <input class=tab type="reset" name="Clear" tabindex="5">
</td>
</tr>
</table>
</td>
</tr>
</form>
</table>
<p>
<table cellpadding=0 cellspacing=0 border=0 width="95%" align=center class="tab">
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width=100%>
<tr class="forumline">
<td class="tab_down" colspan=2 align="left" valign="middle" height="29" background="./templates/Original/im/tab_bg1.gif"><span class="frmtit"><b>$lang[Topic_review]: $topic_name ($lang[new_on_top])</b></span></td>
</tr>
 $topic_data
</table>
</table>
DATA;
?>