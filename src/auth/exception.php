<?php
/**
 *	Auth Exception Classes
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
 *	Licensed under MIT License 
 *	http://www.opensource.org/licenses/mit-license.php
 *
**/

	// class definition
	class AuthPHPSessionError extends Exception {
		// constructor
		public function __construct( $message = 'Auth Error Starting PHP Session', $code = 0, $previous = null ){
			parent::__construct( $message, $code, $previous );
		}
	}

	// class definition
	class AuthSetCookieError extends Exception {
		// constructor
		public function __construct( $message = 'Auth Error Setting Cookie Header', $code = 0, $previous = null ){
			parent::__construct( $message, $code, $previous );
		}
	}

	// class definition
	class AuthInvalidCredentials extends Exception {
		// constructor
		public function __construct( $message = 'Auth Invalid Credentials', $code = 0, $previous = null ){
			parent::__construct( $message, $code, $previous );
		}
	}

	// class definition
	class AuthHAError extends Exception {
		// constructor
		public function __construct( $message = 'Auth HybridAuth Error', $code = 0, $previous = null ){
			parent::__construct( $message, $code, $previous );
		}
	}

?>
