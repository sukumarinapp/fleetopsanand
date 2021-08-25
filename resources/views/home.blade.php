@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3>Dashboard</h3>
            <!-- @foreach($users as $user)
              {{ $user->id }}-{{ $user->parent_id }}-{{ $user->usertype }}-{{ $user->name }}<br>
            @endforeach -->

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">Home</a></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
   <div class="row">
    <div class="col-md-3">
        <div class="sticky-top mb-3">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Tree View</h4>
                </div>
                <div class="card-body">
                  <div id="treeview_container" class="hummingbird-treeview" style="height: 608px; overflow-y: scroll;">
      <ul style="float: left; " id="treeview" class="hummingbird-base">
      <li data-id="0">
    <i class="fa fa-plus"></i>
    <label>
        <input id="xnode-0" data-id="custom-0" type="checkbox" /> Admin
    </label>
    <ul>
        <li data-id="1">
      <i class="fa fa-plus"></i>
      <label>
          <input  id="xnode-0-1" data-id="custom-0-1" type="checkbox" /> node-0-1
      </label>
      <ul>
          <li>
        <label>
            <input class="hummingbird-end-node" id="xnode-0-1-1" data-id="custom-0-1-1" type="checkbox" /> node-0-1-1
        </label>
          </li>
          <li>
        <label>
            <input class="hummingbird-end-node" id="xnode-0-1-2" data-id="custom-0-1-2" type="checkbox" /> node-0-1-2
        </label>
          </li>
      </ul>
        </li>
        <li data-id="1">
      <i class="fa fa-plus"></i>
      <label>
          <input  id="xnode-0-2" data-id="custom-0-2" type="checkbox" /> node-0-2
      </label>
      <ul>
          <li>
        <label>
            <input class="hummingbird-end-node" id="xnode-0-2-1" data-id="custom-0-2-1" type="checkbox" /> node-0-2-1
        </label>
          </li>
          <li>
        <label>
            <input class="hummingbird-end-node" id="xnode-0-2-2" data-id="custom-0-2-2" type="checkbox" /> node-0-2-2
        </label>
          </li>
      </ul>
        </li>
    </ul>
      </li>
  </ul>
    </div>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
    </div>
          <!-- <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>150</h3>
                <p>New Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> -->
          <!-- <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>
                <p>Bounce Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> -->
         <!--  <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>
                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> -->
          <!-- <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>
                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> -->
        
            <div class="col-md-9">

          <div class="card bg-gradient">
              <div class="card-header border-0">
                <h5 class="card-title">
                  <i class="fas fa-map-marker"></i>
                  Map
                </h5>
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
