@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="content-header" style="padding: 0px 0.5rem !important;">
        <div class="row">
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a>Reports</a></li>
              <li class="breadcrumb-item">Workflow Log</li>
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
          <label>WorkFlow Log</label>
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

  <div class="card-body" >
    <div class="table-responsive" >
      <table id="example1" class="table table-bordered">
        <thead>
          <tr>
            <th>DATE</th>
            <th>VNO</th>
            <th>CML</th>
            <th>CHR</th>
            <th>MIN SPEED</th>
            <th>MAX SPEED</th>
            <th>WORK START TIME</th>
            <th>WORK END TIME</th>
            <th>VBM</th>
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
@endsection
@push('page_scripts')
<script>
	var telematicslog = "{{ url('telematicslog') }}";
	function load_report(){
		var from = $("#from").val();
    var to = $("#to").val();
    if(from == ""){
      alert("Please select from Date");
    }else if(to == ""){
      alert("Please select To Date");
    }else{
      var url =  telematicslog + "/" + from + "/" +to;  
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
