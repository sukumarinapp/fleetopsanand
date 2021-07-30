@extends('layouts.driver')
@section('content')
<div class="container" >
  <form method="post" action="{{ route('driverpaysave') }}">
    @csrf
  <div style="padding: 50px; height: 200px;"></div>
  <div class="row justify-content-center">
      <div class="col col-md-6">
        <input type="hidden" id="VNO" name="VNO" value="{{ $sales['VNO'] }}">
        <input type="hidden" id="DCN" name="DCN" value="{{ $sales['DCN'] }}">
        <input type="hidden" id="VBM" name="VBM" value="{{ $sales['VBM'] }}">
        <input type="hidden" id="plat_id_hidden" name="plat_id_hidden" value="{{ $sales['plat_id_hidden'] }}">
        <input type="hidden" id="earning_hidden" name="earning_hidden" value="{{ $sales['earning_hidden'] }}">
        <input type="hidden" id="cash_hidden" name="cash_hidden" value="{{ $sales['cash_hidden'] }}">
        <input type="hidden" id="trips_hidden" name="trips_hidden" value="{{ $sales['trips_hidden'] }}">
        <input type="hidden" id="SSR" name="SSR" value="{{ $sales['SSR'] }}">
        <select name="options" id="options" required="required" class="form-control" style="width: 100%;">
          <option value="">Select Mobile Wallet</option>
        @php
          foreach($options as $item){
            echo "<option value='".$item->provider."' >".$item->name."</option>";
          }
        @endphp
        </select>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-12">
        <br>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col col-md-12 text-center">
        <input type="submit" value="Pay GHC {{ $sales['cash_hidden'] }}" class="btn btn-success btn-large" />
      </div>
    </div>
  <nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">
      <a href="http://fleetops.com">Powered by Fleetops</a>
  </nav>
  </form>
</div>
@endsection