<?php  
/**
 *	PHP/HTML File Inclusion from URL Path
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
 *	Licensed under MIT License 
 *	http://www.opensource.org/licenses/mit-license.php
 *
**/

	// extract path from url parameters
	$path = isset( $URL_ARGS[ 'path' ] ) ? $URL_ARGS[ 'path' ] : HOME;
	$root = isset( $URL_ARGS[ 'root' ] ) ? $URL_ARGS[ 'root' ] : ROOT;

	$path = $path ? $path : HOME;

	// check for php file existence
	if( file_exists( $root. $path .'.php' ) ){
		include_once( $root. $path.'.php' );	
	}
	// check for html file existence
	elseif( file_exists( $root. $path .'.html' ) ){
		include_once( $root. $path.'.html' );		
	}
	// raise error
	else {
		echo 'Include File Not Found: '. $root. $path;
		exit();
	}

?>