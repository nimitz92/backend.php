<?php
/**
 *	Query Expression Classes
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
 *	Licensed under MIT License 
 *	http://www.opensource.org/licenses/mit-license.php
 *
**/

	// class definition
	class EXPR {
		private $_array;
		public static $_delimiter = ' AND ';

		// constructor
		public function __construct( $array = array() ){
			$this->_array = $array;
		}

		// collect keys
		public function vars(){
			return array_keys( $this->_array );
		}

		// generate sql
		public function sql( $vars, &$subs ){
			$q = array();

			foreach( $this->_array as $key => $value ) {
				if( is_a( $value, 'EXPR' ) )
					// recurse
					array_push( $q, $value->sql( $vars, $subs, $i ) );
				else {
					// add to subs
					$subs[] = $value;
					array_push( $q, $vars[ $key ]. '= ?' );
				}
			}

			$cls = get_called_class();
			return implode( $cls::$_delimiter, $q );
		}
	}

	// class definition
	class Q_OR extends EXPR {
		public static $_delimiter = ' OR ';
	}

	// class definition
	class Q_NOT extends EXPR {
		public static $_delimiter = ' AND NOT ';

		public function sql( $vars, &$subs ){
			return 'NOT '.parent::sql( $vars, $subs );
		}
	}	

?>