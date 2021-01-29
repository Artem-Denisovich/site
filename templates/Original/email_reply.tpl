<?
$email = <<<DATA
$lang[Robot_mail]
$addfield
>---------------------------------------------------------------------
$lang[Author] $exbb[member]
$lang[Date] $time
$lang[Message_text]:
>------------------------------------------
$vars[inpost]
>------------------------------------------
$exbb[boardurl]/topic.php?forum=$inforum&topic=$intopic&start=$page#$timelimit
----------------------------------------------------------------------
$lang[Robot_mail_reg]
$lang[Robot_mail_unreg]
$exbb[boardurl]/topic.php?action=untrack&forum=$inforum&topic=$intopic
DATA;
?>