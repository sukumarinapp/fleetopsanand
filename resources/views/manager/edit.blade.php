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
              <li class="breadcrumb-item"><a href="{{ route('manager.index') }}">User</a></li>
              <li class="breadcrumb-item">Edit User</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
			<div class="card-header">
			<h3 class="card-title">Edit User</h3>
			</div>
			<div class="card-body">
                @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
                        <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong> {{ session('error') }} </strong>
                    </div>
                @endif
                <form action="{{ route('manager.update',$user->id) }}" method="post" class="form-horizontal">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label for="UAN" class="col-sm-4 col-form-label">User Account No</label>
                    <div class="col-sm-8">
                        <input readonly="readonly" value="{{ $user->UAN }}" required="required" type="text" class="form-control" name="UAN" id="UAN" maxlength="50" >
                    </div>
                </div>
				<div class="form-group row">
					<label for="parent_id" class="col-sm-4 col-form-label"><span style="color:red">*</span>User Manager</label>
				<div class="col-sm-8">
                  <select name="parent_id" id="parent_id" required="required" class="form-control select2" style="width: 100%;">
                    @foreach($managers as $manager)
                      @if($manager->parent_id != $user->id && $manager->id != $user->id)  
                      <option data-settings="{{ $manager->BPA }},{{ $manager->BPB }},{{ $manager->BPC }},{{ $manager->BPD }},{{ $manager->BPE }},{{ $manager->BPF }},{{ $manager->BPG }},{{ $manager->BPH }},{{ $manager->BPI }},{{ $manager->BPJ }},{{ $manager->BPJ1 }},{{ $manager->BPJ2 }},{{ $manager->BPK }},{{ $manager->BPL }}" {{ (($user->parent_id == $manager->id) ? "selected":"") }} value="{{ $manager->id }}" >{{ $manager->UAN }} {{ $manager->name }} {{ $manager->UZS }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
                </div>
				<div class="form-group row">
					<label for="UJT" class="col-sm-4 col-form-label"><span style="color:red">*</span>Job Title</label>
					<div class="col-sm-8">
						<input value="{{ $user->UJT }}" required="required" type="text" class="form-control" name="UJT" id="UJT" maxlength="50" placeholder="Job Title">
					</div>
				</div>
				<div class="form-group row">
					<label for="name" class="col-sm-4 col-form-label"><span style="color:red">*</span>Name</label>
					<div class="col-sm-8">
						<input value="{{ $user->name }}" required="required" type="text" class="form-control" name="name" id="name" maxlength="50" placeholder="Name">
					</div>
				</div>
				<div class="form-group row">
					<label for="UZS" class="col-sm-4 col-form-label"><span style="color:red">*</span>Surname</label>
					<div class="col-sm-8">
						<input value="{{ $user->UZS }}" required="required" type="text" class="form-control" name="UZS" id="UZS" maxlength="50" placeholder="Surname">
					</div>
				</div>
				<div class="form-group row">
					<label for="UZA" class="col-sm-4 col-form-label"><span style="color:red">*</span>Address</label>
					<div class="col-sm-8">
						<textarea  required="required" class="form-control max200" name="UZA" id="UZA" rows="3" placeholder="Address">{{ $user->UZA }}</textarea>
					</div>
				</div>
				<div class="form-group row">
					<label for="UCN" class="col-sm-4 col-form-label"><span style="color:red">*</span>Contact Number</label>
					<div class="col-sm-4">
						<input value="{{ $user->UCN }}" required="required" type="text" class="form-control Number" name="UCN" id="UCN" maxlength="15" placeholder="Contact Number">
                        <!-- <input onkeyup="duplicateUserContact({{ $user->UCN }})"  value="{{ $user->UCN }}" required="required" type="text" class="form-control Number" name="UCN" id="UCN" maxlength="15" placeholder="Contact Number"> -->
					</div>
                    <div class="col-sm-4">
                        <span id="dupContact" style="color:red"></span>
                    </div>
				</div>
                <hr>
			    <div class="form-group row">
					<label for="email" class="col-sm-4 col-form-label"><span style="color:red">*</span>Email</label>
					<div class="col-sm-4">
						<input value="{{ $user->email }}" onkeyup="duplicateEmail( {{ $user->id }} )" required="required" type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
					</div>
                    <div class="col-sm-4">
                        <span id="dupemail" style="color:red"></span>
                    </div>
				</div>
                <div class="form-group row">
                    <label for="password" class="col-sm-4 col-form-label"><span style="color:red">*</span>Reset Password</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="password" id="password" maxlength="20" placeholder="New Password">
                    </div>
                </div>
				 <div class="form-group row">
                    <div class="col-sm-6">
                      <div class="form-check">
                        <input {{ ($user->UTV == "1" ? "checked":"") }} value="1" type="checkbox" name="UTV" class="form-check-input" id="UTV">
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
                    @if(Auth::user()->usertype == "Admin" || Auth::user()->BPG == true)
                        <button type="button" class="btn btn-outline-primary float-right" data-toggle="modal" data-target="#modal-default"><i class="nav-icon fas fa-cog"></i> User Settings
                        </button>
                    @endif
                  </div>
			</div>
                <div class="form-group row">
					<div class="col-md-12 text-center">
						<input id="save" required="required" class="btn btn-info" type="submit"
						name="submit" value="Update"/>
                        <a href="{{ route('manager.index') }}" class="btn btn-info">Back</a>
					</div>
				</div>	
	<div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              
              <h4 class="modal-title">Manage User Settings</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
             <div class="modal-body">
                <h6>Users</h6>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPA">Can Create New User Account.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input {{ (($current_manager->BPA == 0) ? "disabled=disabled":"") }}  {{ ($user->BPA == "1" ? "checked":"") }} name="BPA" type="checkbox" id="BPA" >
                    </div> 
                </div>

                 <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPD">Can Edit User Account.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input {{ (($current_manager->BPD == 0) ? "disabled=disabled":"") }}  {{ ($user->BPD == "1" ? "checked":"") }} name="BPD" type="checkbox" id="BPD">
                    </div> 
                </div>

                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPG">Can Edit User Settings.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input {{ (($current_manager->BPG == 0) ? "disabled=disabled":"") }}  {{ ($user->BPG == "1" ? "checked":"") }} name="BPG" type="checkbox" id="BPG">
                    </div> 
                </div>
                
                   <h6>Client</h6>

                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPB">Can Create New Client Account.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input  {{ (($current_manager->BPB == 0) ? "disabled=disabled":"") }}  {{ ($user->BPB == "1" ? "checked":"") }} name="BPB" type="checkbox" id="BPB">
                    </div> 
               </div>

                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPE">Can Edit Client Account.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input  {{ (($current_manager->BPE == 0) ? "disabled=disabled":"") }}  {{ ($user->BPE == "1" ? "checked":"") }} name="BPE" type="checkbox" id="BPE">
                   </div> 
                </div>

                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPC">Can Manage Client Vehicles.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input  {{ (($current_manager->BPC == 0) ? "disabled=disabled":"") }}  {{ ($user->BPC == "1" ? "checked":"") }} name="BPC" type="checkbox" id="BPC">
                    </div> 
                </div>
               
               
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPF">Can Manage Client Drivers.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input  {{ (($current_manager->BPF == 0) ? "disabled=disabled":"") }}  {{ ($user->BPF == "1" ? "checked":"") }} name="BPF" type="checkbox" id="BPF">
                    </div> 
                </div>
                
               
               
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPJ">Can Manage Client Workflows.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input  {{ (($current_manager->BPJ == 0) ? "disabled=disabled":"") }}  {{ ($user->BPJ == "1" ? "checked":"") }} name="BPJ" type="checkbox" id="BPJ">
                    </div> 
                </div>
                <div class="row row-padded">
                    <div class="icheck-success d-inline col-sm-1"></div>
                    <div class="icheck-success d-inline col-sm-1">
                        <input  {{ (($current_manager->BPJ1 == 0) ? "disabled=disabled":"") }}  {{ ($user->BPJ1 == "1" ? "checked":"") }} name="BPJ1" type="checkbox" id="BPJ1">
                    </div> 
                    <label class="form-check-label col-sm-8" for="BPJ1">Sales Auditing.</label>
                </div>
                <div class="row row-padded">
                    <div class="icheck-success d-inline col-sm-1"></div>
                    <div class="icheck-success d-inline col-sm-1">
                        <input {{ (($current_manager->BPJ2 == 0) ? "disabled=disabled":"") }}   {{ ($user->BPJ2 == "1" ? "checked":"") }} name="BPJ2" type="checkbox" id="BPJ2">
                    </div> 
                       <label class="form-check-label col-sm-8" for="BPJ2">Override Blocked Vehicles.</label>
                </div>
                 <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPH">Can Edit Client RH Business Settings.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input  {{ (($current_manager->BPH == 0) ? "disabled=disabled":"") }}  {{ ($user->BPH == "1" ? "checked":"") }} name="BPH" type="checkbox" id="BPH">
                    </div> 
                 </div>

                <div class="row row-padded">
                       <label class="form-check-label col-sm-8" for="BPL">Can Access Fueler Function.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input  {{ (($current_manager->BPL == 0) ? "disabled=disabled":"") }}  {{ ($user->BPL == "1" ? "checked":"") }} name="BPL" type="checkbox" id="BPL">
                    </div> 
                 </div>
                 <h6>Systems</h6>
                  <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPI">Can Edit System Parameters.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input  {{ (($current_manager->BPI == 0) ? "disabled=disabled":"") }}  {{ ($user->BPI == "1" ? "checked":"") }} name="BPI" type="checkbox" id="BPI">
                    </div> 
                </div>
        </div>
        <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Confirm</button>
        </div>
    </div>
            </form>
        </div>
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

        $('#parent_id').change(function(){
           var selected = $(this).find('option:selected');
           var settings = selected.data('settings'); 
           var selval = selected.val();
           if(selval != "" && selval != 1){
               var permissions = settings.split(",");
               for (let i = 0; i < permissions.length; i++) {
                if(i==0){
                    if(permissions[0] == 0){
                        $("#BPA").attr('disabled','disabled');
                        $("#BPA").removeAttr('checked');
                    }else{
                        $("#BPA").removeAttr("disabled");
                        $("#BPA").attr('checked','true');
                    }
                }
                if(i==1){
                    if(permissions[1] == 0){
                        $("#BPB").attr('disabled','disabled');
                        $("#BPB").removeAttr('checked');
                    }else{
                        $("#BPB").removeAttr("disabled");
                        $("#BPB").attr('checked','true');
                    }
                }
                if(i==2){
                    if(permissions[2] == 0){
                        $("#BPC").attr('disabled','disabled');
                        $("#BPC").removeAttr('checked');
                    }else{
                        $("#BPC").removeAttr("disabled");
                        $("#BPC").attr('checked','true');
                    }
                }
                if(i==3){
                    if(permissions[3] == 0){
                        $("#BPD").attr('disabled','disabled');
                        $("#BPD").removeAttr('checked');
                    }else{
                        $("#BPD").removeAttr("disabled");
                        $("#BPD").attr('checked','true');
                    }
                }
                if(i==4){
                    if(permissions[4] == 0){
                        $("#BPE").attr('disabled','disabled');
                        $("#BPE").removeAttr('checked');
                    }else{
                        $("#BPE").removeAttr("disabled");
                        $("#BPE").attr('checked','true');
                    }
                }
                if(i==5){
                    if(permissions[5] == 0){
                        $("#BPF").attr('disabled','disabled');
                        $("#BPF").removeAttr('checked');
                    }else{
                        $("#BPF").removeAttr("disabled");
                        $("#BPF").attr('checked','true');
                    }
                }
                if(i==6){
                    if(permissions[6] == 0){
                        $("#BPG").attr('disabled','disabled');
                        $("#BPG").removeAttr('checked');
                    }else{
                        $("#BPG").removeAttr("disabled");
                        $("#BPG").attr('checked','true');
                    }
                }
                if(i==7){
                    if(permissions[7] == 0){
                        $("#BPH").attr('disabled','disabled');
                        $("#BPH").removeAttr('checked');
                    }else{
                        $("#BPH").removeAttr("disabled");
                        $("#BPH").attr('checked','true');
                    }
                }
                if(i==8){
                    if(permissions[8] == 0){
                        $("#BPI").attr('disabled','disabled');
                        $("#BPI").removeAttr('checked');
                    }else{
                        $("#BPI").removeAttr("disabled");
                        $("#BPI").attr('checked','true');
                    }
                }
                if(i==9){
                    if(permissions[9] == 0){
                        $("#BPJ").attr('disabled','disabled');
                        $("#BPJ").removeAttr('checked');
                    }else{
                        $("#BPJ").removeAttr("disabled");
                        $("#BPJ").attr('checked','true');
                    }
                }
                if(i==10){
                    if(permissions[10] == 0){
                        $("#BPJ1").attr('disabled','disabled');
                        $("#BPJ1").removeAttr('checked');
                    }else{
                        $("#BPJ1").removeAttr("disabled");
                        $("#BPJ1").attr('checked','true');
                    }
                }
                if(i==11){
                    if(permissions[11] == 0){
                        $("#BPJ2").attr('disabled','disabled');
                        $("#BPJ2").removeAttr('checked');
                    }else{
                        $("#BPJ2").removeAttr("disabled");
                        $("#BPJ2").attr('checked','true');
                    }
                }
                if(i==12){
                    if(permissions[12] == 0){
                        $("#BPK").attr('disabled','disabled');
                        $("#BPK").removeAttr('checked');
                    }else{
                        $("#BPK").removeAttr("disabled");
                        $("#BPK").attr('checked','true');
                    }
                }
                if(i==13){
                    if(permissions[13] == 0){
                        $("#BPL").attr('disabled','disabled');
                        $("#BPL").removeAttr('checked');
                    }else{
                        $("#BPL").removeAttr("disabled");
                        $("#BPL").attr('checked','true');
                    }
                }
               }
           }
        });

    });
</script>
@endpush