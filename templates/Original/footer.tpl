<?
$admincenter = (defined('IS_ADMIN')) ? '| <a href="announcements.php" title="'.$lang['Announ'].'">'.$lang['Announ'].'</a> | <a href="admincenter.php" title="'.$lang['Admincenter'].' '.$lang['Admincenter'].'"><font color=red>'.$lang['Admincenter'].'</font></a> |<br>' : '<br>';
echo <<<DATA
<p align="center">
<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
<tr><td align="center"><span class="mainmenu">$admincenter</span><span class="copyright">$lang[Powered] <a href="http://www.ExBB.revansh.com" class="copyright"  target="_blank">ExBB $exbb[ver]</a><br>Original Style v1.5a2 created by <a href="http://www.exbb.revansh.com/profile.php?action=show&member=28" class="copyright" target="_blank">Daemon.XP</a></span><br>$counters</td></tr>
</table>
</body>
</html>
DATA;
?>