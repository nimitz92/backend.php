<?php
	
	define( 'ROOT', dirname( __FILE__ ) .DIRECTORY_SEPARATOR );

	/**
	 * 	@configuration settings
	**/
	define( 'HOST', 'http://127.0.0.1' );
	define( 'APP', '/iospace/blackpearl/sample/' );

	define( 'BP_ROOT', ROOT .'..' .DIRECTORY_SEPARATOR );
	define( 'HOME', 'home.php' );
	define( 'DEBUG', true );

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

