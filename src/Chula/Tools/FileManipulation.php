<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 30/04/14
 * Time: 00:07
 */

namespace Chula\Tools;


class FileManipulation {

    public static function listDirByDate($path){
        $dir = opendir($path);
        $list = array();
        while($file = readdir($dir)){
            if ($file != '.' and $file != '..'){
                // add the filename, to be sure not to
                // overwrite a array key
                $ctime = filectime($path . $file) . ',' . $file;
                $list[$ctime] = $file;
            }
        }
        closedir($dir);
        krsort($list);
        return $list;
    }

} 