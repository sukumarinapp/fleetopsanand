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
              <li class="breadcrumb-item">Daily Telematics Log</li>
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
          <label>Daily Telematics Log</label>
        </div>
        <div class="col-md-10">
         <form class="form-inline" >
          <label for="from">&nbsp;Date&nbsp;</label>
          <input value="{{ $date }}" class="form-control" type="date" id="from" name="from"  />
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
            <th>Date</th>
            <th>VNO</th>
            <th>CML</th>
            <th>CHR</th>
            <th>Min Speed</th>
            <th>Max Speed</th>
            <th>Work Start Time</th>
            <th>Work End Time</th>
            <th>VBM</th>
          </tr>
        </thead>
          <tbody>
          @foreach($vehicles as $vehicle)
          <tr>
           <td>{{ date("d-m-Y",strtotime($vehicle->date)) }}</td>
           <td>{{ $vehicle->VNO }}</td>
           <td>{{ $vehicle->CML }}</td>
           <td>{{ $vehicle->CHR }}</td>
           <td>{{ $vehicle->min_speed }}</td>
           <td>{{ $vehicle->max_speed }}</td>
           <td>{{ $vehicle->work_start }}</td>
           <td>{{ $vehicle->work_end }}</td>
           <td>{{ $vehicle->VBM }}</td>
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
    if(from == ""){
      alert("Please select from Date");
    }else{
      var url =  telematicslog + "/" + from;  
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
