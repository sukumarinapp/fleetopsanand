@extends('layouts.driver')
@section('content')
<div class="container" >
  <div style="padding: 50px; height: 200px;"></div>
  <div class="row justify-content-center">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <form method="post" action="{{ route('driverpaysave') }}">
        @csrf
        <input type="hidden" id="VNO" name="VNO" value="{{ $sales['VNO'] }}">
        <input type="hidden" id="DCN" name="DCN" value="{{ $sales['DCN'] }}">
        <input type="hidden" id="plat_id_hidden" name="plat_id_hidden" value="{{ $sales['plat_id_hidden'] }}">
        <input type="hidden" id="earning_hidden" name="earning_hidden" value="{{ $sales['earning_hidden'] }}">
        <input type="hidden" id="cash_hidden" name="cash_hidden" value="{{ $sales['cash_hidden'] }}">
        <input type="hidden" id="trips_hidden" name="trips_hidden" value="{{ $sales['trips_hidden'] }}">
        <input type="hidden" id="SSR" name="SSR" value="{{ $sales['SSR'] }}">
        <input type="submit" value="Pay Now" class="btn btn-success btn-large" />
       </form>
      </div>
    </div>
  <nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">      
      <a href="http://fleetops.com">Powered by Fleetops</a>
  </nav>
</div>
@endsection