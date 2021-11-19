@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			      <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item">Operations</li>
              <li class="breadcrumb-item"><a href="{{ route('vehicle.index') }}">Vehicle</a></li>
              <li class="breadcrumb-item">Assign Vehicle</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Assign Vehicle</h3>
				</div>
          	<div class="card-body">
          		<form method="post" action="{{ route('assigndriver') }}">
      			@csrf
      			<input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

			<div class="card-body" style="overflow-x: auto;" >
				<table class="table table-bordered">
          <thead>
          <tr>
            <th>CAN</th>
            <th>Name</th>
            <th>Assigned Vehicle</th>
            <th>Make</th>
            <th>Model</th>
            <th>Color</th>
          </tr>
          </thead>
          <tbody>
          	<tr>
          		<td>{{ $vehicle->CAN }}</td>
          		<td>{{ $vehicle->name }}</td>
          		<td>{{ $vehicle->VNO }}</td>
          		<td>{{ $vehicle->VMK }}</td>
          		<td>{{ $vehicle->VMD }}</td>
          		<td>{{ $vehicle->VCL }}</td>
          	</tr>
          </tbody>
        </table>
				
				<div class="form-group row">
					<div class="col-md-12">
						<label for="DNM" class="col-form-label"><span style="color:red">*</span>Please Select Driver to Assign Vehicle:</label>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-12">
						<select style="width: 100%;" required="required" class="form-control select2" name="driver_id" id="driver_id" >
							<option value="">Search Driver</option>
	                        @foreach($drivers as $driver)
		                     	<option value="{{ $driver->id }}" >{{ $driver->DNM }} {{ $driver->DSN }} -  {{ $driver->DNO }} - {{ $driver->DCN }}</option>
		                    @endforeach
	                    </select>
                	</div>
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