<?
$email = <<<DATA
$lang[Robot_mail]
>---------------------------------------------------------------------
$lang[Author] $exbb[member]
$lang[Date] $time
>------------------------------------------
$lang[Topic_name]: $intopictitle
$lang[Topic_desc]: $intopicdescription
>------------------------------------------
$exbb[boardurl]/topic.php?forum=$inforum&topic=$intopic
----------------------------------------------------------------------
$lang[Robot_mail_reg]
$lang[Robot_mail_unreg] $exbb[boardurl]/forums.php?action=untrack&forum=$inforum
DATA;
?>