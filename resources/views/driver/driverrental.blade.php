@extends('layouts.driver')
@section('content')
<div class="container" >
 <div class="row justify-content-center">
  <div class="col-md-12 text-center">
    <h3 style="color: lightgray">Declare Sales</h3>
  </div>
</div>
<div class="card card-success">
  <div class="card-header">
    <h3 class="card-title">Vehicle Reg No.Confirmed!</h3>
  </div>
  <div class="card-body">

     <div class="row justify-content-center">
    <div class="col-md-12">
       <label class="col-form-label">Vehicle Reg No: {{ $vehicle->VNO }}</label>
   </div>
   <div class="col-md-12">
     <label class="col-form-label">Phone Number: {{ $vehicle->DCN }}</label>
  </div>
</div>
  <hr>
<div class="row">
  <div class="col-md-12">
   <p>A fixed amount of GHC400 is expected to be remitted to your car owner on a weekly basis.</p>
   <p>You may proceed by pressing ‘Ok’ below.</p>
  </div>
</div>
<nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">      
  <a href="#" class="btn btn-info">OK</a>&nbsp;
  <a href="{{ route('driver') }}" class="btn btn-info">Cancel</a>
</nav>
</div>
</div>
</div>

@endsection