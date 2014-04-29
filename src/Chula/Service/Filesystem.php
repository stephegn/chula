<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 22/04/14
 * Time: 00:30
 */

namespace Chula\Service;


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

    /**
     * @param $name
     * @param $data
     */
    public function create($name, $data)
    {
        // TODO: Implement create() method.
    }

    /**
     * @param $name
     * @param $data
     */
    public function update($name, $data)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param $name
     */
    public function read($name)
    {
        // TODO: Implement read() method.
    }

    /**
     * @param $name
     */
    public function publish($name)
    {
        // TODO: Implement publish() method.
    }

    /**
     * @param $page
     *
     * @throws FileNotFoundException
     * @throws \Exception
     */
    public function delete($page)
    {
        try {
            $filePath = $this->config['location'][$page->getType()] . $page->getSlug();
            if (!file_exists($filePath)) {
                throw new FileNotFoundException();
            }

            unlink($filePath);

        } catch (\Exception $e) {
            throw $e;
        }
    }

}
