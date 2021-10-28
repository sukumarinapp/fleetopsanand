@extends('layouts.app')
@section('content')
<style>
html,body,#map-canvas {
  height: 100%;
  width: 100%;
  margin: 0px;
  padding: 0px;
  font-weight: 400;
}

.controls {
  position: absolute;
  z-index: 999;
  top: 10px;
  right: 50px;
}

button {
  font-size: 14px;
  background: blue;
  color: white;
  border: none;
  padding: 10px;
  border-radius: 10px;
}

button:hover, button:focus {
  background: red;
}

span {
  color: red;
  background: white;
  padding: 10px;
  border-radius: 10px;
}
</style>
<div class="container-fluid">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Replay</h3>
            </div>
            <div class="card-body">
             <div class="col-md-12">
              <form class="row form" method="post" action="{{ route('track') }}">
                @csrf
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="name">Vehicle Reg No</label>
                    <select name="VNO" required="required" class="form-control selectpicker select2" id="VNO">
                     @if($type == "admin")
                     @foreach($usertree as $key => $manager)
                     <optgroup label="{{ $manager['name'] }}">
                      @foreach($manager['client'] as $key2 => $client)
                      <optgroup label="&nbsp;&nbsp;{{ $client['name'] }}">
                        @foreach($client['vehicle'] as $key3 => $vehicle)
                        <option @if($VNO == $vehicle['VNO'])
                        selected
                        @endif
                        value="{{ $vehicle['VNO'] }}">&nbsp;&nbsp;&nbsp;&nbsp;{{ $vehicle['VNO'] }}</option>
                        @endforeach 
                        @endforeach
                        @foreach($manager['submanager'] as $key2 => $submanager)
                        <optgroup label="&nbsp;&nbsp;{{ $submanager['name'] }}">
                          @foreach($submanager['client'] as $key3 => $client)
                          <optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;{{ $client['name'] }}">
                            @foreach($client['vehicle'] as $key4 => $vehicle)
                            <option @if($VNO == $vehicle["VNO"])
                            selected
                            @endif
                            value="{{ $vehicle['VNO'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $vehicle['VNO'] }}</option>
                            @endforeach 
                            @endforeach    
                            @endforeach
                            @endforeach
                            @endif

                            @if($type == "manager")
                            @foreach($usertree as $key1 => $submanager)
                            <optgroup label="{{ $submanager['name'] }}">
                              @foreach($submanager['client'] as $key2 => $client)
                              <optgroup label="{{ $client['name'] }}">
                                @foreach($client['vehicle'] as $key3 => $vehicle)
                                <option @if($VNO == $vehicle["VNO"])
                                selected
                                @endif
                                value="{{ $vehicle['VNO'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $vehicle['VNO'] }}</option>
                                @endforeach 
                                @endforeach
                                @endforeach
                                @endif

                                @if($type == "submanager")
                                @foreach($usertree as $key1 => $client)
                                <optgroup label="{{ $client['name'] }}">
                                  @foreach($client['vehicle'] as $key3 => $vehicle)
                                  <option @if($VNO == $vehicle["VNO"])
                                  selected
                                  @endif
                                  value="{{ $vehicle['VNO'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $vehicle['VNO'] }}</option>
                                  @endforeach 
                                  @endforeach
                                  @endif

                                  @if($type == "client")
                                  @foreach($usertree as $key1 => $vehicle)
                                  <option @if($VNO == $vehicle["VNO"])
                                  selected
                                  @endif
                                  value="{{ $vehicle['VNO'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $vehicle['VNO'] }}</option>
                                  @endforeach
                                  @endif
                                </select>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="email">Start</label>
                                <input value="{{ $starttime }}" class="form-control" type="datetime-local" name="starttime" id="starttime"  required="required">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="username">End</label>
                                <input value="{{ $endtime }}" class="form-control" type="datetime-local" name="endtime" id="endtime"  required="required">
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                <label class="">&nbsp;</label>
                                <input type="submit" name="submit"  value ="Replay" class="btn btn-primary form-control">
                              </div>
                            </div>
                          </form>
                        </div>

                        <div id="map-canvas" style="height: 500px"></div>
  </div>
</div>
</div> 
</div>
</div> 
</div>
</div>
@endsection

@section('third_party_scripts')
<!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=false"></script> -->
<script src="https://unpkg.com/travel-marker/dist/travel-marker.umd.js"></script>
<script>
  var locationData = Array();
  var startlat = "";
  var endlat = "";
  var startlong = "";
  var endlong = "";
  @foreach ($location as $key => $loc)
  @if($key == 0)
  startlat = "@php echo $loc[0]; @endphp";
  startlong = "@php echo $loc[1]; @endphp";
  @endif
  @if($key == count($location)-1 )
  endlat = "@php echo $loc[0]; @endphp";
  endlong = "@php echo $loc[1]; @endphp";
  @endif
  var series = new Array(@php echo $loc[0]; @endphp,@php echo $loc[1]; @endphp);
  locationData.push(series);
  @endforeach

  google.maps.event.addDomListener(window, 'load', initialize);

  var map, line, marker;
  var directionsService = new google.maps.DirectionsService();
  var TravelMarker = travelMarker.TravelMarker;
speedMultiplier = 1; // speedMultiplier to control animation speed

// initialize map
function initialize() {
  var mapOptions = {
    zoom: 16, 
    center: new google.maps.LatLng(startlat,startlong),
  };

  map = new google.maps.Map(document.getElementById('map-canvas'),
    mapOptions);  
  // calcRoute();
  mockDirections();
}


/**
 *                  IMPORTANT NOTICE
 *  Google stopped its FREE TIER for Directions service.
 *  Hence the below route calculation will not work unless you provide your own key with directions api enabled
 *  
 *  Meanwhile, for the sake of demo, precalculated value will be used
 */

  // mock directions api
  function mockDirections() {
    var locationArray = locationData.map(l => new google.maps.LatLng(l[0], l[1]));
    line = new google.maps.Polyline({
      strokeOpacity: 0.5,
      path: [],
      map: map
    });
    locationArray.forEach(l => this.line.getPath().push(l));
    
    var start = new google.maps.LatLng(startlat,startlong);
    var end = new google.maps.LatLng(endlat,endlong);

    var startMarker = new google.maps.Marker({position: start, map: map, label: 'A'});
    var endMarker = new google.maps.Marker({position: end, map: map, label: 'B'});
    initRoute();
  }

/**
 *                  IMPORTANT NOTICE
 *  Google stopped its FREE TIER for Directions service.
 *  Hence the below route calculation will not work unless you provide your own key with directions api enabled
 *  
 *  Meanwhile, for the sake of demo, precalculated value will be used
 */

// get locations from direction service
function calcRoute() {
  line = new google.maps.Polyline({
    strokeOpacity: 0.5,
    path: [],
    map: map
  });
  
  var start = new google.maps.LatLng(51.513237, -0.099102);
  var end = new google.maps.LatLng(51.514786, -0.080799);
  var request = {
    origin:start,
    destination:end,
    travelMode: google.maps.TravelMode.BICYCLING
  };
  directionsService.route(request, (response, status) => {
    if (status == google.maps.DirectionsStatus.OK) {
      var legs = response.routes[0].legs;
      for (i=0;i<legs.length;i++) {
        var steps = legs[i].steps;
        for (j=0;j<steps.length;j++) {
          var nextSegment = steps[j].path;
          for (k=0;k<nextSegment.length;k++) {
            line.getPath().push(nextSegment[k]);
          }
        }
      }
      initRoute();
    }
  });
}

// initialize travel marker
function initRoute() {
  var route = line.getPath().getArray();
  // options
  var options = {
    map: map,  // map object
    speed: 50, // default 10 , animation speed
    interval: 10, //default 10, marker refresh time
    speedMultiplier: speedMultiplier,
    markerOptions: { 
      title: 'Travel Marker',
      animation: google.maps.Animation.DROP,
      icon: {
        url: 'https://i.imgur.com/eTYW75M.png',
        animation: google.maps.Animation.DROP,
        // This marker is 20 pixels wide by 32 pixels high.
        // size: new google.maps.Size(256, 256),
        scaledSize: new google.maps.Size(128, 128),
        // The origin for this image is (0, 0).
        origin: new google.maps.Point(0, 0),
        // The anchor for this image is the base of the flagpole at (0, 32).
        anchor: new google.maps.Point(53, 110)
      }
    },
  };
  
  // define marker
  marker = new TravelMarker(options);
  
 // add locations from direction service 
 marker.addLocation(route);
 
 setTimeout(play, 2000);
}

// play animation
function play() {
  marker.play();
}

// pause animation
function pause() {
  marker.pause();
}

// reset animation
function reset() {
  marker.reset();
}

// jump to next location
function next() {
  marker.next();
}

// jump to previous location
function prev() {
  marker.prev();
}

// fast forward
function fast() {
  speedMultiplier*=2;
  document.getElementById('speed').innerHTML = 'Speed: ' + speedMultiplier + 'x';
  marker.setSpeedMultiplier(speedMultiplier)
}

// slow motion
function slow() {
  speedMultiplier/=2;
  document.getElementById('speed').innerHTML = 'Speed: ' + speedMultiplier + 'x';
  marker.setSpeedMultiplier(speedMultiplier)
}

$(document ).ready(function() {
  $('.select2').select2({
    theme: 'bootstrap4'
  });
  marker.play();
});

</script>
@endsection

