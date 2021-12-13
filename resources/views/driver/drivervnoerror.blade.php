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
  <div class="card card-danger">
    <div class="card-header">
      <h3 class="card-title">Vehicle Not Found!</h3>
    </div>
    <div class="card-body">
       <p>The vehicle Reg. No inputted was not found or vehicle is not active in our system. Please check and try again.</p>
    </div>
    <nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">      
          <a href="{{ route('drivervno') }}" class="btn btn-info">Retry</a>&nbsp;
          <a href="{{ route('driver') }}" class="btn btn-info">Cancel</a>
      </nav>
  </div>
</div>
@endsection 