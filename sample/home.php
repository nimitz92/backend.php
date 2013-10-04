<?php

	require_once( BP_ROOT. 'db.php' );

	class DBTest extends Model {
		var $id;
		var $username;
		var $email;

		static $_table = 'auth_user';
		static $_pk = 'id';
	}

	$qs = DBTest::objects()->filter( array( 'email' => 'vibhaj.itbhu@gmail.com' ) )->only( array( 'id', 'username', 'email' ) )->order_by( array( 'username' ) )->using( 'default' );

	foreach( $qs as $row )
		var_dump( $row );
	echo '<br /><br />';

	$row->set( 'email', 'tr4n2uil@gmail.com' );
	var_dump( $row );
	//$row->save();
	//$row->delete();

	echo 'Hello World! from BlackPearl Sample Project<br /><br />';

	$user = isset( $URL_ARGS[ 'user' ] ) ? $URL_ARGS[ 'user' ] : '';
	$id = isset( $URL_ARGS[ 'id' ] ) ? $URL_ARGS[ 'id' ] : '';

	echo "Parameters: Username=$user ID=$id<br /><br />";
	echo "Pass parameters in URL /view/username/id/";

?>
