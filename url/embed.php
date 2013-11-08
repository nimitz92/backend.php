<?php  
/**
 *	Image/Object Embed Handler
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
 *	Licensed under MIT License 
 *	http://www.opensource.org/licenses/mit-license.php
 *
**/

	// extract path from url parameters
	if( $_FILES[ 'file' ] ){
		$PATH = MEDIA_ROOT;
		require_once( BP_ROOT. 'fs/file.php' );

		$url = str_replace( '\\', '/', substr( $f->path, strlen( ROOT ) ) );

		echo json_encode( array( 
			'html' => '<div contenteditable="false"><a href="' .$url. '" target="_blank" contenteditable="false"><img src="' .$url. '" class="image" /></a></div><div><br/></div>',
		) );
	}

?>
