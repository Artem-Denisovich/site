<?
echo <<<DATA
<script language="javascript" type="text/javascript">
<!--
function show_smiley(newimage)
{
        document.smiley_image.src = "$smilesdir/" + newimage;
}
//-->
</script>
<form method="post" action="smiles.php"><table class="forumline" cellspacing="1" cellpadding="4" border="0" align="center">
$hidden_field
	<tr>
		<th class="thHead" colspan="2">$lang[smile_manage]</th>
	</tr>
	<tr class="gen">
		<td class="row2">$lang[smile_code]</td>
		<td class="row2"><input class="post" type="text" name="sm_code" value="$code" /></td>
	</tr>
	<tr class="gen">
		<td class="row1">$lang[smiley_url]</td>
		<td class="row1"><select name="sm_img" onchange="show_smiley(this.options[selectedIndex].value);">$filename_list</select> &nbsp; <img name="smiley_image" src="$smilesdir/$smiley_images[0]" border="0" alt="" /> &nbsp;</td>
	</tr>
	<tr class="gen">
		<td class="row2">$lang[smile_emotion]</td>
		<td class="row2"><input class="post" type="text" name="sm_emotion" value="$sm_emt" /></td>
	</tr>
	<tr>
		<td class="catBottom" colspan="2" align="center"><input class="mainoption" type="submit" value="$lang[Save]" /></td>
	</tr>
</table></form> 
DATA;
?>