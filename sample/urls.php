<?php 
/**
 *	Sample Project URLs
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
 *	Licenced under MIT Licence 
 *	http://www.opensource.org/licenses/mit-license.php
 *
**/

	$URLS = array(
		'/^(urls|settings)$/i' => array( 'home.php' ),
		'/^view\/(?P<user>[\w\-]+)\/(?P<id>[\d]+)$/i' => array( 'home.php' ),
		'/^(?P<path>[\w\-\/]*)$/i' => array( BP_ROOT. 'url/include.php', array( 'root' => ROOT,  ) ),
	);

?>
