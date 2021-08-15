@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">WorkFlow</h3>
				</div>
				<div class="card-body">
						<table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Open Date</th>
            <th>VNO</th>
            <th>Workflow Type</th>
            <th>Driver</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
            @foreach($vehicles as $vehicle)
            	@if($vehicle->DES =="A4")
		            <tr>
		              <td>{{ $vehicle->DDT }}</td>
		              <td>{{ $vehicle->VNO }}</td>
		              <td>Vehicle Blocked</td>
		              <td>{{ $vehicle->DNM }} {{ $vehicle->DSN }}</td>              
		              <td><a href="{{ url('override') }}/{{ $vehicle->vid }}">Resolve</a></td>
		            </tr>
	            @endif
	            @if($vehicle->VBM =="Ride Hailing")
		            <tr>
		              <td>{{ $vehicle->DDT }}</td>
		              <td>{{ $vehicle->VNO }}</td>
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
