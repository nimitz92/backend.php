<?php  

	$path = isset( $URL_ARGS[ 'path' ] ) ? $URL_ARGS[ 'path' ] : HOME;
	$path = $path ? $path.'.php' : HOME;

	if( !file_exists( ROOT. $path ) ){
		echo 'Include File Not Found: '. ROOT. $path;
		exit();
	}

	include_once( $path );
	
?>
