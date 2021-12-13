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
      <h3 class="card-title">Cash Declared is Incorrect!</h3>
    </div>
    <div class="card-body">
       <p>Further to our checks, the cash collected you have accounted for is incorrect. Please send remaining cash immediately else we shall be compelled to enforce the policy. The car owner has been notified of this issue accordingly.

       Press ‘Ok’ below to receive the cash release prompt. We will confirm with a receipt shortly after.</p>
    </div>
    <nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">      
          <a href="{{ route('driver') }}" class="btn btn-info">OK</a>&nbsp;
         
      </nav>
  </div>
</div>
@endsection 