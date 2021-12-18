@extends('layouts.driver')
@section('content')
<div class="container" >
  <form id="sales_form" method="post" action="{{ route('driverpay') }}">
        @csrf
 <div class="row justify-content-center">
  <div class="col-md-12 text-center">
    <a href="#" class="navbar-brand">
                <img src="{{ URL::to('/') }}/images/fleetopslogo.png" alt="AdminLTE Logo">
            </a>
    <h3 style="color: lightgray">Invoice</h3>
  </div>
</div>
<div class="card card-success">
  <div class="card-header">
    <h3 class="card-title">Vehicle Reg No.Confirmed!</h3>
  </div>
  <div class="card-body">
      <input type="hidden" id="VNO" name="VNO" value="{{ $vehicle->VNO }}">
       <input type="hidden" id="DCN" name="DCN" value="{{ $vehicle->DCN }}">
       <input type="hidden" id="SSA" name="SSA" value="{{ $vehicle->TOT }}">
       <input type="hidden" id="SSR" name="SSR" value="Driver">
       <input type="hidden" id="VBM" name="VBM" value="{{ $vehicle->VBM }}">
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
      @if($vehicle->VBM == "Hire Purchase")
               <b> Hire Purchase Customer </b>
                @else
                <b>Vehicle Rental Customer</b>
                @endif
  </div>
 <div class="col-md-12">
     <p class="col-form-label"><b>Amount</b>       : GHC {{ $vehicle->VAM }}</p>
  </div>
  <div class="col-md-12">
     <p class="col-form-label"><b>Payment Freq</b> : {{ $vehicle->VPF }}</p>
  </div>
  <div class="col-md-12">
     <p class="col-form-label"><b>No of Payments</b>     : {{ $vehicle->QTY }}</p>
  </div>
  <div class="col-md-12">
     <p class="col-form-label"><b>Total</b>        : GHC {{ $vehicle->TOT }}</p>
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