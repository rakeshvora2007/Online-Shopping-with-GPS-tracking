<!DOCTYPE html>
	<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<link 
		href="http://code.google.com/apis/maps/documentation/javascript/examples/default.css" 
		rel="stylesheet" type="text/css" />
		
		<!--Google API Javascript Reference-->
		<script type="text/javascript" 
		src="http://maps.google.com/maps/api/js?sensor=false"></script> 
			
		<script>
		$(document).ready(function(){
		var latitude = parseFloat ("19.0393213"); 
	     var longitude = parseFloat ("72.8443585"); 
	     var latlngPos = new google.maps.LatLng (latitude, longitude);

	    // Set up options for the Google map
	    var myOptions = {
	        zoom: 14,
	        center: latlngPos,
	        mapTypeId: google.maps.MapTypeId.ROADMAP,
	        zoomControlOptions: true,
	        zoomControlOptions: {
	            style: google.maps.ZoomControlStyle.LARGE
	        }
	    };

	    // Define the map
	    map = new google.maps.Map(document.getElementById("map"), myOptions);

	    // Add the marker
	    var marker = new google.maps.Marker({
	        position: latlngPos,
	        map: map,
	        title: "Your Location"
	    });
		});
		</script>
	</head>
	<body>
		<div id="map" style="width: 100%; height: 100%;"></div>
	</body>
</html>