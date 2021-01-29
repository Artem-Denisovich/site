<?
echo <<<DATA

<h1>$lang[Welcome_admin]</h1>

<h1>$lang[Conf_statistic]</h1>

<table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline">
  <tr> 
	<th width="25%" nowrap="nowrap" height="25" class="thCornerL">$lang[Statistic]</th>
	<th width="25%" height="25" class="thTop">$lang[Value]</th>
	<th width="25%" nowrap="nowrap" height="25" class="thTop">$lang[Statistic]</th>
	<th width="25%" height="25" class="thCornerR">$lang[Value]</th>
  </tr>
  <tr class="genmed"> 
	<td class="row1" nowrap="nowrap">$lang[Posts_total]</td>
	<td class="row2"><b>$exbb[totalposts]</b></td>
	<td class="row1" nowrap="nowrap">$lang[Posts_per_day]:</td>
	<td class="row2"><b>$posts_per_day</b></td>
  </tr>
  <tr class="genmed"> 
	<td class="row1" nowrap="nowrap">$lang[Topics_total]:</td>
	<td class="row2"><b>$exbb[totalthreads]</b></td>
	<td class="row1" nowrap="nowrap">$lang[Topics_per_day]:</td>
	<td class="row2"><b>$topics_per_day</b></td>
  </tr>
  <tr class="genmed"> 
	<td class="row1" nowrap="nowrap">$lang[Users_total]</td>
	<td class="row2"><b>$exbb[totalmembers]</b></td>
	<td class="row1" nowrap="nowrap">$lang[Users_per_day]:</td>
	<td class="row2"><b>$users_per_day</b></td>
  </tr>
  <tr class="genmed"> 
	<td class="row1" nowrap="nowrap">$lang[Board_started]:</td>
	<td class="row2"><b>$boardstart</b></td>
	<td class="row1" nowrap="nowrap">$lang[PHP_ver]:</td>
	<td class="row2"><b>$php_ver</b></td>
  </tr>
  <tr class="genmed"> 
	<td class="row1" nowrap="nowrap">$lang[Online_now]:</td>
	<td class="row2"><b>$onlinedata</b></td>
	<td class="row1" nowrap="nowrap">$lang[Gzip_compression]:</td>
	<td class="row2"><b>$gzip</b></td>
  </tr>
  <tr class="genmed"> 
	<td class="row1" nowrap="nowrap">$lang[Uploads_size]</td>
	<td class="row2"><b>$uploads kB</b></td>
	<td class="row1" nowrap="nowrap">$lang[Server_loads]:</td>
	<td class="row2">$server_load</td>
  </tr>
</table>
<br />
DATA;
?>