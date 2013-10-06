<?php
/**
 *	Sample Project Test Page
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
 *	Licensed under MIT License 
 *	http://www.opensource.org/licenses/mit-license.php
 *
**/

	require_once( ROOT. 'models.php' );

	$qs = User::objects()->filter( array( 'email' => 'vibhaj.itbhu@gmail.com' ) )->only( array( 'id', 'username', 'email' ) )->order_by( array( 'username' ) )->using( 'default' );

	foreach( $qs as $row )
		print_r( $row );
	echo '<br /><br />';

	$row->set( 'email', 'tr4n2uil@gmail.com' );
	print_r( $row );
	echo '<br /><br />';
	//$row->save();
	//$row->delete();

	$u = User::objects()->get( array( 'email' => 'vibhajitbhu@gmail.com' ) );
	print_r( $u );
	echo '<br /><br />';

	$p = Person::objects()->values( array( 'user__id', 'user__username', '*' ) )->get( new Q_OR( array( 'user__email' => 'vibhajitbhu@gmail.com', 'user__username' => 'vibhaj8' ) ) );
	print_r( $p );
	echo '<br /><br />';

	//$dbt = User::objects()->create( array( 'email' => 'vibhajitbhu@gmail.com', 'username' => 'vbj' ) );
	//print_r( $dbt );

	echo 'Hello World! from BlackPearl Sample Project<br /><br />';

	$user = isset( $URL_ARGS[ 'user' ] ) ? $URL_ARGS[ 'user' ] : '';
	$id = isset( $URL_ARGS[ 'id' ] ) ? $URL_ARGS[ 'id' ] : '';

	echo "Parameters: Username=$user ID=$id<br /><br />";
	echo "Pass parameters in URL /view/username/id/";

?>
