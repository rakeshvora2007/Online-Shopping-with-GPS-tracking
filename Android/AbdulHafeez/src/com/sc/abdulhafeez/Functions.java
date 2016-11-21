package com.sc.abdulhafeez;


import java.io.BufferedInputStream;
import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.FileInputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;

import android.app.AlertDialog;
import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.wifi.WifiInfo;
import android.net.wifi.WifiManager;
import android.telephony.TelephonyManager;
import android.util.Log;
import android.view.View;

public class Functions {
	
	// ----- Making GET/POST Request Starts Here
	public static String makeRequestForData( String url, String method, String url_parameters ){
		StringBuffer response = null;
		URL obj = null;
		HttpURLConnection con = null;
		
		try{
			String encodedURL = url;
			//URLEncoder.encode(url, "UTF-8");
			//urlParameters     = URLEncoder.encode(urlParameters, "UTF-8");
			//urlParameters     = urlParameters.replaceAll("+", "%20");
			Log.i( null, "url : " +encodedURL );
			
			obj = new URL( encodedURL);
			con = ( HttpURLConnection ) obj.openConnection();
			con.setRequestMethod( method );
			con.setDoOutput( true );
			DataOutputStream wr = new DataOutputStream( con.getOutputStream() );
			wr.writeBytes( url_parameters );
			wr.flush();
			wr.close();
		
			int responseCode = con.getResponseCode();
			
			if( responseCode == 200 ){
				BufferedReader in = new BufferedReader( new InputStreamReader( con.getInputStream() ) );
				String inputLine;
				response = new StringBuffer();
			
				while ( ( inputLine = in.readLine() ) != null ) {
					response.append( inputLine );
				}
				in.close();
			}
			else{
				throw new Exception( "No Response from server." );
			}
		}
		catch( Exception e ){
			e.printStackTrace();
			return null;
		}
		
		return response.toString();
	}
	// ----- Making GET/POST Request Ends Here
	
	// Remove duplicates from String array
	public static String[] removeDuplicates( String arr[] ){
		String temp[] = new String[ arr.length ];
		arr = sortLexicographically( arr );
		int counter = 0;
		for( int i=0; i<arr.length ; i++ ){
			for( int j = i + 1; j<arr.length ; j++ ){
				if( arr[ j ].charAt( 0 ) == arr[ i ].charAt( 0 ) ){
					// IF first characters of current and next is same, then check if the strings are same
					if( ! arr[ j ].equals( arr[ i ] ) ){
						temp[ counter ] = arr[ i ];
						counter++;
						i = j;
						break;
					}
				}
				else{
					temp[ counter ] = arr[ i ];
					counter++;
					i = j;
					break;
				}
					
			}
		}
		
		// Count the number of values in temp excluding null
		int i = 0;
		for( i = 0; temp[ i ] != null ; i++ ){
			
		}
		String[] removed_duplicates = new String[ i ];
		for( i = 0; i < removed_duplicates.length ; i++ ){
			removed_duplicates[ i ] = temp[ i ];
		}
		
		return removed_duplicates;
	}
	
	// String String[] LEXICOGRAPHICALLy
	public static String[] sortLexicographically( String arr[] ){
		String temp;
		for( int i = 0 ; i < arr.length ; i++ ){
			for( int j = i + 1 ; j < arr.length; j++ ){
				if( arr[ j ].compareTo( arr[ i ]) < 0 ){
					temp = arr[ i ];
					arr[ i ] = arr[ j ];
					arr[ j ] = temp;
				}
			}
		}
		return arr;
	}
	
	// Remove null or Blank Strings from the array
	public static String[] removeNullAndBlank( String arr[] ){
		String[] temp = new String[ arr.length ];
		int counter = 0;
		for( int i = 0 ; i < arr.length ; i++ ){
			if( arr[ i ] == null || arr[ i ].equals("") || arr[ i ].equals(" ") )
				continue;
			temp[ counter ] = arr[ i ];
			counter++;
		}
		String temp_new[] = new String[ counter ];
		for( int i = 0 ; i < counter ; i++ ){
			temp_new[ i ] = temp[ i ];
		}
		temp = removeDuplicates( temp_new );
		temp = sortLexicographically( temp );
		return temp;
	}
	
	// Creating a Custom Dialog
	public static AlertDialog.Builder createCustomDialog( Context ct, String title, String message, View view ){
		AlertDialog.Builder alert = new AlertDialog.Builder( ct );
		alert.setTitle( title );
		alert.setMessage( message );
		alert.setCancelable( false );
		alert.setView( view );
		return alert;
	}
	
	// Retrieve Mac Address
	public static String getMacAddress( Context ct ){
		WifiManager manager = (WifiManager ) ct.getSystemService( Context.WIFI_SERVICE );
		WifiInfo info = manager.getConnectionInfo();
		String address = info.getMacAddress();
		return address;
	}
	
	// Common Toast and Log recorder function
	public static void logAndToast( Context context, String TAG, String message ){
		Log.i( TAG, message );
		// Toast.makeText( context, message, Toast.LENGTH_LONG ).show();
	}
	
	// Network Connection Detector
	public static boolean isConnectedToInternet( Context context ){
        ConnectivityManager connectivity = (ConnectivityManager) context.getSystemService( Context.CONNECTIVITY_SERVICE );
          if ( connectivity != null ){
              NetworkInfo[] info = connectivity.getAllNetworkInfo();
              if ( info != null )
                  for ( int i = 0; i < info.length; i++ )
                      if ( info[i].getState() == NetworkInfo.State.CONNECTED ){
                          return true;
                      }
          }
          return false;
    }
	// Network Connection Detector
	
	
	public static String getIMEI( Context context ){
		TelephonyManager mngr = (TelephonyManager) context.getSystemService( context.TELEPHONY_SERVICE ); 
		return mngr.getDeviceId();
	}
	
	// Upload Image
	public static String sendPost(String file_path, String url, String file_extension) throws Exception {

		//String uploadedFilename = url.substring(0, url.lastIndexOf((int)'/') +1);
		Log.i("File Path : ", file_path);
		Log.i("URL : ", url);
		Log.i("Extension : ", file_extension);
		String uploadedFilename  =  "";
		URL obj = new URL(url);
		HttpURLConnection con = (HttpURLConnection) obj.openConnection();
		con.setRequestMethod("POST");
		con.setRequestProperty("enctype", "multipart/form-data");

		con.setDoOutput(true);

		OutputStream os = con.getOutputStream();
		Thread.sleep(1000);
		BufferedInputStream fis = new BufferedInputStream(new FileInputStream( file_path ));

		byte buff[] = new byte[1024];
		while((fis.read(buff)) != -1){
			os.write(buff);
		}
		os.close();

		BufferedReader in = new BufferedReader(new InputStreamReader(con.getInputStream()));

		if(con.getResponseCode() == 200){
			String s;
			while ((s = in.readLine()) != null) {
				s = s.trim();
				uploadedFilename += s;
			}


			//uploadedFilename = uploadedFilename.substring(0, uploadedFilename.indexOf(file_extension) + 3);

			System.out.println("Uploaded file name : "+uploadedFilename);
			in.close();
			fis.close();
			con.disconnect();

			return uploadedFilename;
		}
		else
		{
			fis.close();
			return null;
		}
	}	
	// Upload Image

	// Generate Random Image Name
	public static String generateRandomName( String file_extension ){
		String random = String.valueOf( (long)( Math.random() * 1000000000 ) ) + String.valueOf( (long)( Math.random() * 1000000000 ) );
		return random + "." +file_extension;
	}
	// Generate Random Image Name

}
