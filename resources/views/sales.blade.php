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
              <li class="breadcrumb-item">Sales Ledger (Rental/HP)</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Sales Ledger (Rental/HP)</h3>
				</div>
					<div class="card">
              <div class="card-header d-flex p-0">
                <ul class="nav nav-pills">
              &nbsp; <!--<li class="nav-item"> <button type="button" class="btn btn-default btn-sm"><a class="nav-link" href="#tab_1" data-toggle="collapse">Refresh</a></button></li>&nbsp;
                <div class="btn-group">
                    
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                      <span class="sr-only">Toggle Dropdown</span>
                      Fields
                    </button>
                    <div class="dropdown-menu" role="menu"> 
                      <a class="dropdown-item" href="#">Sales Date</a>
                      <a class="dropdown-item" href="#">CAN</a>    
                      <a class="dropdown-item" href="#">Declaration No</a>
                      <a class="dropdown-item" href="#">VNO</a>
                      <a class="dropdown-item" href="#">Declaration No</a>
                      <a class="dropdown-item" href="#">Sales Amount</a>
                    </div>
                  </div>&nbsp; -->

                  <label>From Date:</label>&nbsp;
                  <li class="nav-item"> <input value="{{ $from }}" name="from" id="from" type="date" class="nav-link" data-toggle="collapse"></li>   &nbsp;&nbsp;&nbsp;
                  <label>To Date:</label>&nbsp;
                    <li class="nav-item"> <input value="{{ $to }}" name="to" id="to"  type="date" class="nav-link" data-toggle="collapse"></li>&nbsp;
                   <li class="nav-item"> <button onclick="load_report()"  type="submit" class="btn btn-default btn-sm"><a class="nav-link" href="#tab_1" data-toggle="collapse">Apply</a></button></li>&nbsp;&nbsp;

                     
                </ul>
                
              </div><!-- /.card-header -->
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
	var sales = "{{ url('sales') }}";
  function load_report(){
    var from = $("#from").val();
    var to = $("#to").val();
    if(from == ""){
      alert("Please select from Date");
    }else if(to == ""){
      alert("Please select To Date");
    }else{
      var url =  sales + "/" + from + "/" +to;  
      window.location.href = url;
    }   
  }

	$(document).ready(function(){
		$('.select2').select2({
        	theme: 'bootstrap4'
    	});
	});


</script>
@endpush
