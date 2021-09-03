@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
      <div class="content-header">
        <div class="row">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Reports</a></li>
              <li class="breadcrumb-item">Sales Ledger (Rental/HP)</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card card-info">
    <div class="card-header">
     <h3 class="card-title">General Sales Ledger</h3>
   </div>
   <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <form class="form-inline" >
          <label for="from">From Date&nbsp;</label>
          <input value="{{ $from }}" type="date" id="from" name="from" class="form-control" />
          <label for="to">To Date&nbsp;</label>
          <input value="{{ $to }}" type="date" id="to" name="to" class="form-control" />
          <label>&nbsp;</label>
          <input onclick="load_report()" type="button"  value="Apply" class="text-center btn btn-success btn-sm" />
        </form>
      </div>
    </div>

    <div class="table-responsive" >
     <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Sales Date</th>
          <th>Declaration No</th>
          <th>CAN</th>
          <th>VNO</th>
          <th>Sales Amount</th>
          <th>Source</th>
          <th>Originator</th>
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
         <td>
          @if($sale->VBM == "Ride Hailing")
          RH
          @elseif($sale->VBM == "Rental")
          RT
          @elseif($sale->VBM == "Hire Purchase")
          HP
          @endif
        </td>
        <td>{{ $sale->DNM }} {{ $sale->DSN }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
</div>
</div>
</div>

@endsection

@push('page_css')
<style>
.ui-datatable thead th {
  word-wrap: break-word;
}
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
