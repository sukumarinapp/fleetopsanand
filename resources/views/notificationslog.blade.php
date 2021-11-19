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
              <li class="breadcrumb-item"><a>Reports</a></li>
              <li class="breadcrumb-item">Notification Log</li>
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
          <label>Notification Log</label>
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
      <table id="notifylog" class="table table-bordered">
        <thead>
          <tr>
            <th>Mobile</th>
            <th>Receipient Name</th>
            <th>Designation</th>
            <th>Message</th>
            <th>Date</th>
            <th>Resend</th>
          </tr>
        </thead>
        <tbody>
          @foreach($logs as $log)
          <tr>
           <td>{{ $log->PHN }}</td>
           <td>{{ $log->NAM }}</td>
           <td>{{ $log->CTX }}</td>
           <td>{{ $log->MSG }}</td>
           <td>{{ date("d-m-Y",strtotime($log->DAT)) }} {{ $log->TIM }}</td>
           <td>
            <form action="{{ route('resendsms', $log->id)}}" method="post">
              @csrf
           <button onclick="return confirm('Do yo want to resend this message?')" class="btn btn-primary btn-xs" type="submit">Resend</button>
           </form>
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
	var notificationslog = "{{ url('notificationslog') }}";
	function load_report(){
		var from = $("#from").val();
    var to = $("#to").val();
    if(from == ""){
      alert("Please select from Date");
    }else if(to == ""){
      alert("Please select To Date");
    }else{
      var url =  notificationslog + "/" + from + "/" +to;  
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
