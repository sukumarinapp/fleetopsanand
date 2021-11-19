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
              <li class="breadcrumb-item">Operations</li>
              <li class="breadcrumb-item">Workflow Manager</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
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
						<table id="example1" class="table table-bordered">
          <thead>
          <tr>
            <th>Open Date</th>
            <th>VNO</th>
            <th>Workflow No</th>
            <th>Workflow Type</th>
            <th>Case Initiator</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
            @foreach($vehicles as $vehicle)
            	@if($vehicle->DES =="A4" || ($vehicle->DES =="A3" && $vehicle->alarm_off == 0))
		            <tr>
		              <td>{{ date("d-m-Y",strtotime($vehicle->DDT)) }}</td>
		              <td>{{ $vehicle->VNO }}</td>
		              <td>WFL{{ str_pad($vehicle->id,3,'0',STR_PAD_LEFT) }}</td>
		              @if($vehicle->DES =="A4")
		              	<td>Vehicle Blocked</td>
		              @elseif($vehicle->DES =="A3" && $vehicle->alarm_off == 0)
		              	<td>Buzzer On</td>

		              @endif
		              <td>{{ $vehicle->DNM }} {{ $vehicle->DSN }}</td>              
		              <td><a href="{{ url('override') }}/{{ $vehicle->vid }}">Resolve</a></td>
		            </tr>
	            @endif
	            @if($vehicle->VBM == "Ride Hailing" && $vehicle->RMT > 0 && $vehicle->ADT == 0)
		            <tr>
		              <td>{{ date("d-m-Y",strtotime($vehicle->DDT)) }}</td>
		              <td>{{ $vehicle->VNO }}</td>
		              <td>WFL{{ str_pad($vehicle->id,3,'0',STR_PAD_LEFT) }}</td>
		              <td>Sales Audit Request</td>
		              <td>{{ $vehicle->DNM }} {{ $vehicle->DSN }}</td>    
		              <td><a href="{{ url('auditing') }}/{{ $vehicle->vid }}/{{ $vehicle->id }}">Resolve</a></td> 
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
</script>
@endpush
