@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">WorkFlow Manager</h3>
        </div>

        <div class="col-md-12">
         <div class="card card-info">
        @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
          <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong> {{ session('error') }} </strong>
        </div>
        @endif
        @if(session()->has('message'))
            <div class="alert alert-success alert-dismissable" style="margin: 15px;">
            <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong> {{ session('message') }} </strong>
          </div>
        @endif
          <div class="card-body row">
            <div class="col-md-1">
              <img src="{{ URL::to('/') }}/images/workflow.png" alt="User Image">
            </div>
            <div class="col-md-8">
              <h4 class="m-0"> Workflow: Sales Declaration Enforcement</h4>
              <h5 class="m-0" style="text-align: right;">Override - Vehicle Immobilized/Blocked <img src="{{ URL::to('/') }}/images/car1.png"></h5>
            </div>

            <div class="col-md-3">
              <h6 class="m-0" style="text-align: right;">{{ date("l M d Y")}}</br>{{ date("h:i A") }}</h6>
            </div>

            <div class="col-12">
             <div class="card-header">
             </div>
           </div>

           <div class="col-6">
             <h3 class="card-title">
              <br>
              Client
            </h3>
            <div class="table ">
              <table class="table">
                <tr>
                  <th style="width:50%">Account No: {{ $vehicle->CAN }}</th>
                </tr>
                <tr>
                  <th>Account Name: {{ $vehicle->name }}</th>
                </tr>
                <tr>
                  <th>Assigned Vehicle:  {{ $vehicle->VNO }}</th>
                  </tr>
              </table>
            </div>
          </div>
          <div class="col-6 text-center d-flex align-items-center justify-content-center">
            <div class="">
              <h4 style=" border: 1px solid grey;padding: 25px 25px 25px 25px;">{{ $vehicle->DNM }}  {{ $vehicle->DSN }}</h4>
            </div>
          </div>
      <div class="container-fluid">
        <div class="form-group row">
         <div class="col-md-12 text-center">
          <a href="{{ route('workflow') }}" class="btn btn-primary ">Back</a>
        </div>

      </div>
    </div>
  </div>
    </div>
</div>


@endsection
@push('page_css')
<style>
  .borderless td, .borderless th {
    border: none;
  }
</style>
@endpush
