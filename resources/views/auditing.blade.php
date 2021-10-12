@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <form action="{{ route('auditingsave') }}" method="post">
    @csrf
    <input type="hidden" name="VID" value="{{ $vehicle->id }}">
    <input type="hidden" name="UAN" value="{{ $vehicle->UAN }}">
    <input type="hidden" name="CAN" value="{{ $vehicle->CAN }}">
    <input type="hidden" name="VNO" value="{{ $vehicle->VNO }}">
    <input type="hidden" name="RCN" value="{{ $vehicle->RCN }}">
    <input type="hidden" name="RHN" value="{{ $vehicle->PLF }}">
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
                  <li class="breadcrumb-item">Auditing</li>
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
                <h4 class="m-0"> </h4>
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
                    <div class="col-sm-3"><b>RH Platform</b></div>
                    <div class="col-sm-1"><b>:</b></div>
                    <div class="col-sm-8">{{ $vehicle->RHN }}</div>
                  </div>

                </form>
              </div>
            </div>
            <div class="col-6 text-center d-flex align-items-center justify-content-center">
              <div class="card-body">
                <h4 style=" border: 1px solid grey;padding: 25px 25px 25px 25px;">{{ $vehicle->DNM }}  {{ $vehicle->DSN }}</h4>
                <br>
                <div class="form-group row">
                 <label for="name" class="col-sm-4 col-form-label"><span style="color:red">*</span>Sales Earnings:</label>
                 <div class="col-sm-8">
                  <input required="required" type="text" class="form-control number" name="SPF" id="SPF" maxlength="10" placeholder="Sales Earnings">
                </div>
              </div>
              <div class="form-group row">
               <label for="name" class="col-sm-4 col-form-label"><span style="color:red">*</span>Cash Collected:</label>
               <div class="col-sm-8">
                <input required="required" type="text" class="form-control number" name="RMT" id="RMT" maxlength="10" placeholder="Cash Collected">
              </div>
            </div>
            <div class="form-group row">
             <label for="name" class="col-sm-4 col-form-label"><span style="color:red">*</span>No of Trips:</label>
             <div class="col-sm-8">
              <input required="required" type="text" class="form-control number" name="TPF" id="TPF" maxlength="3" placeholder="No of Trips">
            </div>
          </div>
          <div class="form-group row">
            <div class="form-check">
              <input type="checkbox" value="1" name="rhvisibility" class="form-check-input" id="rhvisibility">
              <label for="rhvisibility" class="form-check-label col-sm-8"><b>Driver cannot be seen on RH platform?</b></label>
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
