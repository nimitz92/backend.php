<?php
/**
 *	Sample Project Settings
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
 *	Licensed under MIT License 
 *	http://www.opensource.org/licenses/mit-license.php
 *
**/

	// default settings
	define( 'ROOT', dirname( __FILE__ ) .DIRECTORY_SEPARATOR );

	// project settings
	define( 'BP_ROOT', ROOT .'..' .DIRECTORY_SEPARATOR );
	define( 'DEBUG', false );

	// url utility settings
	define( 'HOST', 'http://127.0.0.1' );
	define( 'APP', '/iospace/blackpearl/sample/' );
	define( 'HOME', 'test' );

	// auth utility settings
	define( 'HA_ROOT', ROOT .'..' .DIRECTORY_SEPARATOR .'..' .DIRECTORY_SEPARATOR .'auth' .DIRECTORY_SEPARATOR );
	define( 'COOKIE_NAME', 'sessionid' );
	define( 'COOKIE_EXPIRY', 15 );
	define( 'COOKIE_DOMAIN', '127.0.0.1' );
	define( 'COOKIE_PATH', '/' );
	define( 'COOKIE_SECURE', false );
	define( 'COOKIE_HTTPONLY', true );
	define( 'LOGIN_URL', APP. 'login/' );
	define( 'LOGIN_REDIRECT', APP );
	define( 'LOGOUT_REDIRECT', APP );

	// db utility settings
	$DATABASES = array(
		'default' => array( 
			'dsn' => 'mysql:host=localhost;port=3306;dbname=blackpearl',
			'user' => 'root',
			'pass' => 'krishna',
		),
		'socket' => array(
			'dsn' => 'mysql:unix_socket=/tmp/mysql.sock;dbname=blackpearl',
			'user' => 'root',
			'pass' => 'krishna',
		),
	);
	
	// utility settings
	define( 'CL_ROOT', ROOT .'..' .DIRECTORY_SEPARATOR .'clean' .DIRECTORY_SEPARATOR );
	
?>

