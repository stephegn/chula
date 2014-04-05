<?php
/**
 * Created by PhpStorm.
 * User: qasim
 * Date: 15/01/2014
 * Time: 23:39
 */

namespace Chula\Tools;


class FileManager {

  public static function deletePage($page, $config)
  {
    $path = $config['content_location'] . $page;
    if (file_exists($path))
    {
      unlink($path);
    }
  }
}