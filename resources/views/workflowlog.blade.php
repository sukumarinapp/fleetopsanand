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
              <li class="breadcrumb-item">Workflow Log</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">WorkFlow Log</h3>
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
                      <a class="dropdown-item" href="#">Open Date</a>
                      <a class="dropdown-item" href="#">UAN</a>
                      <a class="dropdown-item" href="#">CAN</a>
                      <a class="dropdown-item" href="#">VNO</a>
                      <a class="dropdown-item" href="#">Workflow No</a>
                      <a class="dropdown-item" href="#">Workflow Type</a>
                      <a class="dropdown-item" href="#">Case Initiator</a>
                      <a class="dropdown-item" href="#">Close Date</a>
                    </div>
                  </div>&nbsp; 

                  <label>From:</label>&nbsp;
                  <li class="nav-item"> <input type="date" class="nav-link" data-toggle="collapse"></li>   &nbsp;&nbsp;&nbsp;
                  <label>To:</label>&nbsp;
                    <li class="nav-item"> <input type="date" class="nav-link" data-toggle="collapse"></li>&nbsp;
                   <li class="nav-item"> <button type="button" class="btn btn-default btn-sm"><a class="nav-link" href="#tab_1" data-toggle="collapse">Apply</a></button></li>&nbsp;

                     
                  
                </ul>
                
              </div><!-- /.card-header -->
            </div>
				<div class="card-body" style="overflow-x: auto;" >
						<table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Open Date</th>
            <th>UAN</th>
            <th>CAN</th>
            <th>VNO</th>
            <th>Workflow No</th>
            <th>Workflow Type</th>
            <th>Case Initiator</th>
            <th>Close Date</th>
          </tr>
          </thead>
          <tbody>
            @foreach($workflow as $flow)
	            <tr>
	              <td>{{ date("d-m-Y",strtotime($flow->WST)) }}</td>
	              <td>{{ $flow->UAN }}</td>
	              <td>{{ $flow->CAN }}</td>
	              <td>{{ $flow->VNO }}</td>
	              <td>{{ $flow->WNB }}</td>
	              <td>{{ $flow->WTP }}</td>
	              <td>{{ $flow->WCI }}</td>
	              <td>{{ date("d-m-Y",strtotime($flow->WCD)) }}</td>
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
