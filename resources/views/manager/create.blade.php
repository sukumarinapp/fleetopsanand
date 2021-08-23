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
              <li class="breadcrumb-item"><a href="#">Manage Account</a></li>
              <li class="breadcrumb-item"><a href="{{ route('manager.index') }}">User</a></li>
              <li class="breadcrumb-item">Add User</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
			<div class="card-header">
			<h3 class="card-title">Add User</h3>
			</div>
			<div class="card-body">
                @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
                        <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong> {{ session('error') }} </strong>
                    </div>
                @endif
                <form action="{{ route('manager.store') }}" method="post" class="form-horizontal">
                @csrf
				<div class="form-group row">
					<label for="parent_id" class="col-sm-3 col-form-label"><span style="color:red">*</span>User Manager</label>
				<div class="col-sm-9">
                  <select name="parent_id" id="parent_id" required="required" class="form-control select2" style="width: 100%;">
                    @foreach($managers as $manager)
                      <option value="{{ $manager->id }}" >{{ $manager->UAN }} {{ $manager->name }}</option>
                    @endforeach
                  </select>
                </div>
                </div>
				<div class="form-group row">
					<label for="UJT" class="col-sm-3 col-form-label"><span style="color:red">*</span>Job Title</label>
					<div class="col-sm-9">
						<input required="required" type="text" class="form-control" name="UJT" id="UJT" maxlength="50" placeholder="Job Title">
					</div>
				</div>
				<div class="form-group row">
					<label for="name" class="col-sm-3 col-form-label"><span style="color:red">*</span>Name</label>
					<div class="col-sm-9">
						<input required="required" type="text" class="form-control" name="name" id="name" maxlength="50" placeholder="Name">
					</div>
				</div>
				<div class="form-group row">
					<label for="UZS" class="col-sm-3 col-form-label"><span style="color:red">*</span>Surname</label>
					<div class="col-sm-9">
						<input required="required" type="text" class="form-control" name="UZS" id="UZS" maxlength="50" placeholder="Surname">
					</div>
				</div>
				<div class="form-group row">
					<label for="UZA" class="col-sm-3 col-form-label"><span style="color:red">*</span>Address</label>
					<div class="col-sm-9">
						<textarea  required="required" class="form-control max200" name="UZA" id="UZA" rows="3" placeholder="Address"></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label for="UCN" class="col-sm-3 col-form-label"><span style="color:red">*</span>Contact Number</label>
					<div class="col-sm-4">
						<input onkeyup="duplicateUserContact(0)" required="required" type="text" class="form-control number" name="UCN" id="UCN" maxlength="15" placeholder="Contact Number">
					</div>
                    <div class="col-sm-4">
                        <span id="dupContact" style="color:red"></span>
                    </div>
				</div>
                <hr>
			    <div class="form-group row">
					<label for="email" class="col-sm-3 col-form-label"><span style="color:red">*</span>Email</label>
					<div class="col-sm-4">
						<input onkeyup="duplicateEmail(0)" required="required" type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
					</div>
                    <div class="col-sm-4">
                        <span id="dupemail" style="color:red"></span>
                    </div>
				</div>
            
				
				<div class="form-group row">
					<label for="password" class="col-sm-3 col-form-label"><span style="color:red">*</span>Password</label>
					<div class="col-sm-4">
						<input value="{{ random_int(100000, 999999) }}" required="required" type="text" class="form-control" name="password" id="password" maxlength="20" placeholder="Password">
					</div>
				</div>
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
                    @if(Auth::user()->usertype == "Admin" || Auth::user()->BPG == true)
                        <button type="button" class="btn btn-outline-primary float-right" data-toggle="modal" data-target="#modal-default"><i class="nav-icon fas fa-cog"></i> User Settings
                        </button>
                    @endif
                  </div>
			</div>
                <div class="form-group row">
					<div class="col-md-12 text-center">
						<input required="required" class="btn btn-info"
						type="submit"
						name="submit" value="Save"/>
                        <a href="{{ route('manager.index') }}" class="btn btn-info">Back</a>
					</div>
				</div>	
	<div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title">Manage User Settings</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPA">Can Create New User Account.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input name="BPA" type="checkbox" id="BPA" >
                    </div> 
                </div>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPB">Can Create New Client Account.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input name="BPB" type="checkbox" id="BPB">
                    </div> 
               </div>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPC">Can Add Vehicle to Client Account.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input name="BPC" type="checkbox" id="BPC">
                    </div> 
                </div>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPD">Can Edit User Account.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input name="BPD" type="checkbox" id="BPD">
                    </div> 
                </div>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPE">Can Edit Client Account.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input name="BPE" type="checkbox" id="BPE">
                   </div> 
                </div>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPF">Can Manage Client Drivers.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input name="BPF" type="checkbox" id="BPF">
                    </div> 
                </div>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPG">Can Edit User Settings.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input name="BPG" type="checkbox" id="BPG">
                    </div> 
                </div>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPH">Can Edit Client RH Business Settings.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input name="BPH" type="checkbox" id="BPH">
                    </div> 
                 </div>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPI">Can Edit System Parameters.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input name="BPI" type="checkbox" id="BPI">
                    </div> 
                </div>
                <div class="row row-padded">
                    <label class="form-check-label col-sm-8" for="BPJ">Can Manage Workflows.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input name="BPJ" type="checkbox" id="BPJ">
                    </div> 
                </div>
                <div class="row row-padded">
                    <div class="icheck-success d-inline col-sm-1"></div>
                    <div class="icheck-success d-inline col-sm-1">
                        <input name="BPJ1" type="checkbox" id="BPJ1">
                    </div> 
                    <label class="form-check-label col-sm-8" for="BPJ1">Perform Driver Sales Auditing.</label>
                </div>
                <div class="row row-padded">
                    <div class="icheck-success d-inline col-sm-1"></div>
                    <div class="icheck-success d-inline col-sm-1">
                        <input name="BPJ2" type="checkbox" id="BPJ2">
                    </div> 
                       <label class="form-check-label col-sm-8" for="BPJ2">Override Blocked/Immobilized Vehicle.</label>
                </div>
                <div class="row row-padded">
                       <label class="form-check-label col-sm-8" for="BPL">Can Access Fueler Function.</label>
                    <div class="icheck-success d-inline col-sm-2">
                        <input name="BPL" type="checkbox" id="BPL">
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