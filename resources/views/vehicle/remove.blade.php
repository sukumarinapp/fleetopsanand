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
			<div class="card-body" style="overflow-x: auto;" >
				<table class="table table-bordered">
          <thead>
          <tr>
            <th>CAN</th>
            <th>Name</th>
            <th>Assigned Vehicle</th>
            <th>Driver</th>
            <th>License No</th>
            <th>Contact No</th>
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
          		<td>{{ $vehicle->DNM }} {{ $vehicle->DSN }}</td>
          		<td>{{ $vehicle->DNO }}</td>
          		<td>{{ $vehicle->DCN }}</td>
          		<td>{{ $vehicle->VMK }}</td>
          		<td>{{ $vehicle->VMD }}</td>
          		<td>{{ $vehicle->VCL }}</td>
          	</tr>
          </tbody>
        </table>
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