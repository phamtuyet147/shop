<?php
/**
 * ww-source - version 1.0
 * Created by: SH
 *
 * @WW-Solution - Copyright 2017
 */

namespace core\utils;


use Exception;

final class LanguageUtils {

	public static $SESSION_LANGUAGE = 'currentLanguage';
	private static $DEFAULT_LANGUAGE_FILENAME = 'default.lang';
	private static $LANGUAGE_COLLECTION = [];

	public function __construct() {

	}

	public static function init( $lang ) {
		$langFile = AppInfo::$LANG_DIR . '/' . $lang . '/' . self::$DEFAULT_LANGUAGE_FILENAME;
		if ( ! file_exists( $langFile ) ) {
			throw new Exception( 'Could not find language file!' );
		}
		self::$LANGUAGE_COLLECTION = (array) FileUtils::readINIFile( $langFile );
	}

	public static function loadLang( $langFile ) {
		$langFile = AppInfo::$LANG_DIR . '/' . $langFile;
		if ( ! file_exists( $langFile ) ) {
			throw new Exception( 'Could not find language file!' );
		}
		self::$LANGUAGE_COLLECTION = array_merge( self::$LANGUAGE_COLLECTION,
			(array) FileUtils::readINIFile( $langFile ) );
	}

	public static function get( $key ) {
		if ( array_key_exists( $key, self::$LANGUAGE_COLLECTION ) ) {
			return self::$LANGUAGE_COLLECTION[ $key ];
		}

		return "LANG_ERROR: Key not found";
	}

	public static function setLanguage( $lang ) {
		HTTPRequest::setSession( self::$SESSION_LANGUAGE, $lang );
	}
}