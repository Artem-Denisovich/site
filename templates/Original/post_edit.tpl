<?
include('./templates/Original/form_code.tpl');

$poll_html = null;

if ($is_poll && $inmembmod) {
$poll_html = <<<POLL
<br>
<table cellpadding=0 cellspacing=0 border=0 width="95%" align=center>
<form name=postform action="postings.php" method="POST">
<input type=hidden name="action" value="poll">
<input type=hidden name="forum" value="$inforum">
<input type=hidden name="topic" value="$intopic">
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width=100% class="tab">
<tr class="forumline">
<td class="tab_down" align=center valign=middle colspan=2 height="29" background="./templates/Original/im/tab_bg1.gif"><span class="catname"><b>$lang[Poll_edit]</b></span></td>
</tr>
<tr class="dats">
<td valign=middle><b>$lang[Question]</b></td>
<td valign=middle><input class="tab" type=text name="pollname" style="width:450px" size=40 maxlength=255  value="$vars[pollname]"></td>
</tr>
<tr class="dats">
<td valign=middle><b>$lang[Poll_chces]:</b><br>$lang[Poll_chces_mes]<br>$lang[Poll_max]<br>$lang[Poll_edit_mes]</td>
<td valign=middle><textarea class="tab" name="pollansw" style="width:380px" rows="10" cols="35" wrap="soft">$vars[pollansw]</textarea><br>
<input class="tab" type=checkbox name="respoll" value="yes">$lang[reset] <br>
<input class="tab" type=checkbox name="delpoll" value="yes">$lang[Poll_del]
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<table cellpadding=2 cellspacing=0 border=0 width=100% class="tab_left_right_down">
<tr class="catname">
<td align=center valign=middle colspan=2 height="22" background="./templates/Original/im/tab_bg.gif"><input class=tab type=Submit value=$lang[Sent] name="editpoll"></td>
</tr>
</table>
</td>
</tr>
</form>
</table>
POLL;
}

echo <<<DATA
$java
<script language="Javascript" src="templates/Original/codes.js"></script>
<table width="95%" cellspacing="2" cellpadding="2" border="0" align="center" class="tab">
<tr>
<td height="22" class="small"><a href="index.php">$exbb[boardname]</a> &raquo; <a href="forums.php?forum=$vars[forum]">$forumname</a></td>
</tr>
</table>
$preview_data
$poll_html
<br>
<table cellpadding=0 cellspacing=0 border=0 width="95%" align=center>
<form name=postform action="postings.php" method="POST" onSubmit="SubmitControl(this)"$enctype>
<input type=hidden name="action" value="processedit">
<input type=hidden name="id" value="$id:$in_file:$in_page">
<input type=hidden name="forum" value="$inforum">
<input type=hidden name="topic" value="$intopic">
$hidden
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width=100% class="tab">
<tr class="forumline">
<td class="tab_down" colspan=2 valign=middle height="29" background="./templates/Original/im/tab_bg1.gif"><span class="dats">$lang[Topic]: $topictitle</span></td>
</tr>
<tr class="dats">
<td valign=top><b>$lang[Message]</b><p>$emoticonslink</td>
<td valign="top">
  <table width="450" border="0" cellspacing="0" cellpadding="2">
     $form_code
	 <tr>
        <td colspan="9"><textarea name="inpost" style="width:600px" cols="60" rows="15" wrap="virtual" tabindex=1 class="tab" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">$rawpost</textarea><br>$smilesmap</td>
     </tr>
  </table>
</td>
</tr>
<tr class="dats">
<td valign=middle><b>$lang[Options_msg]</b></td>
<td valign=middle>$sig_show $emoticonsbutton<b>$lang[Preview_before]</b><input class="tab" name="previewfirst" type="radio" value="yes"> $lang[yes] &nbsp; <input class="tab" name="previewfirst" type="radio" value="no" checked>$lang[no]<br />$filetoup
</td>
</tr>
DATA;
if ($inmembmod) {
echo <<<DATA
<tr class="dats">
<td valign=middle><b>$lang[Admin_options]</b></td>
<td valign=middle>
<input class="tab" type=checkbox name="deletepost" value="yes">$lang[Delete_post]<br>
$lang[Admin_notice]<br><TEXTAREA class="tab" cols=60 name=mo_edit rows=3 wrap=VIRTUAL>$mo_edit</TEXTAREA><br>
<input class="tab" type=checkbox name="lockedit" value="1"$lockedit>$lang[do_block_ed]
</td>
</tr>
DATA;
}
echo <<<DATA
</table>
</td>
</tr>
<tr>
<td>
<table cellpadding=2 cellspacing=0 border=0 width=100% class="tab_left_right_down">
<tr class="dats">
<td valign=middle colspan=2 align=center height="22" background="./templates/Original/im/tab_bg.gif"><input class=tab type=Submit value=$lang[Sent] name="Submit" tabindex="4" onClick="return Formchecker(this.form)"> &nbsp; <input class=tab type="reset" name="Clear" tabindex="5">
</td>
</tr>
</table>
</td>
</tr>
</form>
</table>
DATA;
?>