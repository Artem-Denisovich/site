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

include('common.php');

$vars = parsed_vars();

switch ($vars['action']) {
    case 'newposts': newpostst(); break;
    case 't': in_topic(); break;
    case 'members': members(); break;
    default: search(); break;
}

include('page_tail.php');

function newpostst() {
global $exbb,$vars,$lang,$inuser;

  $allforums = get_file($exbb['home_path'].'data/allforums.php');

  $newest = array();
  foreach ($allforums as $id=>$forum) {
    if ( isset($forum['last_time']) && $forum['last_time'] > $exbb['last_visit'] ) {
      if ($forum['private'] && !$inuser['private'][$id]) continue;
      $newest[] = $id;
    }
  }
  if (count($newest)) {
    $to_show = array();
    foreach ($newest as $inforum) {
      $filetoopen = $exbb['home_path'].'forum'.$inforum.'/list.php';
      $topics = array();
      $topics = get_file($filetoopen);
      $keys = array_keys($topics);
      foreach ($keys as $id=>$topicid) {
        if ($topics[$topicid]['postdate'] >= $exbb['last_visit'] && $topics[$topicid]['p_id'] != $exbb['mem_id']) {
          $date = $topics[$topicid]['postdate'];
          $to_show[$date] = $topics[$topicid]; //all info about topic
          $to_show[$date]['f_id'] = $inforum;
          $to_show[$date]['t_id'] = $topicid;
        } else { break 1;}
      }
    }
    unset($topics,$newest);

    if (!count($to_show)) error($lang['Main_msg'],$lang['No_newposts'],'',0);

    krsort($to_show,SORT_NUMERIC);

    $data = '';
    $l_v = $exbb['last_visit'];
    $t_visits = (isset($_COOKIE['t_visits'])) ? unserialize($_COOKIE['t_visits']) : array();

    $pinned = get_file($exbb['home_path'].'forum'.$inforum.'/_pinned.php');

    foreach ($to_show as $date=>$topic){
       if ($f_readed = (isset($_COOKIE['f'.$inforum])) ? $_COOKIE['f'.$inforum] : 0) {
         $exbb['last_visit'] = $f_readed > $exbb['last_visit'] ? $f_readed : $exbb['last_visit'];
       }

       if ( isset($pinned[$topic['t_id']]) ) $topic['state'] = 'pinned';
       $top_id = $topic['f_id'].$topic['t_id'];
       $topicicon = topic_icon($topic,$t_visits[$top_id]);

       $m_id = isset($topic['a_id']) ? $topic['a_id'] : 0;
       $p_id = isset($topic['p_id']) ? $topic['p_id'] : 0;

       $t_name = sprintf('<a href="topic.php?forum=%d&topic=%d&v=l#%d">%s</a>',$topic['f_id'],$topic['t_id'],$date,wordwrap($topic['name'], 32, ' &shy; ', 1));
       $t_desc = wordwrap($topic['desc'], 32, ' &shy; ', 1);
       $f_name = sprintf('<a href="forums.php?forum=%d">%s</a>',$topic['f_id'],$allforums[$topic['f_id']]['name']);
       $t_post = $topic['posts'];
       $t_strt = $topic['author'] ? $topic['author'] : $lang['Unreg'];
       $poster = $topic['poster'] ? $topic['poster'] : $lang['Unreg'];
       $p_date = longdate($date+$exbb['usertime']*3600);
       include('./templates/'.$exbb['default_style'].'newposts_data.tpl');
    }
    $found = count($to_show);
    $icon_path = './templates/'.$exbb['default_style'].'im';
    $title_page = $exbb['boardname'].' :: '.$lang['Search'];
    include('./templates/'.$exbb['default_style'].'all_header.tpl');
    include('./templates/'.$exbb['default_style'].'logos.tpl');
    include('./templates/'.$exbb['default_style'].'newposts.tpl');
    include('./templates/'.$exbb['default_style'].'footer.tpl');
  }
  else {
    error($lang['Main_msg'],$lang['No_newposts'],'',0);
  }

}

function in_topic() {
global $exbb,$vars,$lang;

  $title_page = $exbb['boardname'].' :: '.$lang['Search'];
  include('./templates/'.$exbb['default_style'].'all_header.tpl');
  include('./templates/'.$exbb['default_style'].'logos.tpl');
  include('./templates/'.$exbb['default_style'].'srch_intop.tpl');
  include('./templates/'.$exbb['default_style'].'footer.tpl');
}

function members() {
global $exbb,$vars,$lang;

  include($exbb['home_path'] . 'language/' . $exbb['default_lang'] . '/lang_reg.php');

  $filetoopen = $exbb['home_path'].'data/users.php';
  $users = get_file($filetoopen);

  $total = count($users);

  $pages = ($total) ? ceil($total/30) : 1;
  $pagestart = ( isset($vars['p']) ) ? intval($vars['p']) : 1;

  $sort = ( $vars['s'] == 'n' ) ? 'n' : 'd';

  $order = ( $vars['order'] == 'DESC') ? 'DESC' : 'ASC';

  $sort_arr = array('d'=>$lang['Sort_join'], 'n'=>$lang['Sort_name']);

  $sort_mode = '<select name="s" class="dats">';
  foreach($sort_arr as $mode=>$name) {
    $selected = ( $mode == $sort ) ? ' selected="selected"' : '';
    $sort_mode .= '<option value="' . $mode . '"' . $selected . '>' . $name . '</option>';
  }
  $sort_mode .= '</select>';
  unset($sort_arr);

  if ($sort == 'd') {
      ksort($users,SORT_NUMERIC);
  } else {
      uasort($users, 'sort_by_name');
  }
  $ids = array_keys($users);
  unset($users);

  $sort_order = '<select name="order" class="dats">';
  if ($order == 'ASC') {
    $sort_order .= '<option value="ASC" selected="selected">' . $lang['Sort_asc'] . '</option><option value="DESC">' . $lang['Sort_desc'] . '</option>';
  } else {
    $sort_order .= '<option value="ASC">' . $lang['Sort_asc'] . '</option><option value="DESC" selected="selected">' . $lang['Sort_desc'] . '</option>';
    $ids = array_reverse($ids);
  }
  $sort_order .= '</select>';
  $p_order = '&s='.$sort.'&order='.$order;
  if ($pagestart < 1 or $pagestart > $pages) $pagestart = 1;

  if ($total > 30) {
     $startarray = ($pagestart - 1) * 30;
     $endarray = 30;
     $page = '';
     for($i=1;$i<=$pages;$i++){
       if ($pagestart != $i) {$page .= '<a href="search.php?action=members&p='.$i.$p_order.'">'.$i.'</a> ';}
       else {$page .= '<span class="moder">['.$i.']</span> ';}
     }
     $pages = '<b>'.$lang['Pages'].'</b> ('.$pages.'): '.$page;
  }
  else {
     $startarray = 0;
     $pages = $lang['Pages'].' ('.$pages.')';
     $endarray = $total;
  }


  $ids = array_slice($ids,$startarray,$endarray);

  $profile = $lang['User_info'];
  foreach ($ids as $id) {

    $member = getmember($id);
    if (!$member) { continue; }
    $name = $member['name'];
    $posts = $member['posts'];

	if (!empty($member['title']) && $member['status'] != 'banned' ) { $title = $member['title']; }
	else { switch ($member['status']) {
             case 'ad' : $title = $lang['Admin']; break;
             case 'me' : $title = $lang['User']; break;
             case 'banned' : $title = $lang['User_banned']; break;
          }
	}
    $location = $member['location'];
    $joined = date("d.m.Y", $member['joined']);
    if ($member['www'] != 'http://') {
      $member['www'] = str_replace('http://','',$member['www']);
      $www = (strlen($member['www']) > 4) ? '<a href="http://'.$member['www'].'" target="_blank">'.$lang['Look'].'</a>' : '&nbsp;';
    }
    $email = ($member['showemail']) ? '<a href="mailto:'.$member['mail'].'">'.$lang['Write'].'</a>' : '<a href="tools.php?mid='.$member['id'].'">'.$lang['Write'].'</a>';
    $icq = ($member['icq']) ? '<a href="http://wwp.icq.com/scripts/search.dll?to='.$member['icq'].'"><img src="http://online.mirabilis.com/scripts/online.dll?icq='.$member['icq'].'&img=5" align=abscenter width=18 height=18 border=0></a>' : '&nbsp;';

    $class = ( !($id % 2) ) ? 'row1' : 'row2';

    include('./templates/'.$exbb['default_style'].'memb_data.tpl');
  }

  $title_page = $exbb['boardname'].' :: '.$lang['Search'];
  include('./templates/'.$exbb['default_style'].'all_header.tpl');
  include('./templates/'.$exbb['default_style'].'logos.tpl');
  include('./templates/'.$exbb['default_style'].'memblist.tpl');
  include('./templates/'.$exbb['default_style'].'footer.tpl');

}

function sort_by_name($a, $b) {
    return strcmp($a['n'], $b['n']);
}

function sort_by_posts($a, $b) {
    if ($a['posts'] == $b['posts']) return 0;
    return ($a['posts'] < $b['posts']) ? -1 : 1;
}


function search() {
global $exbb,$vars,$lang;

    $allforums = get_file($exbb['home_path'].'data/allforums.php');

    if ( !isset($vars['action']) ) {

        $forums = '<option value="-1"> '.$lang['IN_ALL']."\n";

        $last_cat = -1;

        foreach($allforums as $forumid=>$val){
            if ($val['catid'] != $last_cat) $forums .= '<option value="cat:'.$val['catid'].'">-- &nbsp; '.$val['catname']."\n";
            $forums .= '<option value="'.$forumid.'"> '.$val['name']."\n";

            $last_cat = $val['catid'];
        }
        $title_page = $exbb['boardname'].' :: '.$lang['Search'];

        if ( !file_exists($exbb['home_path'].'templates/'.$exbb['default_style'].'search.tpl') ) $exbb['default_style'] = 'Original/';

        include('./templates/'.$exbb['default_style'].'all_header.tpl');
        include('./templates/'.$exbb['default_style'].'logos.tpl');
        include('./templates/'.$exbb['default_style'].'search.tpl');
        include('./templates/'.$exbb['default_style'].'footer.tpl');
		

    }
    elseif ( $vars['action'] == 'start' )  {

        preg_match_all('/([a-zA-Zа-яА-Я]+){3,}/',$vars['search_keywords'],$key_words);
#        preg_match_all('/([a-zA-Zа-яА-Я0-9]+){2,}/',$vars['search_author'],$by_author);

        if ( !count($key_words[0]) ) error($lang['Search'],$lang['SRCH_NOPARAM']);

        $key_words = array_unique($key_words[0]);
#        $by_author = array_unique($by_author[0]);

        switch ($vars['stype']) {
            case 'AND': $type = 'AND'; break;
            case 'OR': $type = 'OR'; break;
            default: $type = 'AND'; break;
        }

        if ( strstr($vars['src_in'],'cat') ) {
            list($in_where,$in_range) = explode(':',$vars['src_in']);
        } else {
            $in_where = 'forum';
            $in_range = $vars['src_in'];
        }
/*
        switch ($vars['search_in']) {
            case 'tit_psts': $search_in = 'tit_psts'; break;
            case 'posts': $search_in = 'posts'; break;
            default: $search_in = 'posts'; break;
        }

        switch ($vars['result_type']) {
            case 'topics': $result_type = 'topics'; break;
            case 'posts': $result_type = 'posts'; break;
            default: $result_type = 'forum'; break;
        }
*/
        #Определим каталоги форумов, в которых будем искать

        #$allforums = get_file($exbb['home_path'].'data/allforums.php');

        $dir_arr = array();

        if ( $in_range == -1 ) { foreach ($allforums as $forumid=>$val) $dir_arr[$forumid] = 0; }
        elseif ( $in_where == 'cat') { foreach ($allforums as $forumid=>$val) if ($in_range == $val['catid']) $dir_arr[$forumid] = 0; }
        else { $dir_arr[$in_range] = 0; }

        if ( !count($dir_arr) ) error($lang['Search'],$lang['SRCH_ERR']);
/*
        #Сохраним определённые параметры поиска
        $search = array();

        $search['type'] = $type;
        $search['key_words'] = $key_words;
        $search['by_author'] = $by_author;
        $search['search_in'] = $search_in;
        $search['result_type'] = $result_type;
        $search['range'] = $dir_arr;
        #$search['found'] = array();

        if ( $fp = @fopen($exbb['home_path'].'search/'.session_id(),'wb') ) {
            save_opened_file($fp,array());
            $_SESSION['srch'] = serialize($search);
        }
        else {
            error('ERROR','Поиск невозможен. ','',0);
        }
*/
        include('./search/search.php');

        $wholeword = $querymode = $query_arr = array();

        get_query($wholeword,$querymode,$query_arr);


        $vars['query_statistics'] = '';

        $total_fount = 0;

        if (count($query_arr) > 0) {

          foreach ($dir_arr as $forum => $trash) {
            if ($allforums[$forum]['private'] && !$inuser['private'][$forum]  ) {
              continue;
            }
            $allres = array();
            get_results($forum,$wholeword,$querymode,$query_arr,$allres);
            boolean($forum,$query_arr,$querymode,$allres);
            $total_fount += $vars['rescount'][$forum];
          }

          if ($total_fount) {

            if ( $fp = @fopen($exbb['home_path'].'search/'.session_id(),'wb') ) {
              save_opened_file($fp,$vars);
            }

            error($lang['SRCH_COMPLT'],sprintf($lang['SRCH_RESULT'],$total_fount),'<meta http-equiv="refresh" content="2; url=search.php?action=next&'.$exbb['sesid'].'">',0);

          } else {
              error($lang['SRCH_COMPLT'],$lang['SRCH_NO'],'',0);
          }

        }
        else {
          error($lang['Search'],$lang['SRCH_NOPARAM']);
        }

    }
    elseif ( $vars['action'] == 'next' )  {

/*        $search = $exbb['home_path'].'search/'.session_id();
        if ( file_exists($search) ) {
            $founded = get_file($fp);
            $search = unserialize($_SESSION['srch']);
        }
        else {
            error('ERROR','Поиск невозможен. ','',0);
        }

        if ( !isset($search['cur_forum']) ) {
            $search['cur_forum'] = key($search['range']);
            unset($search['range'][$search['cur_forum']]);
        }

        if ($search['search_in'] == 'tit_psts') {
            $filetoopen = $exbb['home_path'].'forum'.$search['cur_forum'].'/list.php';
        }
*/

        include('./search/search.php');

        $data = $exbb['home_path'].'search/'.session_id();
        $vars = get_file($data);
        @unlink($data);

        $data = '';
        $l_v = $exbb['last_visit'];
        $t_visits = (isset($_COOKIE['t_visits'])) ? unserialize($_COOKIE['t_visits']) : array();
        $found = 0;

        foreach ($vars['res'] as $inforum => $res ) {

           $topic = get_file($exbb['home_path'].'forum'.$inforum.'/list.php');

           $FINFO = $exbb['home_path'].'search/db/'.$inforum.'_finfo';

           $fp_FINFO = fopen ($FINFO, "rb");
           $found += $vars['rescount'][$inforum];

           for ($i=0; $i<$vars['rescount'][$inforum]; $i++) {
             if ($i >= strlen($vars['res'][$inforum])/4) {break 1;}
             $strpos = unpack("Npos",substr($vars['res'][$inforum],$i*4,4));
             fseek($fp_FINFO,$strpos[pos],0);
             $dum = fgets($fp_FINFO,100);
             list($f, $t) = explode('::',$dum);
             $f= trim($f);
             $t= trim($t);

             if ($f_readed = (isset($_COOKIE['f'.$inforum])) ? $_COOKIE['f'.$inforum] : 0) {
                 $exbb['last_visit'] = $f_readed > $exbb['last_visit'] ? $f_readed : $exbb['last_visit'];
             }
             $top_id = $f.$t;
             $topicicon = topic_icon($topic[$t],$t_visits[$top_id]);

             $m_id = isset($topic[$t]['a_id']) ? $topic[$t]['a_id'] : 0;
             $p_id = isset($topic[$t]['p_id']) ? $topic[$t]['p_id'] : 0;

             $t_name = sprintf('<a href="topic.php?forum=%d&topic=%d">%s</a>',$f,$t,wordwrap($topic[$t]['name'], 32, ' &shy; ', 1));
             $t_desc = wordwrap($topic['desc'], 32, ' &shy; ', 1);
             $f_name = sprintf('<a href="forums.php?forum=%d">%s</a>',$f,$allforums[$f]['name']);
             $t_post = $topic[$t]['posts'];
             $t_strt = $topic[$t]['author'] ? $topic[$t]['author'] : $lang['Unreg'];
             $poster = $topic[$t]['poster'] ? $topic[$t]['poster'] : $lang['Unreg'];
             $p_date = longdate($topic[$t]['date']+$exbb['usertime']*3600);
             include('./templates/'.$exbb['default_style'].'newposts_data.tpl');
           };  # for

           fclose ($fp_FINFO);
           $list = array();
        }
        $icon_path = './templates/'.$exbb['default_style'].'im';
        $title_page = $exbb['boardname'].' :: '.$lang['Search'];
        include('./templates/'.$exbb['default_style'].'all_header.tpl');
        include('./templates/'.$exbb['default_style'].'logos.tpl');
        include('./templates/'.$exbb['default_style'].'newposts.tpl');
        include('./templates/'.$exbb['default_style'].'footer.tpl');

    }

}
?>