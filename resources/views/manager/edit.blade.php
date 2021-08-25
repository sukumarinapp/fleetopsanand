@extends('layouts.app')

@section('content')
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
              <li class="breadcrumb-item"><a href="#">Manage Account</a></li>
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
                    <option {{ (($user->parent_id == Auth::user()->id) ? "selected":"") }} value="{{ Auth::user()->id }}" >{{ Auth::user()->UAN }} {{ Auth::user()->name }}</option>
                    @foreach($managers as $manager)
                      @if($manager->parent_id != $user->id && $manager->id != $user->id)  
                      <option {{ (($user->parent_id == $manager->id) ? "selected":"") }} value="{{ $manager->id }}" >{{ $manager->UAN }} {{ $manager->name }}</option>
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
						<input onkeyup="duplicateUserContact({{ $user->UCN }})"  value="{{ $user->UCN }}" required="required" type="text" class="form-control Number" name="UCN" id="UCN" maxlength="15" placeholder="Contact Number">
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
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPA">Can Create New User Account.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input {{ ($user->BPA == "1" ? "checked":"") }} name="BPA" type="checkbox" id="BPA" >
                    </div> 
                </div>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPB">Can Create New Client Account.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input {{ ($user->BPB == "1" ? "checked":"") }} name="BPB" type="checkbox" id="BPB">
                    </div> 
               </div>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPC">Can Add Vehicle to Client Account.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input {{ ($user->BPC == "1" ? "checked":"") }} name="BPC" type="checkbox" id="BPC">
                    </div> 
                </div>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPD">Can Edit User Account.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input {{ ($user->BPD == "1" ? "checked":"") }} name="BPD" type="checkbox" id="BPD">
                    </div> 
                </div>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPE">Can Edit Client Account.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input {{ ($user->BPE == "1" ? "checked":"") }} name="BPE" type="checkbox" id="BPE">
                   </div> 
                </div>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPF">Can Manage Client Drivers.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input {{ ($user->BPF == "1" ? "checked":"") }} name="BPF" type="checkbox" id="BPF">
                    </div> 
                </div>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPG">Can Edit User Settings.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input {{ ($user->BPG == "1" ? "checked":"") }} name="BPG" type="checkbox" id="BPG">
                    </div> 
                </div>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPH">Can Edit Client RH Business Settings.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input {{ ($user->BPH == "1" ? "checked":"") }} name="BPH" type="checkbox" id="BPH">
                    </div> 
                 </div>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPI">Can Edit System Parameters.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input {{ ($user->BPI == "1" ? "checked":"") }} name="BPI" type="checkbox" id="BPI">
                    </div> 
                </div>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPJ">Can Manage Workflows.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input {{ ($user->BPJ == "1" ? "checked":"") }} name="BPJ" type="checkbox" id="BPJ">
                    </div> 
                </div>
                <div class="row row-padded">
                    <div class="icheck-success d-inline col-sm-1"></div>
                    <div class="icheck-success d-inline col-sm-1">
                        <input {{ ($user->BPJ1 == "1" ? "checked":"") }} name="BPJ1" type="checkbox" id="BPJ1">
                    </div> 
                    <label class="form-check-label col-sm-8" for="BPJ1">Perform Driver Sales Auditing.</label>
                </div>
                <div class="row row-padded">
                    <div class="icheck-success d-inline col-sm-1"></div>
                    <div class="icheck-success d-inline col-sm-1">
                        <input {{ ($user->BPJ2 == "1" ? "checked":"") }} name="BPJ2" type="checkbox" id="BPJ2">
                    </div> 
                       <label class="form-check-label col-sm-8" for="BPJ2">Override Blocked/Immobilized Vehicle.</label>
                </div>
                <div class="row row-padded">
                       <label class="form-check-label col-sm-8" for="BPL">Can Access Fueler Function.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input {{ ($user->BPL == "1" ? "checked":"") }} name="BPL" type="checkbox" id="BPL">
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