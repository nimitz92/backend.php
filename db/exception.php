<?php
/**
 *	DB Exception Classes
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
 *	Licensed under MIT License 
 *	http://www.opensource.org/licenses/mit-license.php
 *
**/

	// class definition
	class DBImproperlyConfigured extends Exception {
		// constructor
		public function __construct( $message = 'DB Improperly Configured', $code = 0, $previous = null ){
			parent::__construct( $message, $code, $previous );
		}
	}

	// class definition
	class DBConnectionFailed extends Exception {
		// constructor
		public function __construct( $message = 'DB Connection Failed', $code = 0, $previous = null ){
			parent::__construct( $message, $code, $previous );
		}
	}

	// class definition
	class DBQueryError extends Exception {
		// constructor
		public function __construct( $message = 'Error Executing Query', $code = 0, $previous = null ){
			parent::__construct( $message, $code, $previous );
		}
	}

	// class definition
	class DBDoesNotExist extends Exception {
		// constructor
		public function __construct( $message = 'Object Not Found', $code = 0, $previous = null ){
			parent::__construct( $message, $code, $previous );
		}
	}
	
	// class definition
	class DBMultipleObjectsReturned extends Exception {
		// constructor
		public function __construct( $message = 'Multiple Objects Found', $code = 0, $previous = null ){
			parent::__construct( $message, $code, $previous );
		}
	}

?>
