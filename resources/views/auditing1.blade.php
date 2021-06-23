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
              <h6 class="m-0" style="text-align: right;">Sunday, March, 25, 2021</h6>
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
                  <th style="width:50%">Account No:</th>
                  <td></td>
                </tr>
                <tr>
                  <th>Account Name:</th>
                  <td></td>
                </tr>
                <tr>
                  <th>Assigned Vehicle:</th>
                  <td></td>
                </tr> 
                 <tr>
                  <th>RH Platform In Use:</th>
                  <td></td>
                </tr>

              </table>
            </div>
          </div>
          <div class="col-6 text-center d-flex align-items-center justify-content-center">
            <div class="card-body">
              <h4 style=" border: 1px solid grey;padding: 25px 25px 25px 25px;">JOHN DOE</h4>
              <br>
              <div class="form-group row">
               <label for="name" class="col-sm-4 col-form-label"><span style="color:red">*</span>Sales Earnings:</label>
               <div class="col-sm-8">
                <input required="required" type="text" class="form-control" name="name" id="name" maxlength="50" placeholder="Userame">
              </div>
            </div>
            <div class="form-group row">
               <label for="name" class="col-sm-4 col-form-label"><span style="color:red">*</span>Cash Collected:</label>
               <div class="col-sm-8">
                <input required="required" type="text" class="form-control" name="name" id="name" maxlength="50" placeholder="Userame">
              </div>
            </div>
           <div class="form-group row">
               <label for="name" class="col-sm-4 col-form-label"><span style="color:red">*</span>Cash Collected::</label>
               <div class="col-sm-8">
                <input required="required" type="text" class="form-control" name="name" id="name" maxlength="50" placeholder="Userame">
              </div>
            </div>
            <div class="form-group row">
               <label for="name" class="form-check-label col-sm-8"><b>Driver cannot be seen on RH platform:</b></label>
               <div class="icheck-success d-inline">
              <input required="required" type="checkbox"  name="name" id="name">
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
          <a href="{{ route('auditing') }}" class="btn btn-primary ">Cancel</a>
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
