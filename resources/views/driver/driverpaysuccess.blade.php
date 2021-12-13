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
    <div class="card-body">
       <p>Thank you for your submission.Please check your phone for the cash release prompt. Upon receipt of cash, we will confirm with a message shortly after.</p>
    </div>
    <nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">
      <a href="{{ route('driver') }}" class="btn btn-info">Cancel</a>
    </nav>
  </div>
</div>
@endsection 