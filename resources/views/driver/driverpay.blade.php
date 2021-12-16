@extends('layouts.driver')
@section('content')
<div class="container" >
  <div class="row justify-content-center">
   <div class="col-md-12 text-center">
    <a href="#" class="navbar-brand">
                <img src="{{ URL::to('/') }}/images/fleetopslogo.png" alt="AdminLTE Logo">
            </a>
    <h3 style="color: lightgray">Payment Options</h3>
  </div>
          </div>
  <form method="post" action="{{ route('driverpaysave') }}">
    @csrf
  <div style="padding: 50px; height: 100px;"></div>
  <div class="row justify-content-center">
        <input type="hidden" id="VNO" name="VNO" value="{{ $sales['VNO'] }}">
        <input type="hidden" id="DCN" name="DCN" value="{{ $sales['DCN'] }}">
        <input type="hidden" id="VBM" name="VBM" value="{{ $sales['VBM'] }}">
        <input type="hidden" id="plat_id_hidden" name="plat_id_hidden" value="{{ $sales['plat_id_hidden'] }}">
        <input type="hidden" id="earning_hidden" name="earning_hidden" value="{{ $sales['earning_hidden'] }}">
        <input type="hidden" id="cash_hidden" name="cash_hidden" value="{{ $sales['cash_hidden'] }}">
        <input type="hidden" id="trips_hidden" name="trips_hidden" value="{{ $sales['trips_hidden'] }}">
        <input type="hidden" id="SSR" name="SSR" value="{{ $sales['SSR'] }}">
      </div>
      <div class="row">
        @php
          foreach($options as $key => $item){
        @endphp    
            <div class="col-sm-12 col-md-4 text-center">
              <div class="custom-control custom-radio image-checkbox">
                  <input {{ $key == 0 ? "checked":"" }} value="{{ $item->provider }}" type="radio" class="custom-control-input" id="{{ $item->name }}" name="options">
                  <label class="custom-control-label" for="{{ $item->name }}">
                      <img width="120px" src="{{ $item->logo }}" alt="#" class="img-fluid">
                  </label>
              </div>
            </div>
        @php
          }
        @endphp
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
  </form>
</div>
@endsection