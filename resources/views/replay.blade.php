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
   <!--  <div class="controls">
      <button onclick="play()">Play</button>
      <button onclick="pause()">Pause</button>
      <button onclick="reset()">Reset</button>
      <button onclick="next()">Next</button>
      <button onclick="prev()">Previous</button>
      <button onclick="fast()">Fast</button>
      <span id="speed">Speed: 1x</span>
      <button onclick="slow()">Slow</button>
    </div> -->
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

  /*var locationData = [[51.51324,-0.09909000000000001],[51.5133,-0.09908],[51.5133,-0.09908],[51.513290000000005,-0.09895000000000001],[51.513290000000005,-0.09885000000000001],[51.513290000000005,-0.09871],[51.513290000000005,-0.09861],[51.513290000000005,-0.0985],[51.513290000000005,-0.09838000000000001],[51.51328,-0.09826000000000001],[51.51328,-0.09826000000000001],[51.5133,-0.09816000000000001],[51.51332000000001,-0.0981],[51.51334000000001,-0.09806000000000001],[51.51339,-0.098],[51.513400000000004,-0.09791000000000001],[51.51342,-0.09781000000000001],[51.51343000000001,-0.09767],[51.513450000000006,-0.09756000000000001],[51.51346,-0.09748000000000001],[51.51346,-0.09741000000000001],[51.513470000000005,-0.09732],[51.51344,-0.09719000000000001],[51.51342,-0.09705000000000001],[51.51341000000001,-0.09694000000000001],[51.51339,-0.09681000000000001],[51.513360000000006,-0.09648000000000001],[51.51335,-0.09634000000000001],[51.51335,-0.09634000000000001],[51.51342,-0.09634000000000001],[51.513470000000005,-0.09634000000000001],[51.51350000000001,-0.09633000000000001],[51.513540000000006,-0.09634000000000001],[51.513580000000005,-0.09634000000000001],[51.51364,-0.09636],[51.51368,-0.09637000000000001],[51.513720000000006,-0.09638000000000001],[51.51375,-0.09639],[51.5138,-0.09642],[51.513830000000006,-0.09643],[51.513850000000005,-0.09644000000000001],[51.513870000000004,-0.09646],[51.51391,-0.09649],[51.513960000000004,-0.09652000000000001],[51.51399000000001,-0.09656],[51.514030000000005,-0.09659000000000001],[51.514120000000005,-0.09671],[51.514160000000004,-0.09675],[51.514210000000006,-0.09680000000000001],[51.51424,-0.09685],[51.514250000000004,-0.09688000000000001],[51.51428000000001,-0.09690000000000001],[51.514300000000006,-0.09692],[51.51433,-0.09693],[51.51437000000001,-0.09694000000000001],[51.514410000000005,-0.09695000000000001],[51.51447,-0.09694000000000001],[51.514520000000005,-0.09694000000000001],[51.51462,-0.09693],[51.51462,-0.09693],[51.514610000000005,-0.09681000000000001],[51.51456,-0.09655000000000001],[51.514540000000004,-0.09644000000000001],[51.514480000000006,-0.09621],[51.514430000000004,-0.09595000000000001],[51.514410000000005,-0.09586000000000001],[51.51435000000001,-0.09552000000000001],[51.514320000000005,-0.09534000000000001],[51.51429,-0.09508000000000001],[51.51422,-0.09473000000000001],[51.5142,-0.09461000000000001],[51.51418,-0.09445],[51.514140000000005,-0.09419000000000001],[51.514140000000005,-0.09419000000000001],[51.51437000000001,-0.09411000000000001],[51.51455000000001,-0.09404000000000001],[51.51456,-0.09404000000000001],[51.51458,-0.09402],[51.514590000000005,-0.09401000000000001],[51.514630000000004,-0.09396],[51.514660000000006,-0.09394000000000001],[51.51476,-0.09382000000000001],[51.51485,-0.09374],[51.51489,-0.0937],[51.51494,-0.09365000000000001],[51.51500000000001,-0.09361000000000001],[51.51507,-0.09357000000000001],[51.515100000000004,-0.09354000000000001],[51.51512,-0.09353],[51.515170000000005,-0.09350000000000001],[51.51527,-0.09345],[51.51532,-0.09343000000000001],[51.515370000000004,-0.09340000000000001],[51.51543,-0.09336000000000001],[51.51543,-0.09336000000000001],[51.51538000000001,-0.09323000000000001],[51.5153,-0.09307000000000001],[51.51527,-0.09301000000000001],[51.515260000000005,-0.09296],[51.515240000000006,-0.09293000000000001],[51.51523,-0.09288],[51.51520000000001,-0.09273],[51.51518,-0.0926],[51.515150000000006,-0.09245],[51.51511000000001,-0.09213],[51.51503,-0.09135],[51.514990000000004,-0.09107000000000001],[51.51494,-0.09061000000000001],[51.51491000000001,-0.09035000000000001],[51.51491000000001,-0.09035000000000001],[51.51489,-0.09018000000000001],[51.514810000000004,-0.08967000000000001],[51.514790000000005,-0.08956],[51.514770000000006,-0.08943000000000001],[51.51475000000001,-0.08932000000000001],[51.51475000000001,-0.08926],[51.51473000000001,-0.08912],[51.514720000000004,-0.08901],[51.514700000000005,-0.08884],[51.514680000000006,-0.08856000000000001],[51.51467,-0.08845],[51.51467,-0.0884],[51.51465,-0.08808],[51.51464000000001,-0.08783],[51.514630000000004,-0.08779],[51.514630000000004,-0.08779],[51.51447,-0.08767000000000001],[51.51433,-0.08758],[51.514140000000005,-0.08743000000000001],[51.513920000000006,-0.08728000000000001],[51.513920000000006,-0.08728000000000001],[51.513960000000004,-0.08704],[51.514010000000006,-0.08681000000000001],[51.514030000000005,-0.08672],[51.514050000000005,-0.08665],[51.514070000000004,-0.08657000000000001],[51.514100000000006,-0.08646000000000001],[51.51411,-0.0864],[51.514120000000005,-0.08633],[51.514120000000005,-0.08620000000000001],[51.514140000000005,-0.08593],[51.514160000000004,-0.08578000000000001],[51.514160000000004,-0.08567000000000001],[51.514190000000006,-0.08545000000000001],[51.5142,-0.08537],[51.51424,-0.08509000000000001],[51.51429,-0.08482],[51.51431,-0.08469],[51.51435000000001,-0.08441000000000001],[51.5144,-0.08415],[51.51442,-0.08402000000000001],[51.51442,-0.08396],[51.514430000000004,-0.08391000000000001],[51.514430000000004,-0.08386],[51.514430000000004,-0.08380000000000001],[51.51442,-0.08374000000000001],[51.5144,-0.08366000000000001],[51.5144,-0.08366000000000001],[51.51446000000001,-0.08358],[51.51453000000001,-0.0835],[51.51464000000001,-0.08336],[51.51473000000001,-0.08322],[51.51489,-0.083],[51.51493000000001,-0.08295000000000001],[51.51493000000001,-0.08295000000000001],[51.514880000000005,-0.08285000000000001],[51.5148,-0.08264],[51.51478,-0.08261],[51.514770000000006,-0.08257],[51.514770000000006,-0.08256000000000001],[51.51476,-0.08252000000000001],[51.51475000000001,-0.08248000000000001],[51.51474,-0.08237000000000001],[51.514720000000004,-0.08226000000000001],[51.51469,-0.08214],[51.51467,-0.08207],[51.514660000000006,-0.08204],[51.51464000000001,-0.08201000000000001],[51.51462,-0.08198000000000001],[51.514590000000005,-0.08195000000000001],[51.51455000000001,-0.08191000000000001],[51.51451,-0.08188000000000001],[51.51451,-0.08188000000000001],[51.514520000000005,-0.08135],[51.514520000000005,-0.08132],[51.51451,-0.08129],[51.514500000000005,-0.08125],[51.51449,-0.08118],[51.514430000000004,-0.08099],[51.514430000000004,-0.08099],[51.51455000000001,-0.0809],[51.5146,-0.08088000000000001],[51.51464000000001,-0.08085],[51.51475000000001,-0.08080000000000001],[51.51478,-0.08078]];*/


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

$( document ).ready(function() {
  marker.play();
});

</script>
@endsection

