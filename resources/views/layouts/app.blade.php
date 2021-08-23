<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('third_party_stylesheets')
    @stack('page_css')
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

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
         <ul class="navbar-nav">
          <li class="nav-item">
           <a href="{{ route('home') }}" class="nav-link {{ (request()->is('home')) ? 'active' : '' }}">
      <p><b>
        Dashboard
      </b></p>
  </a>
          </li>
      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
       
        <ul class="navbar-nav">
         
          @if(Auth::user()->usertype == "Admin")
           <li class="dropdown dropdown-hover {{ (request()->is('parameter') || request()->is('rhplatform') || request()->is('sms')) ? 'active' : '' }}">

            <a id="dropdownSubMenu" href="#"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><b>Settings</b></a>

            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                 @if(Auth::user()->usertype == "Admin" || Auth::user()->BPI == true)
              <li><a href="{{ route('parameter') }}" class="dropdown-item {{ (request()->is('parameter')) ? 'active' : '' }}" class="dropdown-item"><b>Parameter Settings</b> </a></li>
              <li><a href="{{ route('rhplatform.index') }}" class="dropdown-item {{ (request()->is('rhplatform')) ? 'active' : '' }}" class="dropdown-item"><b>RH Platform Settings</b></a></li>
                @endif
                  @if(Auth::user()->usertype == "Admin")
            <a href="{{ route('sms') }}" class="dropdown-item {{ (request()->segment(1) =='sms' ) ? 'active' : '' }}" class="dropdown-item"><b>Notification Setup</b></a>
          </li>
          @endif
          </ul>
           @endif
     

         @if(Auth::user()->usertype != "Client")
          <li class="dropdown dropdown-hover {{ (request()->segment(1) == 'manager' || request()->segment(1) == 'client' || request()->segment(1) == 'vehicle' || request()->segment(1) == 'fdriver' || request()->segment(1) == 'assignvehicle' || request()->segment(1) == 'removevehicle') ? 'active' : '' }}">

            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><b> Manage Account</b></a>

            
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                   @if(Auth::user()->usertype == "Admin" || Auth::user()->BPA == true || Auth::user()->BPD == true)
              <li><a href="{{ route('manager.index') }}" class="dropdown-item {{ (request()->segment(1) == 'manager') ? 'active' : '' }}" class="dropdown-item"><b>User Account</b> </a></li>
              @endif

               @if(Auth::user()->usertype == "Admin" || Auth::user()->BPB == true || Auth::user()->BPE == true)

              <li><a href="{{ route('client.index') }}" class="dropdown-item {{ (request()->segment(1) == 'client') ? 'active' : '' }}" class="dropdown-item"><b>Client Account</b></a></li>
                @endif

                 @if(Auth::user()->usertype == "Admin" || Auth::user()->BPC == true || Auth::user()->BPF == true)
            <li><a href="{{ route('vehicle.index') }}" class="dropdown-item {{ (request()->segment(1) == 'vehicle' || request()->segment(1) == 'assignvehicle' || request()->segment(1) == 'removevehicle') ? 'active' : '' }}" class="dropdown-item"><b>Manage Vehicle</b></a></li>
                @endif

                  @if(Auth::user()->usertype == "Admin" || Auth::user()->BPF == true)

              <li><a href="{{ route('fdriver.index') }}" class="dropdown-item {{ (request()->segment(1) == 'fdriver') ? 'active' : '' }}" class="dropdown-item"><b>Manage Driver</b></a></li>
            </li>
                @endif
          </ul>
           @endif

  

          @if(Auth::user()->usertype == "Admin" || (Auth::user()->BPJ==1 && Auth::user()->BPJ2==1))
       <li class="nav-item">
       <a href="{{ route('workflow') }}" class="nav-link {{ (request()->segment(1) == 'workflow' || request()->segment(1) == 'override') ? 'active' : '' }}" class="nav-link"><b>Workflow Manager</b></a>
    </li>
     @endif

         <li class="dropdown dropdown-hover {{ (request()->is('workflowlog') || request()->is('vehiclelog') || request()->is('sales')) ? 'active' : '' }}">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><b>Reports</b></a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{ route('workflowlog') }}" class="dropdown-item {{ (request()->is('workflowlog')) ? 'active' : '' }}" class="dropdown-item"><b>Workflow Log</b> </a></li>

              <li><a href="{{ route('vehiclelog') }}" class="dropdown-item {{ (request()->is('vehiclelog')) ? 'active' : '' }}" class="dropdown-item"><b>Vehicle Assign Log</b></a></li>

              <li><a href="{{ route('sales') }}" class="dropdown-item {{ (request()->is('sales')) ? 'active' : '' }}" class="dropdown-item"><b>Sales Ledger (Rental/HP)</b></a></li>
            </ul>
          </li>

            @if(Auth::user()->usertype == "Admin" || (Auth::user()->RBA4==1 && (Auth::user()->RBA4A==1 || Auth::user()->RBA4B==1 )))
             <!-- <li class="nav-item">
             <a href="{{ route('fuelsrch') }}" class="nav-link {{ (request()->segment(1) == 'fuelsrch' || request()->segment(1) == 'fuelsrch') ? 'active' : '' }}" class="nav-link"><b>Fueler</b></a>
            </li> -->
            @endif
          </li>
        </li>
      </ul>
    </div>
  </ul>

      <!-- Right navbar links -->
 
 <ul class="navbar-nav ml-auto">
<li class="nav-item dropdown user-menu">
<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
 <span class="d-none d-md-inline"><strong>{{ Auth::user()->name }}</strong></span>
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
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBGD4U0YDBCpPd54yleIeEcFIVfjQ8q9JY"></script>
@yield('third_party_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>

<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>
<script>

@stack('page_scripts')
<script>
$(document).ready(function(){
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
        console.log(VPF);
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
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
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
