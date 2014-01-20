<?php
/**
 * Created by PhpStorm.
 * User: qasim
 * Date: 20/01/2014
 * Time: 20:13
 */

namespace Chula\Models;


interface ModelInterface
{
    public function save($data);
    public function delete();
    public function add($data);
    public function read($key);
}