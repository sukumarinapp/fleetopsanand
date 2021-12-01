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
                      <li class="breadcrumb-item">Edit Client</li>
                  </ol>
              </div>
          </div>
      </div>
  </div>
  <div class="card card-info">
     <div class="card-header">
         <h3 class="card-title">Edit Client</h3>
     </div>
     <div class="card-body">
        @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
            <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong> {{ session('error') }} </strong>
        </div>
        @endif
        <form action="{{ route('client.update',$user->id) }}" method="post" class="form-horizontal">
            @csrf 
            @method('PUT')

            <div class="row">
               <div class="col-md-6">
                  <div class="form-group row">
                    <label for="UAN" class="col-sm-4 col-form-label">Client Account No</label>
                    <div class="col-sm-8">
                        <input readonly="readonly" value="{{ $user->UAN }}" required="required" type="text" class="form-control" name="UAN" id="UAN" maxlength="50" >
                    </div>
                </div>

                <div class="form-group row">
                   <label for="name" class="col-sm-4 col-form-label"><span style="color:red">*</span>Company Name</label>
                   <div class="col-sm-8">
                    <input value="{{ $user->name }}" required="required" type="text" class="form-control" name="name" id="name" maxlength="200" placeholder="Company Name">
                </div>  
            </div>

            <div class="form-group row">
                <label for="CZN" class="col-sm-4 col-form-label"><span style="color:red">*</span>Contact Name</label>
                <div class="col-sm-8">
                    <input value="{{ $user->CZN }}" required="required" type="text" class="form-control" name="CZN" id="CZN" maxlength="50" placeholder="Contact Name">
                </div>
            </div>

            <div class="form-group row">
               <label for="UZA" class="col-sm-4 col-form-label"><span style="color:red">*</span>Address</label>
               <div class="col-sm-8">
                <textarea required="required" class="form-control max200" name="UZA" id="UZA" rows="1" placeholder="Address">{{ $user->UZA }}</textarea>
            </div>
        </div>

        <div class="form-group row">
           <label for="UCN" class="col-sm-4 col-form-label"><span style="color:red">*</span>Contact Number</label>
           <div class="col-sm-8">
            <input value="{{ $user->UCN }}" required="required" type="text" class="form-control number" name="UCN" id="UCN" maxlength="15" placeholder="Contact Number">
            <span id="dupContact" style="color:red"></span>
            <!-- <input onkeyup="duplicateUserContact({{ $user->UCN }})"  value="{{ $user->UCN }}" required="required" type="text" class="form-control number" name="UCN" id="UCN" maxlength="15" placeholder="Contact Number">
            <span id="dupContact" style="color:red"></span> -->
        </div>
    </div>

    <div class="form-group row">
      <label for="email" class="col-sm-4 col-form-label"><span style="color:red">*</span>Email</label>
      <div class="col-sm-8">
        <input onkeyup="duplicateEmail(this.value)" value="{{ $user->email }}" required="required" type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
        <span id="dupemail" style="color:red"></span>
    </div>
</div>

<div class="form-group row">
    <label for="password" class="col-sm-4 col-form-label"><span style="color:red">*</span>Reset Password</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="password" id="password" maxlength="20" placeholder="New Password">
    </div>
</div>
</div>
<div class="col-md-6">

   <div class="form-group row">
    <label for="parent_id" class="col-sm-4 col-form-label"><span style="color:red">*</span>Account Manager</label>
    <div class="col-sm-8">
      <select name="parent_id" id="parent_id" required="required" class="form-control select2" style="width: 100%;">
        @if(Auth::user()->id != 1)
        <option {{ (($user->parent_id == Auth::user()->id) ? "selected":"") }} value="{{ Auth::user()->id }}" >{{ Auth::user()->UAN }} {{ Auth::user()->name }} {{ Auth::user()->UZS }}</option>
        @endif
        @foreach($managers as $manager)
        <option {{ ($user->parent_id == $manager->id ? "selected":"") }} value="{{ $manager->id }}" >{{ $manager->UAN }} {{ $manager->name }} {{ $manager->UZS }}</option>
        @endforeach
    </select>
    
</div>
</div>

<div class="form-group row">
    <label for="CMT" class="col-sm-4 col-form-label">Account Type</label>
    <div class="col-sm-8">
      <select name="CMT" id="CMT" required="required" class="form-control" style="width: 100%;">
       <option {{ ($user->CMT == "B" ? "selected":"") }} value="B" >Bank Account</option>
       <option {{ ($user->CMT == "A" ? "selected":"") }} value="A" >Mobile Money</option>
   </select>
</div>
</div>

<div class="form-group row">           
    <label id="CMALBL" for="CMA" class="col-sm-4 col-form-label">{{ ($user->CMT == "B" ? "Account Name":"Name") }}</label>
    <div class="col-sm-8">
        <input value="{{ $user->CMA }}" type="text" class="form-control" name="CMA" id="CMA" maxlength="50" placeholder='{{ ($user->CMT == "B" ? "Account Name":"Name") }}'>
    </div>
</div>

<div class="form-group row">
 <label id="CMNLBL" for="CMN" class="col-sm-4 col-form-label">{{ ($user->CMT == "B" ? "Account Number":"Mobile Number") }}</label>
 <div class="col-sm-8">
    @php
    if($user->CMT == "B"){
      echo "<input value='$user->CMN' type='text' class='form-control number' name='CMN' id='CMN' maxlength='15' placeholder='Account Number'>";
  }else{
      echo "<input value='$user->CMN' type='text' class='form-control' name='CMN' id='CMN' maxlength='15' placeholder='Mobile Number'>";
  }
  @endphp
</div>
</div>

<div class="form-group row">
   <label id="CBKLBL" for="CBK" class="col-sm-4 col-form-label">{{ ($user->CMT == "B" ? "Bank Name":"Telecom Provider") }}</label>
   <div class="col-sm-8" id="telecom_div">
    @php
    if($user->CMT == "B"){
      echo "<input value='$user->CBK' type='text' class='form-control' name='CBK' id='CBK' maxlength='50' placeholder='Bank Name'>";
  }else{
      echo "<select class='form-control' name='CMB' id='CMB'>";
          echo "<option ";
          if($user->CMB=="AIRTELTIGO") echo " selected ";
          echo " value='AIRTELTIGO'>AIRTELTIGO</option>";
          echo "<option ";
          if($user->CMB=="MTN") echo " selected ";
          echo " value='MTN'>MTN</option>";
          echo "<option ";
          if($user->CMB=="VODAFONE") echo " selected ";
          echo " value='VODAFONE'>VODAFONE</option>";
      echo "</select>";
  }
  @endphp
</div>
</div>


<div class="form-group row">
    <label {{ $user->CMT == 'A' ? "style=display:none" : '' }} id="CMBLBL" for="CMB" class="col-sm-4 col-form-label">Account Branch</label>
    <div {{ $user->CMT == 'A' ? "style=display:none" : '' }} class="col-sm-8" id="branch_div">
      <input value="{{ $user->CMT == 'B' ? $user->CMB : '' }}" type='text' class='form-control' name='CMBR' id='CMBR' maxlength='50' placeholder='Account Branch'>
  </div>
</div>


</div>
</div>
<hr>
<div class="form-group row">
    <div class="col-sm-6">
      <div class="form-check">
        <input 
        @php
        if($deactivate == 0 && $user->UTV == "1"){
            echo "onclick='return false'";
        }
        @endphp
         {{ ($user->UTV == "1" ? "checked":"") }} value="1" type="checkbox" name="UTV" class="form-check-input" id="UTV">
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
      name="submit" value="Update"/>
      <a href="{{ route('manager.index') }}" class="btn btn-info">Back</a>
  </div>
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
            <label class="form-check-label col-sm-8 " for="RBA">RH Business Application.</label>
            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-2">
              <input {{ ($user->RBA == "1" ? "checked":"") }} name="RBA" type="checkbox" class="custom-control-input" id="RBA">
              <label class="custom-control-label" for="RBA"></label>
          </div> 
      </div>

      <div class="row row-padded">
        <label class="form-check-label col-sm-8" for="RBA1">Notify Car owner when driver cash declared is short.</label>
        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-2">
          <input {{ ($user->RBA1 == "1" ? "checked":"") }} name="RBA1" type="checkbox" class="custom-control-input" id="RBA1" >
          <label class="custom-control-label" for="RBA1"></label>
      </div>  
  </div>

  <div class="row row-padded">
    <label class="form-check-label col-sm-8" for="RBA2">Notify Car owner about wastage (Offline Trips) and Fuel Consumed.</label>
    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-2">
      <input {{ ($user->RBA2 == "1" ? "checked":"") }} name="RBA2" type="checkbox" class="custom-control-input" id="RBA2" >
      <label class="custom-control-label" for="RBA2"></label>
  </div> 
</div>

<div class="row row-padded">
    <label class="form-check-label col-sm-8" for="RBA3">Notify Driver about wastage (Offline Trips) and Fuel Consumed.</label>
    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-2">
      <input {{ ($user->RBA3 == "1" ? "checked":"") }} name="RBA3" type="checkbox" class="custom-control-input" id="RBA3" >
      <label class="custom-control-label" for="RBA3"></label>
  </div>  
</div>

<div class="row row-padded">
    <label class="form-check-label col-sm-8" for="RBA4">Vehicle Fueling (Activate Fueler Function).</label>
    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-2">
      <input {{ ($user->RBA4 == "1" ? "checked":"") }} name="RBA4" type="checkbox" class="custom-control-input" id="RBA4" >
      <label class="custom-control-label" for="RBA4"></label>
  </div>  
</div>

<div class="row row-padded">
    <div class="custom-control custom-radio col-sm-1"></div>
    <div class="custom-control custom-radio col-sm-1">
        <input {{ ($user->RBA4A == "Own Vehicles Only" || $user->RBA4A == "" ? "checked":"") }} value="Own Vehicles Only"  name="RBA4A" type="radio" id="RBA4A">
    </div> 
    <label class="form-check-label col-sm-6" for="RBA4A">Own Vehicles Only</label>
</div>

<div class="row row-padded">
    <div class="custom-control custom-radio col-sm-1"></div>
    <div class="custom-control custom-radio col-sm-1">
        <input {{ ($user->RBA4A == "All Vehicles" ? "checked":"") }} value="All Vehicles" name="RBA4A" type="radio" id="RBA4B">
    </div> 
    <label class="form-check-label col-sm-6" for="RBA4B">All Vehicles</label>
</div>

<div class="row row-padded">
    <label class="form-check-label col-sm-8" for="BPJ">Can Manage Workflows.</label>
    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success col-sm-2">
      <input {{ ($user->BPJ == "1" ? "checked":"") }} name="BPJ" type="checkbox" class="custom-control-input" id="BPJ" >
      <label class="custom-control-label" for="BPJ"></label>
  </div> 
</div>

<div class="row row-padded">
    <div class="icheck-success d-inline col-sm-1"></div>
    <div class="icheck-success d-inline col-sm-1">
        <input {{ ($user->BPJ1 == "1" ? "checked":"") }} name="BPJ1" type="checkbox" id="BPJ1">
    </div> 
    <label class="form-check-label col-sm-10" for="BPJ1">Perform Driver Sales Auditing.</label>
</div>

<div class="row row-padded">
    <div class="icheck-success d-inline col-sm-1"></div>
    <div class="icheck-success d-inline col-sm-1">
        <input {{ ($user->BPJ2 == "1" ? "checked":"") }} name="BPJ2" type="checkbox" id="BPJ2">
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