<?php
function del_dir($path) {
    if (!is_dir($path)) {
        return '目标不存在';
    }
    $handle = opendir($path);
    while (($item = @readdir($handle)) !== false) {
        if ($item != '.' && $item != '..') {
            $pathName = $path . DIRECTORY_SEPARATOR . $item;
            if (is_file($pathName)) {
                @unlink($pathName);
            }
            if (is_dir($pathName)) {
                $func = __FUNCTION__;
                $func($pathName);
            }
        }
    }
    closedir($handle);
    rmdir($path);
    return 'success';
}
//
//function del_file($filename) {
//    $handle = fopen($filename,'r');
//    @unlink($filename);
//    fclose($handle);
//    return "del $filename success";
//}

echo del_dir('upload/20170927');
