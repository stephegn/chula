<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 22/04/14
 * Time: 00:04
 */

namespace Chula\Service;

use Chula\Model\Page as PageModel;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

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

    public function getAllPagesFromType($type)
    {
        $filePath = $this->config['location'][$type];
        $pagesArray = $this->getFilesFromPath($filePath);

        $pages = array();
        foreach ($pagesArray as $pageName) {
            $pages[] = $this->getPageFromSlugAndType($pageName, $type);
        }

        return $pages;
    }

    public function deletePage(PageModel $page)
    {
        try {
            $this->removeFileFromPath($this->config['location'][$page->getType()].$page->getSlug());
        } catch (\Exception $e) {
            throw $e;
        }

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

    //@todo this shouldn't be here
    private function getFilesFromPath($filePath)
    {
        $files = array_diff(scandir($filePath), array('..', '.'));
        return $files;
    }

    //@todo move this
    private function removeFileFromPath($filePath)
    {
        if (!file_exists($filePath)) {
           throw new FileNotFoundException();
        }

        unlink($filePath);
    }
} 