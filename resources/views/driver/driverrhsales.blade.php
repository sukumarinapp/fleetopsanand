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
<div class="card card-success">
  <div class="card-header">
    <h3 class="card-title">Vehicle Reg No. Confirmed!</h3>
  </div>
  <div class="card-body">
    <form id="sales_form" method="post" action="{{ route('driverpay') }}">
        @csrf
   <div class="row justify-content-center">
    <div class="col-md-12">
       <input type="hidden" id="VNO" name="VNO" value="{{ $vehicle->VNO }}">
       <input type="hidden" id="DCN" name="DCN" value="{{ $vehicle->DCN }}">
       <input type="hidden" id="plat_id_hidden" name="plat_id_hidden" value="">
       <input type="hidden" id="earning_hidden" name="earning_hidden" value="">
       <input type="hidden" id="cash_hidden" name="cash_hidden" value="">
       <input type="hidden" id="trips_hidden" name="trips_hidden" value="">
       <input type="hidden" id="SSR" name="SSR" value="Driver">
       <input type="hidden" id="VBM" name="VBM" value="Ride Hailing">
       <label class="col-form-label">Vehicle Reg  No: {{ $vehicle->VNO }}</label>
   </div>
   <div class="col-md-12">
      <label class="col-form-label">Phone Number: {{ $vehicle->DCN }}</label>
   </div>
</div>
<hr>
<div class="row justify-content-center">
  <div class="col-md-12">
    <div class="form-group row">
     <label for="RHN" class="col-sm-3 col-form-label">Select Company Platform:</label>
     <div class="col-sm-9">
       <select name="RHN" id="RHN" required="required" class="form-control" style="width: 100%;">
        @foreach($rhplatforms as $rhplatform)
          <option value="{{ $rhplatform->id }}" >{{ $rhplatform->RHN }}</option>
        @endforeach
      </select>
    </div>
  </div>
</div>
</div>
<div class="row justify-content-center">
  <div class="col-md-12">
    <div class="form-group row">
     <label for="SPF" class="col-sm-3 col-form-label">Earning:</label>
     <div class="col-sm-9">
      <input required="required" type="text" class="form-control decimal" name="SPF" id="SPF" maxlength="9" placeholder="Earning">

    </div>
  </div>
</div>
</div>
<div class="row justify-content-center">
  <div class="col-md-12">
    <div class="form-group row">
     <label for="CPF" class="col-sm-3 col-form-label">Cash Collected:</label>
     <div class="col-sm-9">
      <input required="required" type="text" class="form-control decimal" name="CPF" id="CPF" maxlength="9" placeholder="Cash collected">
    </div>
  </div>
</div>
</div>
<div class="row justify-content-center">
  <div class="col-md-12">
    <div class="form-group row">
     <label for="TPF" class="col-sm-3 col-form-label">Trips:</label>
     <div class="col-sm-9">
      <input required="required" type="text" class="form-control decimal" name="TPF" id="TPF" maxlength="2" placeholder="Trips">

    </div>
  </div>
</div>
</div>
<div class="col-md-12" style="padding-bottom: 5px" >
  <input onclick="add_row()" type="button" value="Add" href="#" class="btn btn-info float-right" />
  <br>
</div>
<hr>
<table id="example1" class="table table-bordered table-hover">
  <thead>
    <tr>
      <th style="color:red;font-weight: bold;text-align: center">X</th>
      <th style="text-align: center">Platform</th>
      <th style="text-align: center">Earning</th>
      <th style="text-align: center">Cash</th>
      <th style="text-align: center">Trips</th>
    </tr>
  </thead>
  <tbody>
    <tr id='addr0'></tr>
  </tbody>
</table>
 <div class="col-md-12">
       <label class="col-form-label">Total Cash Collected: <span id="total_cash"></span></label>
   </div>
<br>
<nav class="navbar fixed-bottom navbar-expand-lg justify-content-center"> 
  <a onclick="submit_data()" href="#" class="btn btn-info">Continue</a>&nbsp;
  <a href="{{ route('driver') }}" class="btn btn-info">Cancel</a>&nbsp;
  <a href="{{ url('driverhelp/'. $vehicle->VNO .'/'. $vehicle->DCN ) }}" class="btn btn-info">Help</a>
</nav>
</form>
</div>
</div>
</div>
@endsection