@extends('layouts.driver')
@section('content')
<div class="container" >
  <div class="row justify-content-center">
  <div class="col-md-12 text-center">
    <h3 style="color: lightgray">Declare Sales</h3>
  </div>
</div>
  <div class="card card-success">
    <div class="card-header">
      <h3 class="card-title">Sales Declaration Complete – Thank you!</h3>
    </div>
    <div class="card-body">
       <p>Thank you for a successful sales declaration.Fuel consumed for the sales declared and offline trips (if any) are being measured and shall be communicated to you in a separate message. Press ‘Ok’ to proceed.</p>
    </div>
    <nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">      
          <a href="#" class="btn btn-info">OK</a>&nbsp;
         
      </nav>
  </div>
</div>
@endsection 