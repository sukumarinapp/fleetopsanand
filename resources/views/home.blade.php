@extends('layouts.app')
@section('content')
<style type="text/css">
  @media screen and (min-width: 1000px) {  
    .whatsappshare {  
      display: none
    }  
  }  
</style>
<div class="container-fluid">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="input-group mb-3">
                <input type="text" style="height:35px" id="search_inp" maxlength="15" onkeyup="search_tree(this)" onpaste="search_tree(this)" class="form-control" placeholder="Search" >&nbsp;
                <input id="toogle_button" onchange="toggle_map(this)"  type="checkbox" data-toggle="toggle" data-height="10" data-on="Normal" data-off="Replay" data-onstyle="success" data-offstyle="danger">
              </div>
              
              @include("includes.tree")
            </div>
            <div class="col-md-12">
              <div class="row">
                <div class="col-sm-6" style="font-style: oblique; font-family: sans-serif;font-size: small; padding-bottom: 3px;">Vehicles Online: {{ $online }}</div>
                <div class="col-sm-6" style="font-style: oblique;font-family: sans-serif; font-size: small;">Vehicles Offline: {{ $offline }}</div>
              </div>
              <div class="row">
                <div class="col-sm-6" style="font-style: oblique;font-family: sans-serif;font-size: small; padding-bottom: 3px;">Vehicles Active: {{ $active }}</div>
                <div class="col-sm-6" style="font-style: oblique;font-family: sans-serif;font-size: small;">Vehicles Inactive: {{ $inactive }}</div>
              </div>
              <div class="row">
                <div class="col-sm-6" style="font-style: oblique;font-family: sans-serif;font-size: small;">Total Vehicles: {{ $total }}</div>
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
               <div id="map_canvas" style="height: 500px;"></div>

               <div id="map_replay" style="height: 500px;display: none;">
                <form class="row form" >
                  @csrf
                  <div class="col-md-2">
                      <label for="email">Start Time</label>                    
                  </div>
                  <div class="col-md-3">
                      <input value="{{ $starttime }}" class="form-control" type="datetime-local" name="starttime" id="starttime"  required="required">
                  </div>
                  <div class="col-md-2">
                      <label for="email">End Time</label>                    
                  </div>
                  <div class="col-md-3">
                      <input value="{{ $endtime }}" class="form-control" type="datetime-local" name="endtime" id="endtime"  required="required">
                  </div>
                  <div class="col-md-2">
                      <input type="button" onclick="replaydata()" name="submit"  value ="Replay" class="btn btn-primary form-control">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div> 
      </div>
      <div class="card">
        <div class="card-body">
         <div class="table-responsive" style="height:150px" >
          <table id="examplegrid" class="table table-bordered table-striped" style="overflow-y:auto; padding-bottom: 0; height: 100px; ">
            <thead style="width:70%">
              <tr>
                <th>Event Date/Time</th>
                <th>Vehicle Reg# </th>
                <th>Alert</th>
                <th>Active Duration</th>
                <th>Event Location</th>
              </tr>
            </thead>
            <tbody>

              @foreach($alerts as $alert)
              <tr>
                <td>{{ $alert["date"] }} {{ $alert["time"] }}</td>
                <td><a data-toggle="popover" data-html="true" title="{{ $alert['VMK'] }} {{ $alert['VMD'] }} {{ $alert['VCL'] }}({{ $alert['VBM'] }})" data-content="<b>Customer:</b> {{ $alert['client'] }}<br /><b>Manager:</b> {{ $alert['manager'] }}<br /><b>Driver:</b> {{ $alert['driver'] }}" data-trigger="hover">
                {{ $alert["VNO"] }}</a></td>
                <td>{{ $alert["alert"] }}</td>
                <td>{{ $alert["hours"] }}</td>
                <td> <button type="button"
                  class="btn btn-primary btn-xs" data-lat="{{ $alert['latitude'] }},{{ $alert['longitude'] }}" data-toggle="modal" data-target="#myMapModal" >View</button>
                  <a  href="whatsapp://send?text=https://maps.google.com/?q={{ $alert['latitude'] }},{{ $alert['longitude'] }}" data-action="share/whatsapp/share" target="_blank"><img class="whatsappshare" src="whatsapp.png" /></a>

                  <a class="btn btn-primary btn-xs" href="https://maps.google.com/?q={{ $alert['latitude'] }},{{ $alert['longitude'] }}" target="_blank">Open Map</a>
                </td> 
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
<div class="modal fade" id="myMapModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Event Location</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="map-canvas" style="height: 400px;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('third_party_scripts')

<script>
  var map2;
  function initialize2(myCenter) {
    var marker2 = new google.maps.Marker({
      position: myCenter
    });

    var mapProp2 = {
      center: myCenter,
      zoom: 16,
          //draggable: false,
          //scrollwheel: false,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map2 = new google.maps.Map(document.getElementById("map-canvas"), mapProp2);
        marker2.setMap(map2);
      };

      $('#myMapModal').on('shown.bs.modal', function(e) {
        var element = $(e.relatedTarget);
        var data = element.data("lat").split(',')
        initialize2(new google.maps.LatLng(data[0], data[1]));
      });

  /*function showmap(){
    $('#exampleModal').modal('show');
  }*/

  function check_checked(VNO){
    if($("."+VNO).is(':checked')){
      return true;
    }else{
      return false;
    }
  }
  var locations = [];
  var myOptions = { 
    zoom: 5 // set zoom level
    , mapTypeId: google.maps.MapTypeId.ROADMAP // apply tile (options include ROADMAP, SATELLITE, HYBRID and TERRAIN)
  };
  var map = new google.maps.Map( document.getElementById("map_canvas"), myOptions );

  function refresh_map() {
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
      map.setOptions({ minZoom: 8, maxZoom: 15 });
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
              console.log("License Plate: "+locations[i]["VNO"]+"<br>ID: "+locations[i]["terminal_id"]+"<br>Latitude: "+ locations[i]["latitude"] + "<br>Longitude: "+ locations[i]["longitude"] +"<br>Speed: "+locations[i]["ground_speed"]+"<br>Mileage(km): "+locations[i]["odometer"]);
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
  setInterval(fetch_location, 10000);

  $(document).ready(function(){
    $('#examplegrid').dataTable({
      searching: false, paging: false,
      drawCallback: function() {
        $('[data-toggle="popover"]').popover();
      }  
    });

    $('#myModal').on('shown.bs.modal', function () {
      $('#myInput').trigger('focus')
    })
  });  
</script>

@endsection

