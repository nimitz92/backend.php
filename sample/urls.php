<?php 
	
	$URLS = array(
		'/^(urls|settings)$/i' => 'default.php',
		'/^view\/(?P<user>[\w\-]+)\/(?P<id>[\d]+)$/i' => 'default.php',
		'/^(?P<path>[\w\-\/]*)$/i' => BP_ROOT. 'include.php',
	);

?>
