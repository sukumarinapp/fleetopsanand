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
    <h3 class="card-title">Help: Did not work the previous day!</h3>
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
      <p>Unfortunately, your claim was not successful. System reset failed. Please proceed to declare your sales made within the past days.</p>

<br>
<nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">
  <a href="{{ route('driver') }}" class="btn btn-info">OK</a>
</nav>
</div>
</div>
</div>

@endsection