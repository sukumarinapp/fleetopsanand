@extends('layouts.app')
@section('content')
<style type="text/css">
  @media screen and (min-width: 1000px) {  
    .whatsappshare {  
      display: none
    }  
  }
  #speed{
    color: red;
    background: white;
    padding: 10px;
    border-radius: 10px;
  }    
</style>
<div class="container-fluid">
  <div class="content-header">
    <div class="container-fluid">
     <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title">Vehicle Monitoring</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool btn-secondary" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <div class="input-group mb-3">
                  <input type="text" style="height:35px;width:50%" id="search_inp" maxlength="15" onkeyup="search_tree(this)" onpaste="search_tree(this)" onchange="search_tree(this)" class="form-control-xs" placeholder="Enter VNO" >&nbsp;
                 <!--  <input id="toogle_button" onchange="toggle_map(this)"  type="checkbox" data-toggle="toggle" data-height="10" data-width="10" data-on="Normal" data-off="<i class='fa fa-record'></i>" data-onstyle="success" data-offstyle="danger">&nbsp; -->
                 <button type="button" onclick="toggle_map(this)" class="btn btn-danger btn-xs form-control" id="gmapreplay" value="replay" >Replay</button>&nbsp;
                 <button id="gmaplive" type="button" onclick="live_track_play()" value="live" class="btn btn-success btn-xs form-control" >Live</button>
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
               <div id="map_canvas_live" style="height: 500px;display: none;"></div>
               <div id="map_replay" style="height: 500px;display: none;">
                <form class="form" >
                  @csrf
                  <div style="padding-bottom:5px" class="row">
                  <div class="col-md-2">
                    <label for="starttime">Start Time</label>
                  </div>
                  <div class="col-md-3">
                    <input value="{{ $starttime }}" class="form-control" type="datetime-local" name="starttime" id="starttime"  required="required">
                  </div>
                  <div class="col-md-2">
                    <label for="endtime">End Time</label>
                  </div>
                  <div class="col-md-3">
                    <input value="{{ $endtime }}" class="form-control" type="datetime-local" name="endtime" id="endtime"  required="required">
                  </div>
                  <div class="col-md-1">
                    <button type="button" class="btn btn-success btn-xs form-control" onclick="play()" value ="Apply">Apply</button>
                  </div>
                </div>
                <div style="padding-bottom:5px" class="row">
                  
                  <div class="col-md-1">
                    <button type="button" class="btn btn-success btn-xs form-control" onclick="pauseandplay()" value ="Play"><i class="fa fa-play"></i></button>
                  </div>
                  
                  <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-xs form-control" onclick="pause()" value ="Pause"><i class="fa fa-pause"></i></button>
                  </div>
                  <div class="col-md-1">
                    <button type="button" class="btn btn-primary btn-xs form-control" onclick="reset2()" value ="reset"><i class="fa fa-stop"></i></button>
                  </div>

                <div class="col-md-1">
                  <button type="button" class="btn btn-primary btn-xs form-control" onclick="slow()" value ="slow"><i class="fa fa-fast-backward"></i></button>
               </div>
               <div class="col-md-3">
                <label id="replaytime"></label>
              </div>

              <div class="col-md-1">
                <button type="button" class="btn btn-primary btn-xs form-control" onclick="fast()" value ="fast"><i class="fa fa-fast-forward"></i></button>
              </div>
              <div class="col-md-3">
                <label>Speed:&nbsp;</label><h3 class="badge badge-pill badge-info" id="speed">1x</h3>
              </div>
            </div>


            </form>
            <div class="bg-success"  id="replay-summary" ></div>
            <div id="replay-canvas" style="height: 350px"></div>
          </div>
        </div>
      </div>
    </div> 
  </div>
</div>
</div>
<div class="card card-info">
  <div class="card-header">
    <h3 class="card-title">Alerts</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool btn-secondary" data-card-widget="collapse"><i class="fas fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="card-body">
   <div class="table-responsive">
    <table id="examplegrid" class="table table-bordered" style="overflow-y:auto; padding-bottom: 0; height: 100px; ">
      <thead style="width:70%">
        <tr>
          <th>Event Date/Time</th>
          <th>Vehicle Reg# </th>
          <th>Alert</th>
          <th>Active Duration</th>
          <th>Event Location</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>

        @foreach($alerts as $alert)
        <tr>
          <td>{{ $alert["date"] }} {{ $alert["time"] }}</td>
          <td><a data-toggle="popover" data-html="true" title="{{ $alert['VMK'] }} {{ $alert['VMD'] }} {{ $alert['VCL'] }}({{ $alert['VBM'] }})" data-content="<b>Customer:</b> {{ $alert['client'] }}<br /><b>Manager:</b> {{ $alert['manager'] }}<br /><b>Driver:</b> {{ $alert['driver'] }}" data-trigger="hover">
          {{ $alert["VNO"] }}</a></td>
          <td>
            <img src="{{ $alert['icon'] }}" />
            {{ $alert["alert"] }}
          </td>
          <td>{{ $alert["hours"] }}</td>
          <td > 
            @if($alert["date"] == "")
            &nbsp;
            @else
              <button type="button" class="btn btn-primary btn-sm btn-block" data-lat="{{ $alert['latitude'] }},{{ $alert['longitude'] }}" data-toggle="modal" data-target="#myMapModal" >View</button>
              <a class="btn btn-success btn-sm btn-block whatsappshare" href="whatsapp://send?text=https://maps.google.com/?q={{ $alert['latitude'] }},{{ $alert['longitude'] }}" data-action="share/whatsapp/share" target="_blank"><img class="whatsappshare" src="whatsapp.png" /></a>
              <a class="btn btn-primary btn-sm  btn-block" href="https://maps.google.com/?q={{ $alert['latitude'] }},{{ $alert['longitude'] }}" target="_blank">Open Map</a>
            @endif
            </td>
            <td style="padding-top: 20px;">
            @if($alert['type'] == "battery")
             <a  class="btn btn-primary btn-sm btn-block"  onclick="acknowledgealert({{ $alert['id'] }})" >Acknowledge</a>
            @else
              &nbsp; 
            @endif
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

  var VNO_live = "";
  var map_live = undefined;
  var marker_live = undefined;
  var ground_speed_live = 0;
  var position_live = [5.629031666666666,-0.15723666666666666];
  var snapLength = 0;
  var live_play_mode = 0;

  function live_track_play(){
    VNO_live = $("#search_inp").val();
    if(typeof(VNO_live) == "undefined" || VNO_live == "" ){
      alert("Enter vehicle no");
      $("#search_inp").focus();
      live_play_mode = 0;
      return false;
    }else{
      live_play_mode = 1;
      $("#map_canvas").slideUp("slow");
      $("#map_replay").slideUp("slow");
      $("#map_canvas_live").slideDown("slow");
      $("#gmapreplay").html("<i class='fa fa-arrow-left'>&nbsp;</i>Normal");
      $("#gmapreplay").attr('value', 'normal'); 
      $("#gmaplive").hide();
      initialize_live_track();
    }
  }

  function initialize_live_track() {
    var initial_location = '{{ url('initial_location') }}';
    initial_location = initial_location + "/" + VNO_live;
    $.ajax({
      type: "get",
      url: initial_location,
      success: function(response) {
        prevLatitude = response[0]['latitude'];
        prevLongitude = response[0]['longitude'];
        position_live[0] = response[0]['latitude'];
        position_live[1] = response[0]['longitude'];
        ground_speed_live = response[0]['ground_speed'];
        var latlng = new google.maps.LatLng(position_live[0], position_live[1]);
        var myOptions = {
          zoom: 20,
          center: latlng,
          mapTypeId: google.maps.MapTypeId.SATELLITE
        };
        map_live = new google.maps.Map(document.getElementById("map_canvas_live"), myOptions);
        marker_live = new google.maps.Marker({
          position: latlng,
          map: map_live,
          icon: "carblue.png",
          title: VNO_live + "\n" + ground_speed_live
        });
      },
      error: function (jqXHR, exception) {
        console.log(exception);
      }
    });
    
    
  }
  
  function animateMarkers(){
    if(live_play_mode == 0) return;
    var result;
    var vehicle_location = '{{ url('vehicle_location') }}';
    vehicle_location = vehicle_location + "/" + VNO_live;
    $.ajax({
      type: "get",
      url: vehicle_location,
      success: function(response) {
        if(prevLatitude != response[0]['latitude'] && prevLongitude != response[0]['longitude']){
          result = [response[0]['latitude'], response[0]['longitude']];
          ground_speed_live = response[0]['ground_speed'];
          transition(result)//////;
          prevLatitude = response[0]['latitude'];
          prevLongitude = response[0]['longitude'];
        }
      },
      error: function (jqXHR, exception) {
        console.log(exception);
      }
    });
  }

  setInterval(animateMarkers, 10000);

  var numDeltas = 100;
  var delay = 100;
  var i_live = 0;
  var deltaLat=0.0;
  var deltaLng=0.0;
  var snappedPoints;
  var prevLatitude = 0;
  var prevLongitude = 0;
  
  function transition(result){
    i_live = 0;
    //deltaLat = (result[0] - position[0])/numDeltas;
    deltaLat = (result[0] - prevLatitude)/numDeltas;
    //deltaLng = (result[1] - position[1])/numDeltas;
    deltaLng = (result[1] - prevLongitude)/numDeltas;
    moveMarker();
  }
  
  function moveMarker(){
    var latitude = 0.0,longitude = 0.0;
    latitude = parseFloat(position_live[0]);
    longitude = parseFloat(position_live[1]);
    var roadapi = "https://roads.googleapis.com/v1/snapToRoads?interpolate=true&path=";
    var j = 0;
    while(j < numDeltas){
      latitude = latitude + deltaLat;
      longitude = longitude + deltaLng;
      roadapi = roadapi + latitude + "," + longitude;
      if(j != numDeltas-1) roadapi = roadapi + "|";
      j++;
    }
    roadapi = roadapi + "&key=AIzaSyCQTnsGhNv6Q7H0E8uOhRDDeGk4J4uWnjA";
    $.ajax({
      type: "get",
      url: roadapi,
      success: function(response) {
        snappedPoints = response.snappedPoints;
        console.log(snappedPoints);
        snapLength = snappedPoints.length - 1;
        position_live[0] = snappedPoints[snapLength].location.latitude;
        position_live[1] = snappedPoints[snapLength].location.longitude;
        i_live = 5;
        moveMarkerRepeat();
      },
      error: function (jqXHR, exception) {
        console.log(exception);
      }
    });
  }

  function moveMarkerRepeat(){
    var latlng = new google.maps.LatLng(snappedPoints[i_live].location.latitude,snappedPoints[i_live].location.longitude);
    marker_live.setPosition(latlng);
    map_live.panTo(latlng);
    marker_live.setTitle(VNO_live + "\n" + ground_speed_live);
    if(i_live < snapLength - 1){
      i_live++;
      setTimeout(moveMarkerRepeat, delay);
    }

  }

//live tracking end

  var acknowledge = "{{ url('acknowledge') }}";
  function acknowledgealert(id){
    if(confirm('Do you want to acknowledge this battery power cut alert?')){
      var url =  acknowledge + "/" + id;
      window.location.href = url;
    }
  }

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

      function check_checked(VNO){
        if($("."+VNO).is(':checked')){
          return true;
        }else{
          return false;
        }
      }  
      var mapnormal;
      var markers = []; 
      var vehicles = [];
      function setMarkers(locations) {
        for (var i = 0; i < locations.length; i++) {
          var vehicle = locations[i];
          //console.log(vehicle['VNO']+":"+vehicle['latitude']+":"+vehicle['longitude']);
          var acc = "";
          var engine_on = parseInt(vehicle["engine_on"]);
          var car_icon = "redcar.jpg";
          var driver_id = vehicle["driver_id"];
          if(engine_on == 0){
            acc = "ACC OFF";
            car_icon = "redcar.jpg";
          }else if(engine_on == 1){
            acc = "ACC ON";
            car_icon = "yellowcar.jpg";
          }
          
          var dir = parseFloat(vehicle['direction']);
          /*
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
          */

          if(!driver_id){
            car_icon = "bluecar.png";
          }


          if(check_checked(vehicle['VNO'])){
            console.log(vehicle['VNO']);
            console.log(car_icon);
            var myLatLng = new google.maps.LatLng(vehicle["latitude"], vehicle["longitude"]);
            var title = vehicle["VNO"] + "\n" + vehicle["terminal_id"] + "\n" + "Speed: " + vehicle["ground_speed"]+ "\n" + "Direction: " + vehicle["direction"]; 
            var marker = new google.maps.Marker({
              position: myLatLng,
              map: mapnormal,
              icon: car_icon,
              animation: google.maps.Animation.NONE,
              title: title
            });
            markers.push(marker);
          }
        }
      }
      function reloadMarkers() {
        for (var i=0; i<markers.length; i++) {
          markers[i].setMap(null);
        }
        markers = [];
        $.ajax({
          type: "get",
          url: '{{ route('locations') }}',
          success: function(response) {
            vehicles = response;
            setMarkers(vehicles);
          },
          error: function (jqXHR, exception) {
            console.log(exception);
          }
        });
      }
      function initialize() {
        var mapOptions = {
          zoom: 13,
          center: new google.maps.LatLng(5.604688667802131, -0.187207828880368),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        mapnormal = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
        setInterval(reloadMarkers, 60000);
      }
      initialize();

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

