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
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Mobile</th>
            <th>Message</th>
            <th>Sent Date/Time</th>
            <th>Event</th>
          </tr>
        </thead>
        <tbody>
          @foreach($logs as $log)
          <tr>
           <td>{{ $log->PHN }}</td>
           <td>{{ $log->MSG }}</td>
           <td>{{ date("d-m-Y",strtotime($log->DAT)) }} {{ $log->TIM }}</td>
           <td>{{ $log->CTX }}</td>
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
</script>
@endpush
