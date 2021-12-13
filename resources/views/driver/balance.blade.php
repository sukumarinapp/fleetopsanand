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
    <h3 style="color: lightgray">Collection Note</h3>
  </div>
</div>
<div class="card card-success">
  <div class="card-header">
    <h3 class="card-title">Payment</h3>
  </div>
  <div class="card-body">
       <input type="hidden" id="SSR" name="SSR" value="Driver">
       <input type="hidden" id="VBM" name="VBM" value="Ride Hailing">
       <input type="hidden" id="earning_hidden" name="earning_hidden" value="0">
       <input type="hidden" id="cash_hidden" name="cash_hidden" value="{{ $BAL }}">
       <input type="hidden" id="trips_hidden" name="trips_hidden" value="0">
       <input type="hidden" id="plat_id_hidden" name="plat_id_hidden" value="{{ $RHN }}">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="form-group row">
             <label for="VNO" class="col-sm-3 col-form-label">Vehicle Reg No:</label>
             <div class="col-sm-9">
              <input value="{{ $VNO }}" required="required" type="text" class="form-control" name="VNO" id="VNO" maxlength="15" readonly>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="form-group row">
             <label for="DCN" class="col-sm-3 col-form-label">Phone Number:</label>
             <div class="col-sm-9">
              <input value="{{ $RCN }}" required="required" type="text" class="form-control number" name="DCN" id="RCN" maxlength="15" placeholder="Phone Number">
             </div>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="form-group row">
             <label for="DCN" class="col-sm-3 col-form-label">Amount to Pay in GHC</label>
             <div class="col-sm-9">
              <input readonly="readonly" value="{{ $BAL }}" required="required" type="text" class="form-control number" name="BAL" id="BAL" maxlength="15" placeholder="">
             </div>
          </div>
        </div>
      </div>
  <hr>
<nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">      
  <input type="submit"  class="btn btn-info" value="Continue">&nbsp;
  <a href="{{ route('driver') }}" class="btn btn-info">Cancel</a>
</nav>
</div>
</div>
</form>
</div>

@endsection