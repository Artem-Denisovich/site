<?
echo <<<DATA
<form action="search.php" method="POST"><table cellpadding="0" cellspacing="0" border="0" width="95%" align="center">
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="4" border="0" class="tab">
<tr>
<td height="22" class="small"><a href="index.php">$exbb[boardname]</a> &raquo; $lang[Search]</td>
</tr>
</table>
</td>
</tr>
</table><br>
<input type=hidden name="action" value="start">
<table class="forumline" width="95%" cellpadding="4" cellspacing="1" border="0" align="center">
    <tr class="catname">
        <td colspan="2" height="25" align="center">$lang[QUERY]</td>
    </tr>
    <tr>
        <td class="row1" width="50%" nowrap><span class="gentext">$lang[KEYWORDS]:&nbsp;<input type="text" style="width: 300px" class="post" name="search_keywords" size="30" tabindex="1" /></span><span class="dats"><input type="radio" name="stype" tabindex="2" value="AND" title="$lang[srch_and]" checked>"AND"  <input type="radio" name="stype" value="OR" title="$lang[srch_or]">"OR"</span></td>
        <td class="row1" valign="middle" nowrap><span class="gentext">$lang[SRCH_IN]:&nbsp;<select class="post" name="src_in">$forums</select></span></td>
    </tr>
    <tr class="dats">
        <td class="row1" colspan="2" width="100%">$lang[KEYWORDS_EXP]</td>
    </tr>
    <tr>
        <td colspan="2" align="center" height="28" background="./templates/Original/im/tab_bg.gif"><input class="tab" type="submit" value="$lang[Search]" /></td>
    </tr>
    <tr>
        <td class="row2" colspan="2" align="center" valign="bottom" height="25"><span class="copyright">Search engine: Powered by <A HREF="http://risearch.org/" class="copyright" target=_blank><b>RiSearch PHP</b></A>, &copy; 2002</span></td>
    </tr>
</table>
DATA;
?>
