<?php
/**
 * ww-source - version 1.0
 * Created by: SH
 *
 * @WW-Solution - Copyright 2017
 */

namespace apps\blog\controller;


use core\utils\HTTPRequest;

class ViewPostArticleController extends BaseBlogController {

	/**
	 *
	 * @return mixed
	 */
	public function execute() {
		self::doView( 'success' );
	}
}