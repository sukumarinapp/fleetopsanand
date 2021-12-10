@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<label>Enter VNO</label>
	<input value="GN7122-17" type="text" name="search_inp" id="search_inp">
	<input onclick="live_track_play()" type="button" value="Live Track" class="btn btn-success">
	<div id="map_canvas" style="width:1000px;height:500px"></div>
</div>
@endsection
@section('third_party_scripts')
<script>
	var VNO = "";
	var map = undefined;
	var marker = undefined;
	var ground_speed = 0;
	var position = [5.629031666666666,-0.15723666666666666];

	function live_track_play(){
		VNO = $("#search_inp").val();
		if(typeof(VNO) == "undefined" || VNO == "" ){
			alert("Enter vehicle no");
			$("#search_inp").focus();
			return false;
		}else{
			initialize_live_track();
		}
	}

	function initialize_live_track() {
		var initial_location = '{{ url('initial_location') }}';
		initial_location = initial_location + "/" + VNO;
		$.ajax({
			type: "get",
			url: initial_location,
			success: function(response) {
				prevLatitude = response[0]['latitude'];
				prevLongitude = response[0]['longitude'];
				position[0] = response[0]['latitude'];
				position[1] = response[0]['longitude'];
				ground_speed = response[0]['ground_speed'];
				var latlng = new google.maps.LatLng(position[0], position[1]);
				var myOptions = {
					zoom: 20,
					center: latlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
				marker = new google.maps.Marker({
					position: latlng,
					map: map,
					icon: "carblue.png",
					title: VNO + "\n" + ground_speed
				});
			},
			error: function (jqXHR, exception) {
				console.log(exception);
			}
		});
		
		
	}
	
	function animateMarkers(){
		var result;
		var vehicle_location = '{{ url('vehicle_location') }}';
		vehicle_location = vehicle_location + "/" + VNO;
		$.ajax({
			type: "get",
			url: vehicle_location,
			success: function(response) {
				if(prevLatitude != response[0]['latitude'] && prevLongitude != response[0]['longitude']){
					result = [response[0]['latitude'], response[0]['longitude']];
					ground_speed = response[0]['ground_speed'];
					transition(result);
					prevLatitude = response[0]['latitude'];
					prevLongitude = response[0]['longitude'];
				}
				console.log(response[0]['capture_datetime']);
				console.log(response[0]['latitude']);
				console.log(response[0]['longitude']);
			},
			error: function (jqXHR, exception) {
				console.log(exception);
			}
		});
	}

	setInterval(animateMarkers, 10000);

	var numDeltas = 100;
	var delay = 100;
	var i = 0;
	var deltaLat=0.0;
	var deltaLng=0.0;
	var snappedPoints;
	var prevLatitude = 0;
	var prevLongitude = 0;
	
	function transition(result){
		i = 0;
		//deltaLat = (result[0] - position[0])/numDeltas;
		deltaLat = (result[0] - prevLatitude)/numDeltas;
		//deltaLng = (result[1] - position[1])/numDeltas;
		deltaLng = (result[1] - prevLongitude)/numDeltas;
		moveMarker();
	}
	
	function moveMarker(){
		var latitude = 0.0,longitude = 0.0;
		latitude = parseFloat(position[0]);
		longitude = parseFloat(position[1]);
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
				snapLength = snappedPoints.length - 1;
				position[0] = snappedPoints[snapLength].location.latitude;
				position[1] = snappedPoints[snapLength].location.longitude;
				i = 0;
				moveMarkerRepeat();
			},
			error: function (jqXHR, exception) {
				console.log(exception);
			}
		});
	}

	function moveMarkerRepeat(){
		var latlng = new google.maps.LatLng(snappedPoints[i].location.latitude,snappedPoints[i].location.longitude);
		marker.setPosition(latlng);
		map.panTo(latlng);
		marker.setTitle(VNO + "\n" + ground_speed);
		if(i < numDeltas-1){
			i++;
			setTimeout(moveMarkerRepeat, delay);
		}

	}
	
</script>
@endsection
