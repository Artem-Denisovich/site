<?
/***************************************************************************
 * ExBB v.1.1                                                              *
 * Copyright (c) 2002-20õõ by Alexander Subhankulov aka Warlock            *
 *                                                                         *
 * http://www.exbb.revansh.com                                             *
 * email: admin@exbb.revansh.com                                           *
 *                                                                         *
 ***************************************************************************/
/***************************************************************************
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
define("IS_LOGIN", true);

include('common.php');

$vars = parsed_vars();

if ($vars['action'] == 'login' and $_SERVER['QUERY_STRING'] == '' and  $vars['request_method'] == 'post') {

    $inmembername = (isset($vars['imembername'])) ? $vars['imembername'] : $exbb['member'];
    $inpassword = (isset($vars['ipassword'])) ? $vars['ipassword'] : '';

    $inmembername = substr($inmembername,0,32);
    $inmembername = str_replace( "'" , '&#39;', $inmembername );
    $inmembername = str_replace( "\\" , '', $inmembername );
    $inmembername = str_replace( "/" , '', $inmembername );
    $inmembername = preg_replace ($lang['search'], $lang['replace'], $inmembername);

    $inpassword = substr($inpassword,0,32);
    $filetoopen = $exbb['home_path'].'data/users.php';

    $allu = get_file($exbb['home_path'].'data/users.php');

    $user_id = 0;
    foreach ($allu as $u_id=>$info) {
        if ($inmembername == $info['n']) { $user_id = $u_id; break; }
    }

    $inuser = getmember($user_id);
    #$inuser = ($inuser) ? unserialize($inuser) : '';

    if (is_array($inuser) and $inuser['pass'] == $inpassword) {

      access_log($inuser['name']);

      if ($inuser['status'] == 'banned') error($lang['Error_login'],$lang['Login_dinied']);

	  $now_time = time();

      $_SESSION['mid'] = intval($inuser['id']);
      $_SESSION['sts'] = $inuser['status'];
      $_SESSION['time'] = intval($inuser['timedif']);
      $_SESSION['lastposttime'] = isset($inuser['lastpost']['date']) ? $inuser['lastpost']['date'] : $now_time-180;
      $_SESSION['last_visit'] = isset($inuser['last_visit']) ? $inuser['last_visit'] : $now_time;
	  $_SESSION['iden'] = md5($inuser['name'].$inuser['pass']);

      $inuser['last_visit'] = $now_time;
      save_file($exbb['home_path'].'members/'.$inuser['id'].'.php',$inuser);

      my_setcookie('exbbn',$inuser['id']);
      my_setcookie('exbbp',md5($inpassword));
      my_setcookie('lastvisit',$now_time);
      header('Location: index.php'); exit;
    }

    access_log($vars['imembername'].' :: '.$vars['ipassword']);
    error($lang['Error_login'],$lang['Login_error'],'<meta http-equiv="refresh" content="3; url=loginout.php">');

}
elseif ($vars['action'] == 'logout') {

    $_SESSION = array();
    session_destroy();
    my_setcookie('exbbn','',-1);
    my_setcookie('exbbp','',-1);
    my_setcookie('t_visits','',-1);
    error($lang['Logout'],$lang['Close_browser'],'<meta http-equiv="refresh" content="3; url=index.php">',false);
}


$title_page = $exbb['boardname'].' :: '.$lang['Login_out'];
include('./templates/'.$exbb['default_style'].'all_header.tpl');
include('./templates/'.$exbb['default_style'].'logos.tpl');
include('./templates/'.$exbb['default_style'].'login.tpl');
include('./templates/'.$exbb['default_style'].'footer.tpl');
include('page_tail.php');
?>