@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="content-header">
    <div class="row">
      <div class="col-md-3">
       <div class="sticky-top mb-3">
        <div class="card">
          <div class="card-body">
            @include("includes.tree")
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <!-- checkbox -->
            <div class="form-group" style="text-align:center;">
              <div class="form-check">
                <input class="form-check-input" type="checkbox">
                <label class="form-check-label">Auto Update</label>
              </div>

            </div>
          </div>
          <div class="col-sm-6">
            <!-- radio -->
            <div class="form-group" style="text-align:center;">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" >
                <label class="form-check-label">Auto Track</label>
              </div>

            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="margin">
              <div class="btn-group"  style="padding-right: 10px;">
                <button  type="button" class="btn btn-default">Refresh</button>
              </div>
              <div class="btn-group"  style="padding-right: 10px;">
                <button type="button" class="btn btn-default">Locate</button>
              </div>
              <div class="btn-group">
                <button type="button" class="btn btn-default">Clear</button>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <!-- checkbox -->
                <div class="form-group" style="padding-top: 10px;">
                  <div class="label">
                    <label>Online:1</label>
                  </div>

                </div> <div class="form-group">
                  <div class="label">
                    <label>New:0</label>
                  </div>

                </div> <div class="form-group">
                  <div class="label">
                    <label>Inactive:0</label>
                  </div>

                </div>
              </div>
              <div class="col-sm-6">
                <!-- radio -->
                <div class="form-group" style="padding-top: 10px;">
                  <div class="label">
                    <label>Offline:10</label>
                  </div>

                </div> <div class="form-group">
                  <div class="label">
                    <label>Total:20</label>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div> 
      </div>
    </div>
    <div class="col-md-9">
      <div class="card bg-gradient">
              <!-- <div class="card-header border-0">
                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div> -->
              <div class="card-body">
               <div id="map_canvas" style="height: 730px;"></div>
             </div>
           </div>

         </div>

       </div>
       <div class="card">
        <div class="card-body">
         <div class="table-responsive">
          <table id="example" class="table table-bordered table-striped table-head-fixed ">
            <thead style="width:100%">
              <tr>
                <th > Time</th>
                <th>License plate </th>
                <th>Address</th>
                <th>Tracker status</th>
                <th>Tracker status </th>
                <th>Vehicle status </th>
                <th>Alarm status</th>
                <th>Speed(km/h)</th>
                <th>Mileage(km) </th>
                <th>Used Fuel(%) </th>
                <th>Direction </th>
                <th>Interval(s) </th>
                <th>Over-speed settings</th>
                <th>GPS Signal</th>
                <th>GSM Signal </th>
                <th>Longitude </th>
                <th>Latitude </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>

                </td>
                <td>

                </td>
              </tr>

            </tbody>
          </table>
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

