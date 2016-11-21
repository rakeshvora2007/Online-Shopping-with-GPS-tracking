package com.sc.abdulhafeez;

import java.io.File;



public class Constants {

	/*
	 * MNEMONICS
	 * 
	 * SP -> SharedPreferences
	 * SU -> SuperUser Commands
	 * DV -> Default Values
	 * GN -> Generic Values
	 * RC -> Activity Request Codes for on Activity Result
	 * RTC -> Activity Result Codes for on Activity Result
	 * URL -> Links
	 * JSON -> JSON 'for' messages
	 * BR -> Personalized Broadcast Receivers
	 * GCM -> GCM Messages
	 * 
	 * 
	 * */
	
	// SharedPreferences Keys
	final static String SP_FIRST_TIME_KEY									= "first_time";
	
	// SU Commands
	
	// Default Values
	
	// Generic Values
	final static String GN_YES												= "yes";
	final static String GN_NO												= "no";
	
	// Activity Request Codes for on Activity Result
	
	// Activity Result Codes for on Activity Result
	
	// URL
	public final static String URL_HTTP_PROTOCOL						= "http://";
	public final static String URL_HOST									= "192.168.1.25";
	public final static String URL_WEB_SERVICE							= URL_HTTP_PROTOCOL + URL_HOST + File.separator +
																			"abdul_hafeez/webservice.php";
	
	// JSON 'for' messages
	
	// BR -> Personalized Broadcast Receivers
	final static String BR_DISPLAY_MESSAGE_ACTION 				= "com.pushnotifications.DISPLAY_MESSAGE";
	final static String BR_CONSTANT_EXTRA_MESSAGE 				= "message";
	
	// Google project id
    static final String SENDER_ID								= "39788231137"; 

    // APP Related
    final static String APP_NAME								= "Android Remote Control";
    final static String APP_DIR_NAME							= "AndroidRemoteControl";
    
}
