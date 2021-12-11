@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<label>Enter VNO</label>
	<input type="text" name="search_inp" id="search_inp">
	<input onclick="live_track_play()" type="button" value="Live Track" class="btn btn-success">
	<div id="map_canvas_live" style="width:1000px;height:500px"></div>
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

	function live_track_play(){
		VNO_live = $("#search_inp").val();
		if(typeof(VNO_live) == "undefined" || VNO_live == "" ){
			alert("Enter vehicle no");
			$("#search_inp").focus();
			return false;
		}else{
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
					transition(result);
					prevLatitude = response[0]['latitude'];
					prevLongitude = response[0]['longitude'];
				}
				console.log(response[0]['capture_datetime']);
				console.log(response[0]['latitude']);
				console.log(response[0]['longitude']);
				console.log(response[0]['ground_speed']);
				console.log(response[0]['direction']);
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
				snapLength = snappedPoints.length - 1;
				console.log(snapLength);				
				position_live[0] = snappedPoints[snapLength].location.latitude;
				position_live[1] = snappedPoints[snapLength].location.longitude;
				i_live = 0;
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
	
</script>
@endsection
