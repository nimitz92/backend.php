<?php
/**
 *	Auth Endpoint Page
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
 *	Licensed under MIT License 
 *	http://www.opensource.org/licenses/mit-license.php
 *
**/

require_once( BP_ROOT. "../lib/hybridauth/hybridauth/Hybrid/Auth.php" );
require_once( BP_ROOT. "../lib/hybridauth/hybridauth/Hybrid/Endpoint.php" ); 

require_once( BP_ROOT. "auth/session.php" );

Hybrid_Endpoint::process();

?>
