@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
			  	<ul>
			  	  <form class="form-inline ml-0 ml-md-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>
       </ul>
       <ul>
          <li  class="navbar">
          <button type="button" class="btn btn-light btn-sm">Refresh</button><a href="#">
  </a></button>
          </li>
        </ul>

        <ul>
        	<li class="navbar">
        		  <button type="button" class="btn btn-light btn-sm">Fields</button><a href="#">
  </a></button>
        	</li>
        </ul>
			  </nav>

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
