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

    public function add($data)
    {
        $this->title = $data['title'];
        $this->$path = $data['path'];
        $this->$content = $data['content'];
        $this->encrypted = $data['encrypted'];

        // Create file
        $content = ($this->encrypted) ? Encryption::encrypt($this->content) : $this->content;
        file_put_contents($this->path . $this->title, $content, LOCK_EX);
    }

    public function save($data)
    {
        $this->title = $data['title'];
        $this->$path = $data['path'];
        $this->$content = $data['content'];
        $this->encrypted = $data['encrypted'];

        // Update file -- blindly overwrite for now. TODO: Make this better
        $content = ($this->encrypted) ? Encryption::encrypt($this->content) : $this->content;
        file_put_contents($this->path . $this->title, $content, LOCK_EX);
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