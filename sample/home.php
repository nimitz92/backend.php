<?php

	require_once( BP_ROOT. 'db.php' );

	class DBTest extends Model {
		var $username;
		var $email;

		static $_table = 'auth_user';
	}

	$qs = DBTest::objects()->filter( array( 'email' => 'vibhaj8@gmail.com' ) )->only( array( 'username' ) )->using( 'default' );

	db_get_connection();

	foreach( $qs as $row )
		echo json_encode( $row );
	echo '<br /><br />';


	echo 'Hello World! from BlackPearl Sample Project<br /><br />';

	$user = isset( $URL_ARGS[ 'user' ] ) ? $URL_ARGS[ 'user' ] : '';
	$id = isset( $URL_ARGS[ 'id' ] ) ? $URL_ARGS[ 'id' ] : '';

	echo "Parameters: Username=$user ID=$id<br /><br />";
	echo "Pass parameters in URL /view/username/id/";

?>
