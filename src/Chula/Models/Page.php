<?php
/**
 * Created by PhpStorm.
 * User: qasim
 * Date: 19/01/2014
 * Time: 20:58
 */

namespace Chula\Models;


class Page implements ModelInterface
{

    /* @var string */
    private $path;

    /* @var bool */
    private $encrypted;

    /* @var string */
    private $title;

    /* @var string */
    private $content;

  public function createFromSerialised($string)
  {
    return new this;
  }

  public function add($data)
  {
        $this->title = $data['title'];
        $this->$path = $data['path'];
        $this->$content = $data['content'];
        $this->encrypted = $data['encrypted'];
    }

    public function save($data)
    {
        $this->title = $data['title'];
        $this->$path = $data['path'];
        $this->$content = $data['content'];
        $this->encrypted = $data['encrypted'];
    }

    public function delete()
    {
        // Delete file
        if(file_exists($this->path))
            unlink($this->path);
    }

    public function read($key = NULL)
    {
        if(is_null($key))
            return array('path' => $this->path,
                'encrypted' => $this->encrypted,
                'title' => $this->title,
                'content' => $this->content);

        switch(strtolower($key))
        {
            case 'path':        return $this->path;
            case 'encrypted':   return $this->encrypted;
            case 'title':       return $this->title;
            case 'content':     return $this->content;
            default:            return NULL;
        }
    }


} 