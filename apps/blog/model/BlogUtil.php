<?php
/**
 * ww-source - version 1.0
 * Created by: SH
 *
 * @WW-Solution - Copyright 2017
 */

namespace apps\blog\model;


use core\utils\SQLInstance;

class BlogUtil {

	private static $SQLInstance;

	/**
	 * BlogUtil constructor.
	 */
	public function __construct() {
		self::$SQLInstance = new SQLInstance( 'blog.xml' );
	}

	public function getAricles() {

	}
}