<?php
/**
 *	Sample Project Login Page
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
 *	Licensed under MIT License 
 *	http://www.opensource.org/licenses/mit-license.php
 *
**/

	require_once( BP_ROOT. 'auth/session.php' );
	require_once( ROOT. 'models.php' );

	$error = '';

	if( isset( $_POST[ 'username' ] ) && isset( $_POST[ 'passwd' ] ) ){
		$next = isset( $_POST[ 'next' ] ) ? $_POST[ 'next' ] : LOGIN_REDIRECT;

		if( !$_POST[ 'username' ] )
			$error = 'Username cannot be empty';
		elseif( !$_POST[ 'passwd' ] )
			$error = 'Password cannot be empty';
		else {
			try {
				User::login( $_POST[ 'username' ], $_POST[ 'passwd' ], $SESSION, $next );
				exit();
			}
			catch( AuthInvalidCredentials $e ){
				$error = 'Invalid Credentials';
			}	
		}
	}
	else
		$next = isset( $_GET[ 'next' ] ) ? $_GET[ 'next' ] : LOGIN_REDIRECT;

?>

<html>
	<body>
		<div style="width: 185px; margin: 150px auto 0; text-align: left;">

			<?php if( $error ){
				echo '<div style="border: solid 1px red; color: darkred; font-weight: bold;">'.$error.'</div>';
			} ?>

			<form action="" method="post">
				<label>Username<br /><input type="text" name="username" /></label><br />
				<label>Password<br /><input type="password" name="passwd" /></label><br />
				<input type="hidden" name="next" value="<?php echo $next; ?>"/>
				<input type="submit" value="Login" /><input type="reset" value="Reset" />
			</form>
		</div>
	</body>
</html>
