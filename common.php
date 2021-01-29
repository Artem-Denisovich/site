<?
error_reporting  (E_ERROR | E_PARSE);
#error_reporting  (E_ALL);

session_start();

$exbb = array();

$mtime = microtime();
$mtime = explode(' ',$mtime);
$exbb['starttime'] = $mtime[1] + $mtime[0];

$lang = array();
$vars = array();
$exbb['ver'] = '1.9.1';
include ('./data/boardinfo.php');
###########
$exbb['ch_files'] = 0777;
$exbb['ch_dirs'] = 0777; 
###########

include_once('page_header.php');

include('lib.php');

$exbb['reged'] = checklgn();

$exbb['mem_id'] = $_SESSION['mid'];
$exbb['sesid'] = session_name().'='.session_id();

$exbb['sts'] = $exbb['reged'] ? $_SESSION['sts'] : '';
$exbb['usertime'] = $exbb['reged'] ? $_SESSION['time'] : 0;
$exbb['last_visit'] = $_SESSION['last_visit'];

$root = str_replace( '\\', '/', getcwd() ) . '/';
if ( $exbb['home_path'] != $root ) {
	echo 'Нет доступа к файлу data/boardinfo.php или нарушена его структура, либо не верно задан путь к файлам форума! Проверьте права.';
	$exbb['home_path'] = $root;
}

$exbb['member'] = 'Guest';

$inuser = array();

if ($exbb['reged']) {

	$inuser = getmember($exbb['mem_id']);

    if ( $_SESSION['iden'] != md5($inuser['name'].$inuser['pass']) || !$inuser) {
		
		if (!session_destroy()) session_unset();
		my_setcookie('exbbn','',-1);
		my_setcookie('exbbp','',-1);
		my_setcookie('t_visits','',-1);
		die('Your must <a href="index.php">relogin</a>!');
	}
	
	$exbb['member'] = $inuser['name'];
    $exbb['mem_id'] = intval($inuser['id']);
    $exbb['sts'] = $inuser['status'];
	#$_SESSION['time'] = intval($inuser['timedif']);

    if ($inuser['status'] == 'ad') { define('IS_ADMIN', true); }

	user_locale($inuser);

}

if ( !file_exists($exbb['home_path'] . 'templates/' . $exbb['default_style'] . '/board_body.tpl') ) die('ERROR! No skin files in templates folder!');

$exbb['default_style'] .= '/';

include('./language/' . $exbb['default_lang'] . '/lang.php');

if (!$exbb['reged']) $exbb['member'] = $lang['Unreg'];

if ($inuser['status'] == 'banned') error($lang['Error_login'],$lang['Login_dinied']);

if( $exbb['board_closed'] && !(defined('IS_LOGIN') || defined('IS_ADMIN')) ) error($lang['Board_disabled'], $exbb['board_closed_mes'],'',0);
?>