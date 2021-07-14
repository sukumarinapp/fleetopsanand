@extends('layouts.app')

@section('content')

   <div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-info">
			<div class="card-header">
			<h3 class="card-title">Add Driver</h3>
			</div>

          <div class="card-body">
		    	@if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
                        <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong> {{ session('error') }} </strong>
                    </div>
                @endif
                <form onsubmit="return validate_amount()" action="{{ route('fdriver.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
					<label for="DNM" class="col-sm-4 col-form-label"><span style="color:red">*</span>Driver Name</label>
					<div class="col-sm-8">
						<input required="required" type="text" class="form-control" name="DNM" id="DNM" maxlength="30" placeholder="Driver Name">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="DSN" class="col-sm-4 col-form-label"><span style="color:red">*</span>Driver Surname</label>
					<div class="col-sm-8">
						<input required="required" type="text" class="form-control" name="DSN" id="DSN" maxlength="30" placeholder="Driver Surname">
					</div>
				</div>
				<div class="form-group row">
					<label for="DNO" class="col-sm-4 col-form-label"><span style="color:red">*</span>License Number</label>
					<div class="col-sm-8">
						<input onchange="duplicateDNO(0)" required="required" type="text" class="form-control" name="DNO" id="DNO" maxlength="15" placeholder="License Number">
						<span id="dupDNO" style="color:red"></span>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="DLD" class="col-sm-4 col-form-label"><span style="color:red"></span>License</label>
					<div class="col-sm-8">
                        <input accept="application/pdf,image/png, image/jpeg" name="DLD" type="file" id="DLD">
					</div>
				</div>
				<div class="form-group row">
					<label for="LEX" class="col-sm-4 col-form-label"><span style="color:red">*</span>License Expiry Date</label>
					<div class="col-sm-8">
                        <input required="required" onkeydown="return false" type="date" name="LEX" id="LEX">
					</div>
				</div>
                <div class="form-group row">
					<label for="VCC" class="col-sm-4 col-form-label"><span style="color:red"></span>Contract</label>
					<div class="col-sm-8">
                        <input accept="application/pdf,image/png, image/jpeg" name="VCC" type="file" id="VCC">
					</div>
				</div>
				<div class="form-group row">
					<label for="CEX" class="col-sm-4 col-form-label"><span style="color:red">*</span>Contract Expiry Date</label>
					<div class="col-sm-8">
                        <input required="required" onkeydown="return false" type="date" name="CEX" id="CEX">
					</div>
				</div>
 				<div class="form-group row">
					<label for="DCN" class="col-sm-4 col-form-label"><span style="color:red">*</span>Contact Number</label>
					<div class="col-sm-8">
						<input required="required" type="text" class="form-control number" name="DCN" id="DCN" maxlength="15" placeholder="Contact Number">
					</div>
				</div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
					<div class="form-group row">
					<label for="VBM" class="col-sm-4 col-form-label"><span style="color:red"></span>Business Model</label>
					<div class="col-sm-8">
						 <select name="VBM" id="VBM" class="custom-select">
                <option value="Ride Hailing" selected="selected">Ride Hailing</option>
                <option value="Rental" >Rental</option>
                <option value="Hire Purchase" >Hire Purchase</option>
              </select>
					</div>
				</div>
                  <div class="form-group row" id="rhdiv" >
					<label for="PLF" class="col-sm-4 col-form-label"><span style="color:red"></span>RH Platform</label>
					<div class="col-sm-8">
						 <select name="PLF[]" id="multidropdown" class="custom-select">
                         @foreach($rhplatforms as $rhplatform)
	                     	<option value="{{ $rhplatform->id }}" >{{ $rhplatform->RHN }}</option>
	                     @endforeach
                        </select>
					</div>
				</div>

				<div class="form-group row" id="freqdiv" style="display: none;">
					<label for="VPF" class="col-sm-4 col-form-label"><span style="color:red"></span>Payment Frequency</label>
					<div class="col-sm-8">
						 <select name="VPF" id="VPF" class="custom-select">
                         <option value="Daily" selected="selected">Daily</option>
                         <option value="Weekly" selected="selected">Weekly</option>
                         <option value="Monthly" selected="selected">Monthly</option>
                        </select>
					</div>
				</div>
				 <div class="form-group row" id="paydatediv" style="display: none;">
					<label for="VPD" class="col-sm-4 col-form-label"><span style="color:red"></span>First Payment Date</label>
					<div class="col-sm-8">
						<input value="{{ date('Y-m-d') }}" onkeydown="return false" type="date" class="form-control" name="VPD" id="VPD" maxlength="10" placeholder="First Payment Date">
					</div>
				</div>
				
				<div class="form-group row" id="payamtdiv" style="display: none;">
					<label for="VAM" class="col-sm-4 col-form-label"><span style="color:red"></span>Payment Amount</label>
					<div class="col-sm-8">
						<input type="text" class="form-control decimal" name="VAM" id="VAM" maxlength="10" placeholder="Payment Amount">
					</div>
				</div>
              </div>
            </div>
          </div>
         
        </div>
 <div class="form-group row">
					<div class="col-md-12 text-center">
						<input required="required" class="btn btn-info"
						type="submit" id="save" name="submit" value="Save"/>
                        <a href="{{ route('fdriver.index') }}" class="btn btn-info">Back</a>
					</div>
				</div>	
		
        </div>
				  </div>
    </section>
   
@endsection