<?php  $app = APP;
 global $URL_ARGS;
 require_once( BP_ROOT. 'auth/session.php' );
 require_once( ROOT. 'models.php' );
 $user = isset( $URL_ARGS[ 'user' ] ) ? $URL_ARGS[ 'user' ] : '';
 $id = isset( $URL_ARGS[ 'id' ] ) ? $URL_ARGS[ 'id' ] : '';
 
 $u = null;
 if( $user ){
  $u = session_user();
 }
 
 ?>
<!DOCTYPE html>

<html>
  <head>
    <title>
      <?php echo htmlspecialchars("Backend.php in Jade") ?>
    </title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700' rel='stylesheet' type='text/css'>
    <style>
       body, input { font-family: 'Open Sans', sans-serif; font-size: 14px; }
    </style>
  </head>
  <body>
    <h1>
      <?php echo htmlspecialchars("Backend.php in Jade") ?>
    </h1>
    <p>
      <?php echo htmlspecialchars("Parameters: Username=$user ID=$id") ?>
    </p>
    <p>
      <?php echo htmlspecialchars("Pass parameters in URL /view/username/id/") ?>
    </p>
    <p>
      <a href='<?php echo "" . $app . "view/vibhaj-rajan/15/" ?>'>
        <?php echo htmlspecialchars("Vibhaj's Posts") ?>
      </a>
    </p>
    <?php if(isset( $_SESSION[ 'user_id' ] )) { ?>
      <a href='<?php echo "" . $app . "logout/" ?>'>
        Logout
      </a>
    <?php } else { ?>
      <a href='<?php echo "" . $app . "login/google/" ?>'>
        Login with Google
      </a>
    <?php } ?>
  </body>
</html>
