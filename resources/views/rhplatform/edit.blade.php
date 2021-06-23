@extends('layouts.app')

@section('content')

   <div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-info">
			<div class="card-header">
			<h3 class="card-title">Edit RH Platform</h3>
			</div>

          <div class="card-body">
		    	@if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
                        <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong> {{ session('error') }} </strong>
                    </div>
                @endif
                 <form action="{{ route('rhplatform.update',$rhplatform->id) }}" method="post" class="form-horizontal">
        	@csrf
        	   @method('PUT')
			<div class="card-body">
				@if(session()->has('message'))
				    <div class="alert alert-success alert-dismissable" style="margin: 15px;">
						<a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong> {{ session('message') }} </strong>
					</div>
				@endif
				<div class="form-group row">
					<label for="RHN" class="col-sm-4 col-form-label"><span style="color:red">*</span>RH Company Name</label>
					<div class="col-sm-8">
						<input value="{{ $rhplatform->RHN }}" required="required" type="text" class="form-control" name="RHN" id="RHN" maxlength="50" placeholder="RHN">
					</div>
				</div>
				<div class="form-group row">
					<label for="RML" class="col-sm-4 col-form-label"><span style="color:red">*</span>Business Rate (Mileage)</label>
					<div class="col-sm-8">
						<input value="{{ $rhplatform->RML }}"  required="required" type="text" class="form-control decimal" name="RML" id="RML" maxlength="20" placeholder="RML">
					</div>
				</div>
				<div class="form-group row">
					<label for="RMS" class="col-sm-4 col-form-label "><span style="color:red">*</span>Business Rate (Trip start-up fix rate)</label>
					<div class="col-sm-8">
						<input value="{{ $rhplatform->RMS }}"  required="required" type="text" class="form-control decimal" name="RMS" id="RMS" maxlength="20" placeholder="RMS">
					</div>
				</div>
				<div class="form-group row">
					<label for="RMN" class="col-sm-4 col-form-label "><span style="color:red">*</span>Business Rate (Minute)</label>
					<div class="col-sm-8">
						<input value="{{ $rhplatform->RMN }}" required="required" type="text" class="form-control decimal" name="RMN" id="RMN" maxlength="20" placeholder="RMN">
					</div>
				</div>
				<div class="form-group row">
					<label for="RHF" class="col-sm-4 col-form-label "><span style="color:red">*</span>Service Fees (%)</label>
					<div class="col-sm-8">
						<input value="{{ $rhplatform->RHF }}" required="required" value="0" type="text" class="form-control decimal" name="RHF" id="RHF" maxlength="20" placeholder="RHF">
					</div>
				</div>
				<div class="form-group row">
					<label for="RHT" class="col-sm-4 col-form-label"><span style="color:red">*</span>Note</label>
					<div class="col-sm-8">
						<input value="{{ $rhplatform->RHT }}" required="required" type="text" class="form-control" name="RHT" id="RHT" maxlength="50" placeholder="RHT">
					</div>
				</div>
				<div class="form-group row">
					<label for="status" class="col-sm-4 col-form-label"><span style="color:red">*</span>Status</label>
					<div class="col-sm-8">
						<select name="status" id="status" required="required" class="form-control">
				            <option {{ ($rhplatform->status == "Active" ? "selected":"") }} value="Active" >Active</option>
				            @php
				            if($rhplatform->can_delete == "1"){
					            echo "<option ";
					            if($rhplatform->status == "Inactive") echo " selected ";
					            echo " value='Inactive' >Inactive</option>";
					        }
				            @endphp
			            </select>
					</div>
				</div>
				</div>
				<div class="form-group row">
					<div class="col-md-12 text-center">
						<input required="required" class="btn btn-info"
						type="submit"
						name="submit" value="Save"/>
						 <a href="{{ route('rhplatform.index') }}" class="btn btn-info">Back</a>
					</div>
				</div>			
			
			</form>	
              </div>
           
        </div>
				  </div>
    </section>
   
@endsection