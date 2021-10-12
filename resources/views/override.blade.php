@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <form action="{{ route('saveoverride') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-md-12">
       <div class="content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('workflow') }}">Workflow Manager</a></li>
                <li class="breadcrumb-item">Override</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Workflow: Sales Declaration Enforcement</h3>
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
              <!-- <h4 class="m-0"> Workflow: Sales Declaration Enforcement</h4> -->
              <h5 class="m-0" style="text-align: right;">
                @if($vehicle->DES == "A3")
                Override - Vehicle Buzzer On
                @else
                Override - Vehicle Blocked
                @endif
                &nbsp;&nbsp;<img src="{{ URL::to('/') }}/images/car.png"></h5>
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
              <br>
              <br>
              <div class="form-group">
                <form>
                 <div class="row">
                  <div class="col-sm-3"><b>Account Number</b></div>
                  <div class="col-sm-1"><b>:</b></div>
                  <div class="col-sm-8">{{ $vehicle->CAN }}</div>
                  <div class="col-sm-3"><b>Account Name</b></div>
                  <div class="col-sm-1"><b>:</b></div>
                  <div class="col-sm-8">{{ $vehicle->name }}</div>
                  <div class="col-sm-3"><b>Assigned Vehicle</b></div>
                  <div class="col-sm-1"><b>:</b></div>
                  <div class="col-sm-8">{{ $vehicle->VNO }}</div>
                </div>

              </form>
            </div>

          </div>
          <div class="col-6 text-center d-flex align-items-center justify-content-center">
            <div class="">
              <h4 style=" border: 1px solid grey;padding: 25px 25px 25px 25px;">{{ $vehicle->DNM }}  {{ $vehicle->DSN }}</h4>
            </div>
          </div>
          <div style=" border: 1px solid red;padding: 25px 25px 25px 25px;">
            <h5 style="text-align: center;color: red;">WARNING</h5>

            <p>The vehicle immobilization system (P-CS System) is meant to enforce sales declaration and cash remittance by the driver. This vehicle was buzzer on or blocked because the driver failed to either declare sales or surrender full cash collected from passengers. Before you proceed to unblock the vehicle, lease be sure that you have checked with the driver first. By inputting your username and password below you will override the immobilization system and the vehicle can move again.</p>

          </div>
          <div class="container-fluid">
            <div class="card-body">
              <input type="hidden" name="CAN" value="{{ $vehicle->CAN }}">
              <input type="hidden" name="VNO" value="{{ $vehicle->VNO }}">
              <input type="hidden" name="TSM" value="{{ $vehicle->TSM }}">
              <input type="hidden" name="VID" value="{{ $vehicle->id }}">
              <input type="hidden" name="WCI" value="{{ $vehicle->DNM }} {{ $vehicle->DSN }}">
              <div class="form-group row">
               <label for="UAN" class="col-sm-3 col-form-label"><span style="color:red">*</span>Username</label>
               <div class="col-sm-5">
                <input required="required" type="text" class="form-control" name="UAN" id="UAN" maxlength="30" placeholder="Userame">
              </div>
            </div>
            <div class="form-group row">
             <label for="password" class="col-sm-3 col-form-label"><span style="color:red">*</span>Password</label>
             <div class="col-sm-5">
              <input required="required" type="password" class="form-control" name="password" id="password" maxlength="30" placeholder="Password">
            </div>
          </div>
          <div class="form-group row">
           <label for="OAC" class="col-sm-3 col-form-label"><span style="color:red">*</span>Comments</label>
           <div class="col-sm-9">
            <input required="required" type="text" class="form-control" name="OAC" id="OAC" maxlength="50" placeholder="Comments">
          </div>
        </div>

        <div class="form-group row">
         <div class="col-md-12 text-center">
          <input required="required" class="btn btn-primary"
          type="submit"
          name="submit" value="Save"/>
          <a href="{{ route('workflow') }}" class="btn btn-primary ">Back</a>
        </div>

      </div>
    </div>
  </div>
</form>
</div>


@endsection
@push('page_css')
<style>
.borderless td, .borderless th {
  border: none;
}
</style>
@endpush
