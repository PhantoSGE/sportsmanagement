// http://bl.ocks.org/andyreagan/c81461c8a8ce52d103fc92decf9650b6

var dpjQuery = jQuery.noConflict();
var cities;
var country;			
var countryleafletsearch;
var countryleaflet;

var address;
var street;
var state;
var city;
var zip;
var province;

var yourQuery;	
	
dpjQuery(document).ready(function(){
dpjQuery("#jform_geocomplete").val(getAddresString());

if ( dpjQuery("#jform_latitude").val() )
{
addLayer(dpjQuery("#jform_latitude").val(),dpjQuery("#jform_longitude").val());
}
else
{
getlatlonopenstreet(0);
}	

//geocoder = new L.Control.Geocoder.Nominatim();
countryleaflet = dpjQuery("#jform_country").val();
console.log('ready countryleaflet ' + countryleaflet);
var url = 'index.php?option=com_sportsmanagement&format=json&tmpl=component&task=ajax.getCcountryAlpha2&country=' + countryleaflet;
dpjQuery.ajax({
url: url,
dataType: 'json',
async: false,
type : 'POST'
}).done(function(data1) {
console.log(data1);
dpjQuery.each(data1, function (i, val) {
console.log('ready i ' + i);
console.log('ready text ' + val.text);
countryleafletsearch = val.text;
});
});
console.log('ready url ' + url );
console.log('ready countryleafletsearch ' + countryleafletsearch );

street = dpjQuery("#jform_address").val();
zip = dpjQuery("#jform_zipcode").val();
city = dpjQuery("#jform_location").val();
yourQuery = ( street + ',' + zip + ' ' + city + ',' + countryleafletsearch );

console.log('ready yourQuery ' + yourQuery );

//geocoder.geocode(yourQuery, function(results) {
//console.log(results);
//});


	dpjQuery('#jform_address,  #jform_zipcode, #jform_location,  #jform_state, #jform_country').bind('change', function(e) {
		dpjQuery("#jform_geocomplete").val(getAddresString());
		dpjQuery("#jform_geocomplete").trigger("geocode");
		
getlatlonopenstreet(1);
		
//var inp = dpjQuery("#jform_geocomplete").val();
//console.log('jform_geocomplete ' + inp );
//var xmlhttp = new XMLHttpRequest();
//var url = "https://nominatim.openstreetmap.org/search?format=json&limit=1&q=" + inp ;
 
//console.log('openstreetmap url ' + url );

//dpjQuery.ajax({
//url:url,
//dataType: 'json',
//async: false,
//type: "POST",
//success:function(res){
//console.log('openstreetmap ' + res );

//dpjQuery.each(res , function (i, val) {
//console.log(i);
//console.log(val);

//console.log('latitude ' + val.lat);
//console.log('longitude ' + val.lon);
//dpjQuery("#jform_latitude").val(val.lat);
//dpjQuery("#jform_longitude").val(val.lon);
//addLayer(val.lat,val.lon);
//});			  
//}
//});



			 
// xmlhttp.onreadystatechange = function()
// {
//   if (this.readyState == 4 && this.status == 200)
//   {
//    var myArr = JSON.parse(this.responseText);
//    console.log('openstreetmap ' + myArr.lat );
//    //myFunction(myArr);
//   }
// };
// xmlhttp.open("GET", url, true);
// xmlhttp.send();
 
 		
	});
	
	
	
	
//	dpjQuery("#jform_geocomplete").bind("geocode:dragged", function(event, latLng){
//		dpjQuery.ajax({
//			  url:"//maps.googleapis.com/maps/api/geocode/json?latlng="+latLng.lat()+","+latLng.lng()+"&sensor=true",
//			  type: "POST",
//			  success:function(res){
//				 if(res.results[0].address_components.length){
//					 setGeoResult(res.results[0]);
//				 }
//			  }
//			});
//    });
    
});


function getlatlonopenstreet(result)
{
var inp = dpjQuery("#jform_geocomplete").val();
console.log('jform_geocomplete ' + inp );
//var xmlhttp = new XMLHttpRequest();
var url = "https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&limit=1&q=" + inp ;
console.log('openstreetmap url ' + url );
dpjQuery("#extended_COM_SPORTSMANAGEMENT_ADMINISTRATIVE_AREA_LEVEL_1_LONG_NAME").val('');
dpjQuery("#extended_COM_SPORTSMANAGEMENT_ADMINISTRATIVE_AREA_LEVEL_1_SHORT_NAME").val('');
dpjQuery("#extended_COM_SPORTSMANAGEMENT_ADMINISTRATIVE_AREA_LEVEL_2_LONG_NAME").val('');
dpjQuery("#extended_COM_SPORTSMANAGEMENT_ADMINISTRATIVE_AREA_LEVEL_2_SHORT_NAME").val('');
dpjQuery("#extended_COM_SPORTSMANAGEMENT_ADMINISTRATIVE_AREA_LEVEL_3_LONG_NAME").val('');
dpjQuery("#extended_COM_SPORTSMANAGEMENT_ADMINISTRATIVE_AREA_LEVEL_3_SHORT_NAME").val('');
	
dpjQuery.ajax({
url:url,
dataType: 'json',
async: false,
type: "POST",
success:function(res){
console.log('openstreetmap ' + res );

dpjQuery.each(res , function (i, val) {
console.log(i);
console.log(val);

console.log('latitude ' + val.lat);
console.log('longitude ' + val.lon);

console.log('county ' + val.address.county);
console.log('state_district ' + val.address.state_district);
console.log('state ' + val.address.state);
console.log('city_district ' + val.address.city_district);

console.log('postcode ' + val.address.postcode);
console.log('road ' + val.address.road);
console.log('suburb ' + val.address.suburb);
console.log('neighbourhood ' + val.address.neighbourhood);


state = val.address.state;
//if ( val.address.state != 'undefined' )
//{
dpjQuery("#extended_COM_SPORTSMANAGEMENT_ADMINISTRATIVE_AREA_LEVEL_1_LONG_NAME").val(state);
dpjQuery("#jform_state").val(state);	
//}	
if ( val.address.county )
{
dpjQuery("#extended_COM_SPORTSMANAGEMENT_ADMINISTRATIVE_AREA_LEVEL_2_LONG_NAME").val(val.address.county);	
}	
if ( val.address.state_district )
{
dpjQuery("#extended_COM_SPORTSMANAGEMENT_ADMINISTRATIVE_AREA_LEVEL_3_LONG_NAME").val(val.address.state_district);	
}	
	
dpjQuery("#jform_latitude").val(val.lat);
dpjQuery("#jform_longitude").val(val.lon);
if ( result )
{
addLayer(val.lat,val.lon);
}
}); 
}
});

}

function getAddresString()
{
//	var address = '';
//	var street = '';
//	var city = '';
//	var zip = '';
//	var province = '';
	//var country = '';
	//var countryleaflet = '';
	street = '';
	city = '';
	country = '';
	if(dpjQuery("#jform_address").val()){
		street = dpjQuery("#jform_address").val();
		street += ', ';
	}
	
	if(dpjQuery("#jform_location").val()){
		city = dpjQuery("#jform_location").val();
		if(dpjQuery("#jform_zipcode").val()){
			city += ' ' + dpjQuery("#jform_zipcode").val();
		}
		city += ', ';
	}
	if (dpjQuery("#jform_state").val()) {
		province = dpjQuery("#jform_state").val() + ', ';
	}
	
//  if(dpjQuery("#jform_country").val()){
//		country = dpjQuery("#jform_country").val() + ', ';
//	}
  
//  if(dpjQuery("#jform_country").val()){
//		country = dpjQuery("#jform_country :selected").text() + ', ';
//	}

countryleaflet = dpjQuery("#jform_country").val();
console.log('getAddresString countryleaflet ' + countryleaflet);

var url = 'index.php?option=com_sportsmanagement&format=json&tmpl=component&task=ajax.getCcountryAlpha2&country=' + countryleaflet;
dpjQuery.ajax({
url: url,
dataType: 'json',
async: false,
type : 'POST'
}).done(function(data1) {
console.log(data1);

dpjQuery.each(data1, function (i, val) {
console.log(i);
console.log(val.text);

countryleafletsearch = val.text;

});

});	

var url2 = 'index.php?option=com_sportsmanagement&format=json&tmpl=component&task=ajax.getCcountryName&country=' + countryleaflet;
dpjQuery.ajax({
url: url2,
dataType: 'json',
async: false,
type : 'POST'
}).done(function(data2) {
console.log(data2);

dpjQuery.each(data2, function (i, val) {
console.log(i);
console.log(val.text);

country = val.text;

});

});	
	
	
console.log('getAddresString country alpha2 leaflet ' + countryleafletsearch );
console.log('getAddresString country  ' + country );	
console.log('getAddresString street ' + street);
  
	return street + city + country;
}

function setGeoResult(result)
{
var street_number = '';
var route = '';
	
	dpjQuery('#location-form #details input:not("#jform_title")').removeAttr('value');
	
	for(var i=0;i<result.address_components.length;i++){
		switch(result.address_components[i].types[0]){

			case 'route':
				dpjQuery("#jform_address").val(result.address_components[i].long_name);
				route = result.address_components[i].long_name;
			break;
			case 'locality':
				dpjQuery("#jform_location").val(result.address_components[i].long_name);
			break;
			case 'street_number':
			street_number = result.address_components[i].long_name;
			break;

		  case 'administrative_area_level_1':
			dpjQuery("#jform_state").val(result.address_components[i].long_name);
      dpjQuery("#extended_COM_SPORTSMANAGEMENT_ADMINISTRATIVE_AREA_LEVEL_1_LONG_NAME").val(result.address_components[i].long_name);
      dpjQuery("#extended_COM_SPORTSMANAGEMENT_ADMINISTRATIVE_AREA_LEVEL_1_SHORT_NAME").val(result.address_components[i].short_name);
			break;
      case 'administrative_area_level_2':
      dpjQuery("#extended_COM_SPORTSMANAGEMENT_ADMINISTRATIVE_AREA_LEVEL_2_LONG_NAME").val(result.address_components[i].long_name);
      dpjQuery("#extended_COM_SPORTSMANAGEMENT_ADMINISTRATIVE_AREA_LEVEL_2_SHORT_NAME").val(result.address_components[i].short_name);
			break;
      
      
      
      
//			case 'country':
//				dpjQuery("#jform_country").val(result.address_components[i].long_name);
//			break;
			case 'postal_code':
				dpjQuery("#jform_zipcode").val(result.address_components[i].long_name);
			break;
		}
	}

route += ' ';
route += street_number;
dpjQuery("#jform_address").val(route);
	
	if (typeof result.geometry.location.lat === 'function')
	{
		dpjQuery("#jform_latitude").val(result.geometry.location.lat());
		dpjQuery("#jform_longitude").val(result.geometry.location.lng());
	} else
	{		
		dpjQuery("#jform_latitude").val(result.geometry.location.lat);
		dpjQuery("#jform_longitude").val(result.geometry.location.lng);
	}

var lat = dpjQuery("#jform_latitude").val();
var lng = dpjQuery("#jform_longitude").val();	
console.log('lat ' + lat );
console.log('lng ' + lng );
addLayer(lat,lng);
// Creating a marker
//var marker = L.marker([lat , lng ]);
// Adding marker to the map
//marker.addTo(map);



//	if (dpjQuery("#jform_title").val() == '')
//	{
//		dpjQuery("#jform_title").val(result.formatted_address);
//	}
	
	dpjQuery("#jform_geocomplete").val(result.formatted_address);
}

function addLayer(lat,lng) {
	
var markerLocation = new L.LatLng(lat,lng);
var marker = new L.Marker(markerLocation);
//console.log(marker);
console.log("Adding layer");


    
//L.marker([lat, lng]).addTo(layerGroup);
//console.log(layerGroup);
//map.removeLayer(layerGroup);
//Add a marker to show where you clicked.
theMarker = L.marker([lat,lng]).addTo(map);  
map.setView(new L.LatLng(lat, lng), 15);	
//L.marker([lat, lng]).addTo(layerGroup);
//layerGroup.addLayer(marker);



//var mbAttr = 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
//					'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
//					'Imagery © <a href="http://mapbox.com">Mapbox</a>',
//mbUrl = 'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
//var grayscale   = L.tileLayer(mbUrl, {id: 'mapbox.light', attribution: mbAttr}),
//				streets  = L.tileLayer(mbUrl, {id: 'mapbox.streets',   attribution: mbAttr});

//var baseLayers = {
//				"Grayscale": grayscale,
//				"Streets": streets
//			};
//var baseControl = L.control.layers(baseLayers).addTo(map);
			// make a global control variable for the control with the cities layer...
			//var citiesControl;	
			//	console.log("Adding layer");
//				cities = L.layerGroup();
				//L.marker([39.61, -105.02]).bindPopup('This is Littleton, CO.').addTo(cities),
				//L.marker([39.74, -104.99]).bindPopup('This is Denver, CO.').addTo(cities),
				//L.marker([39.73, -104.8]).bindPopup('This is Aurora, CO.').addTo(cities),
				//L.marker([39.77, -105.23]).bindPopup('This is Golden, CO.').addTo(cities);
				//var overlays = {
//					"Cities": cities
				//};
//console.log(cities);
				//map.addLayer(cities);

				// remove the current control panel
				//map.removeControl(baseControl);
				// add one with the cities
				//citiesControl = L.control.layers(baseLayers, overlays).addTo(map);
}
			
