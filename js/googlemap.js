function GoogleMap(){
    
    this.initialize = function(){
        var map = showMap();
        addMarkersToMap(map);
    }    
    
    var addMarkersToMap = function(map){
        var mapBounds = new google.maps.LatLngBounds();
    
        var latitudeAndLongitudeOne = new google.maps.LatLng('-34.565259','-58.398816');

        var markerOne = new google.maps.Marker({
					position: latitudeAndLongitudeOne,
					map: map
				});
				
        var latitudeAndLongitudeTwo = new google.maps.LatLng('-34.63226', '-58.47476');

        var markerOne = new google.maps.Marker({
					position: latitudeAndLongitudeTwo,
					map: map
				});
				
        mapBounds.extend(latitudeAndLongitudeOne);
        mapBounds.extend(latitudeAndLongitudeTwo);
        
        map.fitBounds(mapBounds);
    }
    
    
    
    var showMap = function(){
        var mapOptions = {
			     zoom: 8,
			     center: new google.maps.LatLng(-34.565259, -58.398816),
			     mapTypeId: google.maps.MapTypeId.ROADMAP
			 }
			 
        var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        
        return map;
    }
}