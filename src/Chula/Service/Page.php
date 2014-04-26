<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 22/04/14
 * Time: 00:04
 */

namespace Chula\Service;

use Chula\Exception\PageExistsException;
use Chula\Exception\TypeDoesNotExistException;
use Chula\Model\Page as PageModel;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Class Page
 * @package Chula\Service
 */
class Page
{

	/**
	 * @var
	 */
	private $config;

	/**
	 * @param $config
	 */
	public function __construct($config)
    {
        $this->config = $config;
    }

	/**
	 * @param $slug
	 * @param $type
	 * @throws \Exception
	 * @return PageModel
	 */
	public function getPageFromSlugAndType($slug, $type)
    {
		$this->checkTypeExists($type);
        $filePath = $this->config['location'][$type] . $slug;

		try {
			$content = $this->getFileFromPath($filePath);
		} catch (\Exception $e) {
			throw $e;
		}
		$page = new PageModel($slug, $content, $type, $this->config['encrypt']);

		return $page;

    }

	/**
	 * @param $type
	 * @return array
	 */
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

	/**
	 * @param PageModel $page
	 * @throws \Exception
	 */
	public function deletePage(PageModel $page)
    {
        try {
            $this->removeFileFromPath($this->config['location'][$page->getType()].$page->getSlug());
        } catch (\Exception $e) {
            throw $e;
        }

    }

	/**
	 * @param PageModel $page
	 * @return PageModel
	 * @throws \Exception
	 */
	public function publishPage(PageModel $page){

		if ($page->getType() != 'draft') {
			throw new \Exception('Cannot publish a page which is not a draft');
		}

		// Move page from drafts folder to content location
		$draftPath = $this->config['location']['draft'] . $page->getSlug();
		$publishedPath = $this->config['location']['published'] . $page->getSlug();

		$this->moveFile($draftPath, $publishedPath);

		$page->setType('published');
		return $page;
	}

	/**
	 * @param PageModel $newPage
	 * @param PageModel $oldPage
	 * @throws \Chula\Exception\PageExistsException
	 */
	public function savePage(PageModel $newPage, PageModel $oldPage = null)
	{

		if ($oldPage == null) {
			if ($this->fileExistsInPaths($this->config['location'], $newPage->getSlug())) {
				throw new PageExistsException();
			}

		}
		if ($oldPage != null && $newPage->getSlug() != $oldPage->getSlug()) {
			$this->deletePage($oldPage);
		}
		$this->saveFile($this->config['location'][$newPage->getType()], $newPage->getSlug(), $newPage->getEncryptedContent());
	}

    //@todo this shouldn't be here
	/**
	 * @param $filePath
	 * @throws \Symfony\Component\Filesystem\Exception\FileNotFoundException
	 * @return string
	 */
	private function getFileFromPath($filePath)
    {
        if (!file_exists($filePath)) {
			throw new FileNotFoundException();
		}
		$content = file_get_contents($filePath);
		return $content;
    }

    //@todo this shouldn't be here
	/**
	 * @param $filePath
	 * @return array
	 */
	private function getFilesFromPath($filePath)
    {
        $files = array_diff(scandir($filePath), array('..', '.'));
        return $files;
    }

    //@todo move this
	/**
	 * @param $filePath
	 * @throws \Symfony\Component\Filesystem\Exception\FileNotFoundException
	 */
	private function removeFileFromPath($filePath)
    {
        if (!file_exists($filePath)) {
           throw new FileNotFoundException();
        }

        unlink($filePath);
    }

	//@todo move this
	/**
	 * @param $filePath
	 * @param $filename
	 * @param $content
	 * @throws \Exception
	 */
	private function saveFile($filePath, $filename, $content)
	{
		$this->makeFolderIfNotExists($filePath);
		if(file_put_contents($filePath.$filename, $content, LOCK_EX) === false) {
			throw new \Exception('Error saving file');
		}

	}

	/**
	 * @param $type
	 * @throws \Chula\Exception\TypeDoesNotExistException
	 */
	private function checkTypeExists($type)
	{
		if(!isset($this->config['location'][$type])) {
			throw new TypeDoesNotExistException();
		}
	}

	//@todo move
	/**
	 * @param $filepath
	 */
	private function makeFolderIfNotExists($filepath)
	{
		if (!file_exists($filepath)) {
			mkdir($filepath);
		}
	}

	//@todo move
	/**
	 * @param array $filepaths
	 * @param $filename
	 * @return bool
	 */
	private function fileExistsInPaths(array $filepaths, $filename)
	{
		foreach ($filepaths as $filepath) {
			if (file_exists($filepath.$filename)) {
				return true;
			}
		}
	}

	//@todo move
	/**
	 * @param $startPath
	 * @param $endPath
	 * @throws \Symfony\Component\Filesystem\Exception\FileNotFoundException
	 */
	private function moveFile($startPath, $endPath)
	{
		if (!file_exists($startPath)) {
			throw new FileNotFoundException;
		}

		rename($startPath, $endPath);

	}
} 