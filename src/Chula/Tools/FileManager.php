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
    $path['published'] = $config['content_location'] . $page;
    $path['draft']     = $config['draft_location'] . $page;

    // Published post
    if (file_exists($path['published']))
    {
      unlink($path['published']);
    }

    // Draft post
    if (file_exists($path['draft']))
    {
      unlink($path['draft']);
    }
  }
}