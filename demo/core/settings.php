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
	//load config file
	$ini = parse_ini_file("conf.ini",true);
	//print_r($ini);
	
	// default settings
	define( 'ROOT', dirname( __FILE__ ) .'/../' );

	// project settings
	define( 'BP_ROOT', ROOT .'lib/backend.php/src/' );
	define( 'DEBUG', false );

	// url utility settings
	define( 'HOME', 'home' );
	define( 'CACHE_DIR', ROOT. 'cache/' );
	define( 'HOST', $ini['URL_UTILITY_SETTINGS']['HOST']);
	define( 'APP', $_SERVER[ 'HTTP_HOST' ] == '127.0.0.1' ? $ini['URL_UTILITY_SETTINGS']['APP_LOCAL'] : $ini['URL_UTILITY_SETTINGS']['APP'] );
	

	// auth utility settings
	
	define( 'COOKIE_DOMAIN', $_SERVER['HTTP_HOST'] );
	foreach($ini['AUTH_UTILITY_SETTINGS'] as $key => $value ){
		define( $key, $value);
	}
	
	define( 'LOGIN_URL', APP. 'login/' );
	define( 'LOGIN_REDIRECT', APP );
	define( 'LOGOUT_REDIRECT', APP );

	// db utility settings
	foreach($ini['DB_UTILITY_SETTINGS'] as $key => $value ){
		define( $key, $value);
	}
	
	$DATABASES = array(
		'default' => array( 
			'dsn' => 'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME,
			'user' => getenv( 'DB_USER' ) ? getenv( 'DB_USER' ) : DB_USER,
			'pass' => getenv( 'DB_PASSWD' ) ? getenv( 'DB_PASSWD' ) : DB_PASS,
		),
		'socket' => array(
			'dsn' => 'mysql:unix_socket=/tmp/mysql.sock;dbname='.DB_NAME,
			'user' => getenv( 'DB_USER' ) ? getenv( 'DB_USER' ) : DB_USER,
			'pass' => getenv( 'DB_PASSWD' ) ? getenv( 'DB_PASSWD' ) : DB_PASS,
		),
	);
	
	// utility settings
	define( 'MEDIA_ROOT', ROOT. 'drive' .DIRECTORY_SEPARATOR );

?>

