<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 22/04/14
 * Time: 00:04
 */

namespace Chula\Service;

use \Chula\Model\Page as PageModel;
class Page {

    private $config;

    public function __construct($config, $storageService)
    {
        $this->config = $config;
        $this->storageService = $storageService;
    }

    public function getDraftPageFromSlug($slug)
    {
        $filePath = $this->config['location']['draft'] . $slug;
        $content = $this->getFileFromPath($filePath);
        if ($content !== null)
        {
            $page = new PageModel($this->config, $content, $slug, 'draft');
            return $page;
        }

        return null;
    }

    public function getPublishedPageFromSlug($slug)
    {
        $filePath = $this->config['location']['published'] . $slug;
        $content = $this->getFileFromPath($filePath);
        if ($content !== null)
        {
            $page = new PageModel($this->config, $content, $slug, 'draft');
            return $page;
        }

        return null;
    }
} 