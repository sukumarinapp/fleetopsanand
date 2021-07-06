@extends('layouts.app')
@section('content')
<div id="map_canvas" style="height: 600px;"></div>
@endsection
@section('third_party_scripts')
<script>
    function initialise_map() {
      // create object literal to store map properties
      var myOptions = {
        zoom: 12 // set zoom level
        , mapTypeId: google.maps.MapTypeId.ROADMAP // apply tile (options include ROADMAP, SATELLITE, HYBRID and TERRAIN)
      };
      
      // create map object and apply properties
      var map = new google.maps.Map( document.getElementById("map_canvas"), myOptions );
      
      // create map bounds object
      var bounds = new google.maps.LatLngBounds();

      //create array containing locations
      /*var locations = [
        [ 'Fleetops Vehicle 1', 5.614433333333333, -0.09158833333333334 ]
        , [ 'Fleetops Vehicle 2', 5.690778333333333, -0.2918783333333333 ]
        , [ 'Fleetops Vehicle 3', 5.6143616666666665, -0.30347 ]
      ];*/

      var locations = [
      @php
        $i=0;
        foreach ($markers as $marker){
          if($i>0) echo ",";
          echo "['".$marker->terminal_id."',".$marker->latitude.",".$marker->longitude."]";
          $i++;
        }
      @endphp
      ];
      console.log(locations);
      
      // loop through locations and add to map
      for ( var i = 0; i < locations.length; i++ )
      {
        // get current location
        var location = locations[ i ];
        
        // create map position
        var position = new google.maps.LatLng( location[ 1 ], location[ 2 ] );
        
        // add position to bounds
        bounds.extend( position );
        
        // create marker (https://developers.google.com/maps/documentation/javascript/reference#MarkerOptions)
        var marker = new google.maps.Marker({
          animation: google.maps.Animation.DROP
          , icon: "car.png"
          , map: map
          , position: position
          , title: location[ 0 ]
        });
        
        // create info window and add to marker (https://developers.google.com/maps/documentation/javascript/reference#InfoWindowOptions)
        google.maps.event.addListener( marker, 'click', ( 
          function( marker, i ) {
            return function() {
              var infowindow = new google.maps.InfoWindow();
              infowindow.setContent( locations[ i ][ 0 ] +"<br>"+"Fleetops");
              infowindow.open( map, marker );
            }
          }
        )( marker, i ) );
      };

      // fit map to bounds
      map.fitBounds( bounds );
    }

    window.onload = initialise_map; 
</script>

@endsection
