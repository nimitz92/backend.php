<?php
/**
 *	Ssession Models
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
 *	Licensed under MIT License 
 *	http://www.opensource.org/licenses/mit-license.php
 *
**/

	require_once( BP_ROOT. 'db.php' );
	require_once( BP_ROOT. 'util.php' );
	require_once( BP_ROOT. 'auth/exception.php' );

	// user model
	class User extends Model {
		var $id;
		var $username;
		var $passwd;
		var $email;
		var $name;
		var $title;
		var $phone;
		var $gender;
		var $dob;
		var $verify;
		var $expiry;
		var $data;

		static $_table = 'auth_users';
		static $_pk = 'id';

		// check password
		public function check_passwd( $passwd ){
			return $passwd && $this->passwd == md5( $this->$username. $passwd );
		}

		// set password
		public function set_passwd( $passwd ){
			if( $passwd ){
				$this->passwd = md5( $this->$username. $passwd );
				$this->save();	
			}
		}

		// login helper
		public static function login( $username, $passwd, $session, $next = LOGIN_REDIRECT ){
			// authenticate
			$u = unique_object( 'User', array( 'username' => $username, 'passwd' => md5( $username. $passwd ) ) );

			// check for error
			if( !$u )
				throw new AuthInvalidCredentials( 'Invalid Credentials' );

			// save session with new id
			$session->user_id = $u->id;
			$session->save( true );

			// redirect after login
			http_redirect( $next );
		}
	}

	// session model
	class Session extends Model {
		var $id;
		var $user_id;
		var $expiry;
		var $active;
		var $data;

		private $_data;
		private $_user;

		static $_table = 'auth_sessions';
		static $_pk = 'id';
		static $_refs = array(
			'user' => array( 'User', 'id' ),
		);

		// initialize user and session data
		public function __construct( $array = array() ){
			parent::__construct( $array );

			$this->_user = null;
			$data = $this->data = isset( $array[ 'data' ] ) ? $array[ 'data' ] : '[]';

			if( isset( $array[ 'user_id' ] ) ){
				$this->_user = unique_object( 'User', array( 'id' => $array[ 'user_id' ] ) );
				if( $this->_user )
					$data = $this->_user->data;
			}

			$this->_data = json_decode( $data );	
		}

		// get session data
		public function data_get( $key ){
			return $this->_data[ $key ];
		}

		// set session data
		public function data_set( $key, $value ){
			$this->_data[ $key ] = $value;
		}

		// get user object
		public function user_get(){
			return $this->_user;
		}

		// save session object
		public function save( $force_insert = false ){
			if( !$this->id or $force_insert ){
				// deactivate old session
				if( $this->id ){
					$this->set( 'active', 0 );
					parent::save();
				}

				// regenerate session id
				$this->set( 'id', $this->generate_id() );
				$this->set( 'expiry', date( "Y-m-d H:i:s", strtotime( date( "Y-m-d H:i:s" ). '+'. COOKIE_EXPIRY. ' days' ) ) );
				$this->set( 'active', 1 );
				
				// delete old cookie
				if( !setcookie( COOKIE_NAME, false, strtotime( date( "Y-m-d H:i:s" ) ) - 5000, COOKIE_PATH, COOKIE_DOMAIN, COOKIE_SECURE, COOKIE_HTTPONLY ) )
					throw new AuthSetCookieError( 'Unable to set cookie header' );

				// set new cookie
				if( !setcookie( COOKIE_NAME, $this->id, strtotime( $this->expiry ), COOKIE_PATH, COOKIE_DOMAIN, COOKIE_SECURE, COOKIE_HTTPONLY ) )
					throw new AuthSetCookieError( 'Unable to set cookie header' );
			}

			// extract session data
			if( $this->_user ){
				$this->_user->set( 'data', json_encode( $this->_data ) );
				$this->_user->save();
			}
			else {
				$this->set( 'data', json_encode( $this->_data ) );	
			}
			
			// save object
			parent::save( $force_insert );
			return $this;
		}

		// generate random session id
		private function generate_id(){
			return random_string( 54 ). time();
		}

		// logout helper
		public function logout(){
			if( $this->id ){
				$this->set( 'active', 0 );
				$this->save();
			}

			http_redirect( LOGOUT_REDIRECT );
		}
	}


?>
