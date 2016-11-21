<?php 
	@session_start();
	$con = null;
	$hooks_array = array();
	
	include( "./library/config.php" );
	//include( "./includes/constants.php" );
	
	// WEBSITE DETAILS
	//initWebsite();
	
	/**
	 * Initialize a connection link with the database, and select the database.
	 *
	 * @return FALSE When error occured,
	 * TRUE When connection is successful
	*/
	function connect(){
		require( "./library/config.php" );
		global $con;
		
		if( empty( $host ) || empty( $database_username ) ){
			$error = createJSONMessage( GENERAL_ERROR_MESSAGE, "config-file", "config.php file not yet configured !" );
			
			// When debug_mod is OFF, redirect user to maintenance page
			checkDebugMode( PAGE_MAINTENANCE, TRUE );
			
			echo $error;
			return FALSE;
		}
		if( $con == null ){
			$con = @mysqli_connect( $host, $database_username, $database_password, $database_name );
			
			if( ( $con == FALSE ) || ( $con == NULL ) ){
				$error = createJSONMessage( GENERAL_ERROR_MESSAGE, "connect()", mysqli_connect_error() );
				// When debug_mod is OFF, redirect user to maintenance page
				checkDebugMode( PAGE_MAINTENANCE, TRUE );
				
				echo $error;
				return FALSE;
			}
		}
		return TRUE;
	}
	
	/**
	 * Check if the Debug Mode is ON or OFF, so as to take appropriate action
	 * 
	 * @param $redirect_url String Redirect user to this URL if debug mode is OFF
	 * 
	 * @param $use_permalink_for_redirect boolean Whether or not to use permalink structure for redirection
	 * 
	 * @return 
	 * none 
	 */
	function checkDebugMode( $redirect_url, $use_permalink_for_redirect ){
		if( ! DEBUG_MODE_ON ){
			redirect1( $redirect_url, $use_permalink_for_redirect );
			return;
		}
	}
	
  /**
	* Creates a randomly generated ID with a prefix of your choice
	* @param
	* String $prefix an identifier of your choice followed by 10 Digit Random Number
	*/
	function createId( $prefix ){
		$id = $prefix . "-" . rand( 1, 99999 ) . rand( 1, 99999 );
		return $id;
	}
	
   /**
	* Generates an Array of Error or Success information
	*
	* @param
	* String $type Identifier of the message ; success or error
	* 
	* @param
	* String $for  Purpose/Task
	* 
	* @param
	* String $info Custom message associated with the identifier and purpose
	*
	*/
	function createMessage( $type, $for, $info ){
		$arr = array();
		array_push( $arr, array( "type"=>$type, "for"=>$for,  "info"=>$info ));
		return $arr;
	}
	
	/**
	 * Generates a JSON Encoded Array of Error or Success information
	 *
	 * @param
	 * String $type Identifier of the message ; success or error
	 *
	 * @param
	 * String $for  Purpose/Task
	 *
	 * @param
	 * String $info Custom message associated with the identifier and purpose
	 *
	 */
	function createJSONMessage( $type, $for, $info ){
		/*
		 * Generates a Json Encoded Array of Error or Success information
		 * 
		 * $type -> Identifier of the message ; success or error
		 * $for  -> Purpose/Task
		 * $info -> Custom message associated with the identifier and purpose
		 * 
		 */
		$arr = array();               
		array_push( $arr, array( "type"=>$type, "for"=>$for,  "info"=>$info ));
		return /* header( 'Content-Type: application/json; charset=utf-8', true, 200 ) .  */json_encode( $arr );
		// return json_encode( $arr );
	}
	
	function isValidFileExtension( $file_url, $allowed_file_extensions ){
		/*
		 * To check if the file extension is allowed
		 * $file_url -> URL or name of the file
		 * $allowed_file_extensions -> Array of valid file extensions
		 *
		 */
		$file_extension = substr( $file_url, strpos( $file_url, "." ) + 1 );
		//for( $i=0; $i<count( $allowed_file_extensions ); $i++ ){
		if( ! in_array( $file_extension, $allowed_file_extensions ) ){
			return false;	
		}
		return true;
		//}
	}
	
	function getFileExtension( $file_url ){
		/*
		* To get the file extension of the File that has been input
		* $file_url -> URL or name of the file
		*
		*/
		return substr( $file_url, strpos( $file_url, "." ) + 1 );
	}
	
	function getFileName( $file_url ){
		/*
		* To get the file name of the File URL that has been input, removing the slashes and its extension
		* $file_url -> URL or name of the file
		*
		*/
		if( ( $pos = strpos( $file_url, "/" ) ) != false )
			return substr( $file_url, $pos+1, strpos( $file_url, "." ) - $pos - 1 );
		
		return substr( $file_url, 0, strpos( $file_url, "." ) );
	}
	
	/**
	* Fires the Select Query over the database handle opened using $con object
	* 
	* @param
	* $query String The SQL query to be fired
	* 
	* @return
	* Result Set object on SUCCESS, JSON encoded array with error message and information on FAILURE
	*/
	function selectQuery( $query ){
		connect();
		global $con;
		$result_set = mysqli_query( $con, $query );
		
		if( $result_set == FALSE ){
			return createJSONMessage( GENERAL_ERROR_MESSAGE, QUERY_FIRE_ERROR, mysqli_error( $con ) );
		}
		
		return $result_set;
	}
	
	/**
	 * Fires the Insert Query over the database handle opened using $con object
	 *
	 * @param
	 * $query String The SQL query to be fired
	 *
	 * @return
	 * int containing count of the number of rows inserted on SUCCESS, JSON encoded array with error message and information on FAILURE
	 */
	function insertQuery( $query ){
		connect();
		global $con;
		$num_rows_inserted = mysqli_query( $con, $query );
	
		if( $num_rows_inserted == FALSE ){
			return createJSONMessage( GENERAL_ERROR_MESSAGE, QUERY_FIRE_ERROR, mysqli_error( $con ) );
		}
	
		return $num_rows_inserted;
	}
	
	/**
	 * Fires the Update Query over the database handle opened using $con object
	 *
	 * @param
	 * $query String The SQL query to be fired
	 *
	 * @return
	 * int containing count of the number of rows updated on SUCCESS, JSON encoded array with error message and information on FAILURE
	 */
	function updateQuery( $query ){
		connect();
		global $con;
		$num_rows_updated = mysqli_query( $con, $query );
	
		if( $num_rows_updated == FALSE ){
			return createJSONMessage( GENERAL_ERROR_MESSAGE, QUERY_FIRE_ERROR, mysqli_error( $con ) );
		}
	
		return $num_rows_updated;
	}
	
	/**
	 * Fires the Delete Query over the database handle opened using $con object
	 *
	 * @param
	 * $query String The SQL query to be fired
	 *
	 * @return
	 * int containing count of the number of rows deleted on SUCCESS, JSON encoded array with error message and information on FAILURE
	 */
	function deleteQuery( $query ){
	   connect();
		global $con;
		$num_rows_deleted = mysqli_query( $con, $query );
	
		if( $num_rows_deleted == FALSE ){
			return createJSONMessage( GENERAL_ERROR_MESSAGE, QUERY_FIRE_ERROR, mysqli_error( $con ) );
		}
		
		return $num_rows_deleted;
	}
	
	/**
	* Redirects to the $relative_destination_url
	* The URL should be relative to the current page
	* 
	* @param
	* $relative_destination_url String : Relative destination URL
	* 
	*/
	function redirect( $relative_destination_url ){
		echo '<script>window.location.href="' . $relative_destination_url . '"</script>';
	}
	
	/**
	 * Redirects to the $relative_destination_url
	 * The URL should be relative to the current page
	 *
	 * @param
	 * $relative_destination_url String : Relative destination URL
	 *
	 * @param
	 * $use_permalink boolean : TRUE -> use permalink structure, FALSE -> $relative_destination_url should be relative 
	 */
	function redirect1( $relative_destination_url, $use_permalink ){
		/*
		 * Redirects to $relative_destination_url
		* The URL should be relative to the current page
		*
		*/
		if( $use_permalink )
			echo '<script>window.location.href="' . $relative_destination_url . WEBSITE_LINK_ENDS_WITH . '"</script>';
		else
			redirect( $relative_destination_url );
	}
	
	function bin2base64( $file_url ){
		/*
		 * Outputs the Base64 Encoded Version of Input File
		 * $file_url -> Input file URL
		 */
		$binary_file = file_get_contents( $file_url );
		echo base64_encode( $binary_file );
	}
	
	function containSpecialCharacters( $string, $special_chars = array( "'", '"', "\\", ".", "+", "," ) ){
		/*
		 * Checks if the String contains Special Characters supplied in $special_chars aray
		 * $string -> String to be checked fo presence of special chars
		 * $special_chars -> Array containing special chars which has to be checked for their presence
		 * 
		 */
		
		//$special_chars = array("'", '"', "\\", ".", "+", ",");
		for( $i=0; $i<count( $special_chars ) ; $i++ ){
			if( strstr( $string, $special_chars[ $i ] ) ){
				return true;
			}
		}
		return false;
	}

	
	function resizeImage( $file_url, $required_width, $required_height, $select_width ) {
		/*
		 * To resize Image specified by the URL $file_url with the Proportions Constrained
		 * $file_url -> URL of the image
		 * $required_width -> Desired width of the image, so that height will be adjusted automatically
		 * $required_height -> Desired width of the image, so that width will be adjusted automatically
		 * $select_width -> Boolean, if true, Only width will be considered, if False, only Height will be considered
		 * 
		 * Returns a $img_new (gd image) object which can be passed to imagepng( $img_new, $tmp_image ) to save the new resized image to $tmp_image URL
		 *
		 */
			
		$size = getimagesize( $file_url );
		$width = $size[ 0 ];
		$height  = $size[ 1 ];
		
		if( $select_width ){
			$factor = $width / $required_width;
			$new_width = $width / $factor;
			$new_height = $height / $factor;
		}
		else{
			$factor = $height / $required_height;
			$new_height = $height / $factor;
			$new_width = $width / $factor;
		}
		/* echo "Original Width : " . $size[0] . "<br>";
		 echo "Original Height : " . $size[1] . "<br>";
		echo "New Width : " . $new_width . "<br>";
		echo "New Height : " . $new_height . "<br>";
		*/
		$image_extension = getFileExtension( $file_url );
			
		// implement switch case for png, jpg, gif, bmp
		switch( $image_extension ){
			case "jpg":
			case "jpeg":
			case "JPG":
			case "JPEG":
				$src = imagecreatefromjpeg( $file );
				break;
	
			case "png":
			case "PNG":
				$src = imagecreatefrompng( $file );
				break;
	
			case "gif":
			case "GIF":
				$src = imagecreatefromgif( $file );
				break;
	
			case "bmp":
			case "BMP":
				$src = imagecreatefromwbmp( $file );
				break;
					
		}
			
		$img_new = imagecreatetruecolor( $new_width, $new_height );
		imagecopyresampled( $img_new, $file_url, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
		//imagepng( $dst, $file );  // save the $dst i.e new small image to the same file $file
			
		return $img_new;
	}
	
	/**
	* Converts the timestamp retrieved from the Database into specified $format
	* 
	* Returns the string representation of the Formatted timestamp
	* 
	* @param
	* $timestamp String : Timestamp value taken from the database e.g: 2014-09-24 15:42:12
	* 
	* @param
	* $format String : Output to be seen e.g: 09 July, 1992 i.e. $format = "d F, Y"
	*
	* @return
	* String Formatted timestamp as supplied by $format
	* 
	*/
	function convertTimestamp( $timestamp, $format ){
		// $timestamp = 2014-09-24 15:42:12;
		$split = explode( "-", $timestamp );
		$year  = $split[ 0 ];
		$month = $split[ 1 ];
		$day   = substr( $split[ 2 ], 0, 2 );
			
		$d = date( $format, mktime( 0,0,0, $month, $day, $year ) );
		return $d;
	}
	
	function uploadBinaryFileFromAndroid( $file_name, $file_extension, $directory ){
		/*
		 * Uploads a Binary File to the same directory from Android Device
		 * 
		 * $file_name -> File to be Named As
		 * $file_extension -> Extension for the File
		 * $directory -> Directory name where file has to be moved after getting uploaded
		 * 
		 * Returns the Constructed FileName
		 */
		
		$filename .= "." . $file_extension;
		$fileData = file_get_contents( 'php://input' );
		$fhandle = fopen($filename, 'wb');
		fwrite( $fhandle, $fileData );
		fclose( $fhandle );
		rename( $file_name, $directory . FILE_SEPARATOR . $file_name );
		//copy( $filename, "./$move_to/" . $filename );
		// delete from here
		echo $filename;
	}
	
	function sendMail( $to, $from, $subject, $message ){
		
		//Headers
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8\r\n";
		$headers .= "From: <" . $from . ">" ;
		
		
		
		mail( $to, $subject, $message, $headers );
	}
	
	function getPageName( $url_type ){
		/*
		* Returns the name of the Curent Page Stripping off all the other parts of the URL
		*
		* $url_type -> the type of URL that is Provided as Input (currently on clean is supported)
		*
		* Returns the name of the Current Page
		*/
		
		if( $url_type == "clean" ){
			$current_relative_path = $_SERVER['REQUEST_URI']; // /silentcoders/services.html	 --- On Server, it gives only /
			if( ( $till = strrpos( $current_relative_path, "." ) ) == FALSE )
				$till = strlen( $current_relative_path );
			
			$page_name = substr( $current_relative_path, 0, $till );
			$page_name = substr( $page_name, strrpos( $page_name, "/" ) + 1 );
		}
		else{
			
		}
	
		return $page_name;
	}
	
	function getDomainName(){
		/*
		 * Returns the domain name without "www."
		 * 
		 */
		
		$host = $_SERVER[ 'HTTP_HOST' ];
		return ( strpos( $host, "www." ) )?( trim( $host, "www." ) ):$host;
	}
	
	function initHooks(){
		/*
		 * Fire SQL query to initialize hooks
		*
		* Returns The Mysqli_fetched_Associative_array containing all the hook data
		*
		*/
		connect();
		global $con;
		$query = "Select * from " . DB_HOOKS_TABLE;
		$result_set = mysqli_query( $con, $query ) or ( $error = createJSONMessage( GENERAL_ERROR_MESSAGE, QUERY_FIRE_ERROR, mysqli_error($con) ) );
		global $hooks_array;

		if( count( @$error ) > 0 ){
			// echo;
			return $error;
		}

		while( ( $row = mysqli_fetch_assoc( $result_set ) ) != null ){
			$hooks_array[] = $row;
		}
		return $hooks_array;
	}
	
	function getHookContent( $hook_name ){
		/*
		 * Retuns the content corresponding to the supplied hook
		*
		* $hook_name -> The name of the hook whose content is needed
		*
		*/
		global $hooks_array;
		foreach ( $hooks_array as $data ){
			if ( $data[ CLM_HOOKS_HOOK_NAME ] === $hook_name )
				return $data[ CLM_HOOKS_HOOK_CONTENT ];
		}
	}
	
	function initWebsite(){
	   /*
		* Initialize the DOMAIN_NAME constant
		*
		*/
		connect();
		global $con;
		$sql = "Select * from " . DB_SITE_CONFIG_TABLE;
		$result_set = selectQuery( $sql );
		
		if( gettype( $result_set ) == "object" ){
			$value = mysqli_fetch_array( $result_set );
		
			define( 'WEBSITE_URL_TYPE', $value[ CLM_SITE_CONFIG_URL_TYPE ] ); // No ? in the URL
			define( 'WEBSITE_LINK_ENDS_WITH', $value[ CLM_SITE_CONFIG_LINK_ENDS_WITH ] );
			define( 'WEBSITE_DOMAIN_NAME', $value[ CLM_SITE_CONFIG_DOMAIN_NAME ] );
			define( 'WEBSITE_ADMINPANEL_URL', "index" . WEBSITE_LINK_ENDS_WITH );
		}
	}

	function getUrlParameters( $url ){
		// $url = "/digital_signage/events.html?menu=create&oi=tou";
		// $url = "/digital_signage/events.html";
	
		// check if Question mark exist in the url
		if( strpos( $url, "?" ) == false ){ // false is returned if question mark is not found
			return false;
		}
		else{
			$params = substr( $url, strpos( $url, "?" ) + 1 );
		}

		$params2 = explode( "&", $params );
		// print_r( $params2 );
	
		for( $i = 0 ; $i < count( $params2 ) ; $i++ ){
			$temp = explode( "=", $params2[ $i ] );
			$params_arr[ $temp[ 0 ] ] = $temp[ 1 ];
		}
	
		// print_r( $params_arr );
		return $params_arr;
	}

	function convertMillisecondsToTimestamp( $milliseconds, $format ){
		return $d = date( $format, $milliseconds/1000 );
	}
	
	function getCurrentTimeMilliseconds(){
		return round( microtime( true ) * 1000 );
	}
	
	function havePrivilege( $functionality ){
		$query = "Select COUNT(*) FROM ". DB_ROLES_TABLE .", ". DB_PRIVILEGES_TABLE ." WHERE ". DB_PRIVILEGES_TABLE .".". CLM_PRIVILEGES_FUNCTIONALITY ." = '$functionality' AND ". DB_ROLES_TABLE .".". CLM_ROLES_PRIVILEGE_NAME ." = ". DB_PRIVILEGES_TABLE .".". CLM_PRIVILEGES_PRIVILEGE_NAME ." AND ". DB_ROLES_TABLE .".". CLM_ROLES_ROLE_NAME ." = '". $_SESSION[ SESSION_ROLE_NAME ] ."'";
		$result_set = selectQuery( $query );
		$value = mysqli_fetch_assoc( $result_set );
		return ($value[ 'COUNT(*)' ] == 0) ? false : true;
	}
	
	/**
	 * Validate the string based on specific category of validation
	 * 
	 * @param
	 * $string String : The data string to be validated
	 * 
	 * @param 
	 * $category String : Predefined category constants for different type of validation
	 * 
	 */
	function validate( $string, $category ){
		
	}
?>