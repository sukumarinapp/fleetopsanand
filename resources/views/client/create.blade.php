@extends('layouts.app')

@section('content')
<style type="text/css">
.row-padded {
  background-color: #F7F7F7;
  padding: 1px;
  margin: 4px;
  border: 1px solid #DDD;
}
</style>
<div class="container-fluid">
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
                <li class="breadcrumb-item">File</li>
                <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Client</a></li>
                <li class="breadcrumb-item">Add Client</li>
              </ol>
            </div>
          </div>
        </div>
      </div> 
      <div class="card card-info">
       <div class="card-header">
         <h3 class="card-title">Add Client</h3>
       </div>
       <div class="card-body">
        @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
          <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong> {{ session('error') }} </strong>
        </div>
        @endif
        <form action="{{ route('client.store') }}" method="post" class="form-horizontal">
          @csrf 
          <div class="row">
           <div class="col-md-6">
            <div class="form-group row">
             <label for="name" class="col-sm-4 col-form-label"><span style="color:red">*</span>Company Name</label>
             <div class="col-sm-8">
              <input required="required" type="text" class="form-control" name="name" id="name" maxlength="200" placeholder="Company Name">
            </div>
          </div>

          <div class="form-group row">
           <label for="CZN" class="col-sm-4 col-form-label"><span style="color:red">*</span>Contact Name</label>
           <div class="col-sm-8">
            <input required="required" type="text" class="form-control" name="CZN" id="CZN" maxlength="50" placeholder="Contact Name">
          </div>
        </div>

        <div class="form-group row">
          <label for="UZA" class="col-sm-4 col-form-label"><span style="color:red">*</span>Address</label>
          <div class="col-sm-8">
            <textarea  required="required" class="form-control max200" name="UZA" id="UZA" rows="1" placeholder="Address"></textarea>
          </div>
        </div>

        <div class="form-group row">
         <label for="UCN" class="col-sm-4 col-form-label"><span style="color:red">*</span>Contact Number</label>
         <div class="col-sm-8">
          <input required="required" type="text" class="form-control number" name="UCN" id="UCN" maxlength="15" placeholder="Contact Number"><span id="dupContact" style="color:red"></span>
          <!-- <input onkeyup="duplicateUserContact(0)" required="required" type="text" class="form-control number" name="UCN" id="UCN" maxlength="15" placeholder="Contact Number"><span id="dupContact" style="color:red"></span> -->
        </div>
      </div>

      <div class="form-group row">
       <label for="email" class="col-sm-4 col-form-label"><span style="color:red">*</span>Email</label>
       <div class="col-sm-8">
        <input onkeyup="duplicateEmail(0)" required="required" type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
        <span id="dupemail" style="color:red"></span>
      </div>
    </div>

    <div class="form-group row">
     <label for="password" class="col-sm-4 col-form-label"><span style="color:red">*</span>Password</label>
     <div class="col-sm-8">
      <input value="{{ random_int(100000, 999999) }}"required="required" type="text" class="form-control" name="password" id="password" maxlength="20" placeholder="Password">
    </div>
  </div>  
</div>

<div class="col-md-6">

  <div class="form-group row">
    <label for="parent_id" class="col-sm-4 col-form-label"><span style="color:red">*</span>Account Manager2</label>
    <div class="col-sm-8">
      <select name="parent_id" id="parent_id" required="required" class="form-control select" style="width: 100%;">
        @if(Auth::user()->id != 1)
        <option value="{{ Auth::user()->id }}" >{{ Auth::user()->UAN }} {{ Auth::user()->name }} {{ Auth::user()->UZS }}</option>
        @endif
        @foreach($managers as $manager)
        <option value="{{ $manager->id }}" >{{ $manager->UAN }} {{ $manager->name }} {{ $manager->UZS }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="form-group row">
    <label for="CMT" class="col-sm-4 col-form-label">Account Type</label>
    <div class="col-sm-8">
      <select name="CMT" id="CMT" required="required" class="form-control" style="width: 100%;">
        <option value="B" selected="selected">Bank Account</option>
        <option value="A">Mobile Money</option>
      </select>
    </div>
  </div>

  <div class="form-group row">
    <label id="CMALBL" for="CMA" class="col-sm-4 col-form-label">Account Name</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="CMA" id="CMA" maxlength="50" placeholder="Account Name">
    </div>
  </div>

  <div class="form-group row">
    <label id="CMNLBL" for="CMN" class="col-sm-4 col-form-label">Account Number</label>
    <div class="col-sm-8">
      <input type="text" class="form-control number" name="CMN" id="CMN" maxlength="15" placeholder="Account Number">
    </div>
  </div>

  

  <div class="form-group row">
    <label id="CBKLBL" for="CBK" class="col-sm-4 col-form-label">Bank Name</label>
    <div class="col-sm-8" id="telecom_div">
      <input type='text' class='form-control' name='CBK' id='CBK' maxlength='50' placeholder='Bank Name'>
    </div>
  </div>
  

  <div class="form-group row">
    <label id="CMBLBL" for="CMB" class="col-sm-4 col-form-label">Account Branch</label>
    <div class="col-sm-8" id="branch_div">
      <input type='text' class='form-control' name='CMB' id='CMB' maxlength='50' placeholder='Account Branch'>
    </div>
  </div>
</div>
</div>
<hr>
<div class="form-group row">
  <div class="col-sm-6">
    <div class="form-check">
      <input value="1" type="checkbox" name="UTV" class="form-check-input" id="UTV">
      <label class="form-check-label text-success" for="UTV"><b>Activate Account</b></label>
    </div>
  </div>
  <div class="col-sm-6 pull-right" >
   <div class="form-check" style="float: right !important">
    <input type="checkbox" class="form-check-input" name="sms" id="sms">
    <label class="form-check-label" for="sms"><b>Send Login Credentials</b></label>
  </div> 
</div>

</div>
<div class="card-footer">
 @if(Auth::user()->usertype == "Admin" || Auth::user()->BPH == true) 
 <button type="button" class="btn btn-outline-primary float-right" data-toggle="modal" data-target="#modal-default"><i class="nav-icon fas fa-cog"></i> Client Settings
 </button>
 @endif
</div>

<div class="form-group row">
 <div class="col-md-12 text-center">
  <input id="save" required="required" class="btn btn-info"
  type="submit"
  name="submit" value="Save"/>
  <a href="{{ route('client.index') }}" class="btn btn-info">Back</a>
</div>
</div>	
<div class="modal fade" id="modal-default">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title">Manage Client Settings</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row row-padded">
          <label class="form-check-label col-sm-11 " for="RBA">RH Business Application.</label>
          <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1">
            <input name="RBA" type="checkbox" class="custom-control-input" id="RBA">
            <label class="custom-control-label" for="RBA"></label>
          </div> 
        </div>

        <div class="row row-padded">
          <label class="form-check-label col-sm-11" for="RBA1">Notify Car owner when driver cash declared is short.</label>
          <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1">
            <input name="RBA1" type="checkbox" class="custom-control-input" id="RBA1">
            <label class="custom-control-label" for="RBA1"></label>
          </div>  
        </div>

        <div class="row row-padded">
          <label class="form-check-label col-sm-11" for="RBA2">Notify Car owner about wastage (Offline Trips) and Fuel Consumed.</label>
          <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1">
            <input name="RBA2" type="checkbox" class="custom-control-input" id="RBA2">
            <label class="custom-control-label" for="RBA2"></label>
          </div> 
        </div>

        <div class="row row-padded">
          <label class="form-check-label col-sm-11" for="RBA3">Notify Driver about wastage (Offline Trips) and Fuel Consumed.</label>
          <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1">
            <input name="RBA3" type="checkbox" class="custom-control-input" id="RBA3">
            <label class="custom-control-label" for="RBA3"></label>
          </div>  
        </div>

        <div class="row row-padded">
          <label class="form-check-label col-sm-11" for="RBA4">Vehicle Fueling (Activate Fueler Function).</label>
          <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1">
            <input name="RBA4" type="checkbox" class="custom-control-input" id="RBA4">
            <label class="custom-control-label" for="RBA4"></label>
          </div>  
        </div>

        <div class="row row-padded">
          <div class="custom-control custom-radio col-sm-1"></div>
          <div class="custom-control custom-radio col-sm-1">
            <input value="Own Vehicles Only"  name="RBA4A" type="radio" id="RBA4A">
          </div> 
          <label class="form-check-label col-sm-10" for="RBA4A">Own Vehicles Only</label>
        </div>

        <div class="row row-padded">
          <div class="custom-control custom-radio col-sm-1"></div>
          <div class="custom-control custom-radio col-sm-1">
            <input value="All Vehicles" name="RBA4A" type="radio" id="RBA4B">
          </div> 
          <label class="form-check-label col-sm-10" for="RBA4B">All Vehicles</label>
        </div>

        <div class="row row-padded">
          <label class="form-check-label col-sm-11" for="BPJ">Can Manage Workflows.</label>
          <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-1">
            <input name="BPJ" type="checkbox" class="custom-control-input" id="BPJ">
            <label class="custom-control-label" for="BPJ"></label>
          </div> 
        </div>

        <div class="row row-padded">
          <div class="icheck-success d-inline col-sm-1"></div>
          <div class="icheck-success d-inline col-sm-1">
            <input name="BPJ1" type="checkbox" id="BPJ1">
          </div> 
          <label class="form-check-label col-sm-10" for="BPJ1">Perform Driver Sales Auditing.</label>
        </div>

        <div class="row row-padded">
          <div class="icheck-success d-inline col-sm-1"></div>
          <div class="icheck-success d-inline col-sm-1">
            <input name="BPJ2" type="checkbox" id="BPJ2">
          </div> 
          <label class="form-check-label col-sm-10" for="BPJ2">Override Blocked/Immobilized Vehicle.</label>
        </div>
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Confirm</button>
      </div>
    </div>
  </div> 
  @endsection
@push('page_scripts')
<script>
  $(document).ready(function(){
    $('.select2').select2({
      theme: 'bootstrap4'
    });
  });
</script>
@endpush