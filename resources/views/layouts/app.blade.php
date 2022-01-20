<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        @if(isset($title))
        {{ $title }}
        @else
        {{ config('app.name') }}
        @endif
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
    integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
    crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/hummingbird-treeview.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    @yield('third_party_stylesheets')
    @stack('page_css')
    <style>
        .buttons-columnVisibility.active {
            color: green;
        }
        /*.dt-buttons{
            float: left;
            position: absolute;
            white-space: nowrap;
        }
        .dataTables_filter{
            float: right;
            position: relative;
            white-space: nowrap;
        }
        .dataTables_length{
            float: right;
            position: relative;
            margin-left: 10px;
            white-space: nowrap;
            }*/
            .select2-container--default{
                border-radius: 5px;
                border: 1px solid red;
            }
            .select2-selection__rendered{
                display: block ;
                border-radius: 5px;
                border: 1px solid black;
                padding: 1px 1px 1px 1px;
            }
        </style>
    </head>
    <body class="hold-transition layout-top-nav">
        <div class="wrapper">
          <nav class="main-header navbar navbar-expand-md navbar-light">
            <div class="container">

               <a href="#" class="navbar-brand">
                <img src="{{ URL::to('/') }}/images/fleetopslogo.png" alt="AdminLTE Logo">
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-3" id="navbarCollapse" style="padding-left: 50px;">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                  <li class="nav-item">
                     <a href="{{ route('home') }}" class="nav-link {{ (request()->is('home')) ? 'active' : '' }}">
                      <p>
                        Dashboard
                    </p>
                </a>
            </li>
            <div class="collapse navbar-collapse order-3" id="navbarCollapse">

                <ul class="navbar-nav">



               @if(Auth::user()->usertype != "Client")
               <li class="dropdown dropdown-hover {{ (request()->segment(1) == 'manager' || request()->segment(1) == 'client' ) ? 'active' : '' }}">

                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">File</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                  <li><a href="{{ route('manager.index') }}" class="dropdown-item {{ (request()->segment(1) == 'manager') ? 'active' : '' }}" class="dropdown-item">User Account </a></li>
                  <li><a href="{{ route('client.index') }}" class="dropdown-item {{ (request()->segment(1) == 'client') ? 'active' : '' }}" class="dropdown-item">Client Account</a></li>
          </ul>
          @endif


                  @if(Auth::user()->usertype == "Admin")
                  <li class="dropdown dropdown-hover {{ (request()->is('parameter') || request()->is('rhplatform') || request()->is('sms')) ? 'active' : '' }}">

                    <a id="dropdownSubMenu" href="#"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Settings</a>

                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                       @if(Auth::user()->usertype == "Admin" || Auth::user()->BPI == true)
                       <li><a href="{{ route('parameter') }}" class="dropdown-item {{ (request()->is('parameter')) ? 'active' : '' }}" class="dropdown-item">Parameter Settings </a></li>
                       <li><a href="{{ route('rhplatform.index') }}" class="dropdown-item {{ (request()->is('rhplatform')) ? 'active' : '' }}" class="dropdown-item">RH Platform Settings</a></li>
                       @endif
                       @if(Auth::user()->usertype == "Admin")
                       <a href="{{ route('sms') }}" class="dropdown-item {{ (request()->segment(1) =='sms' ) ? 'active' : '' }}" class="dropdown-item">Notification Setup</a>
                   </li>
                   @endif
               </ul>
               @endif


               @if(Auth::user()->usertype != "Client")
               <li class="dropdown dropdown-hover {{ ( request()->segment(1) == 'vehicle' || request()->segment(1) == 'fdriver' || request()->segment(1) == 'assignvehicle' || request()->segment(1) == 'removevehicle' || request()->segment(1) == 'workflow') ? 'active' : '' }}">

                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"> Operations</a>


                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">


                  @if(Auth::user()->usertype == "Admin" || Auth::user()->BPC == true || Auth::user()->BPF == true)
                  <li><a href="{{ route('vehicle.index') }}" class="dropdown-item {{ (request()->segment(1) == 'vehicle' || request()->segment(1) == 'assignvehicle' || request()->segment(1) == 'removevehicle') ? 'active' : '' }}" class="dropdown-item">Fleet Manager</a></li>
                  @endif

                  @if(Auth::user()->usertype == "Admin" || Auth::user()->BPF == true)

                  <li><a href="{{ route('fdriver.index') }}" class="dropdown-item {{ (request()->segment(1) == 'fdriver') ? 'active' : '' }}" class="dropdown-item">Driver Manager</a></li>
              </li>
              @endif

               @if(Auth::user()->usertype == "Admin" || (Auth::user()->BPJ==1 && Auth::user()->BPJ2==1))
          <li>
             <a href="{{ route('workflow') }}" class="dropdown-item {{ (request()->segment(1) == 'workflow' || request()->segment(1) == 'override') ? 'active' : '' }}" class="dropdown-item">Workflows</a>
         </li>
         @endif
          </ul>
          @endif




         <li class="dropdown dropdown-hover {{ ( request()->segment(1) == 'rhreport' || request()->segment(1) == 'sales' || request()->segment(1) == 'collection'  ) ? 'active' : '' }}">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Sales</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">


              <li><a href="{{ url('rhreport') }}/{{ date('Y-m-d', strtotime('-6 days')) }}/{{ date('Y-m-d') }}" class="dropdown-item {{ (request()->segment(1) == 'rhreport') ? 'active' : '' }}" class="dropdown-item">RH Daily Report</a></li>

              <li><a href="{{ url('sales') }}/{{ date('Y-m-d', strtotime('-6 days')) }}/{{ date('Y-m-d') }}" class="dropdown-item {{ (request()->segment(1) =='sales') ? 'active' : '' }}" class="dropdown-item">Pending Sales (RT/HP)</a></li>

              <li><a href="{{ url('collection') }}/{{ date('Y-m-d', strtotime('-6 days')) }}/{{ date('Y-m-d') }}" class="dropdown-item {{ (request()->segment(1) == 'collection') ? 'active' : '' }}" class="dropdown-item">General Sales Ledger</a></li>


          </ul>
      </li>

  <li class="dropdown dropdown-hover {{ (request()->segment(1) == 'workflowlog' || request()->segment(1) == 'vehiclelog' || request()->segment(1) == 'notificationslog' || request()->segment(1) == 'alertlog' || request()->segment(1) == 'telematicslog' ) ? 'active' : '' }}">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Reports</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{ url('workflowlog') }}/{{ date('Y-m-d', strtotime('-6 days')) }}/{{ date('Y-m-d') }}" class="dropdown-item {{ (request()->segment(1) =='workflowlog') ? 'active' : '' }}" class="dropdown-item">Workflow Log </a></li>

              <li><a href="{{ url('vehiclelog') }}/{{ date('Y-m-d', strtotime('-6 days')) }}/{{ date('Y-m-d') }}" class="dropdown-item {{ (request()->segment(1) == 'vehiclelog') ? 'active' : '' }}" class="dropdown-item">Vehicle Assign Log</a></li>

              <li><a href="{{ url('notificationslog') }}/{{ date('Y-m-d', strtotime('-6 days')) }}/{{ date('Y-m-d') }}" class="dropdown-item {{ (request()->segment(1) == 'notificationslog') ? 'active' : '' }}" class="dropdown-item">Notifications Log</a></li>

              <li><a href="{{ url('alertlog') }}/{{ date('Y-m-d') }}/{{ date('Y-m-d') }}" class="dropdown-item {{ (request()->segment(1) == 'alertlog') ? 'active' : '' }}" class="dropdown-item">Alert Log</a></li>

               <li><a href="{{ url('telematicslog') }}/{{ date('Y-m-d', strtotime('-1 days')) }}/{{ date('Y-m-d', strtotime('-1 days')) }}" class="dropdown-item {{ (request()->segment(1) == 'telematicslog') ? 'active' : '' }}" class="dropdown-item">Daily Telematics Log</a></li>

          </ul>
      </li>
      @if(Auth::user()->usertype == "Admin" || (Auth::user()->RBA4==1 && (Auth::user()->RBA4A==1 || Auth::user()->RBA4B==1 )))
             <!-- <li class="nav-item">
             <a href="{{ route('fuelsrch') }}" class="nav-link {{ (request()->segment(1) == 'fuelsrch' || request()->segment(1) == 'fuelsrch') ? 'active' : '' }}" class="nav-link"><b>Fueler</b></a>
         </li> -->
         @endif
     </li>
 </li>

 <li class="nav-item">
     <a href="{{ route('help') }}" class="nav-link {{ (request()->segment(1) == 'help' ) ? 'active' : '' }}" class="nav-link">Help</a>
 </li>
</ul>
</div>
</ul>

<!-- Right navbar links -->

<ul class="navbar-nav ml-auto ">
    <li class="nav-item dropdown user-menu ">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
           <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
       </a>
       <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <li class="user-footer">
            <a href="{{ route('change_password') }}" class="btn btn-default btn-flat">Change Password</a>
            <a href="#" class="btn btn-default btn-flat float-right"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Sign out
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
           @csrf
       </form>
   </li>
</ul>
</li>
</ul>
</div>
</nav>


<div class="content-wrapper">
    <section class="content">
        @yield('content')
    </section>
</div>
</div>

<script src="{{ mix('js/app.js') }}" ></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMFPPAlejgNNF0FPoxBNjqVpThqXRvy_s"></script>
@yield('third_party_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>

<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" language="javascript" src="{{ asset('js/hummingbird-treeview.js') }}"></script>

<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script type="text/javascript" language="javascript" src="{{ asset('js/travel-marker.umd.js') }}"></script>
@stack('page_scripts')
<script>
//https://codepen.io/manpreetsingh80/pen/aEpzjB
var map, line, marker;
var directionsService = new google.maps.DirectionsService();
var TravelMarker = travelMarker.TravelMarker;
speedMultiplier = 1;
var locationData = Array();
var startlat = "";
var endlat = "";
var startlong = "";
var endlong = "";
var startdate = "";
var enddate = "";
speedMultiplier = 1; // speedMultiplier to control animation speed
//google.maps.event.addDomListener(window, 'load', initializereplay);
//$(document).ajaxStop(initializereplay);

function initializereplay() {
    var mapOptions = {
        zoom: 16,
        center: new google.maps.LatLng(startlat,startlong),
    };
    map = new google.maps.Map(document.getElementById('replay-canvas'),
        mapOptions);
    console.log('startLat', startlat);
    mockDirections();
}

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

    var startMarker = new google.maps.Marker({position: start, map: map, label: 'A', title: startdate});
    var endMarker = new google.maps.Marker({position: end, map: map, label: 'B', title: enddate});

    /*var marker, i;
for (i = 0; i < locationData.length; i++) {
    marker = new google.maps.Marker({
         position: new google.maps.LatLng(locationData[i][0], locationData[i][1]),
         map: map,
         title: locationData[i][2]
         icon: "dot.png"
    });
}*/


    initRoute();
}
// initialize travel marker
function initRoute() {
  var route = line.getPath().getArray();
  // options

  var options = {
    map: map,  // map object
    speed: 30, // default 10 , animation speed
    interval: 10, //default 10, marker refresh time
    speedMultiplier: speedMultiplier,
    markerOptions: {
      title: "",
      animation: google.maps.Animation.NONE,
      icon: {
        url: 'track.png',
        animation: google.maps.Animation.NONE,
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

  // console.log('marker', marker.options.markerOptions.title);

 // add locations from direction service
 marker.addLocation(route);

    marker.event.onEvent(function (eventName, data) {
        try {
            $('#replaytime').text(locationData[data.index][2]);
        } catch (error) {}
    });
 //setTimeout(play, 2000);
 marker.play();
}

function pauseandplay(){
    marker.play();
}

function pause() {
  marker.pause();
}

function next() {
  marker.next();
}

function prev() {
  marker.prev();
}

function reset2() {
  marker.reset();
}

function fast() {
  speedMultiplier*=2;
  document.getElementById('speed').innerHTML = speedMultiplier + 'x';
  marker.setSpeedMultiplier(speedMultiplier)
}

// slow motion
function slow() {
  speedMultiplier/=2;
  document.getElementById('speed').innerHTML = speedMultiplier + 'x';
  marker.setSpeedMultiplier(speedMultiplier)
}


function play(){

    var VNO = $("#search_inp").val();
    var starttime = $("#starttime").val();
    var endtime = $("#endtime").val();
    var formData = "VNO="+VNO+"&starttime="+starttime+"&endtime="+endtime;
    var track = "{{ url('track') }}";
    var url =  track + "/" + VNO + "/" +starttime + "/" +endtime;
    if(typeof(VNO) == "undefined" || VNO == "" ){
        alert("Enter vehicle no");
        $("#search_inp").focus();
        return false;
    }else if(!check_checked(VNO.toUpperCase())){
        alert("Vehicle No not found");
        $("#search_inp").focus();
        return false;
    }else if(starttime == ""){
        alert("select Start Time");
        return false;
    }else if(endtime == ""){
        alert("select End Time");
        return false;
    }else{
        locationData = Array();
        $("#gmapreplay").html("<i class='fa fa-arrow-left'>&nbsp;</i>Normal");
        $.ajax({
          type: "get",
          url: url,
          success: function(response) {
            response = JSON.parse(response);
            console.log("response");
            console.log(response);


            $("#replay-summary").html("<div style='font-size:large' class='bg-danger text-center'><b>"+response['VNO']+"</b></div><div class='text-center'>"+"<b>Mileage covered: </b>"+response['mileage']+"  "+"<b>Engine Active Hours: </b>"+response['hours_worked']+"  "+"<b>Min. Speed: </b>"+response['min_speed']+"  "+"<b>Max. Speed: </b> "+response['max_speed']+"</div>");
            if(response["loc"] == undefined){
                alert("No data found");
                return false;
            }

            for (let i = 0; i < response["loc"].length; i++) {
                if(i == 0){
                    startlat = response["loc"][i][0];
                    startlong = response["loc"][i][1];

                    startdate = response["loc"][i][2];
                }
                if(i == response["loc"].length-1){
                    endlat = response["loc"][i][0];
                    endlong = response["loc"][i][1];
                    enddate = response["loc"][i][2];
                }
                var series = new Array(response["loc"][i][0],response["loc"][i][1],response["loc"][i][2]);
                locationData.push(series);
                console.log('lookme');

            }
            $("#replaytime").html(startdate);
            initializereplay();
        },
        error: function (jqXHR, exception) {
            console.log(exception);
        }
    });
    }
}

function replay(){
    $("#map_canvas").slideUp("slow");
    $("#map_replay").slideDown("slow");
    live_play_mode = 0;
}

function toggle_map(arg){
    var VNO = $("#search_inp").val();
    if(typeof(VNO) == "undefined" || VNO == "" ){
        alert("Enter vehicle no");
        $("#search_inp").focus();
        live_play_mode = 0;
    }else{
        VNO = VNO.toUpperCase();
        if(!check_checked(VNO)){
            alert("Vehicle No not found");
            $("#search_inp").focus();
            live_play_mode = 0;
        }else{
            if(arg.value == "replay"){
                $("#map_canvas").slideUp("slow");
                $("#map_canvas_live").slideUp("slow");
                $("#map_replay").slideDown("slow");
                $("#gmapreplay").prop('value', 'normal');
                $("#gmapreplay").html("<i class='fa fa-arrow-left'>&nbsp;</i>Normal");
                $("#gmaplive").hide();
                live_play_mode  = 0;
            }else if(arg.value == "normal"){
                $("#map_canvas").slideDown("slow");
                $("#map_canvas_live").slideUp("slow");
                $("#map_replay").slideUp("slow");
                $("#gmapreplay").text("Replay");
                $("#gmapreplay").prop('value', 'replay');
                $("#gmaplive").show();
                live_play_mode = 0;
            }
        }
    }
}

    function search_tree(arg){
        var srch = arg.value;
        if(typeof(srch) != "undefined" && srch != ""){
            srch = srch.toUpperCase();
        }
        $("#treeview").hummingbird("uncheckAll");
        $("#treeview").hummingbird("collapseAll");
        if(srch == "") return;
        $("#treeview").hummingbird("expandNode",{sel:"id",vals:[srch],expandParents:true});
        $("#treeview").hummingbird("checkNode",{sel:"id", vals:[srch]});
    }

    $(document).ready(function(){


        $("#search_inp").bind('paste', function(e) {
            var elem = $(this);
            search_tree(e);
        });

        $("#treeview").hummingbird();
        $("#treeview").hummingbird("checkAll");
        //reloadMarkers();


        $('#treeview :checkbox').click(function () {
            reloadMarkers();
        });

        $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert-success").slideUp(500);
        });
        $('#rhvisibility').change(function() {
            if(this.checked) {
                $("#SPF").attr("disabled", "disabled");
                $("#RMT").attr("disabled", "disabled");
                $("#TPF").attr("disabled", "disabled");
            }else{
                $("#SPF").removeAttr("disabled");
                $("#RMT").removeAttr("disabled");
                $("#TPF").removeAttr("disabled");
            }
        });

        if(($('#BPJ1').prop("checked")) == false){
            $('#BPJ1').prop("checked", false);
            $('#BPJ2').prop("checked", false);
            $('#BPJ1').attr("disabled", true);
            $('#BPJ2').attr("disabled", true);
        }

        if(($('#RBA4').prop("checked")) == false){
            $('#RBA4A').attr("disabled", true);
            $('#RBA4B').attr("disabled", true);
        }

        $('#RBA4').change(function() {
            if(this.checked) {
                $('#RBA4A').attr("disabled", false);
                $('#RBA4B').attr("disabled", false);
            }else{
                $('#RBA4A').attr("disabled", true);
                $('#RBA4B').attr("disabled", true);
            }
        });

        $('#BPJ').change(function() {
            if(this.checked) {
                $('#BPJ1').prop("checked", true);
                $('#BPJ2').prop("checked", true);
                $('#BPJ1').attr("disabled", false);
                $('#BPJ2').attr("disabled", false);
            }else{
                $('#BPJ1').prop("checked", false);
                $('#BPJ2').prop("checked", false);
                $('#BPJ1').attr("disabled", true);
                $('#BPJ2').attr("disabled", true);
            }
        });

        $("#VPF").change(function(evt){
            var VPF = $("#VPF").val();
            if(VPF=="Daily"){
                $("#weekdaydiv").hide("slow");
                $("#monthdaydiv").hide("slow");
            }else if(VPF=="Weekly"){
                $("#weekdaydiv").show("slow");
                $("#monthdaydiv").hide("slow");
            }else if(VPF=="Monthly"){
                $("#weekdaydiv").hide("slow");
                $("#monthdaydiv").show("slow");
            }
        });
        $("#VBM").change(function(evt){
            var VBM = $("#VBM").val();
            if(VBM=="Ride Hailing"){
                $("#rhdiv").show("slow");
                $("#freqdiv").hide("slow");
                $("#paydatediv").hide("slow");
                $("#payamtdiv").hide("slow");
            }else{
                $("#rhdiv").hide("slow");
                $("#freqdiv").show("slow");
                $("#paydatediv").show("slow");
                $("#payamtdiv").show("slow");
            }
        });
        $("#CMT").change(function(evt){
            var CMT = $("#CMT").val();
            if(CMT == "A"){
                $("#CMBLBL").hide();
                $("#branch_div").hide();
                $("#CMALBL").text("Name");
                $("#CMNLBL").text("Mobile Number");
                $("#CBKLBL").text("Telecom Provider");
                $("#CMA").attr("placeholder", "Name");
                $("#CMN").attr("placeholder", "Mobile Number");
                $("#telecom_div").html("<select class='form-control' name='CMB' id='CMB'><option value='AIRTELTIGO'>AIRTELTIGO</option><option value='MTN'>MTN</option><option value='VODAFONE'>VODAFONE</option></select>");
            }else if(CMT == "B"){
                $("#CMBLBL").show();
                $("#branch_div").show();
                $("#CMALBL").text("Account Name");
                $("#CMNLBL").text("Account Number");
                $("#CBKLBL").text("Bank Name");
                $("#CMA").attr("placeholder", "Account Name");
                $("#CMN").attr("placeholder", "Account Number");
                $("#telecom_div").html("<input type='text' class='form-control number' name='CBK' id='CBK' maxlength='15' placeholder='Bank Name'>");
            }
        });
        $(".decimal").keypress(function(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57)) {
                return false;
        }
        if (charCode == 46 && this.value.indexOf(".") !== -1) {
            return false;
        }
        return true;
    });

        $('.number').keypress(function (event) {
            var keycode = event.which;
            if (!(event.shiftKey == false && (keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
                event.preventDefault();
            }
        });

        $('#example1').DataTable( {
            responsive: true,
            initComplete: function() {
             $('.buttons-excel').html('<i class="fa fa-file-excel" style="color:green"/>')
             $('.buttons-pdf').html('<i class="fa fa-file-pdf" style="color:red"/>')
             $('.buttons-print').html('<i class="fa fa-print" style="color:#0d5b9e"/>')
         },
         dom: "<'row'<'col-sm-12 col-md-9'B><'col-sm-12 col-md-3'f>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-12 col-md-2'i><'col-sm-12 col-md-2'l><'col-sm-12 col-md-8'p>>",
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
         buttons: [
         'excel', 'pdf', 'print','columnsToggle'
         ]
     } );

        var maxLen200 = 200;
        $('.max200').keypress(function(event){
            var Length = $(".max200").val().length;
            if(Length >= maxLen200){
                if (event.which != 8) {
                    return false;
                }
            }
        });

        $('body').on('keyup paste', '.max200', function () {
            $(this).val($(this).val().substring(0, maxLen200));
            var tlength = $(this).val().length;
            remain = maxLen200 - parseInt(tlength);
            $('.max200').text(remain);
        });
    });

function isNumber(evt){
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function duplicateEmail(id){
    var email = $("#email").val();
    var _token = $('input[name="_token"]').val();
    $.ajax({
        type: "post",
        url: '{{ route('checkemail') }}',
        data:{id:id,email:email, _token:_token},
        success: function(res) {
            console.log(res);
            if(res.exists){
                $("#dupemail").html("Email already used by another user");
                $("#save").prop('disabled', true);
            }else{
                $("#dupemail").html("<span style='color:green'>Available</span>");
                $("#save").prop('disabled', false);
            }
        },
        error: function (jqXHR, exception) {
            console.log(exception);
        }
    });
}

function duplicateUserContact(id){
    var UCN = $("#UCN").val();
    var _token = $('input[name="_token"]').val();
    $.ajax({
        type: "post",
        url: '{{ route('duplicateUserContact') }}',
        data:{id:id,UCN:UCN, _token:_token},
        success: function(res) {
            if(res.exists){
                $("#dupContact").html("Contact Number already in use");
                $("#save").prop('disabled', true);
            }else{
                $("#dupContact").html("<span style='color:green'></span>");
                $("#save").prop('disabled', false);
            }
        },
        error: function (jqXHR, exception) {
            console.log(exception);
        }
    });
}
function checkDCN(id){
    var DCN = $("#DCN").val();
    var _token = $('input[name="_token"]').val();
    $.ajax({
        type: "post",
        url: '{{ route('checkDCN') }}',
        data:{id:id,DCN:DCN, _token:_token},
        success: function(res) {
            if(res.exists){
                $("#dupContact").html("Contact Number already exists");
                $("#save").prop('disabled', true);
            }else{
                $("#dupContact").html("<span style='color:green'></span>");
                $("#save").prop('disabled', false);
            }
        },
        error: function (jqXHR, exception) {
            console.log(exception);
        }
    });
}

function duplicateDNO(id){
    var DNO = $("#DNO").val().trim();
    var _token = $('input[name="_token"]').val();
    $.ajax({
        type: "post",
        url: '{{ route('checkDNO') }}',
        data:{id:id,DNO:DNO, _token:_token},
        success: function(res) {
            if(res.exists){
                $("#save").prop('disabled', true);
                $("#dupDNO").html("Duplicate License Number");
            }else{
                $("#save").prop('disabled', false);
                $("#dupDNO").html("");
            }
        },
        error: function (jqXHR, exception) {
            console.log(exception);
        }
    });
}

function duplicateVNO(id){
    var VNO = $("#VNO").val().trim();
    var _token = $('input[name="_token"]').val();
    $.ajax({
        type: "post",
        url: '{{ route('checkVNO') }}',
        data:{id:id,VNO:VNO,_token:_token},
        success: function(res) {
            if(res.exists){
                $("#save").prop('disabled', true);
                $("#dupVNO").html("Duplicate Vehicle No");
            }else{
                $("#save").prop('disabled', false);
                $("#dupVNO").html("");
            }
        },
        error: function (jqXHR, exception) {
            console.log(exception);
        }
    });
}

function duplicateDeviceSN(id){
    var TSN = $("#TSN").val().trim();
    var _token = $('input[name="_token"]').val();
    $.ajax({
        type: "post",
        url: '{{ route('tracker_device_sn') }}',
        data:{id:id,TSN:TSN,_token:_token},
        success: function(res) {
            if(res.exists){
                $("#save").prop('disabled', true);
                $("#dupTSN").html("Duplicate Tracker Device SN");
            }else{
                $("#save").prop('disabled', false);
                $("#dupTSN").html("");
            }
        },
        error: function (jqXHR, exception) {
            console.log(exception);
        }
    });
}

function duplicateTrackerID(id){
    var TID = $("#TID").val().trim();
    var _token = $('input[name="_token"]').val();
    $.ajax({
        type: "post",
        url: '{{ route('tracker_id') }}',
        data:{id:id,TID:TID,_token:_token},
        success: function(res) {
            if(res.exists){
                $("#save").prop('disabled', true);
                $("#dupTID").html("Duplicate Tracker ID");
            }else{
                $("#save").prop('disabled', false);
                $("#dupTID").html("");
            }
        },
        error: function (jqXHR, exception) {
            console.log(exception);
        }
    });
}

function duplicateTrackerSIM(id){
    var TSM = $("#TSM").val().trim();
    var _token = $('input[name="_token"]').val();
    $.ajax({
        type: "post",
        url: '{{ route('tracker_sim_no') }}',
        data:{id:id,TSM:TSM,_token:_token},
        success: function(res) {
            if(res.exists){
                $("#save").prop('disabled', true);
                $("#dupTSM").html("Duplicate Tracker SIM No");
            }else{
                $("#save").prop('disabled', false);
                $("#dupTSM").html("");
            }
        },
        error: function (jqXHR, exception) {
            console.log(exception);
        }
    });
}

function load_driver_license(){
    var DNM = $("#DNM").val();
    $('#DNO option').each(function() {
        if($(this).val() == DNM) $(this).prop('selected', true);
    });
}

function load_driver_name(){
    var DNO = $("#DNO").val();
    $('#DNM option').each(function() {
        if($(this).val() == DNO) $(this).prop('selected', true);
    });
}

function validate_amount(){
    if($("#VBM").val()!="Ride Hailing"){
        if($("#VPD").val().trim()==""){
            alert("Enter payment date");
            $("#VPD").focus();
            return false;
        }
        if($("#VAM").val().trim()==""){
            alert("Enter payment amount");
            $("#VAM").focus();
            return false;
        }
    }
    return true;
}

</script>
</body>
</html>
