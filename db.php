<?php

	function db_get_connection( $key = 'default' ){
		global $DATABASES;

		if( !isset( $DATABASES[ $key ] ) )
			die( 'Configuration Not Found For DB: '. $key );

		$db = $DATABASES[ $key ];

		if( !isset( $db[ 'conn' ] ) ){
			try {
				$conn = new PDO( $db[ 'dsn' ], $db[ 'user' ], $db[ 'pass'] );
				$db[ 'conn' ] = $conn;
			} 
			catch( PDOException $e ) {
				die( 'Connection failed: ' . $e->getMessage() );
			}
		}

		return $conn;
	}

	function db_close_connection( $key = 'default' ){
		global $DATABASES;

		if( !isset( $DATABASES[ $key ] ) )
			die( 'Configuration Not Found For DB: '. $key );

		$db = $DATABASES[ $key ];

		if( isset( $db[ 'conn' ] ) )
			$db[ 'conn' ] = null;
			unset( $db[ 'conn' ] );
	}

	class Model {
		private static $_objects = false;
		static $_table = 'model';
		static $_pk = 'id';

		private $_loaded = array();
		private $_changed = array();
		private $_extra = array();


		function Model( $array = array() ){
			foreach( $array as $k => $v ){
				if( property_exists( get_called_class(), $k ) ){
					$this->$k = $v;
					$this->_loaded[] = $k;
				}
				else
					$this->_extra[ $k ] = $v;
			}
		}

		function set( $name, $value ) {
			if( $this->$name != $value )
				$this->$name = $value;
				$this->_changed[ $name ] = true;
		}

		function save( $force_insert = false ){
			$pk = self::$_pk;
			$pkval = $this->$pk;

			if( !$pkval or $force_insert ){
				// insert into table
			}
			else {
				$db = self::objects()->filter( array( $pk => $pkval ) );
				$args = array();

				foreach( $this->_changed as $k => $v )
					if( in_array( $k, $this->_loaded ) )
						$args[ $k ] = $this->$k;

				$db->update( $args );
				return $this;
			}
		}

		function delete(){
			$pk = self::$_pk;
			$pkval = $this->$pk;

			$db = self::objects()->filter( array( $pk => $pkval ) );
			$db->delete( $args );
			
			return $this;
		}

		static function objects(){
			if( !self::$_objects ){
				self::$_objects = new DB( get_called_class() );
			}
			return self::$_objects;
		}

		static function setup_join( $join, $pieces, &$i, &$joins, &$tables ){
			$i++;
			$joins[ $join ] = "T$i";
		}
	}

	class EXPR {
		var $_array;

		function __construct( $array = array() ){
			$this->_array = $array;
		}

		function vars(){
			return array_keys( $this->_array );
		}

		function sql( $vars, &$subs ){
			$q = array();
			foreach( $this->_array as $key => $value ) {
				if( is_a( $value, 'EXPR' ) )
					array_push( $q, $value->sql( $vars, $subs, $i ) );
				else {
					$subs[] = $value;
					array_push( $q, $vars[ $key ]. '= ?' );
				}
			}
			return implode( 'AND ', $q );
		}
	}


	class DB implements IteratorAggregate  {
		var $_model;
		var $_result;
		var $_count;

		var $_select;
		var $_distinct;
		var $_where;
		var $_group;
		var $_having;
		var $_order;
		var $_low;
		var $_high;

		var $_dbkey;


		function __construct( $model ){
			$this->_model = $model;
			$this->_result = false;
			$this->_count = 0;

			$this->_select = array();
			$this->_distinct = false;
			$this->_where = new EXPR();
			$this->_group = array();
			$this->_having = new EXPR();
			$this->_order = array();
			$this->_low = false;
			$this->_high = false;

			$this->_dbkey = 'default';
		}

		function getIterator(){
			if( !is_array( $this->_result ) ){
				$this->_query();
			}

			return new ArrayIterator( $this->_result );
		}

		function _clone(){
			$db = new DB( $this->_model );

			$db->_distinct = $this->_distinct;
			$db->_low = $this->_low;
			$db->_high = $this->_high;

			$db->_select = $this->_select;
			$db->_where = $this->_where;
			$db->_group = $this->_group;
			$db->_having = $this->_having;
			$db->_order = $this->_order;

			return $db;
		}

		function _query(){
			$vars = array();
			$subs = array();

			$q = array( "SELECT" );

			if( $this->_distinct ){
				array_push( $q, "DISTINCT" );
			}

			if( !$this->_select ){
				foreach( array_keys( get_class_vars( $this->_model ) ) as $k )
					if( $k[ 0 ] != '_' )
						$this->_select[] = $k;
			}

			foreach( $this->_select as $e ){
				$vars[ $e ] = false;
			}

			foreach( $this->_where->vars() as $e ){
				$vars[ $e ] = false;
			}

			foreach( $this->_group as $e ){
				$vars[ $e ] = false;
			}

			foreach( $this->_having->vars() as $e ){
				$vars[ $e ] = false;
			}

			foreach( $this->_order as $e ){
				$vars[ $e ] = false;
			}

			$tables = $this->_setup_joins( $vars );

			if( $this->_select ){
				$qs = array();
				foreach( $this->_select as $e ){
					array_push( $qs, $vars[ $e ].' AS `'. $e.'`' );
				}
				array_push( $q, implode( ', ', $qs ), 'FROM', $tables );	
			}
			
			if( $this->_where ){
				$qs = $this->_where->sql( $vars, $subs );
				if( $qs )
					array_push( $q, 'WHERE', $qs );	
			}
			
			if( $this->_group ){
				$qs = array();
				foreach( $this->_group as $e ){
					array_push( $qs, $vars[ $e ] );
				}
				array_push( $q, 'GROUP BY', implode( ', ', $qs ) );
			}

			if( $this->_having ){
				$qs = $this->_having->sql( $vars, $subs );
				if( $qs )
					array_push( $q, 'HAVING', $qs );
			}

			if( $this->_order ){
				$qs = array();
				foreach( $this->_order as $e ){
					array_push( $qs, $vars[ $e ] );
				}
				array_push( $q, 'ORDER BY', implode( ', ', $qs ) );	
			}

			if( $this->_low !== false && $this->_high !== false ){
				$limit = $this->_high - $this->_low;
				array_push( $q, 'LIMIT', $limit, 'OFFSET', $this->_low );
			}

			$q = implode( ' ', $q );

			$conn = db_get_connection( $this->_dbkey );
			$stmt = $conn->prepare( $q );
			$res = $stmt->execute( $subs );

			if( $res === false ){
				$error = $stmt->errorInfo();
				die( 'Error Executing Query: '. $q. ' Error: '.$error[ 2 ].' (Code '.$error[ 1 ].')' );
			}
			
			$this->_result = array();

			foreach( $stmt->fetchAll( PDO::FETCH_ASSOC ) as $row )
				$this->_result[] = new $this->_model( $row );
				$this->_count++;
		}

		function _setup_joins( &$vars ){
			$model = $this->_model;
			$tables = array( '`'. $model::$_table. '` T1' );
			$joins = array();
			$i = 1;

			foreach( $vars as $var => $e ){
				$pieces = explode( '__', $var );
				$field = array_pop( $pieces );

				if( $pieces ){
					$join = implode( '__', $pieces );
					if( !isset( $joins[ $join ] ) ){
						$model::setup_join( $join, $pieces, $i, $joins, $tables );
					}
					
					$vars[ $var ] = $joins[ $join ]. '.`'. $field .'`';
				}
				else {
					$vars[ $var ] = 'T1.`'. $field .'`';
				}
			}

			return implode( ', ', $tables );
		}

		function update( $set ){
			$model = $this->_model;
			$vars = array();
			$subs = array();

			$q = array( "UPDATE", '`'.$model::$_table.'`', 'SET' );

			foreach( $this->_where->vars() as $e ){
				$vars[ $e ] = '`'.$e.'`';
			}

			if( $set ){
				$qs = array();
				foreach( $set as $k => $v ){
					array_push( $qs, '`'.$k.'`=?' );
					$subs[] = $v;
				}
				array_push( $q, implode( ', ', $qs ) );	
			}
			
			if( $this->_where ){
				$qs = $this->_where->sql( $vars, $subs );
				if( $qs )
					array_push( $q, 'WHERE', $qs );	
			}
			
			$q = implode( ' ', $q );

			$conn = db_get_connection( $this->_dbkey );
			$stmt = $conn->prepare( $q );
			$res = $stmt->execute( $subs );

			if( $res === false ){
				$error = $stmt->errorInfo();
				die( 'Error Executing Query: '. $q. ' Error: '.$error[ 2 ].' (Code '.$error[ 1 ].')' );
			}
			
			return $res;
		}

		function delete(){
			$model = $this->_model;
			$vars = array();
			$subs = array();

			$q = array( "DELETE FROM", '`'.$model::$_table.'`' );

			foreach( $this->_where->vars() as $e ){
				$vars[ $e ] = '`'.$e.'`';
			}

			if( $this->_where ){
				$qs = $this->_where->sql( $vars, $subs );
				if( $qs )
					array_push( $q, 'WHERE', $qs );	
			}
			
			$q = implode( ' ', $q );

			$conn = db_get_connection( $this->_dbkey );
			$stmt = $conn->prepare( $q );
			$res = $stmt->execute( $subs );

			if( $res === false ){
				$error = $stmt->errorInfo();
				die( 'Error Executing Query: '. $q. ' Error: '.$error[ 2 ].' (Code '.$error[ 1 ].')' );
			}
			
			return $res;
		}

		function only( $select ){
			$this->_select = $select;
			return $this;
		}

		function values( $select ){
			$this->_select = $select;
			return $this;
		}

		function filter( $where ){
			if( is_array( $where ) )
				$where = new EXPR( $where );

			$this->_where = $where;
			return $this;
		}

		function limit( $low, $high ){
			$this->_low = $low;
			$this->_high = $high;
			return $this;
		}

		function order_by( $order ){
			$this->_order = $order;
			return $this;
		}

		function count(){
			if( $this->result === false ){
				$db = $this->_clone();
				$db->_query();
				return $db->_count;
			}

			return $this->count;
		}

		function using( $dbkey ){
			$this->_dbkey = $dbkey;
			return $this;
		}

	}

?>
