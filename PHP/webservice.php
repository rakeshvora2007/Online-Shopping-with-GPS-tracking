<?php
	include( './library/config.php' );	
	include( './library/functions.php' );
	
	$what_do_you_want = $_REQUEST[ 'what_do_you_want' ];
	
	if( $what_do_you_want == "update_location" ){
		$latlng = $_REQUEST[ 'latlng' ];
		
		$loc = explode( ",", $latlng );
		
		//	echo "https://maps.googleapis.com/maps/api/geocode/json?latlng=$latlng&AIzaSyCK0wbxZ5MiMQ3Fd1EEHK3SIwB6c2qv1eI";
		
		/* $result = file_get_contents( "https://maps.googleapis.com/maps/api/geocode/json?latlng=$latlng&key=AIzaSyBhlHNfM1OnGzoloSmC-GrdzNBrp2JTiqU" );
		
		$res = json_decode( $result );
		
		$status  = $res->status;
		$address = $res->results[ 0 ]->formatted_address;//$res->results[ 'formatted_address' ];
		
		if( $status == "OK" )
			echo $address;
		else
			echo "Address Not Found"; */
		$address = "";
		
		$query = "Insert into user_location( `latitude`, `longitude`, `address` ) VALUES( '$loc[0]', '$loc[1]', '$address' )";
		updateQuery( $query );
		
		echo  createJSONMessage( "success", "update_location", "Location Updated" );
		//echo $address;
	}
	else{
		echo createJSONMessage( GENERAL_ERROR_MESSAGE, "webservice", "Webservice does not perform such an action, Sorry !!" );
	}