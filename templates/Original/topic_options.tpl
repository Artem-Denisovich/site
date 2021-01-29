<?
$mod_options = <<<DATA
<table cellspacing=3 cellpadding=0 width=$exbb[tablewidth] align=center>
<tr><td valign=middle nowrap align=right class="dats">
<form method='post' name='mod' action='postings.php'>
  <input type='hidden' name='forum' value='$inforum'>
  <input type='hidden' name='topic' value='$intopic'>
<select name='action' class='input' style="font-weight:bold;color:blue">
  <option value='-1' style='color:black'>$lang[Topic_options]</option>
  <option value='edittopic'>$lang[Edit_title]</option>
  <option value='$do'>$lang[Unlock]</option>
  $pin
  <option value='delete'>$lang[Delete]</option>
  <option value='top_recount'>$lang[top_recount]</option>
  <option value='movetopic'>$lang[Move]</option>
  <option value='trackers'>$lang[Del_trackers]</option>
  <option value='restore'>$lang[top_recover]</option>
</select>
&nbsp;<input type='submit' value='Go!' class='forminput' />
</form>
</td></tr></table>
DATA;
?>