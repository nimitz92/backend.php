<?php

	echo 'Hello World! from BlackPearl Sample Project<br /><br />';

	$user = isset( $URL_ARGS[ 'user' ] ) ? $URL_ARGS[ 'user' ] : '';
	$id = isset( $URL_ARGS[ 'id' ] ) ? $URL_ARGS[ 'id' ] : '';

	echo "Parameters: Username=$user ID=$id<br /><br />";
	echo "Pass parameters in URL /view/username/id/";

?>
