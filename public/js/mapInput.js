function initialise() {
      // create object literal to store map properties
      var myOptions = {
        zoom: 12 // set zoom level
        , mapTypeId: google.maps.MapTypeId.ROADMAP // apply tile (options include ROADMAP, SATELLITE, HYBRID and TERRAIN)
      };
      
      // create map object and apply properties
      var map = new google.maps.Map( document.getElementById( "map_canvas" ), myOptions );
      
      // create map bounds object
      var bounds = new google.maps.LatLngBounds();

      //create array containing locations
      var locations = [
        [ 'Fleetops Vehicle 1', 5.614433333333333, -0.09158833333333334 ]
        , [ 'Fleetops Vehicle 2', 5.690778333333333, -0.2918783333333333 ]
        , [ 'Fleetops Vehicle 3', 5.6143616666666665, -0.30347 ]
      ];

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
              infowindow.setContent( locations[ i ][ 0 ] );
              infowindow.open( map, marker );
            }
          }
        )( marker, i ) );
      };

      // fit map to bounds
      map.fitBounds( bounds );
    }

    // load map after page has finished loading
    function loadScript() {
      var script = document.createElement( "script" );
      script.type = "text/javascript";
      script.src = "http://maps.googleapis.com/maps/api/js?key=AIzaSyBGD4U0YDBCpPd54yleIeEcFIVfjQ8q9JY&sensor=false&callback=initialise"; // initialize method called using callback parameter
      document.body.appendChild( script );
    }
    window.onload = loadScript;   