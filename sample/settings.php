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

	// db utility settings
	$DATABASES = array(
		'default' => array( 
			'dsn' => 'mysql:host=localhost;port=3306;dbname=geostore',
			'user' => 'root',
			'pass' => 'krishna',
		),
		'socket' => array(
			'dsn' => 'mysql:unix_socket=/tmp/mysql.sock;dbname=geostore',
			'user' => 'root',
			'pass' => 'krishna',
		),
	);
	
?>

