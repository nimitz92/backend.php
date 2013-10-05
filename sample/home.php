<?php
/**
 *	Sample Project Test Page
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
**/

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
		print_r( $row );
	echo '<br /><br />';

	$row->set( 'email', 'tr4n2uil@gmail.com' );
	print_r( $row );
	echo '<br /><br />';
	//$row->save();
	//$row->delete();

	$dbt = DBTest::objects()->get( array( 'email' => 'vibhajitbhu@gmail.com' ) );
	print_r( $dbt );
	echo '<br /><br />';

	//$dbt = DBTest::objects()->create( array( 'email' => 'vibhajitbhu@gmail.com', 'username' => 'vbj' ) );
	//print_r( $dbt );

	echo 'Hello World! from BlackPearl Sample Project<br /><br />';

	$user = isset( $URL_ARGS[ 'user' ] ) ? $URL_ARGS[ 'user' ] : '';
	$id = isset( $URL_ARGS[ 'id' ] ) ? $URL_ARGS[ 'id' ] : '';

	echo "Parameters: Username=$user ID=$id<br /><br />";
	echo "Pass parameters in URL /view/username/id/";

?>
