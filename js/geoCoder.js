var geocoder = new google.maps.Geocoder();

function getGeo(){

	if (navigator && navigator.geolocation) {
	navigator.geolocation.getCurrentPosition(geoOK, geoKO);
	} else {
	geoMaxmind();
	}

}

function geoOK(position) {
	showLatLong(position.coords.latitude, position.coords.longitude);
}
function geoMaxmind() {
	showLatLong(geoip_latitude(), geoip_longitude());
}
function geoKO(err) {
	if (err.code == 1) {
		error('El usuario ha denegado el permiso para obtener informacion de ubicacion.');
	} else if (err.code == 2) {
		error('Tu ubicacion no se puede determinar.');
	} else if (err.code == 3) {
		error('TimeOut.')
	} else {
		error('No sabemos que pasó pero ocurrio un error.');
	}
}

function showLatLong(lat, longi) {
	var geocoder = new google.maps.Geocoder();
	var yourLocation = new google.maps.LatLng(lat, longi);
	geocoder.geocode({ 'latLng': yourLocation },muestraDestino);

}
function processGeocoder(results, status){

	var direccion ="";
		if (status == google.maps.GeocoderStatus.OK) {
			if (results[0]) {
				direccion=results[0].formatted_address;
			//var sevilla = new google.maps.LatLng(37.377222, -5.986944);  
			//var buenos_aires = new google.maps.LatLng(-34.608333, -58.371944);  
			//var distancia = google.maps.geometry.spherical.computeDistanceBetween(sevilla, buenos_aires); 
			//alert(distancia);


		} else {
			error('Google no retorno resultado alguno.');
		}
		} else {
			error("Geocoding fallo debido a : " + status);
	}
	return direccion;

}

function convertDireccionTOLatLang(address)
 {
			//var geocoder = new google.maps.Geocoder();
			//var address = document.getElementById('textboxid').value;
			var latitude;
			var longitude;
			geocoder.geocode({ 'address': address }, function (results, status) {

				if (status == google.maps.GeocoderStatus.OK) {
					 latitude= results[0].geometry.location.lat();
					 longitude = results[0].geometry.location.lng();
					 alert(latitude);
				}
			});
			
		var response = {
			latitud: latitude,
			lng: longitude,
		   };
		   
		 return response;
}
	
	
function error(msg) {
alert(msg);
}