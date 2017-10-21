<?php
/**
 * ww-source - version 1.0
 * Created by: SH
 *
 * @WW-Solution - Copyright 2017
 */

namespace apps\blog\controller;


use core\utils\HTTPRequest;

class ArticleController extends BaseBlogController {

	public function execute() {
		parent::init();
		$requestURI       = HTTPRequest::getRequestURI();
		$articleLink      = explode( '/', $requestURI );
		$articleLink      = end( $articleLink );
		$prepareStatement = parent::$SQLInstance->getPreparedStatement( 'getArticleByLink' );
		$result           = $prepareStatement->execute( [ $articleLink ] );
		if ( ! $result || $result->num_rows == 0 ) {
			self::doView( 'error' );

			return;
		}
		$article = $result->fetch_assoc();
		HTTPRequest::setAttribute( 'article', $article );
		self::doView( 'success' );
	}
}