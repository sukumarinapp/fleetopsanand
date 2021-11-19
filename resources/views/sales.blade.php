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
              <li class="breadcrumb-item">Sales</li>
              <li class="breadcrumb-item">Pending Sales (RT/HP)</li>
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
          <label>Pending Sales (RT/HP)</label>
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
    <div class="row" style="margin-bottom: 5px;">
      <div class="col-md-6">
        <canvas id="pieChart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
      </div>
      <div class="col-md-6">
        <canvas id="pieChart2" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
      </div>
    </div>
    <div class="row">
       <div class="col-md-4">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h4>Total Pending</h4>

                <h6>GHC {{ $total_sale }}</h6>
              </div>
              <div class="icon">
                <i class="far fa-money-bill-alt"></i>
              </div>
               <a class="small-box-footer"><h6>&nbsp;&nbsp;</h6></a>
            </div>
          </div>
          <div class="col-md-4">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h4>RT Pending</h4>

                <h6>GHC {{ $rt_sale }}</h6>
              </div>
              <div class="icon">
                <i class="fas fa-chart-line"></i>
              </div>
              
              <a class="small-box-footer"><h6>No : {{ $rt_sold }}</h6></a>
            </div>
          </div>
          <div class="col-md-4">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h4>HP Pending</h4>

                <h6>GHC {{ $hp_sale }}</h6>
              </div>
               <div class="icon">
                <i class="fas fa-chart-line"></i>
              </div>
              <a class="small-box-footer"><h6>No : {{ $hp_sold }}</h6></a>
            </div>
          </div>
    </div>

    <div class="table-responsive" >
     <table id="examplesales" class="table table-bordered">
      <thead>
        <tr>
          <th>Sales Date</th>
          <th>Declaration No</th>
          <th>CAN</th>
          <th>VNO</th>
          <th>VBM</th>
          <th>Sales Amount</th>
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
         <td>
          @if($sale->VBM == "Rental")
          RT
          @elseif($sale->VBM == "Hire Purchase")
          HP
          @endif
         </td>
         <td>{{ $sale->SSA }}</td>         
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

<script type="text/javascript" language="javascript" src="{{ asset('js/Chart.min.js') }}"></script>
<script>
  var pieData  = {
    labels: [
    'RT Pending Sales',
    'HP Pending Sales',
    ],
    datasets: [
    {
      data: [{{ $rt_sale }},{{ $hp_sale }}],
      backgroundColor : ['#4CAF50', '#1976D2'],
    }
    ]
  }  
  var pieData2  = {
    labels: [
    'RT No',
    'HP No',
    ],
    datasets: [
    {
      data: [{{ $rt_sold }},{{ $hp_sold }}],
      backgroundColor : ['#4CAF50', '#1976D2'],
    }
    ]
  }  
  var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
  var pieChartCanvas2 = $('#pieChart2').get(0).getContext('2d')
  var pieOptions     = {
    maintainAspectRatio : false,
    responsive : true,
  }
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

    new Chart(pieChartCanvas2, {
      type: 'pie',
      data: pieData2,
      options: pieOptions
    })
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

  $('#examplesales').DataTable( {
            responsive: true,
            initComplete: function() {
             $('.buttons-excel').html('<i class="fa fa-file-excel" style="color:green"/>')
             $('.buttons-pdf').html('<i class="fa fa-file-pdf" style="color:red"/>')
             $('.buttons-print').html('<i class="fa fa-print" style="color:#0d5b9e"/>')
         },
         "order": [[ 0, "desc" ]],
         dom: "<'row'<'col-sm-12 col-md-9'B><'col-sm-12 col-md-3'f>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-12 col-md-2'i><'col-sm-12 col-md-2'l><'col-sm-12 col-md-8'p>>",
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],  
         buttons: [
         'excel', 'pdf', 'print','columnsToggle'
         ]
     } );
</script>
@endpush
