@extends('layouts.driver')
@section('content')
<div class="container" >
  <div style="padding: 50px; height: 200px;"></div>
  <div class="row justify-content-center">
    <div class="col-md-12 text-center">
      <h3>Menu</h3>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-12">
        @if ($time["current_time"] > .15)
          <a href="{{ route('drivervno') }}" type="button" class="btn btn-block btn-primary btn-lg text-center">Declare Sales</a>
        @endif
      </div>
    </div>
  <nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">      
      <a href="http://fleetops.com">Powered by Fleetops</a>
  </nav>
</div>
@endsection