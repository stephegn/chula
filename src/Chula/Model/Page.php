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
use Michelf\Markdown;

/**
 * Class Page
 * @package Chula\Model
 */
class Page
{
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

	/**
	 * @var Bool
	 */private $encrypted;

    /**
	 * @param $slug
	 * @param $content
	 * @param $type
	 * @param $encrypted
	 */public function __construct($slug, $content, $type, $encrypted)
    {
        $this->setEncrypted($encrypted);
        $this->setSlug($slug);
        $this->content = $content;
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
		$encryptedContent = ($this->isEncrypted()) ? Encryption::encrypt($content) : $content;
        $this->content = $encryptedContent;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        //@todo should this be here???
        $content = ($this->isEncrypted()) ? Encryption::decrypt($this->content) : $this->content;
        return $content;
    }

    /**
	 * @return mixed
	 */public function getHtmlContent()
    {
        //@todo should this be here?
        return Markdown::defaultTransform($this->getContent());
    }


	/**
	 * @return mixed
	 */
	public function getEncryptedContent()
	{
		return $this->content;
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

	/**
	 * @param mixed $encrypted
	 */
	public function setEncrypted($encrypted)
	{
		$this->encrypted = $encrypted;
	}/**
	 * @return mixed
	 */
	public function isEncrypted()
	{
		return $this->encrypted;
	}
} 