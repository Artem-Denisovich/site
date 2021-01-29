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

#===================================================================
#
#         Set variables below
#
#===================================================================

# site size
# 1 - Tiny    ~1Mb
# 2 - Medium  ~10Mb
# 3 - Big     ~50Mb
# 4 - Large   >100Mb
$site_size = 3;

# Indexing scheme
# Whole word - 1
# Beginning of the word - 2
# Every substring - 3
$vars['INDEXING_SCHEME'] = 2;


switch ($site_size) {
   case 1: $vars['HASHSIZE'] = 20001; break;
   case 2: $vars['HASHSIZE'] = 50001; break;
   case 3: $vars['HASHSIZE'] = 100001; break;
   default: $vars['HASHSIZE'] = 300001;
}

#=====================================================================

function get_query(&$wholeword,&$querymode,&$query_arr) {

    global $vars;

    $query = $vars['search_keywords'];
    $stype = $vars['stype'];


    $query = strtolower($query);
    $query = preg_replace("/[^a-zà-ÿ0-9 +!-]/"," ",$query);

    $vars['search_keywords'] = $query;

    $query_arr = preg_split("/\s+/",$query);
    $query_arr = array_unique($query_arr);

    $k = count($query_arr);
    for ($i=0; $i<$k; $i++) {

        if (preg_match("/\!/", $query_arr[$i]))   { $wholeword[$i] = 1;} # WholeWord
        $query_arr[$i] = preg_replace("/[\! ]/",'',$query_arr[$i]);
        if ($stype == 'AND')     { $querymode[$i] = 2;} # AND
        if (preg_match ("/^\-/", $query_arr[$i])) { $querymode[$i] = 1;} # NOT
        if (preg_match ("/^\+/", $query_arr[$i])) { $querymode[$i] = 2;} # AND
        $query_arr[$i] = preg_replace("/^[\+\- ]/",'',$query_arr[$i]);
    }
}
#=====================================================================

function get_results($inforum,$wholeword,$querymode,$query_arr,&$allres) {

    global $vars,$exbb;


    $HASH      = $exbb['home_path'].'search/db/'.$inforum.'_hash';
    $HASHWORDS = $exbb['home_path'].'search/db/'.$inforum.'_hashwords';
    $SITEWORDS = $exbb['home_path'].'search/db/'.$inforum.'_sitewords';
    $WORD_IND  = $exbb['home_path'].'search/db/'.$inforum.'_word_ind';


    $fp_HASH = fopen ($HASH, "rb");
    $fp_HASHWORDS = fopen ($HASHWORDS, "rb");
    $fp_SITEWORDS = fopen ($SITEWORDS, "rb");
    $fp_WORD_IND = fopen ($WORD_IND, "rb");

    $k = count($query_arr);


for ($j=0; $j<$k; $j++) {

    $query = $query_arr[$j];

    $allres[$j] = array();

    if ($vars['INDEXING_SCHEME'] == 1) {
        $substring_length = strlen($query);
    } else {
        $substring_length = 4;
    }
    $hash_value = abs(hash(substr($query,0,$substring_length)) % $vars['HASHSIZE']);

    fseek($fp_HASH,$hash_value*4,0);
    $dum = fread($fp_HASH,4);
    $dum = unpack("Ndum", $dum);
    fseek($fp_HASHWORDS,$dum[dum],0);
    $dum = fread($fp_HASHWORDS,4);
    $dum1 = unpack("Ndum", $dum);

   for ($i=0; $i<$dum1[dum]; $i++) {
        $dum = fread($fp_HASHWORDS,8);
        $arr_dum = unpack("Nwordpos/Nfilepos",$dum);
        fseek($fp_SITEWORDS,$arr_dum[wordpos],0);
        $word = fgets($fp_SITEWORDS,1024);
        $word = preg_replace("/\x0A/","",$word);
        $word = preg_replace("/\x0D/","",$word);

        if ( ($wholeword[$j]==1) && ($word != $query) ) {$word = '';};
        $pos = strpos($word, $query);
        if ($pos !== false) {
            fseek($fp_WORD_IND,$arr_dum[filepos],0);
            $dum = fread($fp_WORD_IND,4);
            $dum2 = unpack("Ndum",$dum);
            $dum = fread($fp_WORD_IND,$dum2[dum]*4);
            for($k=0; $k<$dum2[dum]; $k++){
                $zzz = unpack("Ndum",substr($dum,$k*4,4));
                $allres[$j][$zzz[dum]] = 1;
            }
        }

    }

    fclose ($WORD_IND);
    fclose ($SITEWORDS);
    fclose ($HASHWORDS);
    fclose ($HASH);

}

}
#=====================================================================

function boolean($inforum,&$query_arr,&$querymode,&$allres) {

    global $vars;

    $vars['res'][$inforum] = '';
if (count($query_arr) == 1) {
    foreach ($allres[0] as $k => $v) {
        if ($k) {
            $vars['res'][$inforum] .= pack("N",$k);
        }
    }
    $vars['rescount'][$inforum] = intval(strlen($vars['res'][$inforum])/4);

    unset($allres);
    return;
} else {
    $kk = count($query_arr);
    if ($vars['stype'] == "AND") {
        for ($i=0; $i<$kk; $i++) {
            if ($querymode[$i] == 2) {
                $min = $i;
                break;
            }
        }
        for ($i=$min+1; $i<$kk; $i++) {
            if (count($allres[$i]) < count($allres[$min]) && $querymode[$i] == 2) {
                $min = $i;
            }
        }
        for ($i=0; $i<$kk; $i++) {
            if ($i == $min) {
                continue;
            }
            if ($querymode[$i] == 2) {
                foreach ($allres[$min] as $k => $v) {
                    if (array_key_exists($k,$allres[$i])) {
                    } else {
                        unset($allres[$min][$k]);
                    }
                }
            } else {
                foreach ($allres[$min] as $k => $v) {
                    if (array_key_exists($k,$allres[$i])) {
                        unset($allres[$min][$k]);
                    }
                }
            }
        }
        foreach ($allres[$min] as $k => $v) {
            if ($k) {
                $vars['res'][$inforum] .= pack("N",$k);
            }
        }
        $vars['rescount'][$inforum] = intval(strlen($vars['res'][$inforum])/4);
        return;
    }


    if ($vars['stype'] == "OR") {
        for ($i=0; $i<$kk; $i++) {
            if ($querymode[$i] != 1) {
                $max = $i;
                break;
            }
        }
        for ($i=$max+1; $i<$kk; $i++) {
            if (count($allres[$i]) > count($allres[$min]) && $querymode[$i] != 1) {
                $max = $i;
            }
        }
        for ($i=0; $i<$kk; $i++) {
            if ($i == $max) {
                continue;
            }
            if ($querymode[$i] != 1) {
                foreach ($allres[$i] as $k => $v) {
                    $allres[$max][$k] = 1;
                }
            } else {
                foreach ($allres[$i] as $k => $v) {
                    if (array_key_exists($k,$allres[$max])) {
                        unset($allres[$max][$k]);
                    }
                }
            }
        }
        foreach ($allres[$max] as $k => $v) {
            if ($k) {
                $vars['res'][$inforum] .= pack("N",$k);
            }
        }
        $vars['rescount'][$inforum] = intval(strlen($vars['res'][$inforum])/4);
        return;
    }

}


}
#=====================================================================

function getmicrotime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
    }

#=====================================================================

function hash($key) {

    $chars = preg_split("//",$key);
    for($i=1;$i<count($chars)-1;$i++) {
        $chars2[$i] = ord($chars[$i]);
    }


    $h = hexdec("00000000");
    $f = hexdec("F0000000");


    for($i=1;$i<count($chars)-1;$i++) {
        $h = ($h << 4) + $chars2[$i];
        if ($g = $h & $f) { $h ^= $g >> 24; };
        $h &= ~$g;
    }

    return $h;

}

?>