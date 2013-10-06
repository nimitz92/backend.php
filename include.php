<?php  
/**
 *	PHP File Inclusion from URL Path
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
 *	Licenced under MIT Licence 
 *	http://www.opensource.org/licenses/mit-license.php
 *
**/

	// extract path from url parameters
	$path = isset( $URL_ARGS[ 'path' ] ) ? $URL_ARGS[ 'path' ] : HOME;
	$path = $path ? $path.'.php' : HOME;

	// check for file existence
	if( !file_exists( ROOT. $path ) ){
		echo 'Include File Not Found: '. ROOT. $path;
		exit();
	}

	// include file
	include_once( $path );
	
?>
