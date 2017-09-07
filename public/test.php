<?php


echo strtotime(rtrim(preg_replace('/\"年\"|\"月\"|\"日\"/', '/', '2017"年"10"月"12"日"'), '/')) ;

echo "<hr>";
echo date('Y-m-d', '1493913600');