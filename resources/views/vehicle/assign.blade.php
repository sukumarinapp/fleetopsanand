@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Assign Vehicle</h3>
				</div>
          	<div class="card-body">
          		<form method="post" action="{{ route('assigndriver') }}">
      			@csrf
      			<input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
				<div class="form-group row">
					<label class="col-sm-6 col-form-label"><span style="color:red"></span>
					Account No: {{ $vehicle->CAN }}</label>
					<label class="col-sm-6 col-form-label"><span style="color:red"></span>
					Account Name: {{ $vehicle->name }}</label>
				</div>
				<div class="form-group row">
					<label class="col-sm-6 col-form-label"><span style="color:red"></span>
					Assigned Vehicle: {{ $vehicle->VNO }}</label>
					<label class="col-sm-6 col-form-label"><span style="color:red"></span>
					Make: {{ $vehicle->VMK }}</label>
				</div>
				<div class="form-group row">
					<label class="col-sm-6 col-form-label"><span style="color:red"></span>
					Model: {{ $vehicle->VMD }}</label>
					<label class="col-sm-6 col-form-label"><span style="color:red"></span>
					Color: {{ $vehicle->VCL }}</label>
				</div>
				<div class="form-group row">
					<div class="col-md-12">
						<label for="DNM" class="col-form-label"><span style="color:red">*</span>Driver Name - License Number - Contact Number</label>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-12">
						<select autofocus="autofocus"  style="width: 100%;" required="required" class="form-control select2" name="driver_id" id="DNM" >
							<option value="">Search Driver</option>
	                        @foreach($drivers as $driver)
		                     	<option value="{{ $driver->id }}" >{{ $driver->DNM }} {{ $driver->DSN }} -  {{ $driver->DNO }} - {{ $driver->DCN }}</option>
		                    @endforeach
	                    </select>
                	</div>
				</div>
				<div class="form-group row">
					<div class="col-md-12 text-center">
						<input required="required" class="btn btn-info"
						type="submit"
						name="submit" value="Save"/>
                        <a href="{{ route('vehicle.index') }}" class="btn btn-info">Back</a>
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
	});
</script>
@endpush