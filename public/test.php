<?php
$str   = 'oiling/analysis/search';
$p     = '/oiling\/(\w+)\/search/';
$match = preg_match($p, $str,$mathches);
echo $match;
echo '<hr>';
echo $mathches[0];
echo '<hr>';
echo $mathches[1];