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
      <h3 class="card-title">Thank you for your submission. Please check your phone for the cash release prompt. Upon receipt of cash, we will confirm with a message shortly after.</h3>
    </div>
    <div class="card-body">
       
    </div>
    <nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">      
          <a href="{{ route('driver') }}" class="btn btn-info">OK</a>&nbsp;
         
      </nav>
  </div>
</div>
@endsection 