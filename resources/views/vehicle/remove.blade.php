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
              <li class="breadcrumb-item"><a href="#">Manage Account</a></li>
              <li class="breadcrumb-item"><a href="{{ route('vehicle.index') }}">Vehicle</a></li>
              <li class="breadcrumb-item">Unassign Vehicle</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Unassign Vehicle</h3>
				</div>
				
          	<div class="card-body">
          		<form action="{{ route('removedriver') }}" method="post" class="form-horizontal">
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
					<label class="col-sm-6 col-form-label"><span style="color:red"></span>
					Driver Name: {{ $vehicle->DNM }} {{ $vehicle->DSN }}</label>
					<label class="col-sm-6 col-form-label"><span style="color:red"></span>
					License Number: {{ $vehicle->DNO }}</label>
				</div>
				<div class="form-group row">
					<div class="col-md-12 text-center">
						<input onclick="return confirm('Are you sure to unassign the vehicle?')" required="required" class="btn btn-danger"
						type="submit"
						name="submit" value="Unassign"/>
                        <a href="{{ route('vehicle.index') }}" class="btn btn-info">Back</a>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection