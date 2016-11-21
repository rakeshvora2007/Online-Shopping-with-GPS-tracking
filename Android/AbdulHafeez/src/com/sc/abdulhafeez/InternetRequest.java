package com.sc.abdulhafeez;

import android.app.ProgressDialog;
import android.os.AsyncTask;

public class InternetRequest extends AsyncTask< String, Integer, String > {

	final static int URL = 0;
	final static int METHOD = 1;
	final static int URL_PARAMETERS = 2;
	
	ProgressDialog p;
	
	@Override
	protected void onPreExecute() {
		super.onPreExecute();
		
	}
	
	@Override
	protected String doInBackground( String... params ) {
		return Functions.makeRequestForData( params[ URL ], params[ METHOD ], params[ URL_PARAMETERS ] );
	}
	
	@Override
	protected void onPostExecute( String result ) {
		super.onPostExecute( result );
	}

}
