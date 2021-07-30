@extends('layouts.driver')
@section('content')
<div class="container" >
  <form id="sales_form" method="post" action="{{ route('driverpay') }}">
        @csrf
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
      <input type="hidden" id="VNO" name="VNO" value="{{ $vehicle->VNO }}">
       <input type="hidden" id="DCN" name="DCN" value="{{ $vehicle->DCN }}">
       <input type="hidden" id="SSA" name="SSA" value="{{ $vehicle->VAM }}">
       <input type="hidden" id="SSR" name="SSR" value="Driver">
       <input type="hidden" id="VBM" name="VBM" value="Rental">
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
   <p>A fixed amount of GHC {{ $vehicle->VAM }} is expected to be remitted to your car owner on a {{ $vehicle->VPF }} basis.</p>
   <p>You may proceed by pressing ‘Ok’ below.</p>
  </div>
</div>
<nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">      
  <input type="submit"  class="btn btn-info" value="Continue">&nbsp;
  <a href="{{ route('driver') }}" class="btn btn-info">Cancel</a>
</nav>
</div>
</div>
</form>
</div>

@endsection