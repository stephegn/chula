<?php
/**
 * Created by PhpStorm.
 * User: steph
 * Date: 26/04/2014
 * Time: 19:31
 */

namespace Chula\Exception;


class TypeDoesNotExistException extends \Exception {

	public function __construct() {
		parent::__construct('That type does not exist');
	}
} 