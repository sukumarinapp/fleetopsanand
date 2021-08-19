@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Sales Ledger (Rental/HP)</h3>
				</div>
				<div class="card-body" style="overflow-x: auto;" >
						<table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Sales Date</th>
            <th>Declaration No</th>
            <th>CAN</th>
            <th>VNO</th>
            <th>Sales Amount</th>
          </tr>
          </thead>
          <tbody>
            @foreach($sales as $sale)
	            <tr>
	              <td>{{ date("d-m-Y",strtotime($sale->SDT)) }}</td>
	              <td>{{ $sale->DCR }}</td>
	              <td>{{ $sale->CAN }}</td>
	              <td>{{ $sale->VNO }}</td>
	              <td>{{ $sale->SSA }}</td>
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
