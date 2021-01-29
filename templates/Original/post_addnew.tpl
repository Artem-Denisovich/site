<?
include('./templates/Original/form_code.tpl');

$poll_html = null;
if ($set_poll) {

$poll_html = <<<POLL
<tr class="catname">
<td class="tab_down" align=center valign=middle colspan=2 background="./templates/Original/im/bg.gif"><b>$lang[Poll_create]</b></td>
</tr>
<tr class="dats">
<td valign=middle><b>$lang[Question]</b></td>
<td valign=middle><input class="tab" type=text name="pollname" style="width:450px" size=40 maxlength=255  value="$vars[pollname]"></td>
</tr>
<tr class="dats">
<td class="tab_down" valign=middle><b>$lang[Poll_chces]:</b><br>$lang[Poll_chces_mes]<br>$lang[Poll_max]</td>
<td class="tab_down" valign=middle><textarea class="tab" name="pollansw" style="width:380px" rows="10" cols="35" wrap="soft">$vars[pollansw]</textarea></td>
</tr>
POLL;

}

echo <<<DATA
$java
<script language="Javascript" src="templates/Original/codes.js"></script>

$preview_data

<table width="95%" cellspacing="2" cellpadding="2" border="0" align="center" class="tab">
<tr>
<td height="22" class="small"><a href="index.php">$exbb[boardname]</a> &raquo; <a href="forums.php?forum=$vars[forum]">$forumname</a></td>
</tr>
</table>

<br>
<table cellpadding=0 cellspacing=0 border=0 width="95%" align=center>
<form name=postform action="post.php" method=post onSubmit="SubmitControl(this)"$enctype>
<input type=hidden name="action" value="addnew">
<input type=hidden name="forum" value="$vars[forum]">
$hidden
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width=100% class="tab">
<tr class="forumline">
<td class="tab_down" align="center" valign=middle colspan=2 height="29" background="./templates/Original/im/tab_bg1.gif"><span class="catname"><b>$lang[add_topic]</b></soan></td>
</tr>
<tr class="dats">
<td class="tab_down" align="left" valign=middle colspan=2>$startthreads</td>
</tr>
<tr class="dats">
<td valign=middle><b>$lang[Name]</b></td>
<td valign=middle><b>$exbb[member]</b>$reg</td>
</tr>
<tr class="dats">
<td valign=middle nowrap><b>$lang[Topic_name]</b></td>
<td valign=middle nowrap><input class="tab" type=text name="intopictitle" style="width:450px" tabindex="1" size=40 maxlength=255  value="$vars[intopictitle]"></td>
</tr>
<tr class="dats">
<td class="tab_down" valign=middle><b>$lang[Topic_desc]</b></td>
<td class="tab_down" valign=middle><input class="tab" type=text name="intopicdescription" tabindex="2" style="width:450px" size=40 maxlength=160 value="$vars[intopicdescription]"></td>
</tr>
$poll_html
<tr class="dats">
<td valign=middle><b>$lang[Message]</b><p>$emoticonslink</td>
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
$sig_show $requestnotify $emoticonsbutton $sticked
<b>$lang[Preview_before]</b><input class="tab" name="previewfirst" type="radio" value="yes"> $lang[yes] &nbsp; <input class="tab" name="previewfirst" type="radio" value="no" checked>$lang[no]<br>$filetoup
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
<table cellpadding=2 cellspacing=0 border=0 width=100% class="tab_left_right_down">
<tr class="dats">
<td valign=middle colspan=2 align=center height="22" background="./templates/Original/im/tab_bg.gif">
<input class=tab type=Submit value=$lang[Sent] name="Submit" tabindex="4" onClick="return Formchecker(this.form)"> &nbsp; <input class=tab type="reset" name="Clear" tabindex="5">
</td>
</tr>
</table>
</td>
</tr>
</form>
</table>
<p>
DATA;
?>