<?
include('./templates/Original/form_code.tpl');

echo <<<DATA
$java
<script language="Javascript" src="templates/Original/codes.js"></script>
<br>
<table cellpadding=0 cellspacing=0 border=0 width="95%" align=center>
<form name=postform action="messenger.php" method=post>
<input type=hidden name="action" value="send">
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width=100% class="tab">
<tr class="forumline">
<td class="tab_down" colspan=2 valign=middle align=center height="29" background="./templates/Original/im/tab_bg1.gif"><span class="big"><b>$lang[Message_sending]</b></span></td>
</tr>
<tr>
<td class="tab_down" valign=middle align=center colspan=2><a href="messenger.php?action=inbox"><img src="./templates/Original/im/$exbb[default_lang]/inboxpm.gif" border=0></a> &nbsp; <a href="messenger.php?action=outbox"><img src="./templates/Original/im/$exbb[default_lang]/outboxpm.gif" border=0></a> &nbsp; <a href="messenger.php?action=new"><img src="./templates/Original/im/$exbb[default_lang]/newpm.gif" border=0></a></td>
</tr>
<tr class="normal">
<td class="tab_down" colspan=2 align=center background="./templates/Original/im/bg.gif"><b>$lang[PM_fill]</b></td>
</tr>
<tr class="normal">
<td valign=middle><b>$lang[PM_for_user]</b></td>
<td valign=middle><input class="tab" type=text name="touser" value="$from" size=40></a></td>
</tr>
<tr class="normal">
<td valign=top width=30%><b>$lang[Message_title]</b></td>
<td valign=middle><input class="tab" type=text name="msgtitle" size=40 maxlength=80 value="$messagetitle"></td>
</tr>
<tr class="normal">
<td valign=top width=30%><b>$lang[Message_text]</b></td>
<td valign="top">
  <table width="450" border="0" cellspacing="0" cellpadding="2">
     $form_code
	 <tr>
        <td colspan="9"><textarea name="inpost" style="width:600px" cols="60" rows="15" wrap="virtual" tabindex=1 class="tab" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">$post</textarea><br>$smilesmap</td>
     </tr>
  </table>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<table cellpadding=2 cellspacing=0 border=0 width=100% class="tab_left_right_down">
<tr class="normal">
<td valign=middle colspan=2 align=center height="22" background="./templates/Original/im/tab_bg.gif">
<input class="tab" type=Submit value=$lang[Sent] name="Submit"> &nbsp; <input class="tab" type="reset" name="$lang[Clear]">
</td>
</tr>
</table>
</td>
</tr>
</form>
</table>
DATA;
?>