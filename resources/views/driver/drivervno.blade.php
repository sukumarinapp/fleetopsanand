@extends('layouts.driver')
@section('content')
<div class="container" >
  <div class="card card-default">
    <div class="card-body">
      <form method="post" action="{{ route('drivervnovalid') }}">
        @csrf
      <div class="row justify-content-center">
        <div class="col-md-12 text-center">
          <a href="#" class="navbar-brand">
                <img src="{{ URL::to('/') }}/images/fleetopslogo.png" alt="AdminLTE Logo">
            </a>
          <h3 style="color: lightgray">Authenticate Driver</h3>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-12">
          <p>Input the vehicle registration number and your phone number. Please be clear about your entries. You are responsible for your own mistakes. Thank you.</p>
        </div> 
      </div>
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="form-group row">
             <label for="VNO" class="col-sm-3 col-form-label">Vehicle Reg No:</label>
             <div class="col-sm-9">
              <input required="required" type="text" class="form-control" name="VNO" id="VNO" maxlength="15" placeholder="Vehicle Registration No">
              <p>Enter registration number without any space or ‘-’ dash
                between the letters or numbers. Example for GW 1234-20,
              input GW123420 or gw123420</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="form-group row">
             <label for="DCN" class="col-sm-3 col-form-label">Phone Number:</label>
             <div class="col-sm-9">
              <input required="required" type="text" class="form-control number" name="DCN" id="DCN" maxlength="15" placeholder="Phone Number">
              <p>Cash collection is done through mobile money on all
                networks. A collection note will be sent to the phone
                number you inputted. Please be sure it is the number you
              want to use then press ‘continue’.</p>
            </div>
          </div>
        </div>
      </div>
      <nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">      
          <input required="required" class="btn btn-info"
                type="submit" id="save" name="submit" value="Continue"/>&nbsp;
          <a href="{{ route('driver') }}" class="btn btn-info">Cancel</a>
      </nav>
    </form>
    </div>
  </div>
</div>
@endsection