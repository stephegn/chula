<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 22/04/14
 * Time: 00:31
 */

namespace Chula\Service;

use Chula\Model\Page;

interface StorageInterface
{
    /**
     * @param Page $page
     *
     * Consumes a \Chula\Model\Page object, handles the serialising of this object and it's storage.
     *
     */
    public function create(Page $page);

    /**
     * @param Page $page
     *
     * Consumes a \Chula\Model\Page object, purges the file from storage.
     *
     */
    public function delete(Page $page);

    /**
     * @param Page $old
     * @param Page $new
     *
     * Takes two \Chula\Model\Page objects, replacing $old with $new. It disposes of the $old Page once it's done.
     *
     */
    public function update(Page $old, Page $new);

    /**
     * @param $type
     * @param $name
     *
     * Finds a page representation and deserialising it, retuning a Page object to the sender.
     *
     * @return \Chula\Model\Page
     */
    public function read($type, $name);

    /**
     * @param Page $page
     *
     * Promotes a draft page to a published page, making changes on the storage provider as required.
     *
     */
    public function publish(Page $page);

    /**
     * @param $type
     *
     * Looks up all the available pages for a given $type, returns an array of \Chula\Model\Page objects. If no pages
     * are found an empty array will be returned.
     *
     * @return mixed
     */
    public function getAllPages($type);

}
