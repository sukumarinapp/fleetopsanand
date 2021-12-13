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
    <form id="sales_form" method="post" action="{{ route('driverpay') }}">
        @csrf
   <div class="row justify-content-center">
    <div class="col-md-12">
       <input type="hidden" id="VNO" name="VNO" value="{{ $sales['VNO'] }}">
       <input type="hidden" id="plat_id_hidden" name="plat_id_hidden" value="{{ $sales['PLF'] }}">
       <input type="hidden" id="DCN" name="DCN" value="{{ $sales['DCN'] }}">
       <input type="hidden" id="earning_hidden" name="earning_hidden" value="0">
       <input type="hidden" id="cash_hidden" name="cash_hidden" value="{{ $sales['expected_sales'] }}">
       <input type="hidden" id="trips_hidden" name="trips_hidden" value="0">
       <input type="hidden" id="SSR" name="SSR" value="Help">
       <input type="hidden" id="VBM" name="VBM" value="Ride Hailing">
       <label class="col-form-label">Vehicle Reg  No: {{ $sales['VNO'] }} </label>
   </div>
   <div class="col-md-12">
      <label class="col-form-label">Phone Number: {{ $sales['DCN'] }} </label>
   </div>
</div>
<hr>
      <p>Thank you for your submission.</p>

      <p>Below summary is for your attention,</p>

      <div class="row justify-content-center">
    <div class="col-md-12">
       <label class="col-form-label">Date:  {{ $sales['SDT_dMY'] }} </label>
   </div>
   <div class="col-md-12">
      <label class="col-form-label">Sales amount to declare:  GHC {{ $sales['expected_sales'] }} </label>
   </div>
</div>

   
<br>
<nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">
  <input type="submit" value="OK" class="btn btn-info" />&nbsp;
  <a href="{{ route('driver') }}" class="btn btn-info">Cancel</a>
</nav>
</form>
</div>
</div>
</div>

@endsection