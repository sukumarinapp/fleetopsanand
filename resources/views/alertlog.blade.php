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
              <li class="breadcrumb-item">Alert Log</li>
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
          <label>Alert Log</label>
        </div>
        <div class="col-md-10">
         <form class="form-inline" >
          <label for="from">&nbsp;Start Time&nbsp;</label>
          <input value="{{ $from }}" class="form-control" type="datetime-local" id="from" name="from"  />
          <label for="to">&nbsp;End Time&nbsp;</label>
          <input value="{{ $to }}" class="form-control" type="datetime-local" id="to" name="to"  />
          <label>&nbsp;</label>
          <input onclick="load_report()" type="button"  value="Apply" class="form-control text-center btn btn-success btn-sm" />
        </form>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive" >
      <table id="example1" class="table table-bordered">
        <thead>
          <tr>
            <th>Vehicle Reg#</th>
            <th>Alert</th>
            <th>Active Duration</th>
            <th>Event Time</th>
            <th>Resolved Time</th>
          </tr>
        </thead>
        <tbody>
          @foreach($alerts as $alert)
          <tr>
           <td>{{ $alert['VNO'] }}</td>
           <td>{{ $alert['alert'] }}</td>
           <td>{{ $alert['hours'] }}</td>
           <td>{{ $alert['alert_time'] }}</td>
           <td>{{ $alert['resolve_time'] }}
           @if($alert['type'] == "battery")
            <br>Resolved By: {{ $alert['resolved_by'] }}
           @endif 
           </td>
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
	var alertlog = "{{ url('alertlog') }}";
	function load_report(){
		var from = $("#from").val();
    var to = $("#to").val();
    if(from == ""){
      alert("Please select from Date");
    }else if(to == ""){
      alert("Please select To Date");
    }else{
      var url =  alertlog + "/" + from + "/" +to;  
      window.location.href = url;
    }		
  }

  $(document).ready(function() {
    $('#notifylog').DataTable( {
            responsive: true,
            initComplete: function() {
             $('.buttons-excel').html('<i class="fa fa-file-excel" style="color:green"/>')
             $('.buttons-pdf').html('<i class="fa fa-file-pdf" style="color:red"/>')
             $('.buttons-print').html('<i class="fa fa-print" style="color:#0d5b9e"/>')
         },
         "order": [[ 4, "desc" ]],
         dom: "<'row'<'col-sm-12 col-md-9'B><'col-sm-12 col-md-3'f>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-12 col-md-2'i><'col-sm-12 col-md-2'l><'col-sm-12 col-md-8'p>>",
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],  
         buttons: [
         'excel', 'pdf', 'print','columnsToggle'
         ]
     } );
  } );
</script>
@endpush
