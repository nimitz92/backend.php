<?php
/**
 *	Utility Functions
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
 *	Licensed under MIT License 
 *	http://www.opensource.org/licenses/mit-license.php
 *
**/

	// http redirect
	function http_redirect( $url, $array = array() ){
		if( $array ){
			$params = array();
			foreach( $array as $k => $v )
				$params[] = $k.'='.$v;
			$url .= '?'.implode( '&', $params );
		}
		
		header( 'Location: '. $url );
	}

	// get unique object
	function unique_object( $cls, $array = array() ){
		try {
			return $cls::objects()->get( $array );
		}
		catch( Exception $e ){
			return null;
		}
	}

	// generate random string
	function random_string( $length = 10, $charset = 'qwert12yuiop34asdf56ghjkl78zxcv90bnm' ){
		$result = '';
		$charsetlen = strlen( $charset ) - 1;

		for( $i = 0; $i < $length; $i++ ){
			$result .= $charset[ mt_rand( 0, $charsetlen ) ];
		}

		return $result;
	}

	// generate random uuid
	function random_uuid(){
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
			// 32 bits for "time_low"
			mt_rand(0, 0xffff), mt_rand(0, 0xffff),
	 
			// 16 bits for "time_mid"
			mt_rand(0, 0xffff),
	 
			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand(0, 0x0fff) | 0x4000,
	 
			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand(0, 0x3fff) | 0x8000,
	 
			// 48 bits for "node"
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);
	}

?>
