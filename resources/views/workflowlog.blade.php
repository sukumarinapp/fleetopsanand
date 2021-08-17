@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
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
