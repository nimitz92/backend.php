<?php
/**
 *	Regex URL Controller
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/

	// extract REQUEST_URI for parsing
	$path = explode( '?', $_SERVER[ 'REQUEST_URI' ] );
	$path = isset( $path[ 0 ] ) ? trim( substr( $path[ 0 ], strlen( APP ) ), '/' ) : '';

	// match regex from urls.php
	$URL_ARGS = array();
	$matched = false;
	foreach( $URLS as $pattern => $value ) {
		if( preg_match( $pattern, $path, $URL_ARGS ) ){
			$path = $value;
			$matched = true;
			break;
		}
	}

	// check matched
	if( !$matched ){
		if( DEBUG )
			print 'URL Not Matched: '. $path;
		exit();
	}

	// check file existence
	if( !file_exists( $path ) ){
		if( DEBUG )
			print 'PHP File Not Found: '. $path;
		exit();
	}

	// include php file
	include_once( $path );

?>
