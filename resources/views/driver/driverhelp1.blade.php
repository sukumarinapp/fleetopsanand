@extends('layouts.driver')
@section('content')
<div class="container" >
 <div class="row justify-content-center">
  <div class="col-md-12 text-center">
    <a href="#" class="navbar-brand">
                <img src="{{ URL::to('/') }}/images/fleetopslogo.png" alt="AdminLTE Logo">
            </a>
    <h3 style="color: lightgray">Collection Note</h3>
  </div>
</div>
<div class="card card-purple">
  <div class="card-header">
    <h3 class="card-title">Help: Cannot retrieve sales data</h3>
  </div>
  <div class="card-body">
   <div class="row justify-content-center">
    <div class="col-md-12">
       <label class="col-form-label">Vehicle Reg  No:  {{ $sales['VNO'] }} </label>
   </div>
   <div class="col-md-12">
      <label class="col-form-label">Phone Number:  {{ $sales['DCN'] }} </label>
   </div>
</div>
<hr>
      <p>The sales declaration “Help” function is made available to assist you declare sales in the event where you are not able to retrieve information from your mobile device as a result of unfortunate instances or situations such as theft or damage to your mobile device etc.</p>

      <p>Remember that in the event of theft you are to report the case to the nearest police station as demanded by law.</p>

      <p>Please be informed that if you accept to proceed, we will retrieve your sales made using our AI and Enhanced Mapping Technology.Please press ‘I accept’ to proceed.</p>
  
    
   
<br>
<nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">
  <a href="{{ url('driverhelp2/'. $sales['VNO'] .'/'. $sales['DCN'] ) }}" class="btn btn-info">I Accept</a>&nbsp;
</nav>
</div>
</div>
</div>

@endsection