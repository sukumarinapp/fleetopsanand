@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">

      		<div class="col-md-12">
			<div class="card card-info">
			<div class="card-header">
			<h3 class="card-title">RH Platform Settings</h3>
			<a href="#" class="btn btn-secondary float-right"><i class="nav-icon fas fa-plus"></i>&nbsp; ADD USER</a>
		    </div>
			<div class="card-body">
			<table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr> 
            <th>Company Name</th>
            <th>BR (Mileage)</th>
            <th>BR (Minute)</th>
            <th>Service Fees (%)</th>
            <th>Notes</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          	<tr>
          		<td>FleetOps</td>
          		<td>2.85</td>
          		<td>.21</td>
          		<td>10.0</td>
          		<td>N/A</td>
          		<td>Default</td>
          	</tr>
          	<tr>
          		<td>FEENIX</td>
          		<td>2.85</td>
          		<td>.21</td>
          		<td>10.0</td>
          		<td>N/A</td>
          		<td><a href="#" class="btn btn-danger">Delete</a></td>
          	</tr>
          </tbody>
      </table>
			</div>
		</div>
		</div>
	</div>
</div>
@endsection