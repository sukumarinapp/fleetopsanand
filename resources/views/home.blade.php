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
                <div class="col-sm-6" style="font-weight: bold; font-size: small; padding-bottom: 3px;">Vehicles Online: {{ $online }}</div>
                <div class="col-sm-6" style="font-weight: bold; font-size: small;">Vehicles Offline: {{ $offline }}</div>
              </div>
              <div class="row">
                <div class="col-sm-6" style="font-weight: bold; font-size: small; padding-bottom: 3px;">Vehicles Active: {{ $active }}</div>
                <div class="col-sm-6" style="font-weight: bold; font-size: small;">Vehicles Inactive: {{ $inactive }}</div>
              </div>
              <div class="row">
                <div class="col-sm-6" style="font-weight: bold; font-size: small;">Total Vehicles: {{ $total }}</div>
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
               <div id="map_canvas" style="height: 443px;"></div>
             </div>
           </div>
         </div> 
       </div>
       <div class="card">
        <div class="card-body">
         <div class="table-responsive" style="height:100px" >
          <table id="examplegrid" class="table table-bordered table-striped" style="overflow-y:auto; padding-bottom: 0; height: 100px; ">
            <thead style="width:70%">
              <tr>
                <th>Event Date/Time</th>
                <th>Vehicle Reg# </th>
                <th>Alert</th>
                <th>Hours-in-Effect</th>
                <th>Event Location</th>
              </tr>
            </thead>
            <tbody>

              @foreach($alerts as $alert)
                <tr>
                  <td>{{ $alert["date"] }} {{ $alert["time"] }}</td>
                  <td><a data-toggle="popover" title="{{ $alert['VMK'] }} {{ $alert['VMD'] }} {{ $alert['VCL'] }}" data-content="test \n 3432432" data-trigger="hover">
                      {{ $alert["VNO"] }}</a></td>
                  <td>{{ $alert["alert"] }}</td>
                  <td></td>
                  <td></td>
                </tr>
              @endforeach
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
  for ( var i = 0; i < locations.length; i++ )
  {
    var location = locations[i];
    
    var acc = "";
    var engine_on = parseInt(location["engine_on"]);
    if(engine_on == 0){
      acc = "ACC OFF";
    }else{
      acc = "ACC ON";
    }
    var car_icon = "off0.png";
    var dir = parseFloat(location['direction']);

    if(dir < 22.5 || dir >= 337.5 ){
      if(engine_on == 1) {
        car_icon = "0.png";
      }else{
        car_icon = "off0.png";
      }
    }else if(dir >= 22.5 && dir < 67.5 ){
      if(engine_on == 1) {
        car_icon = "45.png";
      }else{
        car_icon = "off45.png";
      }
    }else if((dir >= 67.5) && (dir < 112.5)){
      if(engine_on == 1) {
        car_icon = "90.png";
      }else{
        car_icon = "off90.png";
      }
    }else if((dir >= 112.5) && (dir < 157.5)){
      if(engine_on == 1) {
        car_icon = "135.png";
      }else{
        car_icon = "off135.png";
      }
    }else if((dir >= 157.5) && (dir < 202.5)){
      if(engine_on == 1) {
        car_icon = "180.png";
      }else{
        car_icon = "off180.png";
      }
    }else if((dir >= 202.5) && (dir < 247.5)){
      if(engine_on == 1) {
        car_icon = "225.png";
      }else{
        car_icon = "off225.png";
      }
    }else if((dir >= 247.5) && (dir < 292.5)){
      if(engine_on == 1) {
        car_icon = "270.png";
      }else{
        car_icon = "off270.png";
      }
    }else if((dir >= 292.5) && (dir < 337.5)){
      if(engine_on == 1) {
        car_icon = "315.png";
      }else{
        car_icon = "off315.png";
      }
    }
    //if(location["engine_on"]=="0") car_icon = "red.png";
    var capture_time = location['capture_time'];
    capture_time = capture_time.substring(0, 2)+":"+capture_time.substring(2, 4)+":"+capture_time.substring(4, 6);
    if(check_checked(location['VNO'])){
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
              infowindow.setContent("License Plate: "+locations[i]["VNO"]+"<br>ID: "+locations[i]["terminal_id"]+"<br>Latitude: "+ locations[i]["latitude"] + "<br>Longitude: "+ locations[i]["longitude"] +"<br>Speed: "+locations[i]["ground_speed"]+"<br>Mileage(km): "+locations[i]["odometer"]);
              infowindow.open( map, marker );
            }
          }
          )( marker, i ) );
      }//if VNO checked
    }
    map.fitBounds( bounds );
  }
  refresh_map();
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

$(document).ready(function(){
  $('#examplegrid').dataTable({
    drawCallback: function() {
      $('[data-toggle="popover"]').popover();
    }  
  });
});  
</script>

@endsection

