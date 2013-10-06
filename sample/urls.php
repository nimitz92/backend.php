<?php 
/**
 *	Regex URL Settings
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
 *	Licenced under MIT Licence 
 *	http://www.opensource.org/licenses/mit-license.php
 *
**/

	$URLS = array(
		'/^(urls|settings)$/i' => 'home.php',
		'/^view\/(?P<user>[\w\-]+)\/(?P<id>[\d]+)$/i' => 'home.php',
		'/^(?P<path>[\w\-\/]*)$/i' => BP_ROOT. 'include.php',
	);

?>
