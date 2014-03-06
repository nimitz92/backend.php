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
	require_once( BP_ROOT. 'auth/models.php' );
	require_once( BP_ROOT. 'auth/session.php' );

	require_once( ROOT. 'apps/models.php' );

	$URLS = array(
		'/^(urls|settings)/i' => array( 'tpl/test.php' ),
		'/^auth$/i' => array( BP_ROOT. 'auth/endpoint.php' ),
		'/^login\/?(?P<provider>[\w\-]+)?$/i' => array( 'tpl/login.php' ),
		'/^logout$/i' => array( BP_ROOT. 'auth/logout.php' ),

		'/^api\/user\/?(?P<id>[\d]+)?$/i' => array( BP_ROOT. 'url/rest.php', array( 'model' => 'User' )),
		'/^api\/session\/?(?P<id>[\w\.]+)?$/i' => array( BP_ROOT. 'url/rest.php', array( 'model' => 'Session' )),
		'/^api\/note\/?(?P<id>[\d]+)?$/i' => array( BP_ROOT. 'url/rest.php', array( 'model' => 'Note' )),

		'/^embed$/i' => array( BP_ROOT. 'url/embed.php' ),
		'/^view\/(?P<user>[\w\-]+)\/(?P<id>[\d]+)$/i' => array( BP_ROOT. 'url/include.php', array( 'path' => 'tpl/home' )),
		'/^(?P<path>[\w\-\/]*)$/i' => array( BP_ROOT. 'url/include.php', array( 'root' => ROOT. 'tpl/',  ) ),
	);

?>
