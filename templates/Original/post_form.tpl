<?
include('./templates/Original/form_code.tpl');

$post_form = <<<DATA
<script language="Javascript" src="templates/Original/codes.js"></script>
<table cellpadding=0 cellspacing=0 border=0 width=95% align=center>
<form action='post.php' method='POST' name='postform' onSubmit='SubmitControl(this)'$enctype>
<input type=hidden name="action" value="addreply">
<input type=hidden name="forum" value="$inforum">
<input type=hidden name="topic" value="$intopic">
<input type=hidden name="previewfirst" value="no">
$hidden
<tr>
<td>
<table cellpadding=4 cellspacing=0 border=0 width=100% class="tab" align="center">
<tr class="forumline">
<td colspan="2" align="center" class="tab_down" height="29" background="./templates/Original/im/tab_bg1.gif"><span class="catname"><b>$lang[Message]</b></span></td>
</tr>
<tr class="dats">
<td valign=middle><b>$lang[Name]</b></td>
<td valign=middle><b>$exbb[member]</b>$reg</td>
</tr>
<tr class="dats">
<td valign=top><b>$lang[Message]</b><br><br>$lang[name_paste]<br>$lang[MS_paste]</td>
<td valign="top">
  <table width="450" border="0" cellspacing="0" cellpadding="2">
     $form_code
	 <tr>
        <td colspan="9"><textarea name="inpost" style="width:520px" cols="60" rows="15" wrap="virtual" tabindex=1 class="tab" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">$inpost</textarea><br>$smilesmap</td>
     </tr>
  </table>
</td>
</tr>
<tr class="dats">
<td valign=top><b>$lang[Options_msg]</b></td>
<td valign=top>$showsig<br>$requestnotify $emoticonsbutton $filetoup</td>
</tr>
</table>
<table cellpadding=2 cellspacing=0 border=0 width=100% align="center" class="tab_left_right_down">
<tr class="dats">
<td valign=middle align=center height="22" background="./templates/Original/im/tab_bg.gif">
<input class=tab type="submit" value="$lang[Sent]" name="submit" onClick="return Formchecker(this.form)"> &nbsp; <input class=tab type="reset" name="$lang[Clear]">
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