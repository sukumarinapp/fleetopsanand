@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Sales Auditing</h3>
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
              <h5 class="m-0" style="text-align: right;">Driver Sales Auditing
                <img src="{{ URL::to('/') }}/images/sales.png"></h5>
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
              <u> Client</u>
            </h3>
            <div class="table borderless">
              <table class="table">
                <tr>
                  <th>Account No: {{ $vehicle->CAN }}</th>
                </tr>
                <tr>
                  <th>Account Name: {{ $vehicle->name }}</th>
                </tr>
                <tr>
                  <th>Assigned Vehicle: {{ $vehicle->VNO }}</th>
                  <td></td>
                </tr> 
                 <tr>
                  <th>RH Platform In Use: {{ $vehicle->RHN }}</th>
                  <td></td>
                </tr>

              </table>
            </div>
          </div>
          <div class="col-6 text-center d-flex align-items-center justify-content-center">
            <div class="card-body">
              <h4 style=" border: 1px solid grey;padding: 25px 25px 25px 25px;">{{ $vehicle->DNM }}  {{ $vehicle->DSN }}</h4>
              <br>
              <div class="form-group row">
               <label for="name" class="col-sm-4 col-form-label"><span style="color:red">*</span>Sales Earnings:</label>
               <div class="col-sm-8">
                <input required="required" type="text" class="form-control number" name="name" id="name" maxlength="10" placeholder="Sales Earnings">
              </div>
            </div>
            <div class="form-group row">
               <label for="name" class="col-sm-4 col-form-label"><span style="color:red">*</span>Cash Collected:</label>
               <div class="col-sm-8">
                <input required="required" type="text" class="form-control number" name="name" id="name" maxlength="10" placeholder="Cash Collected">
              </div>
            </div>
           <div class="form-group row">
               <label for="name" class="col-sm-4 col-form-label"><span style="color:red">*</span>No of Trips:</label>
               <div class="col-sm-8">
                <input required="required" type="text" class="form-control number" name="name" id="name" maxlength="3" placeholder="No of Trips">
              </div>
            </div>
            <div class="form-group row">
              <div class="form-check">
                  <input type="checkbox" name="check1" class="form-check-input" id="check1">
                  <label for="check1" class="form-check-label col-sm-8"><b>Driver cannot be seen on RH platform:</b></label>
                </div>
              </div>
            </div>
            </div>
          </div>

          <div class="container-fluid">
            <div class="card-body">

        <div class="form-group row">
         <div class="col-md-12 text-center">
          <input required="required" class="btn btn-primary"
          type="submit"
          name="submit" value="Save"/>
          <a href="{{ route('auditsrch') }}" class="btn btn-primary ">Cancel</a>
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