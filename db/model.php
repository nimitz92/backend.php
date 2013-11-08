<?php
/**
 *	Database Object Model Abstract Base Class
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
 *	Licensed under MIT License 
 *	http://www.opensource.org/licenses/mit-license.php
 *
**/
	
	// model definition
	abstract class Model {
		// objects manager
		private static $_objects;

		// meta settings for model
		public static $_table = 'model';
		public static $_pk = 'id';

		// private variables
		private $_loaded = array();
		private $_changed = array();
		private $_extra = array();

		// constructor
		public function __construct( $array = array() ){
			self::$_objects = $_objects = array();

			foreach( $array as $k => $v ){
				// check if property
				if( property_exists( get_called_class(), $k ) ){
					$this->$k = $v;
					// add to loaded
					$this->_loaded[] = $k;
				}
				// add to extra
				else
					$this->_extra[ $k ] = $v;
			}
		}

		// setter for editing properties
		public function set( $name, $value ) {
			if( $this->$name != $value )
				$this->$name = $value;
				$this->_changed[ $name ] = true;
		}

		// getter for extra fields
		public function get( $key ){
			return isset( $this->_extra[ $key ] ) ? $this->_extra[ $key ] : null;
		}

		// save or create as per pk
		public function save( $force_insert = false ){
			$pk = self::$_pk;
			$pkval = $this->$pk;
			$db = self::objects();
			$args = array();

			// check for insert
			if( !$pkval or $force_insert ){
				// collect args
				foreach( get_object_vars( $this ) as $k => $v )
					if( $k[ 0 ] != '_' && $v != null )
						$args[ $k ] = $v;
				
				// insert into db
				$newpkval = $db->insert( $args );
				if( $pkval )
					return $db->get( array( $pk => $pkval ) );
				elseif( $newpkval )
					return $db->get( array( $pk => $newpkval ) );
				else
					return $db->get( $args );
			}
			else {	
				// collect args
				foreach( $this->_changed as $k => $v )
					if( in_array( $k, $this->_loaded ) )
						$args[ $k ] = $this->$k;

				// update in db
				$db->filter( array( $pk => $pkval ) )->update( $args );
				return $this;
			}
		}

		// delete object
		public function delete(){
			$pk = self::$_pk;
			$pkval = $this->$pk;

			// delete from db
			$db = self::objects()->filter( array( $pk => $pkval ) );
			$db->delete( $args );
			
			// return stale object
			return $this;
		}

		// objects manager helper
		public static function objects(){
			$cls = get_called_class();
			if( !isset( self::$_objects[ $cls ] ) ){
				self::$_objects[ $cls ] = new DB( $cls );
			}

			return self::$_objects[ $cls ];
		}

		// join setup helper in model
		public static function setup_join( $join, $pieces, &$i, &$joins, &$tables ){
			$cls = get_called_class();
			$j = $i;

			while( $pieces ){
				// find reference
				$field = array_pop( $pieces );	

				if( !isset( $cls::$_refs[ $field ] ) ){
					$ifield = $cls::$_pk;

					$cls = ucfirst( $field );
					$jfield = $cls::$_pk;
					
				}
				else {
					$ref = $cls::$_refs[ $field ];
					$cls = $ref[ 0 ];

					$jfield = $ref[ 1 ];
					$ifield = $field.'_id';
				}

				// init variables Ti
				$j = $i;
				$i++;

				// append join to tables
				$tables[] = '`'.$cls::$_table.'` T'.$i." ON ( T$i.`$jfield` = T$j.`$ifield` )";
			}

			// cache Ti variable into joins
			$joins[ $join ] = "T$i";
		}
	}

?>