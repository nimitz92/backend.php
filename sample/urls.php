<?php 
	
	$URLS = array(
		'/^(urls|settings)$/i' => 'home.php',
		'/^view\/(?P<user>[\w\-]+)\/(?P<id>[\d]+)$/i' => 'home.php',
		'/^(?P<path>[\w\-\/]*)$/i' => BP_ROOT. 'include.php',
	);

?>
