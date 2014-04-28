<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 22/04/14
 * Time: 00:31
 */

namespace Chula\Service;


interface StorageInterface
{
    public function create($name, $data);

    public function delete($name);

    public function update($name, $data);

    public function read($name);

    public function publish($name);

    public function getPages($type);
}
