<?
/***************************************************************************
 * ExBB v.1.1                                                              *
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

error_reporting  (0);
$vars = parsed_vars();
$vars['safe_mode'] = ini_get('safe_mode') ? 1 : 0;

if ( file_exists('install.lock') )
{
    out_error("Инсталлятор заблокирован!<br>Для запуска инсталлятора удалите (через FTP) файл 'install.lock'");
    exit();
}

switch($vars['s'])
{
    case '1':
        form_one();
        break;

    case '2':
        form_two();
        break;

    default:
        form_begin();
        break;
}


function form_begin()
{
    global $vars;

    out_header('Здравствуйте!');
    $safe = $vars['safe_mode'] ? 'т.к. активирован SAFE MODE, то вероятнее всего это - 0777' : 'на многих хостингах - 0777, иногда достаточно 0666';
    $vars['contents'] .= "<tr>
                              <td class='catname'>&#149;&nbsp;Здравствуйте!</td>
                            <tr>
                            <td>
                              <table cellpadding='8' cellspacing='0' width='100%' align='center' border='0' class='forumbar'>
                              <tr>
                                <td>
                              <table width='100%' cellspacing='1' cellpadding='0' align='center' border='0'>
                               <tr>
                                <td>
                                 <table width='100%' cellspacing='2' cellpadding='3' align='center' border='0'>
                                 <tr class='normal'>
                                   <td class='postclr1'>
                                           <b>Вас приветствует инсталлятор Exclusive Bulletin Board</b>
                                           <br><br>
                                           Прежде чем продолжить, пожалуйста убедитесь, что все файлы загружены на сервер, а также для директорий:<br>
                                           <ul><li>data</li><li>members</li><li>messages</li><li>im</li><li>im/avatars</li><li>im/avatars/personal</li><li>search</li><li>search/db</li><li>uploads</li></ul> и на все файлы в директории 'data' установлены права на запись из скрипта ( $safe ).
                                           <br><br>
                                           Во время установки Вам потребуется подтвердить правильность определения пути до скриптов на сервере,
                                           а также будет создан аккаунт Администратора конференции.
                                           <br><br>
                                           <b>БУДЬТЕ ВНИМАТЕЛЬНЫ: ПРИ ИСПОЛЬЗОВАНИИ ЭТОГО СКРИПТА СОЗДАЁТСЯ АККАУНТ АДМИНИСТРАТОРА И ПРОПИСЫВАЮТСЯ ОСНОВНЫЕ ПУТИ.
                                           ДЛЯ ИСКЛЮЧЕНИЯ НЕПРАВОМЕРНЫХ ДЕЙСТВИЙ, УДАЛИТЕ ФАЙЛ install.php ПОСЛЕ УСТАНОВКИ</b>
                                       </td>
                                 </tr>
                                </table>
                              </td>
                             </tr>
                            </table>
                           </td>
                          </tr>
                         </table>";

    $data_dir = './data';
    $members_dir = './members';
    $info_file = './data/boardinfo.php';
    $mes_dir = './messages';

    $warnings = array();

    if ( !is_writeable($info_file) )
    {
        $warnings[] = "Права на запись в файл 'boardinfo.php' в директории 'data' не установлены!";
    }
    if ( !is_writeable($data_dir) )
    {
        $warnings[] = "Права на запись в директорию 'data' не установлены!";
    }
    if ( !is_writeable($members_dir) )
    {
        $warnings[] = "Права на запись в директорию 'members' не установлены!";
    }
    if ( !is_writeable($mes_dir) )
    {
        $warnings[] = "Права на запись в директорию 'messages' не установлены!";
    }

    if (!function_exists('version_compare') ) {
        $warnings[] = 'Вы не можете продолжить установку форума Exclusive Bulletin Board. Для работы форума требуется PHP версии 4.1.0 или выше. У Вас РНР весрии: '.phpversion();
    }

    if ( count($warnings) > 0 )
    {

        $err_string = "<ul><li>".implode( "<li>", $warnings )."</ul>";

        $vars['contents'] .= "<tr>
                              <td class='big'>&#149;&nbsp;Внимание!</td>
                            <tr>
                            <td>
                              <table cellpadding='8' cellspacing='0' width='100%' align='center' border='0' class='forumbar'>
                              <tr>
                                <td>
                              <table width='100%' cellspacing='1' cellpadding='0' align='center' border='0'>
                               <tr>
                                <td>
                                 <table width='100%' cellspacing='2' cellpadding='3' align='center' border='0'>
                                 <tr>
                                   <td>
                                           <b>Чтобы продолжить Вы должны устранить следующие ошибки!</b>
                                           <br><br>
                                           $err_string
                                       </td>
                                 </tr>
                                </table>
                              </td>
                             </tr>
                            </table>
                           </td>
                          </tr>
                         </table>";
    }
    else
    {
        $vars['contents'] .= "<tr><td align='center' style='font-size:18px'><br><b><a href='install.php?s=1'>Начать установку &gt;&gt;</a></b></td></tr>";
    }


    out_content();
}



    function out_header($title="") {
    global $vars;

$vars['contents'] = <<<DATA
            <html>
                  <head><title>Exclusive Bulletin Board :: $title </title>
                  <link rel='stylesheet' href="./templates/Original/style.css" type="text/css">
                  </head>
                 <body marginheight='0' marginwidth='0' leftmargin='0' topmargin='0' bgcolor='#FFFFFF'>

                 <table width='100%' height='70' cellpadding='0' cellspacing='0' border='0' class='bodyline'>
                    <tr>
                        <td align='center'><img src='./im/logo_ExBB.gif' width='126' height='58'></td>
                    </tr>
                </table>
                <br>
                <table width='90%' cellpadding='0' cellspacing='0' border='0' align='center'>
DATA;

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


    function out_content() {
    global $vars;
        echo $vars['contents'];
        echo "
                 </table>
                 <br><br><center><span class='copyright'>&copy 2003 Exclusive Bulletin Board (www.ExBB.revansh.com)</span></center>

                 </body>
                 </html>";
        exit();
    }

function form_one()
{
    global $vars, $HTTP_SERVER_VARS;

    out_header('Конфигурирование');

    //--------------------------------------------------

    $this_url = dirname($HTTP_SERVER_VARS['HTTP_REFERER']);

    if ( ! $this_url )
    {
        $this_url = substr($HTTP_SERVER_VARS['SCRIPT_NAME'],0, -16);

        if ($this_url == '')
        {
            $this_url = '/';
        }
        $this_url = 'http://'.$HTTP_SERVER_VARS['SERVER_NAME'].$this_url;
    }
    $root = str_replace( '\\', '/', getcwd() ) . '/';


    //--------------------------------------------------

    $vars['contents'] .= "<tr>
                              <td class='catname'>&#149;&nbsp;Конфигурация Вашего сервера</td>
                            <tr>
                            <td>
                              <form action='install.php' method='POST'>
                              <input type='hidden' name='s' value='2'>
                              <table cellpadding='8' cellspacing='0' width='100%' align='center' border='0' class='forumbar'>
                              <tr>
                                <td>
                              <table width='100%' cellspacing='1' cellpadding='0' align='center' border='0'>
                               <tr>
                                <td>
                                 <table width='100%' cellspacing='2' cellpadding='3' align='center' border='0'>
                                 <tr>
                                   <td colspan='2' class='forumline1'>
                                           Здесь Вам необходимо ввести путь и URL до скриптов форума на сервере.
                                       </td>
                                 </tr>

                                 <tr>
                                   <td width='40%' class='forumline1'><b>URL до скриптов</b><br>URL (должен начинаться с http://) адрес, где находятся скрипты<br><i>(например http://www.your_site.ru/forums)</i></td>
                                   <td width='60%' class='forumline1'><input type='text' style='width: 400px' name='boardurl' value='$this_url'></td>
                                 </tr>

                                 <tr>
                                   <td colspan='2' class='forumline1'>
                                           Здесь Вам необходимо ввести полный путь до скриптов форума на сервере.
                                       </td>
                                 </tr>

                                 <tr>
                                   <td width='40%' class='forumline1'><b>Путь до скриптов</b><br>Путь (должен быть вида /home/www/domain/exbb/), где находятся скрипты</td>
                                   <td width='60%' class='forumline1'><input type='text' style='width: 400px' name='home_path' value='$root'></td>
                                 </tr>

                                </table>
                              </td>
                             </tr>
                            </table>
                           </td>
                          </tr>
                         </table>

                         </td>
                         </tr>

                         <tr>
                              <td class='catname'>&#149;&nbsp;Зарегистрируйтесь как Администратор</td>
                            <tr>
                            <td>
                              <table cellpadding='8' cellspacing='0' width='100%' align='center' border='0' class='forumbar'>
                              <tr>
                                <td>
                              <table width='100%' cellspacing='1' cellpadding='0' align='center' border='0'>
                               <tr>
                                <td>
                                 <table width='100%' cellspacing='2' cellpadding='3' align='center' border='0'>
                                 <tr>
                                   <td colspan='2' class='forumline1'>
                                           Здесь Вам необходимо ввести Ваше имя на форуме в качестве Администратора. Дважды всё проверьте!
                                       </td>
                                 </tr>

                                 <tr>
                                   <td width='40%' class='forumline1'><b>Имя</b></td>
                                   <td width='60%' class='forumline1'><input type='text'  style='width: 200px' name='adminname' value=''></td>
                                 </tr>

                                 <tr>
                                   <td width='40%' class='forumline1'><b>Пароль</b></td>
                                   <td width='60%' class='forumline1'><input type='password' style='width: 200px' name='adminpassword' value=''></td>
                                 </tr>

                                 <tr>
                                   <td width='40%' class='forumline1'><b>Повторите пароль</b></td>
                                   <td width='60%' class='forumline1'><input type='password' style='width: 200px' name='adminpassword2' value=''></td>
                                 </tr>

                                 <tr>
                                   <td width='40%' class='forumline1'><b>Email</b></td>
                                   <td width='60%' class='forumline1'><input type='text' class='input' name='email' value=''></td>
                                 </tr>

                                 <tr>
                                     <td colspan='2' class='forumline1' align='center'><input type='submit' value='Продолжить'></td>
                                 </tr>
                                </table>
                              </td>
                             </tr>
                            </table>
                           </td>
                          </tr>
                         </table>
                         </form>
                         </td>
                         </tr>
                         ";

    out_content();

}

function form_two()
{
    global $vars, $HTTP_POST_VARS;

    $need = array('boardurl','home_path','adminname','adminpassword','adminpassword2','email');

    //-----------------------------------

    foreach($need as $greed)
    {
        if ($vars[ $greed ] == "")
        {
            out_error("Вы должны заволнить все поля формы!");
        }
    }

    //-----------------------------------

    $vars['boardurl'] = preg_replace( "#/$#", "", $vars['boardurl'] );

    if ($vars['adminpassword2'] != $vars['adminpassword'])
    {
        out_error("Вы ввели разные пароли!");
    }

    $require = './data/board_info.tpl';

    if ( ! file_exists($require) )
    {
        out_error("Не доступен файл '$require'. Вы неправильно указали путь до скриптов на сервере!");
    }

$new_exbb['boardurl'] = $vars['boardurl'];
$new_exbb['home_path'] = $vars['home_path'];
$new_exbb['boardname'] = 'Название форума';
$new_exbb['boarddesc'] = 'описание форума';
$new_exbb['announcements'] = 1;
$new_exbb['topics_per_page'] = 15;
$new_exbb['posts_per_page'] = 10;
$new_exbb['ch_files'] = '0777';
$new_exbb['ch_dirs'] = '0777';
$new_exbb['ru_nicks'] = 1;
$new_exbb['reg_simple'] = 0;
$new_exbb['default_lang'] = 'russian';
$new_exbb['default_style'] = 'Original';
$new_exbb['membergone'] = 15;
$new_exbb['gzip_compress'] = 0;
$new_exbb['board_closed'] = 0;
$new_exbb['board_closed_mes'] = '';
$new_exbb['pm'] = 1;
$new_exbb['text_menu'] = 1;
$new_exbb['exbbcodes'] = 1;
$new_exbb['emoticons'] = 1;
$new_exbb['ratings'] = 1;
$new_exbb['wordcensor'] = 1;
$new_exbb['autoup'] = 0;
$new_exbb['sig'] = 1;
$new_exbb['max_sig_chars'] = 100;
$new_exbb['max_sig_lin'] = 3;
$new_exbb['avatars'] = 1;
$new_exbb['adminemail'] = '';
$new_exbb['emailfunctions'] = 1;
$new_exbb['boardstart'] = time();
$new_exbb['mail_posts'] = 1;
$new_exbb['max_posts'] = 10240;
$new_exbb['anti_bot'] = 0;
$new_exbb['reg_on'] = 1;
$new_exbb['passwordverification'] = 1;
$new_exbb['newusernotify'] = 1;
$new_exbb['flood_limit'] = 30;
$new_exbb['location'] = 0;
$new_exbb['hot_topic'] = 15;
$new_exbb['tablewidth'] = '95%';
$new_exbb['avatar_upload'] = 0;
$new_exbb['avatar_size'] = 6124;
$new_exbb['avatar_max_width'] = 80;
$new_exbb['avatar_max_height'] = 80;
$new_exbb['file_upload'] = 1;
$new_exbb['log'] = 1;
$new_exbb['show_img'] = 1;

   $board_config = '';
   include($require);

   if (empty($board_config)) {
      out_error("Файл ./data/board_info.tpl' отсутствует, либо неправильно закачан на сервер. Закачайте все файлы из директории 'templates' заново в ASCII формате.");
   }

    $filetomake = $new_exbb['home_path'].'data/boardinfo.php';

    if ( $fp = fopen($filetomake,'w') )
    {
         fwrite($fp,$board_config);
         fclose($fp);
    }
    else
    {
        out_error("Запись в файл '$new_exbb[home_path]"."data/boardinfo.php' невозможна!");
    }

    $forums = array();
    $filetomake = $new_exbb['home_path'].'data/allforums.php';
    if ( $fp = fopen($filetomake,'w') )
    {
         fwrite($fp,'<?die;?>'.serialize($forums));
         fclose($fp);
    }
    else
    {
        out_error("Запись в файл './data/allforums.php' невозможна!");
    }
    // Insert the admin...

    $passy = md5($vars['adminpassword']);
    $time  = time();
    $vars['email'] = strtolower($vars['email']);

    $user = array();
    $user['name'] = $vars['adminname'];
    $user['id'] = 1;
    $user['pass'] = $vars['adminpassword'];
    $user['status'] = 'ad';
    $user['title'] = 'Администратор';
    $user['posts'] = 0;
    $user['mail'] = $vars['email'];
    $user['showemail'] = false;
    $user['www'] = '';
    $user['aim'] = '';
    $user['icq'] = '';
    $user['location'] = '';
    $user['joined'] = $time;
    $user['sig'] = '';
    $user['timedif'] = 0;
    $user['upload'] = true;
    $user['avatar'] = 'noavatar.gif';
	$lang['replace'] = array ('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я','q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m');
	$lang['search'] = array ("'А'","'Б'","'В'","'Г'","'Д'","'Е'","'Ё'","'Ж'","'З'","'И'","'Й'","'К'","'Л'","'М'","'Н'","'О'","'П'","'Р'","'С'","'Т'","'У'","'Ф'","'Х'","'Ц'","'Ч'","'Ш'","'Щ'","'Ъ'","'Ы'","'Ь'","'Э'","'Ю'","'Я'","'Q'","'W'","'E'","'R'","'T'","'Y'","'U'","'I'","'O'","'P'","'A'","'S'","'D'","'F'","'G'","'H'","'J'","'K'","'L'","'Z'","'X'","'C'","'V'","'B'","'N'","'M'");


    $filetomake = $new_exbb['home_path'].'members/1.php';
    if ( $fp = fopen($filetomake,'w') )
    {
         fwrite($fp,'<?die;?>'.serialize($user));
         fclose($fp);
		 @chmod($filetomake,0777);
         $fp = fopen($new_exbb['home_path'].'data/users.php','w');
         $user = array();
         $user[1]['n'] = preg_replace ($lang['search'], $lang['replace'], $vars['adminname']);
         $user[1]['m'] = $vars['email'];
         fwrite($fp,'<?die;?>'.serialize($user));
         fclose($fp);
         @chmod($new_exbb['home_path'].'data/users.php',0777); 
         save_statfile();
	     @chmod($new_exbb['home_path'].'data/boardstats.php',0777);	
    }
    else
    {
        out_error("Запись в файл '$new_exbb[home_path]".'members/1.php\' невозможна!');
    }

    out_header('Ок!');

    if ($fp = @fopen( $new_exbb['home_path'].'install.lock', 'w' ) )
    {
        @fwrite( $fp, 'lock', 4 );
        @fclose($fp);

        @chmod( $new_exbb['home_path'].'install.lock', 0666 );


        $vars['contents'] .= "<tr>
                                  <td class='catname'>&#149;&nbsp;Установка успешно завершена!</td>
                                <tr>
                                <td>
                                  <table cellpadding='8' cellspacing='0' width='100%' align='center' border='0' class='forumbar'>
                                  <tr>
                                    <td>
                                  <table width='100%' cellspacing='1' cellpadding='0' align='center' border='0'>
                                   <tr>
                                    <td>
                                     <table width='100%' cellspacing='2' cellpadding='3' align='center' border='0'>
                                     <tr>
                                       <td>
                                            <b>Ваш форум установлен!</b>
                                            <br><br>
                                            Теперь инсталляция форума заблокирована (чтобы переустановить форум, удалите файл 'install.lock').
                                            Рекомендуем также удалить файл 'install.php'.
                                            <br><br>
                                            <center><b><a href='loginout.php'>Войти на форум</a></center>
                                        </td>
                                     </tr>
                                    </table>
                                  </td>
                                 </tr>
                                </table>
                               </td>
                              </tr>
                             </table>";
    }
    else
    {

     $vars['contents'] .= "<tr>
                              <td class='big'>&#149;&nbsp;Внимание!</td>
                            <tr>
                            <td>
                              <table cellpadding='8' cellspacing='0' width='100%' align='center' border='0' class='forumbar'>
                              <tr>
                                <td>
                              <table width='100%' cellspacing='1' cellpadding='0' align='center' border='0'>
                               <tr>
                                <td>
                                 <table width='100%' cellspacing='2' cellpadding='3' align='center' border='0'>
                                 <tr>
                                   <td>
                                        <b>Ваш форум установлен!</b>
                                        <br><br>
                                        ОБЯЗАТЕЛЬНО УДАЛИТЕ ЭТОТ ИНСТАЛЛЯТОР ('install.php') ПРЕЖДЕ ЧЕМ ПРОДОЛЖИТЬ!
                                        <br>
                                        Если этого не сделать, то любой может удалить форум!
                                        <br><br>
                                        <center><b><a href='loginout.php'>Войти на форум</a></center>
                                    </td>
                                 </tr>
                                </table>
                              </td>
                             </tr>
                            </table>
                           </td>
                          </tr>
                         </table>";
    }

    out_content();

}

function save_statfile() {
global $vars;

  $filetomake = $vars['home_path'].'data/boardstats.php';
  $tofile="<?\n\$exbb['lastreg'] = '$vars[adminname]';\n\$exbb['last_id'] = '1';\n\$exbb['totalmembers'] = '1';\n\$exbb['totalthreads'] = '0';\n\$exbb['totalposts'] = '0';\n?>";
  $fp = @fopen($filetomake, 'w');
  @fwrite($fp, $tofile);
  @fclose($fp);
  return;
}

function out_error($msg="")
{
    global $vars;

    out_header('Внимание!');

    $vars['contents'] .= "<tr>
                          <td class='big'>&#149;&nbsp;Внимание!</td>
                        <tr>
                        <td>
                          <table cellpadding='8' cellspacing='0' width='100%' align='center' border='0' class='forumbar'>
                          <tr>
                            <td>
                          <table width='100%' cellspacing='1' cellpadding='0' align='center' border='0'>
                           <tr>
                            <td>
                             <table width='100%' cellspacing='2' cellpadding='3' align='center' border='0'>
                             <tr>
                               <td>
                                    <b>Для продолжения устраните следующие ошибки!</b><br>Вернитесь назад и поробуйте снова!
                                    <br><br>
                                    $msg
                                </td>
                             </tr>
                            </table>
                          </td>
                         </tr>
                        </table>
                       </td>
                      </tr>
                     </table>";

    out_content();
}

?>