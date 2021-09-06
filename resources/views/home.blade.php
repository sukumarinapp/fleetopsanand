@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            @include("includes.tree")
        </div>
<!--         <div class="col-md-9">
            <div class="card bg-gradient">
               <div class="card-header border-0">
                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
               <div id="map_canvas" style="height: 600px;"></div>
             </div>
           </div>
        </div>
 -->      </div>
    </div>
  </div>
</div>
 @endsection
 @section('third_party_scripts')
 
 <script>
  var locations = [];
  function refresh_map() {
    var myOptions = {
    zoom: 12 // set zoom level
    , mapTypeId: google.maps.MapTypeId.ROADMAP // apply tile (options include ROADMAP, SATELLITE, HYBRID and TERRAIN)
  };
  var map = new google.maps.Map( document.getElementById("map_canvas"), myOptions );
  var bounds = new google.maps.LatLngBounds();
  for ( var i = 0; i < locations.length; i++ )
  {
    var location = locations[i];
    var car_icon = "red.png";
    if(location["engine_on"]=="1") car_icon = "blue.png";
    var position = new google.maps.LatLng( location["latitude"], location["longitude"] );
    bounds.extend( position );
        // create marker (https://developers.google.com/maps/documentation/javascript/reference#MarkerOptions)
        var marker = new google.maps.Marker({
          animation: google.maps.Animation.NONE
          , icon: car_icon
          , map: map
          , position: position
          , title: location["VNO"]
        });
        // create info window and add to marker (https://developers.google.com/maps/documentation/javascript/reference#InfoWindowOptions)
        google.maps.event.addListener( marker, 'click', ( 
          function( marker, i ) {
            return function() {
              var infowindow = new google.maps.InfoWindow();
              infowindow.setContent("License Plate: "+locations[i]["VNO"]+"<br>ID: "+locations[i]["terminal_id"]+"<br>Latitude: "+locations[i]["latitude"]+"<br>Longitude: "+locations[i]["longitude"]+"<br>Speed: "+locations[i]["ground_speed"]+"<br>Mileage(km): "+locations[i]["odometer"]);
              infowindow.open( map, marker );
            }
          }
          )( marker, i ) );
      };
      map.fitBounds( bounds );
    }
    window.onload = fetch_location; 
    function fetch_location(id){
      locations = [];
      $.ajax({
        type: "get",
        url: '{{ route('locations') }}',
        success: function(response) {
          locations = response;
          refresh_map();
        },
        error: function (jqXHR, exception) {
          console.log(exception);
        }
      });
    }
    setInterval(fetch_location, 30000);
  </script>

  @endsection

