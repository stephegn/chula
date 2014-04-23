<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 22/04/14
 * Time: 00:04
 */

namespace Chula\Service;

use Chula\Model\Page as PageModel;

class Page
{

    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getPageFromSlugAndType($slug, $type)
    {
        $filePath = $this->config['location'][$type] . $slug;
        $content = $this->getFileFromPath($filePath);
        if ($content !== null) {
            $page = new PageModel($this->config, $slug, $content, $type);
            return $page;
        }

        return null;
    }

    //@todo this shouldn't be here
    private function getFileFromPath($filePath)
    {
        if (file_exists($filePath)) {
            $content = file_get_contents($filePath);
            return $content;
        }
        return null;
    }
} 