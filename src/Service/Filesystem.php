<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 22/04/14
 * Time: 00:30
 */

namespace Chula\Service;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Chula\Model\Page;

/**
 * Class Filesystem
 * @package Chula\Service
 */
class Filesystem implements StorageInterface
{
    /**
     * @var
     */
    private $config;

    /**
     * @throws \Exception
     */
    public function getPages($type)
    {
        // TODO: Implement getPages() method.
    }

    /**
     * @param $config
     */
    function __construct($config)
    {
        $this->config = $config;
    }

    public function create($name, $data)
    {
        $parent = $this->config['draft']['location'];
        if (!file_exists($parent)) {
            mkdir($parent);
        }
        if (file_put_contents($parent . $name, $data, LOCK_EX) === false) {
            throw new \Exception('Error saving file');
        }
    }

    public function update(Page $name, $data)
    {
        // TODO: Implement update() method.
    }


    public function read($path)
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException();
        }
        return file_get_contents($path);
    }

    public function publish($name)
    {
        $path['draft']     = $this->config['location']['draft'] . $name;
        $path['published'] = $this->config['location']['published'] . $name;
        if (!file_exists($path['draft'])) {
            throw new FileNotFoundException;
        }

        return rename($path['draft'], $path['published']);
    }

    public function delete(Page $page)
    {
        try {
            $filePath = $this->config['location'][$page->getType()] . $page->getSlug();
            if (!file_exists($filePath)) {
                throw new FileNotFoundException();
            }

            return unlink($filePath);

        } catch (\Exception $e) {
            throw $e;
        }
    }

}
