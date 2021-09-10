@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              @include("includes.tree")
            </div>
            <div class="col-md-12">
              <div class="row">
                <div class="col-sm-4" style="font-weight: bold; font-size: small;">Online: {{ $online }}</p></div>
                <div class="col-sm-4" style="font-weight: bold; font-size: small;">Offline: {{ $offline }}</div>
              </div>
              <div class="row">
                <div class="col-sm-4" style="font-weight: bold; font-size: small;">New: {{ $new }}</div>
                <div class="col-sm-4" style="font-weight: bold; font-size: small;">Inactive: {{ $inactive }}</div>
                <div class="col-sm-4" style="font-weight: bold; font-size: small;">Total: {{ $total }}</div>
              </div>
            </div>
          </div>
        </div> 

        <div class="col-md-9">
          <div class="card bg-gradient">
              <!--

                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>   -->   
              <div class="card-body">
               <div id="map_canvas" style="height: 433px;"></div>
             </div>
           </div>
         </div> 
       </div>
       <div class="card">
        <div class="card-body">
         <div class="table-responsive" style="height:100px">
          <table id="header-fixed" class="table table-bordered table-striped" style="overflow-y:auto; padding-bottom: 0; ">
            <thead style="width:70%">
              <tr>
                <th>Time</th>
                <th>License Plate </th>
                <th>Tracker ID</th>
                <th>Tracker Status</th>
                <th>Speed(km/h)</th>
                <th>Mileage(km) </th>
                <th>Direction </th>
                <th>Longitude </th>
                <th>Latitude </th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div> 
        </div>
      </div>
    </div>
  </div>
</div>
</div>

@endsection
@section('third_party_scripts')

<script>
  function check_checked(VNO){
    if($("."+VNO).is(':checked')){
      return true;
    }else{
      return false;
    }
  }
  var locations = [];
  function refresh_map() {
    var myOptions = {
    zoom: 12 // set zoom level
    , mapTypeId: google.maps.MapTypeId.ROADMAP // apply tile (options include ROADMAP, SATELLITE, HYBRID and TERRAIN)
  };
  var map = new google.maps.Map( document.getElementById("map_canvas"), myOptions );
  var bounds = new google.maps.LatLngBounds();
  $("#header-fixed > tbody").html("");
  for ( var i = 0; i < locations.length; i++ )
  {
    var location = locations[i];
        
    var acc = "";
    if(location["engine_on"]=="0"){
      acc = "ACC OFF";
    }else{
      acc = "ACC ON";
    }
    var car_icon = "blue.png";
    var dir = location['direction'];
    if(dir < 22.5 && dir >= 337.5 ){
      car_icon = "0.png";
    }else if(dir >= 22.5 && dir < 67.5 ){
      car_icon = "45.png";
    }else if(dir >= 67.5 && dir < 112.5 ){
      car_icon = "90.png";
    }else if(dir >= 112.5 && dir < 157.5 ){
      car_icon = "135.png";
    }else if(dir >= 157.5 && dir < 202.5 ){
      car_icon = "180.png";
    }else if(dir >= 202.5 && dir < 247.5 ){
      car_icon = "225.png";
    }else if(dir >= 247.5 && dir < 292.5 ){
      car_icon = "270.png";
    }else if(dir >= 292.5 && dir < 337.5 ){
      car_icon = "315.png";
    }else{
      car_icon = "blue.png";
    }
    if(location["engine_on"]=="0") car_icon = "red.png";
    var capture_time = location['capture_time'];
    capture_time = capture_time.substring(0, 2)+":"+capture_time.substring(2, 4)+":"+capture_time.substring(4, 6);
    if(check_checked(location['VNO'])){
      $("#header-fixed > tbody").append("<tr><td>"+location['capture_date']+"&nbsp;"+capture_time+"</td><td>"+location['VNO']+"</td>,<td>"+location['terminal_id']+"</td><td>"+acc+"</td><td>"+location['ground_speed']+"</td>,<td>"+location['odometer']+"</td>,<td>"+location['direction']+"</td><td>"+location['latitude']+"</td><td>"+location['longitude']+"</td></tr>");
    

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
      }//if VNO checked
      }
      map.fitBounds( bounds );
    }
      
  window.onload = fetch_location; 
    function fetch_location(){
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

