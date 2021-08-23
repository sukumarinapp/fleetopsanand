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
              <li class="breadcrumb-item"><a href="#">Reports</a></li>
              <li class="breadcrumb-item">Vehicle Log</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Vehicle Assign Log</h3>
				</div>
				<div class="card">
              <div class="card-header d-flex p-0">
                <ul class="nav nav-pills">
             &nbsp; <li class="nav-item"> <button type="button" class="btn btn-default btn-sm"><a class="nav-link" href="#tab_1" data-toggle="collapse">Refresh</a></button></li>&nbsp;
                <div class="btn-group">
                    
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                      <span class="sr-only">Toggle Dropdown</span>
                      Fields
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" href="#">CAN</a>
                      <a class="dropdown-item" href="#">VNO</a>
                      <a class="dropdown-item" href="#">Driver</a>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">User</a>
                      <a class="dropdown-item" href="#">Time</a>
                    </div>
                  </div>&nbsp;

                  <label>From:</label>&nbsp;
                  <li class="nav-item"> <input type="date" class="nav-link" data-toggle="collapse"></li>   &nbsp;&nbsp;&nbsp;
                  <label>To:</label>&nbsp;
                    <li class="nav-item"> <input type="date" class="nav-link" data-toggle="collapse"></li>&nbsp;
                   <li class="nav-item"> <button type="button" class="btn btn-default btn-sm"><a class="nav-link" href="#tab_1" data-toggle="collapse">Apply</a></button></li>&nbsp;

                     <li class="nav-item"> <button type="button" class="btn btn-default btn-sm"><a class="nav-link" href="#tab_1" data-toggle="collapse"><i class="fa fa-file-excel"></i>&nbsp;Excel</a></button></li>&nbsp;

                  <li class="nav-item"> <button type="button" class="btn btn-default btn-sm"><a class="nav-link" href="#tab_1" data-toggle="collapse"><i class='fas fa-file-pdf'></i>&nbsp;PDF</a></button></li>
                  &nbsp;&nbsp;
                  
                </ul>
                
              </div><!-- /.card-header -->
            </div>
				<div class="card-body" style="overflow-x: auto;" >
						<table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>CAN</th>
            <th>VNO</th>
            <th>Driver</th>
            <th>Action</th>
            <th>User</th>
            <th>Time</th>
          </tr>
          </thead>
          <tbody>
            @foreach($vehiclelog as $log)
	            <tr>
	              <td>{{ $log->CAN }}</td>
	              <td>{{ $log->VNO }}</td>
	              <td>{{ $log->DNM }} {{ $log->DSN }}</td>
	              <td>{{ $log->ATN }}</td>
	              <td>{{ $log->UAN }}</td>
	              <td>{{ $log->TIM }}</td>
	            </tr>
            @endforeach
          </tbody>
      </table>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection

@push('page_css')
<style>
	
</style>
@endpush

@push('page_scripts')
<script>
	var override = "{{ url('override') }}";
	function load_vehicle(){
		var VNO = $("#VNO").val();
		var url =  override + "/" + VNO;
		window.location.href = url;
	}

	$(document).ready(function(){
		$('.select2').select2({
        	theme: 'bootstrap4'
    	});
	});


</script>
@endpush
