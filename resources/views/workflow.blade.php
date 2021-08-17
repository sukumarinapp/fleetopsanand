@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-info">
				@if(session()->has('error'))
        <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
          <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong> {{ session('error') }} </strong>
        </div>
        @endif
        @if(session()->has('message'))
            <div class="alert alert-success alert-dismissable" style="margin: 15px;">
            <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong> {{ session('message') }} </strong>
          </div>
        @endif
				<div class="card-header">
					<h3 class="card-title">WorkFlow</h3>
				</div>
				<div class="card-body" style="overflow-x: auto;" >
						<table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Open Date</th>
            <th>VNO</th>
            <th>Workflow No</th>
            <th>Workflow Type</th>
            <th>Case Initiator</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
            @foreach($vehicles as $vehicle)
            	@if($vehicle->DES =="A4")
		            <tr>
		              <td>{{ date("d-m-Y",strtotime($vehicle->DDT)) }}</td>
		              <td>{{ $vehicle->VNO }}</td>
		              <td>WFL{{ str_pad($vehicle->id,3,'0',STR_PAD_LEFT) }}</td>
		              <td>Vehicle Blocked</td>
		              <td>{{ $vehicle->DNM }} {{ $vehicle->DSN }}</td>              
		              <td><a href="{{ url('override') }}/{{ $vehicle->vid }}">Resolve</a></td>
		            </tr>
	            @endif
	            @if($vehicle->VBM =="Ride Hailing")
		            <tr>
		              <td>{{ date("d-m-Y",strtotime($vehicle->DDT)) }}</td>
		              <td>{{ $vehicle->VNO }}</td>
		              <td>WFL{{ str_pad($vehicle->id,3,'0',STR_PAD_LEFT) }}</td>
		              <td>Sales Audit Request</td>
		              <td>{{ $vehicle->DNM }} {{ $vehicle->DSN }}</td>    
		              <td><a href="{{ url('auditing') }}/{{ $vehicle->vid }}">Resolve</a></td>          
		            </tr>
	            @endif
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
