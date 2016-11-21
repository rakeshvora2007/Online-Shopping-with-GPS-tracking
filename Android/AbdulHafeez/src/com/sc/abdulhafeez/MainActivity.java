package com.sc.abdulhafeez;

import static com.sc.abdulhafeez.Constants.URL_WEB_SERVICE;
import android.content.Context;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;
import android.util.Log;
import android.widget.TextView;
import android.support.v7.appcompat.*;

public class MainActivity extends ActionBarActivity {

	TextView tv_lat;
	TextView tv_lng;
	String lat="", lon="";
	LocationManager locationManager;
	LocationListener locationListener;
	long startTime;
	long interval = 5;
	
	public static final String TAG = "ABDUL";
	
    @Override
    protected void onCreate( Bundle savedInstanceState ) {
        super.onCreate( savedInstanceState );
        setContentView( R.layout.activity_main );
        
        tv_lat = (TextView) findViewById( R.id.tv_lat );
        tv_lng = (TextView) findViewById( R.id.tv_lng );
        
        interval = 0;
        startTime = System.currentTimeMillis();
        Log.i( TAG, "Start Time millis : "+startTime );
        startTime = startTime / 1000;
        Log.i( TAG, "Start Time Seconds : "+startTime );
        
        // Acquire a reference to the system Location Manager
		locationManager = (LocationManager) getSystemService( Context.LOCATION_SERVICE );
		// Define a listener that responds to location updates
		locationListener = new LocationListener() {
			public void onLocationChanged(Location location) {
				// Called when a new location is found by the network location provider.
				if( location == null )
					return;
				lat = Double.toString( location.getLatitude() );
				lon = Double.toString( location.getLongitude() );
				tv_lat.setText( lat );
				tv_lng.setText( lon );
				
				long now = System.currentTimeMillis() / 1000;
				Log.i( TAG, "now - startTime : "+(now - startTime) );
				Log.i( TAG, "interval : "+(interval) );
				
				if( ( now - startTime ) > interval ){
					interval = 5;
					startTime = System.currentTimeMillis() / 1000;
			        Log.i( TAG, "Location changed after 5 seconds" );
			        // upload the location
			        InternetRequest ir = new InternetRequest(){
			        	@Override
			        	protected void onPostExecute( String result ) {
			        		super.onPostExecute( result );
			        		
			        		if( result == null )
			        			return;
			        		
			        		Log.i( TAG, result );
			        		
			        	}
			        };
			        String URL_PARAMETERS = "what_do_you_want=update_location&latlng="+lat+","+lon;
			        String params[] = new String[]{ URL_WEB_SERVICE, "POST", URL_PARAMETERS };
			        ir.execute( params );
				}
			}

			public void onStatusChanged(String provider, int status, Bundle extras) {}
			public void onProviderEnabled(String provider) {}
			public void onProviderDisabled(String provider) {}
		};
		// Register the listener with the Location Manager to receive location updates
		locationManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER, 0, 0, locationListener);
	
        
    }


    
}
