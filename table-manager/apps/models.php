<?php

	require_once( BP_ROOT. 'db.php' );

	// table model
	class Table extends Model {
		var $id;
		var $name;
		var $pk;
		var $rows;
		var $ctime;
		var $mtime;
		
		private $_old = array();
		
		static $_table = 'schema_table';
		static $_pk = 'id';
	
		
		public function set( $name, $value ){
			if( !isset( $this->_old[ $name ] ) )
				$this->_old[ $name ] = $this->$name;
			parent::set( $name, $value );
		}
		
		public function save( $force_insert = false ){
			//check for create
			//echo $this->name;
			if(!isset($this->id)){
				if(!isset($this->name)){
					echo "Table name is required!";
					return $this;
				}
				
				$this->set('pk', isset($this->pk) ? $this->pk : 'id');
				$this->set('rows', isset($this->rows) ? $this->rows : 0);

				
				$q = "CREATE TABLE IF NOT EXISTS `".$this->name."` ( ".$this->pk." INT(11) AUTO_INCREMENT PRIMARY KEY );";
				
				$conn = db_get_connection();
				$stmt = $conn->prepare( $q );
				$res = $stmt->execute();
				
				if( $res === false ){
					$error = $stmt->errorInfo();
					throw new DBQueryError( ( DEBUG ? 'Error Executing Query: '. $q : '' ) .' Error: '.$error[ 2 ].' (Code '.$error[ 1 ].')' );
				}

				parent::save( $force_insert );
				return $this;
			}
			else{
				$action = 0;
				if( !$this->_changed[ 'name' ] ){
					return $this;
				}
				$q = "ALTER TABLE ".$this->_old[ 'name' ]." RENAME ".$this->name.";";
				
				$conn = db_get_connection();
				$stmt = $conn->prepare( $q );
				$res = $stmt->execute();
				
				if( $res === false ){
					$error = $stmt->errorInfo();
					throw new DBQueryError( ( DEBUG ? 'Error Executing Query: '. $q : '' ) .' Error: '.$error[ 2 ].' (Code '.$error[ 1 ].')' );
				}

				parent::save( $force_insert );
				return $this;
			}
		}
		
		public function delete(){
			if(!isset($this->name)){
				echo "Table name required!!";
				return $this;
			}
			$q = "DROP TABLE IF EXISTS ".$this->name.";";
			$conn = db_get_connection();
			$stmt = $conn->prepare( $q );
			$res = $stmt->execute();
			
			if( $res === false ){
				$error = $stmt->errorInfo();
				throw new DBQueryError( ( DEBUG ? 'Error Executing Query: '. $q : '' ) .' Error: '.$error[ 2 ].' (Code '.$error[ 1 ].')' );
			}

			parent::delete();
			return $this;
		}
	}

?>
