<?php
/**
 *	Auth Session Helpers
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
 *	Licensed under MIT License 
 *	http://www.opensource.org/licenses/mit-license.php
 *
**/

	require_once( BP_ROOT. 'auth/models.php' );

	// initialize session
	function session_init(){
		$session = false;
		if( isset( $_COOKIE[ COOKIE_NAME ] ) ){
			$session = unique_object( 'Session', array( 'id' => $_COOKIE[ COOKIE_NAME ], 'active' => 1 ) );
		}

		if( !$session ){
			$session = Session::objects()->create();
		}

		return $session;
	}

	// check logged in
	function session_user( $session ){
		$u = $session->user_get();
		
		if( !$u ){
			$next = $_SERVER[ 'REQUEST_URI' ];
			$arg = array();

			if( $next != LOGIN_REDIRECT )
				$arg[ 'next' ] = $next;

			http_redirect( LOGIN_URL, $arg );
		}
		
		return $u;
	}

	$SESSION = session_init();

?>
