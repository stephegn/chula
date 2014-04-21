<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 21/04/14
 * Time: 23:59
 */

namespace Chula\Model;


use Chula\Tools\Encryption;
use Chula\Tools\StringManipulation;

/**
 * Class Page
 * @package Chula\Model
 */
class Page {
    /**
     * @var
     */
    private $slug;

    /**
     * @var
     */
    private $type;

    /**
     * @var
     */
    private $content;

    public function __construct($config, $slug, $content, $type)
    {
        $this->config = $config;
        $this->setSlug($slug);
        $this->setContent($content);
        $this->setType($type);
    }
    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        //@todo should this be here???
        $this->content = ($this->config['encrypt']) ? Encryption::encrypt($content) : $content;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        //@todo should this be here???
        $content = ($this->config['encrypt']) ? Encryption::decrypt($this->content) : $this->content;
        return $content;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        //@todo should this be here???
        $this->slug = StringManipulation::toSlug($slug);
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }
} 