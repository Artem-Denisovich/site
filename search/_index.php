<?

/**
 *           RiSearch PHP
 *
 * web search engine, version 0.1.03
 * (c) Sergej Tarasov, 2000-2002
 *
 * Homepage: http://risearch.org/
 * email: risearch@risearch.org
 * Last modified: 13.01.2003
 */

@set_time_limit(1000);
print "Start indexing<BR>\n";

include('search.php');
include ('../data/boardinfo.php');
include('../lib.php');
include('../language/russian/lang.php');

$allforums = get_file($exbb['home_path'].'data/allforums.php');

$stat_file = $exbb['home_path'].'search/last_index.php';

if ( !file_exists($stat_file) ) {
      $fp = @fopen($stat_file,'w');
      save_opened_file($fp,array());
      chmod($stat_file,0777);
}

$stat = get_file($exbb['home_path'].'search/last_index.php');


foreach ($allforums as $inforum => $trash) {


   $base_dir = $exbb['home_path'].'forum'.$inforum;
   print "Indexing dir: $base_dir<BR>\n";

   if ( isset($stat[$inforum]) ) {

      $modified = filemtime($exbb['home_path'].'forum'.$inforum.'/list.php');
      if ( $stat[$inforum] >= $modified ) continue;
   }

   #DEFINE CONSTANTS
   $cfn = 0;
   $cwn = 0;
   $kbcount = 0;

   $HASH      = $exbb['home_path'].'search/db/'.$inforum.'_hash';
   $HASHWORDS = $exbb['home_path'].'search/db/'.$inforum.'_hashwords';
   $FINFO = $exbb['home_path'].'search/db/'.$inforum.'_finfo';
   $SITEWORDS = $exbb['home_path'].'search/db/'.$inforum.'_sitewords';
   $WORD_IND  = $exbb['home_path'].'search/db/'.$inforum.'_word_ind';

   $fp_FINFO = fopen ($FINFO, 'w');
   fwrite($fp_FINFO, "\n");
   $fp_SITEWORDS = fopen ($SITEWORDS, 'wb');
   $fp_WORD_IND = fopen ($WORD_IND, 'wb');

   $time1 = getmicrotime();

   $words = array();

   scan_files($base_dir);

   $time2 = getmicrotime();
   $time = $time2-$time1;
   print "<BR>Scan took $time sec.<BR>";


   print "Writing SITEWORDS\n";
    $pos_sitewords = ftell($fp_SITEWORDS);
    $pos_word_ind  = ftell($fp_WORD_IND);
    $to_print_sitewords = "";
    $to_print_word_ind  = "";

    foreach($words as $word=>$value) {
        $cwn++;
        $words_word_dum = pack("NN",$pos_sitewords+strlen($to_print_sitewords),
                                $pos_word_ind+strlen($to_print_word_ind));
        $to_print_sitewords .= $word."\x0A";
        $to_print_word_ind .= pack("N",strlen($value)/4).$value;
        $words[$word] = $words_word_dum;
        if (strlen($to_print_word_ind) > 32000) {
            fwrite($fp_SITEWORDS, $to_print_sitewords);
            fwrite($fp_WORD_IND, $to_print_word_ind);
            $to_print_sitewords = "";
            $to_print_word_ind  = "";
            $pos_sitewords = ftell($fp_SITEWORDS);
            $pos_word_ind  = ftell($fp_WORD_IND);
        }

    }
    fwrite($fp_SITEWORDS, $to_print_sitewords);
    fwrite($fp_WORD_IND, $to_print_word_ind);

    fclose($fp_SITEWORDS);
    fclose($fp_WORD_IND);
    fclose($fp_FINFO);

    chmod($SITEWORDS,0777);
    chmod($WORD_IND,0777);
    chmod($FINFO,0777);

    print "Build hash\n";

    build_hash();

    print "$cfn files are indexed. Totalsize of indexed files -> $kbcount kB<br><br>\n";

    $stat[$inforum] = time();
}
#=====================================================================
save_file($stat_file,$stat);

function  scan_files ($dir) {

    global $cfn, $exbb, $lang, $inforum;


    $list = get_file($dir.'/list.php');

    $dir_h = opendir($dir);

    while (false !== ($file = readdir($dir_h))) {
        if ($file != "." && $file != "..") {
            $new_dir = $dir.'/'.$file;
            if (strstr ($new_dir, '-thd')) {
                    $intopic = substr($file,0,strpos($file,'-'));
                    index_file($new_dir,$inforum,$intopic,$list[$intopic]['name']);
                    $cfn++;
            }

        }
    }
    closedir($dir_h);

}
#=====================================================================

function index_file($new_dir,$forum,$top,$tema = '') {

    global $cfn, $kbcount;
    global $fp_FINFO;
    global $words;
    global $exbb,$lang;


    $size = filesize($new_dir);
    $kbcount += intval($size/1024);

    $topic = get_file ($new_dir);
    $html_text = '';
    foreach ($topic as $id => $infa) {
       $html_text .= ' '.$infa['post'];
    }
    unset($topic);

    $html_text .= ' '.$tema;
    $html_text = preg_replace("/[^a-zA-Zà-ÿÀ-ß ]/"," ",$html_text);
    $html_text = preg_replace("/\s+/s"," ",$html_text);
    $html_text = preg_replace ($lang['search'], $lang['replace'], $html_text);;

    print $cfn.' -> '.$new_dir.'; filesize -> '.$size.'; Indexed text size -> '.strlen($html_text)."<BR>\n";

    $words_temp = array();

    preg_match_all('/([a-zà-ÿ]+){3,}/',$html_text,$words_temp);

    unset($html_text);


    $pos = ftell($fp_FINFO);
    $pos = pack("N",$pos);
    fwrite($fp_FINFO, $forum.'::'.$top."\n");

    foreach($words_temp[0] as $val => $word) {
        @$words[$word] .= $pos;
    }

    unset($words_temp);
    unset($words_temp2);
}
#=====================================================================

function build_hash() {

    global $words, $vars;
    global $HASH, $HASHWORDS;


    for ($i=0; $i<$vars['HASHSIZE']; $i++) {$hash_array[$i] = "";};

    foreach($words as $word=>$value) {
        if ($vars['INDEXING_SCHEME'] == 3) { $subbound = strlen($word)-3; }
        else { $subbound = 1; }
        if (strlen($word)==3) {$subbound = 1;}
        $substring_length = 4;
        if ($vars['INDEXING_SCHEME'] == 1) { $substring_length = strlen($word); }

        for ($i=0; $i<$subbound; $i++){
            $hash_value = abs(hash(substr($word,$i,$substring_length)) % $vars['HASHSIZE']);
            $hash_array[$hash_value] .= $value;
        };

    }


    $fp_HASH = fopen ($HASH, "wb");
    $fp_HASHWORDS = fopen ($HASHWORDS, "wb");

    $zzz = pack("N", 0);
    fwrite($fp_HASHWORDS, $zzz);
    $pos_hashwords = ftell($fp_HASHWORDS);
    $to_print_hash = "";
    $to_print_hashwords = "";

    for ($i=0; $i<$vars['HASHSIZE']; $i++){

        if ($hash_array[$i] == "") {$to_print_hash .= $zzz;}
        else
        {
            $to_print_hash .= pack("N",$pos_hashwords + strlen($to_print_hashwords));
            $to_print_hashwords .= pack("N", strlen($hash_array[$i])/8).$hash_array[$i];
        }
        if (strlen($to_print_hashwords) > 64000) {
            fwrite($fp_HASH,$to_print_hash);
            fwrite($fp_HASHWORDS,$to_print_hashwords);
            $to_print_hash = "";
            $to_print_hashwords = "";
            $pos_hashwords  = ftell($fp_HASHWORDS);
        }
    }; # for $i
    fwrite($fp_HASH,$to_print_hash);
    fwrite($fp_HASHWORDS,$to_print_hashwords);

    fclose($fp_HASH);
    fclose($fp_HASHWORDS);

    chmod($HASH,0777);
    chmod($HASHWORDS,0777);

}
?>