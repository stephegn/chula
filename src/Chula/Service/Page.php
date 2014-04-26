<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 22/04/14
 * Time: 00:04
 */

namespace Chula\Service;

use Chula\Exception\PageExistsException;
use Chula\Exception\TypeDoesNotExist;
use Chula\Exception\TypeDoesNotExistException;
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
		$this->checkTypeExists($type);
        $filePath = $this->config['location'][$type] . $slug;
        $content = $this->getFileFromPath($filePath);
        if ($content !== null) {
            $page = new PageModel($slug, $content, $type, $this->config['encrypt']);
            return $page;
        }

        return null;
    }

    public function getAllPagesFromType($type)
    {
		$this->checkTypeExists($type);
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

	public function savePage(PageModel $newPage, PageModel $oldPage = null)
	{

		if ($oldPage == null) {
			if ($this->checkFileExists($this->config['location'], $newPage->getSlug())) {
				throw new PageExistsException();
			}

		}
		if ($oldPage != null && $newPage->getSlug() != $oldPage->getSlug()) {
			$this->deletePage($oldPage);
		}
		$this->saveFile($this->config['location'][$newPage->getType()], $newPage->getSlug(), $newPage->getEncryptedContent());
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

	//@todo move this
	private function saveFile($filePath, $filename, $content)
	{
		$this->makeFolderIfNotExists($filePath);
		if(file_put_contents($filePath.$filename, $content, LOCK_EX) === false) {
			throw new \Exception('Error saving file');
		}

	}

	private function checkTypeExists($type)
	{
		if(!isset($this->config['location'][$type])) {
			throw new TypeDoesNotExistException();
		}
	}

	//@todo move
	private function makeFolderIfNotExists($filepath)
	{
		if (!file_exists($filepath)) {
			mkdir($filepath);
		}
	}

	//@todo move
	private function checkFileExists(array $filepaths, $filename)
	{
		foreach ($filepaths as $filepath) {
			if (file_exists($filepath.$filename)) {
				return true;
			}
		}
	}
} 