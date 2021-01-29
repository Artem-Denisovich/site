<?
/***************************************************************************
 * ExBB v.1.7                                                              *
 * Copyright (c) 2002-20хх by Alexander Subhankulov aka Warlock            *
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

function checkuser($un) {
global $exbb;

  if (file_exists($exbb['home_path'].'members/'.$un.'.php')) {return true;}

  return false;

}

function getmember($un) {
global $exbb;

  if (checkuser($un)) {
    $filetoopen = $exbb['home_path'].'members/'.$un.'.php';
    /*
	$fp = fopen($filetoopen,'r');
	lock_file($fp,1);
    #flock($fp,1);
    $infa = file($filetoopen);
    fclose($fp);
    $infa = substr($infa[0],8,strlen($infa[0]));
	*/
    return get_file($filetoopen);
  } else {return false;}

}

function checklgn() {
global $exbb;
  if (isset($_SESSION['mid']) && $_SESSION['mid'] != 0) {
    return true;
  }
  elseif (isset($_SESSION['mid']) && $_SESSION['mid'] == 0) { $_SESSION['mid'] = 0; return false; }
  else { //first run
    $id_cookie = (isset($_COOKIE['exbbn'])) ? (int) $_COOKIE['exbbn'] : 0;
    $pass_cookie = (isset($_COOKIE['exbbp'])) ? $_COOKIE['exbbp'] : '';
    if ( (!empty($id_cookie)) and (!empty($pass_cookie)) ) {

      $inuser = getmember($id_cookie);
      #$inuser = ($inuser) ? unserialize($inuser) : '';
    }

	$now_time = time();

    if (is_array($inuser) and $pass_cookie == md5($inuser['pass'])) {

       if ($inuser['status'] == 'banned') error('Denial of access','You are banned!');

       $_SESSION['mid'] = (int) $inuser['id'];
       $_SESSION['sts'] = $inuser['status'];
       $_SESSION['time'] = intval($inuser['timedif']);
       $_SESSION['lastposttime'] = isset($inuser['lastpost']['date']) ? $inuser['lastpost']['date'] : $now_time-180;
       $_SESSION['last_visit'] = isset($inuser['last_visit']) ? (int)$inuser['last_visit'] : $now_time;
       $_SESSION['iden'] = md5($inuser['name'].$inuser['pass']);

       #$inuser['last_visit'] = $now_time;
	   
	   #$fp = fopen($exbb['home_path'].'members/'.$inuser['id'].'.php','w');
	   #lock_file($fp,2);
	   #save_opened_file($fp,$inuser);

       my_setcookie('exbbn',$inuser['id']);
       my_setcookie('exbbp',md5($inuser['pass']));
       my_setcookie('lastvisit',$inuser['last_visit']);

       access_log($inuser['name']);
       return true;
    }
    else {
        $_SESSION = array();
        $_SESSION['mid'] = 0;
        $_SESSION['time'] = 0;
        $_SESSION['lastposttime'] = $now_time-180;
        $_SESSION['last_visit'] = isset($_COOKIE['lastvisit']) ? (int) $_COOKIE['lastvisit'] : $now_time;
        my_setcookie('lastvisit',time());
        access_log();
        return false;
    }
  } //is first run

}

function access_log($user = 'Guest') {
global $exbb,$vars;

  if ( !$exbb['log'] ) return;
  if (!isset($vars['IP_ADDRESS'])) {
     $vars['IP_ADDRESS'] = select_var( array(
                                            1 => $_SERVER['REMOTE_ADDR'],
                                            2 => $_SERVER['HTTP_X_FORWARDED_FOR'],
                                            3 => $_SERVER['HTTP_PROXY_USER']
                                              )
                                       );


     $vars['IP_ADDRESS'] = preg_replace( "/^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})/", "\\1.\\2.\\3.\\4", $vars['IP_ADDRESS'] );

  }
  $fp = @fopen($exbb['home_path'].'data/access_log.php','a');
  @flock($fp,2);
  @fwrite($fp,date("d.m.y - H:i:s",time()).' :: '.$user.' :: '.$vars['IP_ADDRESS']."\n");
  @fclose($fp);
return;

}

function user_locale($userinfo = array()) {

  global $exbb,$lang;

        $l = $exbb['default_lang'];
        $s =  $exbb['default_style'];

        if (isset($userinfo['lang']) && !empty($userinfo['lang'])) $exbb['default_lang'] = $userinfo['lang'];
        if (isset($userinfo['skin']) && !empty($userinfo['skin'])) $exbb['default_style'] = $userinfo['skin'];

        if ( !file_exists($exbb['home_path'] . 'language/' . $exbb['default_lang'] . '/lang.php') )
        {
                $exbb['default_lang'] = $l;
        }

        if ( !file_exists($exbb['home_path'] . 'templates/' . $exbb['default_style'] . '/board_body.tpl') )
        {
                $exbb['default_style'] = $s;
        }

        if (defined('IN_ADMIN'))
        {
                if( !file_exists($exbb['home_path'] .'language/' . $exbb['default_lang'] . '/lang_admin.php') )
                {
                        $exbb['default_lang'] = 'russian';
                }

                include('./language/' . $exbb['default_lang'] . '/lang_admin.php');
        }

        return;
}

function parsed_vars() {

 $return = array();

 if ( is_array($_GET) ) {

   while( list($k, $v) = each($_GET) ) {
     if ( is_array($_GET[$k]) ) {
        while( list($k2, $v2) = each($_GET[$k]) ) {
          $return[$k][ clean_key($k2) ] = clean_value($v2);
        }
     }
     else { $return[$k] = clean_value($v); }
   }
 }

 if ( is_array($_POST) ) {

   while( list($k, $v) = each($_POST) ) {
     if ( is_array($_POST[$k]) ) {
        while( list($k2, $v2) = each($_POST[$k]) ) {
          $return[$k][ clean_key($k2) ] = clean_value($v2);
        }
     }
     else { $return[$k] = clean_value($v); }
   }
 }


 $return['IP_ADDRESS'] = select_var( array(
                                            1 => $_SERVER['REMOTE_ADDR'],
                                            2 => $_SERVER['HTTP_X_FORWARDED_FOR'],
                                            3 => $_SERVER['HTTP_PROXY_USER']
                                           )
                                                 );

 // valid IP?

 $return['IP_ADDRESS'] = preg_replace( "/^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})/", "\\1.\\2.\\3.\\4", $return['IP_ADDRESS'] );

 $return['request_method'] = strtolower($_SERVER['REQUEST_METHOD']);

 if ( isset($return['topic']) ) {
	 $return['topic'] = intval($return['topic']);
	 if ( $return['topic'] == 0 ) die('Hack attempt!');
 }
 if ( isset($return['forum']) ) {
	 $return['forum'] = intval($return['forum']);
	 if ( $return['forum'] == 0 ) die('Hack attempt!');
 }
    return $return;
}

function clean_key($key) {

 if ($key == '') { return ''; }
 $key = preg_replace( "/\.\./"           , ''  , $key );
 $key = preg_replace( "/\_\_(.+?)\_\_/"  , ''  , $key );
 $key = preg_replace( "/^([\w\.\-\_]+)$/", "$1", $key );
 return $key;
}

function clean_value($val) {

  if ($val == '') { return '';  }
  $val = str_replace( "&#032;"       , ' '             , $val );
  $val = str_replace( "&"            , '&amp;'         , $val );
  $val = str_replace( "<!--"         , '&#60;&#33;--'  , $val );
  $val = str_replace( "-->"          , '--&#62;'       , $val );
  $val = preg_replace( "/<script/i"  , '&#60;script'   , $val );
  $val = str_replace( ">"            , '&gt;'          , $val );
  $val = str_replace( "<"            , '&lt;'          , $val );
  $val = str_replace( "\""           , '&quot;'        , $val );
  $val = preg_replace( "/\n\n/"      , '<p>'           , $val );
  $val = preg_replace( "/\n/"        , '<br>'          , $val );
  $val = preg_replace( "/\\\$/"      , '&#036;'        , $val );
  $val = preg_replace( "/\r/"        , ''              , $val );
  $val = stripslashes($val);
  $val = preg_replace( "/\\\/"       , '&#092;'        , $val );
  return $val;
}

function soft_clr_value($val) {

  if ($val == '') { return '';  }
  $val = str_replace( "&#032;"       , ' '             , $val );
  $val = str_replace( "&"            , '&amp;'         , $val );
  $val = preg_replace( "/<script/i"  , '&#60;script'   , $val );
  $val = str_replace( "\""           , '&quot;'        , $val );
  $val = preg_replace( "/\n\n/"      , '<p>'           , $val );
  $val = preg_replace( "/\n/"        , '<br>'          , $val );
  $val = preg_replace( "/\\\$/"      , '&#036;'        , $val );
  $val = preg_replace( "/\r/"        , ''              , $val );
  $val = stripslashes($val);
  $val = preg_replace( "/\\\/"       , '&#092;'        , $val );
  return $val;
}


function select_var($array) {

 if ( !is_array($array) ) return -1;

 #ksort($array);

 $chosen = -1;

 foreach ($array as $k => $v) {
   if (isset($v)) {
     $chosen = $v;
     break;
   }
 }
 return $chosen;
}

function mark_forum() {
global $exbb,$vars,$lang;

  $vars['forum'] = intval($vars['forum']);

  if ($vars['forum'] == '') exit();

  my_setcookie('f'.$vars['forum'], time() );
  $url = $exbb['boardurl'].'/forums.php?forum='.$vars['forum'];
  error($lang['Info'],$lang['Forum_marked'],"<meta http-equiv='refresh' content='3; url=$url'>",0);

}

function mark_board() {
global $exbb,$vars,$lang,$inuser;

  $_SESSION['last_visit'] = time();
  $inuser['last_visit'] = time();
  save_file($exbb['home_path'].'members/'.$exbb['mem_id'].'.php',$inuser);

  $url = $exbb['boardurl'].'/index.php';
  error($lang['Info'],$lang['Board_marked'],"<meta http-equiv='refresh' content='3; url=$url'>",0);

}

function post_size() {
global $lang,$exbb,$vars;

  if ($vars['request_method'] != 'post') {error($lang['Main_msg'],$lang['Correct_post']);}
  if ( strlen($_POST['inpost']) > $exbb['max_posts'] && !defined('IS_ADMIN') ) {error($lang['Message_sending'],$lang['Big_post']);}
  if ( strlen(trim($_POST['inpost'])) < 1) {error($lang['Message_sending'],$lang['Mess_needed']);}

}

function error($msg_title,$msg_text,$meta = '',$reas = true) {
global $exbb,$lang;

  $title_page = $msg_title;
  if (empty($meta)) $return = ' <a href="javascript:history.go(-1)"> << '.$lang['Back'].'</a>';
  $reasons = ($reas) ? '<b>'.$lang['Reasons'].'</b><ul><li>'.$lang['Wrong_pass'].'<li>'.$lang['Wrong_membername'].'<li><a href="register.php">'.$lang['User_unreg'].'</a></ul>' : '';
  include('./templates/'.$exbb['default_style'].'all_header.tpl');
  include('./templates/'.$exbb['default_style'].'error.tpl');
  include('./templates/'.$exbb['default_style'].'footer.tpl');
  include('page_tail.php');
}

function save_statfile() {
global $exbb;

  $filetomake = $exbb['home_path'].'data/boardstats.php';
  $tofile="<?\n\$exbb['lastreg'] = '$exbb[lastreg]';\n\$exbb['last_id'] = '$exbb[last_id]';\n\$exbb['totalmembers'] = '$exbb[totalmembers]';\n\$exbb['totalthreads'] = '$exbb[totalthreads]';\n\$exbb['totalposts'] = '$exbb[totalposts]';\n?>";
  $fp = @fopen($filetomake, 'w');
  flock($fp,LOCK_EX);
  @fwrite($fp, $tofile);
  fclose($fp);
  return;
}


function replace ($string)
{
$string = str_replace("\n\n",'<p>',$string);
$string = str_replace("\n",'<br>',$string);
$string = str_replace("\t",'',$string);
$string = str_replace("\r",'',$string);
$string = str_replace('  ','',$string);
return $string;
}

function vm($ml = '') {

  $ml = preg_replace( "#[\n\r\*\'\"<>&\%\!\(\)\{\}\[\]\?\\/]#", "", $ml );
  if ( preg_match( "/^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,4}|[0-9]{1,4})(\]?)$/", $ml) ) {
     return $ml;
  }
  else  {
         return FALSE;
        }
}

function seekHttp($rawText)
{
        $pattern=array(
                "#([\t\r\n ])([a-z0-9]+?){1}://([\w\-]+\.([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^ \"\n\r\t<]*)?)#i",
                "#([\t\r\n ])(www|ftp)\.(([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^ \"\n\r\t<]*)?)#i",
                "#([\n ])([a-z0-9\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i");
        $replacement=array(
                '\1<a href="\2://\3" target="_blank">\2://\3</a>',
                '\1<a href="http://\2.\3" target="_blank">\2.\3</a>',
                "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>");
        $ret = ' ' . $rawText;
        $hyperlinkedText=preg_replace($pattern, $replacement, $ret);
        $hyperlinkedText = substr($hyperlinkedText, 1);
        return $hyperlinkedText;
}

function divideWord($content,$maxWordLength = '30') {
   $newContent = wordwrap($content, $maxWordLength, chr(13), 1);
   return $newContent;
}


function longDate($todt,$add = 0) {
global $lang;
  $currDay = strftime ("%d",$todt);
  $currMonth = strftime ("%m",$todt);
  $currYear = strftime ("%Y",$todt);
  $tm = date("H:i:s",$todt);
  #if ($add) { return $tm.' - '.$currDay.' '.$lang[$currMonth].', '.$currYear; }
  return $currDay.' '.$lang['rus_m'][$currMonth].', '.$currYear.' - '.$tm;
}

function joindate($time) {
   $months = array('00' => '','01' => 'Янв.','02' => 'Февр.','03' => 'Март','04' => 'Апр.','05' => 'Май','06' => 'Июнь','07' => 'Июль','08' => 'Авг.','09' => 'Сент.','10' => 'Окт.','11' => 'Нояб.','12' => 'Дек.');
   $currMonth = strftime ("%m",$time);
   $currYear = strftime ("%Y",$time);
   return $months["$currMonth"]." ".$currYear;
}

function my_setcookie($name, $value = "", $exp = 1) {

        $exipres = 0;

        if ($exp == 1) {
			$expires = time() + 31536000;  #+ year (60*60*24*365 = 31536000)
		} elseif ($exp > 1) {
			$expires = time() + $exp;  #+ year (60*60*24*365 = 31536000)
        } else {$expires = time() - 1000;}

        @setcookie($name, $value, $expires, '/','');
}



function getlastvisit() {
global $lastvisitinfo;
    $lastvisitinfo = (isset($_COOKIE['f_visits'])) ? unserialize($_COOKIE['f_visits']) : array();
}

function setlastvisit($inforum) {
    $lastvisit = (isset($_COOKIE['f_visits'])) ? unserialize($_COOKIE['f_visits']) : array();
    $lastvisit[$inforum] = time();
    my_setcookie('f_visits',serialize($lastvisit));
}

function set_font($attr) {

  if (!is_array($attr)) return '';

  if ( preg_match( "/;/", $attr['1'] ) ) {
    $attr = explode( ';', $attr['1'] );
    $attr['1'] = $attr[0];
  }

  if ($attr['s'] == 'size') {

    #$attr['1'] = $attr['1'] + 7;
    if ($attr['1'] > 30) $attr['1'] = 30;

    return "<span style='font-size:".$attr['1']."pt;line-height:100%'>".$attr['2']."</span>";
  }
  elseif ($attr['s'] == 'col') {
    $attr['1'] = substr($attr['1'],0,9);
    return "<span style='color:".$attr['1']."'>".stripslashes($attr['2'])."</span>";
  }
  elseif ($attr['s'] == 'font') {
    $attr['1'] = substr($attr['1'],0,9);
    return "<span style='font-family:".$attr['1']."'>".$attr['2']."</span>";
  }
}

function set_code($code="") {
  $code = preg_replace( "#\s{2}#", ' &nbsp;', $code );
  $code = str_replace('<','&lt;',$code);
  $code = str_replace('>','&gt;',$code);
  $code = str_replace('&lt;br&gt;','<br>',$code);
  $code = str_replace(']','&#93;',$code);
  $code = str_replace('[','&#91;',$code);
  $code = str_replace('(','&#40;',$code); //избавимся от смайликов :) ;) :(
  $code = str_replace(')','&#41;',$code);
  $code = str_replace('&amp;#036;','$',$code);
  $code = str_replace('&amp;quot;','"',$code);
  $code = '<span class=small>Код:</span><table cellpadding="3" cellspacing="0" width="100%" class="code_table"><tr><td class=code_td>'.$code.'</td></tr></table>';
  return $code;
}

function set_php($code="") {
  $code = str_replace('&lt;','<',$code);
  $code = str_replace('&gt;','>',$code);
  $code = str_replace('<br>',"\n",$code);
  $code = str_replace('<p>',"\n\n",$code);
  $code = str_replace('&amp;','&',$code);
  $code = str_replace('&#036;','$',$code);
  #$code = str_replace('&quot;','"',$code);
  $code = str_replace('&#092;','', $code );
  $code = '<span class=small>PHP:</span><table cellpadding="3" cellspacing="0" width="100%" class="php_table"><tr><td class=php_td>'.highlight_string($code, true).'</td></tr></table>';
  $code = str_replace('(','&#40;',$code); //избавимся от смайликов :) ;) :(
  $code = str_replace(')','&#41;',$code);
  $code = str_replace(']','&#93;',$code);
  $code = str_replace('[','&#91;',$code);
  return $code;
}

function set_rus($code="") {

  $replace = array ('Щ',    'Ш',   'Э',   'Ч',   'Ю',   'Ж',   'Ё',   'Я',   'я',   'а',  'б',  'в',  'г',  'д',  'э',   'е',  'ё',   'ж',   'з',  'и',  'й',  'к',  'л',  'м',  'н',  'о',  'п',  'р',   'щ',   'ш',   'с',  'т',  'ю',   'у',  'ф',  'ч',   'х',  'ц',   'ъ',    'ы',  'ь',   'А',  'Б',  'В',  'Г',  'Д',  'Е',  'З',  'И',  'К',  'Л',  'М',  'Н',  'О',  'П',  'Р',  'С',  'Т',  'У',  'Ф',  'Х',  'Ц');
  $search = array ("'Sch'","'Sh'","'Ye'","'Ch'","'Yu'","'Zh'","'Jo'","'Ja'","'ja'","'a'","'b'","'v'","'g'","'d'","'ye'","'e'","'yo'","'zh'","'z'","'i'","'I'","'k'","'l'","'m'","'n'","'o'","'p'","'r'","'sch'","'sh'","'s'","'t'","'yu'","'u'","'f'","'ch'","'h'","'c'","'\'\''","'y'","'\''","'A'","'B'","'V'","'G'","'D'","'E'","'Z'","'I'","'K'","'L'","'M'","'N'","'O'","'P'","'R'","'S'","'T'","'U'","'F'","'H'","'C'");

  return '[s]Перевод с транслита[/s]:<br />'.preg_replace ($search, $replace, $code);
}

function ikoncode($post) {

  $post = str_replace('&quot;','"',$post);
  $post = preg_replace("#<p>#is",'<br><br>', $post);
  $post = str_replace('<br>',' <br> ',$post);

  $post = preg_replace("#\[hr\]#i",'<hr width=40% align=left>',$post);

  $post = preg_replace("#\[code\](.+?)\[/code\]#ies","set_code('\\1')",$post);
  $post = preg_replace("#\[php\](.+?)\[/php\]#ies","set_php('\\1')",$post);

  #Translite
  $post = preg_replace("#\[rus\](.+?)\[/rus\]#ies","set_rus('\\1')",$post);

  $post = preg_replace("#\[q\]\s*(.*?)\s*\[/q\]#is","<span class=small>Цитата:</span><table cellpadding=3 cellspacing=0 width=85% class=q_table><tr><td class=q_td>$1</td></tr></table>",$post);
  $post = preg_replace("#\[quote\]\s*(.*?)\s*\[/quote\]#is","<span class=small>Цитата:</span><table cellpadding=3 cellspacing=0 width=85% class=q_table><tr><td class=q_td>$1</td></tr></table>",$post);

  $post = preg_replace("#\[url\](http\:\/\/)+(\S+?)\[/url\]#i","<a href='$1$2' target='_blank'>$1$2</a>",$post);
  $post = preg_replace("#\[url\](\S+?)\[/url\]#i","<a href='http://$1' target='_blank'>$1</a>",$post);
  $post = preg_replace("#\[url\s*=\s*\&quot\;\s*(\S+?)\s*\&quot\;\s*\](.*?)\[\/url\]#i","<a href=$1 target=_blank>$2</a>",$post);
  $post = preg_replace("#\[url\s*=\s*(\S+?)\s*\](.*?)\[\/url\]#i","<a href=$1 target='_blank'>$2</a>",$post);

  $post = preg_replace( "#(^|\s)((http|https|news|ftp)://\w+[^\s\[\]\<]+)#i"  , "$1<a href=$2 target='_blank'>$2</a>", $post );

  $post = preg_replace("#\[c\](.*?)\[/c\]#is","<center>$1</center>",$post);
  $post = preg_replace("#\[center\](.+?)\[/center\]#is","<center>$1</center>",$post);
  $post = preg_replace("#\[s\](.*?)\[/s\]#is","<span class=small>$1</span>",$post);

  $post = preg_replace( "#\[b\](.+?)\[/b\]#is", "<b>\\1</b>", $post );
  $post = preg_replace( "#\[i\](.+?)\[/i\]#is", "<i>\\1</i>", $post );
  $post = preg_replace( "#\[u\](.+?)\[/u\]#is", "<u>\\1</u>", $post );

   while ( preg_match( "#\[size=([^\]]+)\](.+?)\[/size\]#ies", $post ) ) {
        $post = preg_replace( "#\[size=([^\]]+)\](.+?)\[/size\]#ies"    , "set_font(array('s'=>'size','1'=>'\\1','2'=>'\\2'))", $post );
   }

   while ( preg_match( "#\[font=([^\]]+)\](.*?)\[/font\]#ies", $post ) ) {
        $post = preg_replace( "#\[font=([^\]]+)\](.*?)\[/font\]#ies"    , "set_font(array('s'=>'font','1'=>'\\1','2'=>'\\2'))", $post );
   }

   while ( preg_match( "#\[color=([^\]]+)\](.+?)\[/color\]#ies", $post ) ) {
        $post = preg_replace( "#\[color=([^\]]+)\](.+?)\[/color\]#ies"  , "set_font(array('s'=>'col' ,'1'=>'\\1','2'=>'\\2'))", $post );
  }

  $post = preg_replace( "#\[email\](\S+?)\[/email\]#i", "<a href='mailto:\\1'>\\1</a>", $post );
  $post = preg_replace( "#\[email\s*=\s*\&quot\;([\.\w\-]+\@[\.\w\-]+\.[\.\w\-]+)\s*\&quot\;\s*\](.*?)\[\/email\]#i", "<a href='mailto:\\1'>\\2</a>", $post );
  $post = preg_replace( "#\[email\s*=\s*([\.\w\-]+\@[\.\w\-]+\.[\w\-]+)\s*\](.*?)\[\/email\]#i", "<a href='mailto:\\1'>\\2</a>", $post );

  $post = preg_replace("#\[img\](.*?)(script:|\?|\&|;)(.*?)\[/img\]#is","$1$2$3<br><span class=small>\[<font color=red>No dynamic images</font>\]</span>",$post);
  $post = preg_replace("#\[img\](.*?)(mailto:)(.*?)\[/img\]#is","$1$2$3<br><span class=small>\[<font color=red>!!!</font>\]</span>",$post);
  $post = preg_replace("#\[img\](.+?)\[/img\]#is","<img src=\"$1\">",$post);

  $post = preg_replace("#(\[list\])(.+?)(\[\/list\])#is","<ul>$2</ul>",$post);
  $post = preg_replace("#(\[list=)(A|1)(\])(.+?)(\[\/list\])#is","<OL TYPE=$2>$4</OL>",$post);
  $post = preg_replace("#(\[\*\])#is","<li>",$post);
/*
  $post = preg_replace("/(\[FLASH SIZE=1\])(.+?)(\[\/FLASH\])/is","<OBJECT CLASSID='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' WIDTH=80 HEIGHT=60><PARAM NAME=movie VALUE=\"$2\"><PARAM NAME=PLAY VALUE=TRUE><PARAM NAME=LOOP VALUE=TRUE><PARAM NAME=QUALITY VALUE=HIGH><PARAM NAME=scale VALUE=exactfit><PARAM NAME=menu VALUE=false><EMBED src=\"$2\" quality=high menu=false scale=exactfit WIDTH=80 HEIGHT=60 swLiveConnect=true TYPE=\"application/x-shockwave-flash\"></EMBED></OBJECT>",$post);
  $post = preg_replace("/(\[FLASH SIZE=2\])(.+?)(\[\/FLASH\])/is","<OBJECT CLASSID='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' WIDTH=160 HEIGHT=120><PARAM NAME=movie VALUE=\"$2\"><PARAM NAME=PLAY VALUE=TRUE><PARAM NAME=LOOP VALUE=TRUE><PARAM NAME=QUALITY VALUE=HIGH><PARAM NAME=scale VALUE=exactfit><PARAM NAME=menu VALUE=false><EMBED src=\"$2\" quality=high menu=false scale=exactfit WIDTH=160 HEIGHT=120 swLiveConnect=true TYPE=\"application/x-shockwave-flash\"></EMBED></OBJECT>",$post);
  $post = preg_replace("/(\[FLASH SIZE=3\])(.+?)(\[\/FLASH\])/is","<OBJECT CLASSID='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' WIDTH=320 HEIGHT=240><PARAM NAME=movie VALUE=\"$2\"><PARAM NAME=PLAY VALUE=TRUE><PARAM NAME=LOOP VALUE=TRUE><PARAM NAME=QUALITY VALUE=HIGH><PARAM NAME=scale VALUE=exactfit><PARAM NAME=menu VALUE=false><EMBED src=\"$2\" quality=high menu=false scale=exactfit WIDTH=320 HEIGHT=240 swLiveConnect=true TYPE=\"application/x-shockwave-flash\"></EMBED></OBJECT>",$post);
  $post = preg_replace("/(\[FLASH=)(\S+?)(\,)(.+?)(\])(.+?)(\[\/FLASH\])/is"," <embed src=\"$6\" menu=false scale=exactfit HEIGHT=\"$4\" WIDTH=\"$2\" quality=\"high\"></embed> ",$post);
  $post = preg_replace("/(\[sound\])(\S+?)(\.mid|\.midi|\.wav)(\[\/sound\])/is","<EMBED SRC=\"$2$3\" AUTOSTART=FALSE LOOP=FALSE WIDTH=100></EMBED> ",$post);
*/
  $post = str_replace(' <br> ','<br>',$post);
  $post = stripslashes($post);
  return $post;

}

function setsmiles($sm) {
static $sm_code,$sm_img;

  if( empty($sm_code) ) {
    $smilies = get_file('./data/smiles.php');
    $sm_code = array();
    $sm_img = array();
    foreach ($smilies as $code=>$data) {
      $code = str_replace(')','\)',$code);
      $code = str_replace('(','\(',$code);
      $sm_code[] = "'$code'";
      $sm_img[] = '<img src="./im/emoticons/'.$data['img'].'" border="0">';
    }
  }
  #$sm = str_replace('&quot;','"',$sm);
  return preg_replace($sm_code,$sm_img,$sm);
}


function whosonline($where,$show = false) {
global $exbb,$vars,$memberoutput,$guests,$members,$mod_ids;


    $guests = 0;
    $members = 0;
    $currenttime = time();
    $userexpire = $currenttime - ($exbb['membergone'] * 60);

    $ip = $vars['IP_ADDRESS'];
    $b = is_search_bot();

    $filetoopen = $exbb['home_path'].'data/onlinedata.php';
    $onlinedata = get_file($filetoopen);
    if (!is_array($onlinedata)) $onlinedata = array();
    $fp = @fopen($filetoopen,'r+');
    @flock($fp,2);
    $onlinedata[$ip]['n'] = $exbb['member'];
    $onlinedata[$ip]['id'] = $exbb['mem_id'];
    $onlinedata[$ip]['t'] = $currenttime;
    $onlinedata[$ip]['in'] = $where;
	$onlinedata[$ip]['st'] = $exbb['sts'];
	if ( !empty($onlinedata[$ip]['st']) ) {
		$onlinedata[$ip]['st'] = ( in_array($exbb['mem_id'],$mod_ids) ) ? 'mo' : '';
		if ( defined('IS_ADMIN') ) $onlinedata[$ip]['st'] = $exbb['sts'];
	}
	if (!empty($b)) $onlinedata[$ip]['b'] = $b;

    $memberoutput = array();
    $remove_id = 0;
    foreach ($onlinedata as $id=>$info) {
       if ($userexpire > $info['t']) { unset($onlinedata[$id]); continue;}
       if ($info['n'] == $exbb['member'] && $id != $ip) { $remove_id = $id;}
       if ($show) {
         switch ($info['id']) {
            case 0: $guests++; break 1;
            default: 
				$info['n'] = ( $info['st'] == 'ad' ) ? '<font color=red>'.$info['n'].'</font>' : $info['n'];
				$info['n'] = ( $info['st'] == 'mo' ) ? '<font color=green>'.$info['n'].'</font>' : $info['n'];
				$memberoutput[] = '<a href="profile.php?action=show&member='.$info['id'].'">'.$info['n'].'</a>';
                break 1;
         }
       }
    }
    unset($onlinedata[$remove_id]);
    $memberoutput = array_unique($memberoutput);
    $members = count($memberoutput);
    $memberoutput = implode ( ' &raquo; ', $memberoutput);
    save_opened_file($fp,$onlinedata);
    $filetoopen = $exbb['home_path'].'data/max_online.php';
    $m_online =  @file($filetoopen);
    if ( !is_array($m_online) ) $m_online = array($currenttime,0);
    $now_online = $members + $guests;
    if ($m_online[1] < $now_online) {
       $fp = @fopen($filetoopen,'w');
       @flock($fp,2);
       @fwrite($fp,$currenttime."\n".$now_online);
       @fclose($fp);
    }

    return $b;
}

function is_search_bot() {

    if ( strstr($_SERVER['HTTP_USER_AGENT'], 'Yandex') ) { return 'Yandex';}
    elseif ( strstr($_SERVER['HTTP_USER_AGENT'], 'Googlebot') ) {return 'Google';}
    elseif ( strstr($_SERVER['HTTP_USER_AGENT'], 'Slurp') ) {return 'Slurp';}
    elseif ( strstr($_SERVER['HTTP_USER_AGENT'], 'WebCrawler') ) {return 'WebCrawler';}
    elseif ( strstr($_SERVER['HTTP_USER_AGENT'], 'ZyBorg') ) {return 'ZyBorg';}

    return '';
}


function max_online(){
global $exbb;

    $filetoopen = $exbb['home_path'].'data/max_online.php';
    $m_online =  @file($filetoopen);
    if ( !is_array($m_online) ) return array(time(),0);
    return $m_online;
}

function bads_filter($check,$replc = 1) {
global $exbb;

     $filetoopen = $exbb['home_path'].'data/badwords.php';
     $badwords = @file($filetoopen);
     unset($badwords[0]);
     if (count($badwords)) {
       $bad = array();
       $good = array();
       foreach ($badwords as $words) {
         list($bw, $gw) = explode('=',$words);
         $bad[] = '/(^|\b)' . trim($bw) . '(\b|!|\?|\.|,|$)/i';
         $good[] = trim($gw);
       }
       if (sizeof($bad)) $ok = preg_replace($bad,$good,$check);
     } else {
         $ok = $check;
     }

     if( $replc ) { return $ok; }
     if ($check != $ok) return true; //есть плохие слова
}

function topic_icon($topic, $read_time=-1) {
global $exbb;

 $icon_path = './templates/'.$exbb['default_style'].'im';

 $read_time = $read_time > $exbb['last_visit'] ? $read_time : $exbb['last_visit'];
 if ($topic['state'] == 'pinned') return '<img src="'.$icon_path.'/folder_sticky.gif" border="0">';
 if ($topic['state'] == 'closed') return '<img src="'.$icon_path.'/locked.gif" border="0">';
 if ($topic['state'] == 'moved') return '<img src="'.$icon_path.'/moved.gif" border="0">';
 if (($topic['posts'] >= $exbb['hot_topic']) and ( (isset($read_time) )  && ($topic['postdate'] <= $read_time ))) return '<img src="'.$icon_path.'/tc_hot.gif" border="0">';
 if ($topic['posts'] >= $exbb['hot_topic']) return '<img src="'.$icon_path.'/to_hot.gif" border="0">';
 if ($read_time  && ($topic['postdate'] > $read_time)) return '<img src="'.$icon_path.'/to_new.gif" border="0">';
 return '<img src="'.$icon_path.'/tc_new.gif" border="0">';

}


function forumjump($allfrm) {
global $exbb,$lang,$jumphtml;
$jumphtml = '
<SCRIPT LANGUAGE="JavaScript">
<!--
function menu(){
var URL = document.jump.jumpto.options[document.jump.jumpto.selectedIndex].value;
top.location.href = URL; target = "_self";
}
// -->
</SCRIPT>
<form action="forums.php" method="post" name="jump">
<select name="jumpto" onchange="menu()">
<option value="index.php">'.$lang['Forum_jump'];
$last_cat = -1;
foreach($allfrm as $forumid=>$val){
  if ($val['catid'] != $last_cat) { #start if $categoryplace
    $jumphtml .= '<option value="'.$exbb['boardurl']."/index.php\">\n";
    $jumphtml .= '<option value="'.$exbb['boardurl'].'/index.php">-- &nbsp; '.$val['catname']."\n";
    $jumphtml .= '<option value="'.$exbb['boardurl'].'/forums.php?forum='.$forumid.'" target="_self"> '.$val['name']."\n";
  } else {
       $jumphtml .= '<option value="'.$exbb['boardurl'].'/forums.php?forum='.$forumid.'" target="_self"> '.$val['name']."\n";
  }
  $last_cat = $val['catid'];
}
$jumphtml .= "</select></form>";
}


function moderator($where,$data) {
global $exbb,$modoutput,$lang,$lang_moder,$mod_ids;

  $inmembmod = false;
  $mod_url = array();
  if (!empty($data[$where]['moderator'])) {
    $moderators = unserialize($data[$where]['moderator']);

    foreach ($moderators as $id=>$name) {
      $mod_url[] = '<a href="profile.php?action=show&member='.$id.'">'.$name.'</a>';
      if ($exbb['mem_id'] == $id) $inmembmod = true;
	  $mod_ids[] = $id;
    }
  }
  $modoutput = ( count($mod_url) ) ? implode(', ', $mod_url) : $lang['no'];
  $lang_moder = ( count($mod_url) > 1 ) ? $lang['Moderators'] : $lang['Moderator'].':';
  if (defined('IS_ADMIN')) $inmembmod = true;
  return $inmembmod;
}

function sendmail($from_name,$from_address,$message,$subject = '',$to_bcc = array()) {
global $exbb;
  @set_time_limit(600);
  $headers = 'From: '.$from_name.' <'.$from_address.">\n";
  $headers .= 'Reply-To: '.$from_address."\n";
  $headers .= 'Return-Path: '.$from_address."\n";
  $headers .= "MIME-Version: 1.0\nContent-type: text/plain; charset=windows-1251\nContent-Transfer-Encoding: 8bit\nDate: " . gmdate('D, d M Y H:i:s', time()) . " UT\nX-Priority: 3\nX-MSMail-Priority: Normal\nX-Mailer: PHP\n";
  #$to = reset($to_bcc);
  #unset($to_bcc[0]);
  #if (count($to_bcc)) $headers .= 'Bcc: '.implode( ', ' , $to_bcc ) . "\r\n";

  $skip_mails = '';
  if ( ($skip_mails = file($exbb['home_path'].'data/skip_mails.php')) ) {
	  unset($skip_mails[0]);
	  $skip_mails = implode(':',$skip_mails);

	  if ( is_array($to_bcc) ) {
		  $cur_mails = get_file($exbb['home_path'].'data/users.php');
		  if ( is_array($cur_mails) ) {
			  foreach ($to_bcc as $id=>$to) {
				  $domen = substr($cur_mails[$id]['m'],strpos($cur_mails[$id]['m'],'@'));
				  if (!strstr($skip_mails,$domen)) @mail($cur_mails[$id]['m'], $subject, $message, $headers);
			  }
		  }
	  }
	  else {
		  $domen = substr($to_bcc,strpos($to_bcc,'@'));
		  if (!strstr($skip_mails,$domen)) @mail($to_bcc, $subject, $message, $headers);
	  }
  }
  else {

	  if ( is_array($to_bcc) ) {
		  $cur_mails = get_file($exbb['home_path'].'data/users.php');
		  if ( is_array($cur_mails) ) {
			  foreach ($to_bcc as $id=>$to) @mail($cur_mails[$id]['m'], $subject, $message, $headers);
		  }
	  }
	  else {
		  @mail($to_bcc, $subject, $message, $headers);
	  }
  }

  unset($headers,$to_bcc,$cur_mails,$subject,$message);
}

function attach_upload($oldid = "",$name = "",$mode = 'post') {
global $exbb,$lang,$vars,$HTTP_POST_FILES;

		$attach = array( 'attach_id'   => "",
                         'attach_file' => "",
                       );

		switch ( $HTTP_POST_FILES['FILE_UPLOAD']['error'] ) {
			case 1: access_log($exbb['member'] . ' - Filed upload file: the uploaded file exceeds the upload_max_filesize directive in php.ini.'); return $attach; break;
			case 2: access_log($exbb['member'] . ' - Filed upload file: the uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form.'); return $attach; break;
			case 3: access_log($exbb['member'] . ' - Filed upload file: the uploaded file was only partially uploaded.'); return $attach; break;
			case 4: return $attach; break;
			default: break;
		}

		$FILE_NAME = trim($HTTP_POST_FILES['FILE_UPLOAD']['name']);
        $FILE_SIZE = $HTTP_POST_FILES['FILE_UPLOAD']['size'];

		if ($FILE_NAME == "" or !$HTTP_POST_FILES['FILE_UPLOAD']['name'] or ($FILE_NAME == 'none') ) {
			#access_log($exbb['member'] . ' - Filed upload file: file name was empty');
			return $attach;
		}

        if ($FILE_SIZE > $exbb['uploadsize'] && $FILE_SIZE > 0) {
			access_log($exbb['member'] . ' - Filed upload file: file to big');
			error($lang['Info'],$lang['Attach_tobig'],'',0);
		}

        $FILE_NAME = preg_replace( "/[^\w\.]/", "_", $FILE_NAME);

	if ($mode == 'post') {
        $storage_name = (empty($name)) ? 'file-'.$vars['forum'].'-'.time().'.ext' : $name;

        if ($vars['previewfirst'] == 'yes'){
          return array( 'FILE_NAME' => $FILE_NAME );
        }

		$img = false;

		if ( preg_match('#image\/[x\-]*([a-z]+)#', $HTTP_POST_FILES['FILE_UPLOAD']['type']) ) {
			list($width, $height) = @getimagesize($HTTP_POST_FILES['FILE_UPLOAD']['tmp_name']);
			$FILE_NAME = uniqid("att-").substr($FILE_NAME,-8);
			$storage_name = $FILE_NAME;
			$img = true;
			$filetoopen = $exbb['home_path'].'uploads/'.$name;
			if ( file_exists($filetoopen) ) @unlink($filetoopen);
		}


        if (! @move_uploaded_file( $HTTP_POST_FILES['FILE_UPLOAD']['tmp_name'], $exbb['home_path'].'uploads/'.$storage_name) )
        {
            access_log($exbb['member'] . ' - Filed upload to: '.$exbb['home_path'].'uploads/'.$storage_name);
			error($lang['Info'],$lang['upload_failed'],'',0);
        }
        else
        {
            @chmod( $exbb['home_path'].'uploads/'.$storage_name, 0777 );
        }


        $filetoopen = $exbb['home_path'].'forum'.$vars['forum'].'/attaches-'.$vars['topic'].'.php';
        $alldata = ( file_exists($filetoopen) ) ? get_file($filetoopen) : array();
        $id = (empty($oldid)) ? count($alldata) + 1 : intval($oldid);
        $alldata[$id]['id'] = $storage_name;
        $alldata[$id]['hits'] = 0;
        $alldata[$id]['file'] = $FILE_NAME;
		if ($img) $alldata[$id]['size'] = $width.':'.$height;
        save_file($filetoopen,$alldata);

        $attach['attach_id']  = $id;
        $attach['attach_file'] = $FILE_NAME;
        return $attach;
	} else {
		
		preg_match('#image\/[x\-]*([a-z]+)#', $HTTP_POST_FILES['FILE_UPLOAD']['type'], $filetype);

		if ( ($types = file($exbb['home_path']. 'im/avatars/personal/types.txt')) ) {

			if ( !strstr($types[0],$filetype[1]) ) {
				access_log($exbb['member'] . ' - Filed upload avatar: unsupported type - '.$filetype[1].' or type miss in im/avatars/personal/types.txt.');
				return $attach;
			}

		}

		switch ( $filetype[1] ) {
			case 'jpeg':
			case 'pjpeg':
			case 'jpg': $type = '.jpg';
				break;
			case 'gif': $type = '.gif';
				break;
			case 'png': $type = '.png';
				break;
			case 'bmp': $type = '.bmp';
				break;
			case 'tiff': $type = '.tiff';
				break;
			default:
				access_log($exbb['member'] . ' - Filed upload avatar: unsupported type - '.$filetype[1].' Contact to www.exbb.revansh.com');
				return $attach;
				break;
		}

		if ( (isset($HTTP_POST_FILES['FILE_UPLOAD']['type'])) && ($HTTP_POST_FILES['FILE_UPLOAD']['size'] > $exbb['avatar_size']) ) {
			access_log($exbb['member'] . ' - Filed upload avatar: size to big '.$HTTP_POST_FILES['FILE_UPLOAD']['size']);
			return $attach;
		}

		$avatar_name = $exbb['mem_id'] . '-avatar' . $type;
		$storage_name = 'personal/' . $avatar_name;
		
		list($width, $height) = @getimagesize($HTTP_POST_FILES['FILE_UPLOAD']['tmp_name']);

		if ( $width <= $exbb['avatar_max_width'] && $height <= $exbb['avatar_max_height'] ) {
			
			if (@move_uploaded_file( $HTTP_POST_FILES['FILE_UPLOAD']['tmp_name'], $exbb['home_path']. 'im/avatars/' .$storage_name) ) {
				@chmod( $exbb['home_path'] . 'im/avatars/' . $storage_name, 0777 );
				$attach['attach_file'] = $storage_name;

				if ( ($loaded = get_dir($exbb['home_path'] . 'im/avatars/personal/',$exbb['mem_id'] . '-avatar.*')) ) {
					foreach ($loaded as $trash) if ($trash != $avatar_name) @unlink($exbb['home_path'] . 'im/avatars/personal/' . $trash);
				}
				return $attach;
			}
			$attach['attach_file'] = $name;
			access_log($exbb['member'] . ' - Filed upload avatar: server can not move file to '.$exbb['home_path'] . 'im/avatars/personal/. Check chmod to dirs.');
			return $attach;

        }
		
	}

}


function sort_by_catid($a, $b) {
    if ($a['catid'] == $b['catid']) return 0;
    return ($a['catid'] < $b['catid']) ? -1 : 1;
}
function sort_by_position($a, $b) {
    if ($a['position'] == $b['position']) return 0;
    return ($a['position'] < $b['position']) ? -1 : 1;
}

function sort_by_postdate($a, $b) {
    if ($a['postdate'] == $b['postdate']) return 0;
    return ($a['postdate'] > $b['postdate']) ? -1 : 1;
}

function get_file($filename) {
  if ( $fp = @fopen($filename,'r') ) lock_file($fp,1);
  $str = @fread($fp,filesize($filename));
  @fclose($fp);
  return unserialize( substr($str,8,strlen($str)) );
}

function save_file($filename,$arr){
  $fp = fopen($filename,'w');
  lock_file($fp);
  fwrite($fp,'<?die;?>'.serialize($arr));
  fclose($fp);
}

function save_opened_file(&$pointer,$arr) {
  fseek ($pointer,0);
  ftruncate ($pointer,0);
  fwrite($pointer,'<?die;?>'.serialize($arr));
  fflush($pointer);
  @flock($pointer,3);
  fclose($pointer);
  unset($arr);
  return;
}

function myprint($arr = array()) {
#echo '<pre>';
var_dump($arr);
#print_r($arr);
#echo '</pre>';
return;
}

function lock_file(&$file,$mode = 2) {

  if ( preg_match('/[c-z]:\\\.*/i', $_SERVER['PATH']) ) return;
  $i = 0;
  while ( !flock($file,$mode) ) {
      sleep(1);
      $i++;
      if ($i>=10) {
          @fclose($file);
          die('Access to file blocked! Try again later<br>You may save your message:<br>'.$_POST['inpost']);
      }
  }

}

function get_dir($path = './', $mask = '*.php', $mode = GLOB_NOSORT) {
	global $exbb;

	if ( version_compare( phpversion(), '4.3.0', '>=' ) ) {
		if ( chdir($path) ) {
			$temp = glob($mask,$mode);
			chdir($exbb['home_path']);
			return $temp;
		}
	}
	return false;

}
?>