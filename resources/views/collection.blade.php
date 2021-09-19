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
              <li class="breadcrumb-item">General Sales Ledger</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card card-info">
    <div class="card-header align-items-center">
      <div class="row">
        <div class="col-md-2">
          <label>General Sales Ledger</label>
        </div>
        <div class="col-md-10">
         <form class="form-inline" >
          <label for="from">&nbsp;From Date&nbsp;</label>
          <input value="{{ $from }}" class="form-control" type="date" id="from" name="from"  />
          <label for="to">&nbsp;To Date&nbsp;</label>
          <input value="{{ $to }}" class="form-control" type="date" id="to" name="to"  />
          <label>&nbsp;</label>
          <input onclick="load_report()" type="button"  value="Apply" class="form-control text-center btn btn-success btn-sm" />
        </form>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive" >
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Date</th>
            <th>Dec No</th>
            <th>CAN</th>
            <th>VNO</th>
            <th>VBM</th>
            <th>Contact#</th>
            <th>Amount</th>
            <th>Operator</th>
            <th>Tran#</th>
            <th>Status</th>
            <th>Source</th>
            <th>Request Time</th>
            <th>Response Time</th>
          </tr>
        </thead>
        <tbody>
          @foreach($sales as $sale)
          <tr>
           <td>{{ date("d-m-Y",strtotime($sale->SDT)) }}</td>
           <td>{{ $sale->DCR }}</td>
           <td>{{ $sale->CAN }}</td>
           <td>{{ $sale->VNO }}</td>
           @if($sale->VBM == "Ride Hailing")
            <td>RH</td>
           @elseif($sale->VBM == "Rental")
            <td>RT</td>
           @elseif($sale->VBM == "Hire Purchase")
            <td>HP</td>
           @endif
           <td>{{ $sale->RCN }}</td>
           <td>{{ $sale->RMT }}</td>
           <td>{{ $sale->ROI }}</td>
           <td>{{ $sale->RTN }}</td>
           <td>
            @if($sale->RST == 1)
            Complete
            @else
            Incomplete
            @endif
          </td>
          <td>{{ $sale->SSR }}</td>
          <td>{{ $sale->TIM }}</td>
          <td>{{ $sale->TIM2 }}</td>
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

</style>
@endpush

@push('page_scripts')
<script>
	var collection = "{{ url('collection') }}";
  function load_report(){
    var from = $("#from").val();
    var to = $("#to").val();
    if(from == ""){
      alert("Please select from Date");
    }else if(to == ""){
      alert("Please select To Date");
    }else{
      var url =  collection + "/" + from + "/" +to;  
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
