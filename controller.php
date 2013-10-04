<?php
	
	$path = explode( '?', $_SERVER[ 'REQUEST_URI' ] );
	$path = isset( $path[ 0 ] ) ? trim( substr( $path[ 0 ], strlen( APP ) ), '/' ) : '';

	$URL_ARGS = array();
	$matched = false;
	foreach( $URLS as $pattern => $value ) {
		if( preg_match( $pattern, $path, $URL_ARGS ) ){
			$path = $value;
			$matched = true;
			break;
		}
	}

	if( !$matched ){
		if( DEBUG )
			print 'URL Not Matched: '. $path;
		exit();
	}

	if( !file_exists( $path ) ){
		if( DEBUG )
			print 'PHP File Not Found: '. $path;
		exit();
	}

	include_once( $path );

?>
