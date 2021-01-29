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

# forum size
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
?>