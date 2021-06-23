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

          <div class="card-body row">
            <div class="col-md-1">
              <img src="{{ URL::to('/') }}/images/workflow.png" alt="User Image">
            </div>
            <div class="col-md-8">
              <h4 class="m-0"> Workflow: Sales Declaration Enforcement</h4>
              <h5 class="m-0" style="text-align: right;">Override - Vehicle Immobilized/Blocked <img src="{{ URL::to('/') }}/images/car.png"></h5>
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
            <div class="table borderless">
              <table class="table">
                <tr>
                  <th style="width:50%">Account No: {{ $vehicle->CAN }}</th>
                  <td></td>
                </tr>
                <tr>
                  <th>Account Name: {{ $vehicle->name }}</th>
                  <td></td>
                </tr>
                <tr>
                  <th>Assigned Vehicle:  {{ $vehicle->VNO }}</th>
                  <td></td>
                </tr>

              </table>
            </div>
          </div>
          <div class="col-6 text-center d-flex align-items-center justify-content-center">
            <div class="">
              <h4 style=" border: 1px solid grey;padding: 25px 25px 25px 25px;">{{ $vehicle->DNM }}  {{ $vehicle->DSN }}</h4>
            </div>
          </div>
          <div style=" border: 1px solid red;padding: 25px 25px 25px 25px;">
            <h5 style="text-align: center;color: red;">WARNING</h5>

            <p>The vehicle immobilization system (P-CS System) is meant to enforce sales declaration and cash remittance by the driver. This vehicle was immobilized or blocked because the driver failed to either declare sales or surrender full cash collected from passengers. Before you proceed to unblock the vehicle, lease be sure that you have checked with the driver first. By inputting your username and password below you will override the immobilization system and the vehicle can move again.</p>

          </div>
          <div class="container-fluid">
            <div class="card-body">

             <div class="form-group row">
               <label for="name" class="col-sm-3 col-form-label"><span style="color:red">*</span>Userame</label>
               <div class="col-sm-5">
                <input required="required" type="text" class="form-control" name="name" id="name" maxlength="50" placeholder="Userame">
              </div>
            </div>
            <div class="form-group row">
             <label for="UZS" class="col-sm-3 col-form-label"><span style="color:red">*</span>Password</label>
             <div class="col-sm-5">
              <input required="required" type="text" class="form-control" name="UZS" id="UZS" maxlength="50" placeholder="Password">
            </div>
          </div>
          <div class="form-group row">
           <label for="UZS" class="col-sm-3 col-form-label"><span style="color:red">*</span>Comments</label>
           <div class="col-sm-9">
            <input required="required" type="text" class="form-control" name="UZS" id="UZS" maxlength="50" placeholder="Comments">
          </div>
        </div>

        <div class="form-group row">
         <div class="col-md-12 text-center">
          <input required="required" class="btn btn-primary"
          type="submit"
          name="submit" value="Save"/>
          <a href="{{ route('workflow') }}" class="btn btn-primary ">Cancel</a>
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
