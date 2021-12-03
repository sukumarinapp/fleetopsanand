@extends('layouts.app')
@section('content')
<div class="container-fluid">
<div id="map_canvas" style="width:1000px;height:500px"></div>
</div>
@endsection
@section('third_party_scripts')
<script>
    var map = undefined;
    var marker = undefined;
    var ground_speed = 0;
    var position = [ {{ $latitude }} , {{ $longitude }} ];
    ground_speed = "{{ $ground_speed }}";

    function initialize() {
        var latlng = new google.maps.LatLng(position[0], position[1]);
        var myOptions = {
            zoom: 19,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        marker = new google.maps.Marker({
            position: latlng,
            map: map,
            icon: "carblue.png",
            title: "GT4298-18\n" + ground_speed
        });
        google.maps.event.addListener(map, 'click', function(me) {
            var result = [me.latLng.lat(), me.latLng.lng()];
            transition(result);
        });
    }
    
    function animateMarkers(){
        var result;
        $.ajax({
          type: "get",
          url: '{{ route('vehicle_location') }}',
          success: function(response) {
            console.log(response[0]['ground_speed']);
            result = [response[0]['latitude'], response[0]['longitude']];
            ground_speed = response[0]['ground_speed'];
            transition(result);
          },
          error: function (jqXHR, exception) {
            console.log(exception);
          }
        });
    }

    setInterval(animateMarkers, 10000);

    var numDeltas = 100;
    var delay = 100; //milliseconds
    var i = 0;
    var deltaLat;
    var deltaLng;
    
    function transition(result){
        i = 0;
        deltaLat = (result[0] - position[0])/numDeltas;
        deltaLng = (result[1] - position[1])/numDeltas;
        moveMarker();
    }
    
    function moveMarker(){
        position[0] += deltaLat;
        position[1] += deltaLng;
        var latlng = new google.maps.LatLng(position[0], position[1]);
        marker.setPosition(latlng);
        map.panTo(new google.maps.LatLng(position[0], position[1]));
        marker.setTitle("GT4298-18\n" + ground_speed);
        if(i!=numDeltas){
            i++;
            setTimeout(moveMarker, delay);
        }
    }

    $(document).ready(function() {
        initialize();
    });
    
</script>
@endsection
