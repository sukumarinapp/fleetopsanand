@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Change Password</h3>
				</div>
				<div class="card-body">
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
	                <form action="{{ route('update_password') }}" method="post" class="form-horizontal">
	                	@csrf
	                	<div class="form-group row">
							<label for="new_password" class="col-sm-3 col-form-label"><span style="color:red">*</span>New Password</label>
							<div class="col-sm-3">
								<input required="required" type="text" class="form-control" name="new_password" id="new_password" maxlength="20" placeholder="New Password">
							</div>
						</div>
						<div class="form-group row">
							<label for="confirm_password" class="col-sm-3 col-form-label"><span style="color:red">*</span>Confirm Password</label>
							<div class="col-sm-3">
								<input required="required" type="text" class="form-control" name="confirm_password" id="confirm_password" maxlength="20" placeholder="Confirm Password">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-6 text-center">
								<input required="required" class="btn btn-info"
								type="submit"
								name="submit" value="Change Password"/>
							</div>
						</div>
	                </form>
	            </div>
	        </div>
        </div>
	</div>
</div>
@endsection