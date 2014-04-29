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
    public function create($name, $data);

    public function delete(Page $name);

    public function update(Page $name, $data);

    public function read($name);

    public function publish($name);

    public function getPages($type);
}
