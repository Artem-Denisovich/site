<?
echo <<<DATA
<p>
<table cellpadding=0 cellspacing=0 border=0 width=$exbb[tablewidth] align=center>
<form action="printpage.php" method="get" name="search">
<input type="hidden" name="action" value="1">
<input type="hidden" name="forum" value="$vars[f]">
<input type="hidden" name="topic" value="$vars[t]">
<tr>
<td>
<table border=0 cellpadding=3 cellspacing=1 width=100% class="bodyform">
<tr class="frmtit"><th colspan=2 class="forumline">$lang[srch_intop]</th></tr>
<tr class="dats">
<td width=15% align=right class="forumline1">$lang[srch_text]:</td>
<td class="forumline2"><input type="text" name="post" style="width:450px" tabindex="1" size=40 maxlength=100><br>$lang[srch_param]:
<input type="radio" name="stype" tabindex="2" value="AND" title="$lang[srch_and]" checked>"and"
<input type="radio" name="stype" value="OR" title="$lang[srch_or]">"or"</td>
</tr>
<tr class="dats"><td align=right class="forumline1">$lang[srch_author]:</td>
<td class="forumline2"><input type="text" name="user" style="width:450px" tabindex="3" size=40 maxlength=50 class></td>
</tr>
<tr class="dats">
<td align=right class="forumline1">$lang[srch_options]:</td>
<td class="forumline2">
<input type="checkbox" name="color" tabindex="4" value="1" style="height=15; width=17" checked> $lang[srch_color]
</td>
</tr>
<tr class="dats">
<td class="forumline1" valign=middle colspan=2 align=center>
<input type="submit" tabindex="5" value="$lang[srch_do]" class=button>
<input type="reset" tabindex="6" value="$lang[Clear]" class=button>
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