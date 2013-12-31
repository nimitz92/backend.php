<?php
/**
 *	Session Models
 *
 *	Vibhaj Rajan <vibhaj8@gmail.com>
 *
 *	Licensed under MIT License 
 *	http://www.opensource.org/licenses/mit-license.php
 *
**/

	require_once( BP_ROOT. 'db.php' );
	require_once( BP_ROOT. 'util.php' );

	// user model
	class File extends Model {
		var $id;
		var $owner_id;
		var $alias;
		var $repeat;
		var $ext;
		var $name;
		var $path;
		var $title;
		var $size;
		var $mime;
		var $type;

		static $_table = 'storage_files';
		static $_pk = 'id';
	}


?>
