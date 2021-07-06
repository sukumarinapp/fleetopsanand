<?php
$mysql_hostname = "localhost";
$mysql_user = "fleetops";
$mysql_password = "fleetops123$";
$mysql_database = "fleetops";
// $mysql_user = "root";
// $mysql_password = "";
$conn = new mysqli($mysql_hostname, $mysql_user, $mysql_password, $mysql_database);
$sql = "select terminal_id,latitude,longitude from current_location where id in (select max(id) from current_location group by terminal_id)";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
  
    <style type="text/css">
    html{ height:100%; }
    body{ height:100%; margin:0; padding:0; }
    #map_canvas{ height:100%; width:100%; }
    </style>
    
    <script type="text/javascript">
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

      var locations = [
      <?php
        $i=0;
        while ($row = mysqli_fetch_assoc($result)) {
          if($i>0) echo ",";
          echo "['".$row['terminal_id']."',".$row['latitude'].",".$row['longitude']."]";
          $i++;
        }
      ?>
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
    </script>
  </head>

  <body>
    <!-- map container -->
    <div id="map_canvas"><noscript><p>JavaScript is required to render the Google Map.</p></noscript></div>
  </body>
</html>