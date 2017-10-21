<?php
/**
 * ww-source - version 1.0
 * Created by: SH
 *
 * @WW-Solution - Copyright 2017
 */

namespace apps\blog\controller;


use core\utils\HTTPRequest;
use core\utils\HTTPResponse;
use core\utils\StringUtils;

class PostArticleController extends BaseBlogController {

	public function execute() {
		parent::init();
		$title   = HTTPRequest::getParameter( 'articleTitle' );
		$content = HTTPRequest::getParameter( 'articleContent' );
		if ( empty( $title ) || empty( $content ) ) {
			HTTPRequest::setAttribute( 'errorMsg', 'Please input title and content' );
			self::doView( 'error' );

			return;
		}
		$now              = date( 'Y-m-d H:i:s' );
		$link             = StringUtils::convertStringToURL( $title );
		$data             = [
			$title,
			$content,
			HTTPRequest::getSession( 'userId' ),
			$now,
			$now,
			$link,
		];
		$prepareStatement = parent::$SQLInstance->getPreparedStatement( 'addArticle' );
		$prepareStatement->execute( $data );
		HTTPResponse::redirect( '/' );
	}
}