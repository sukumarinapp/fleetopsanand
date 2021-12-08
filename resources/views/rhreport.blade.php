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
              <li class="breadcrumb-item">RH Daily Report</li>
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
          <label>RH Daily Report</label>
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
       <div class="col-md-3">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h4>GHC {{ $total_exps }}</h4>

                <p>Total Expected Sales</p>
              </div>
              <div class="icon">
                <i class="far fa-money-bill-alt"></i>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h4>GHC {{ $total_ccei }}</h4>

                <p>Total Expected Cash Collected</p>
              </div>
               <div class="icon">
              <i class="fas fa-money-bill-alt"></i>
              </div>
              
            </div>
          </div>
          <div class="col-md-2">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h4>{{ $rh_sold }}</h4>

                <p>RH No Sold</p>
              </div>
              <div class="icon">
              <i class="fas fa-coins"></i>
              </div>
              
            </div>
          </div>
          <div class="col-md-2">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h4>{{ $total_cml }}</h4>

                <p>Total Mileage Covered</p>
              </div>
              <div class="icon">
              <i class="fas fa-tachometer-alt"></i>
              </div>
            </div>
          </div>
          <div class="col-md-2">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h4>{{ $total_chr }}</h4>

                <p>Total Hours Worked</p>
              </div>
              <div class="icon">
              <i class="far fa-clock"></i>
              </div>
             
            </div>
          </div>
    </div>
    <div class="table-responsive" >
     <table id="examplesales" class="table table-bordered">
      <thead>
        <tr>
          <th>Date</th>
          <th>Declaration No</th>
          <th>CAN</th>
          <th>VNO</th>
          <th>Contact#</th>
          <th>CML</th>
          <th>CHR</th>
          <th>SPF</th>
          <th>CPF</th>
          <th>TPF</th>
          <th>EXPS (Sale)</th>
          <th>EXPS (Earning)</th>
          <th>CCEI</th>
          <th>FTP</th>
          <th>CWI</th>
        </tr>
      </thead>
      <tbody>
       @foreach($rhreport as $sale)
       <tr>
           <td>{{ date("d-m-Y",strtotime($sale->DDT)) }}</td>
           <td>{{ $sale->id }}</td>
           <td>{{ $sale->CAN }}</td>
           <td>{{ $sale->VNO }}</td>
           <td>{{ $sale->DCN }}</td>
           <td>{{ $sale->CML }}</td>
           <td>{{ $sale->CHR }}</td>
           <td>{{ $sale->SPF }}</td>
           <td>{{ $sale->CPF }}</td>
           <td>{{ $sale->TPF }}</td>
           <td>{{ $sale->EXPS }}</td>
           <td>{{ $sale->EXPS_EARNING }}</td>
           <td>{{ $sale->CCEI }}</td>
           <td>{{ $sale->FTP }}</td>
           <td>{{ $sale->CWI }}</td>
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
    'EXPS(Earnings)',
    'SAL',
    ],
    datasets: [
    {
      data: [{{ $total_exps }},{{ $total_sal }}],
      backgroundColor : ['#d9534f','#4CAF50'],
    }
    ]
  }  

  var pieData2  = {
    labels: [
    'CCEI',
    'CPF',
    ],
    datasets: [
    {
      data: [{{ $total_ccei }},{{ $total_cpf }}],
      backgroundColor : ['#d9534f','#4CAF50'],
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


  var rhreport = "{{ url('rhreport') }}";
  function load_report(){
    var from = $("#from").val();
    var to = $("#to").val();
    if(from == ""){
      alert("Please select from Date");
    }else if(to == ""){
      alert("Please select To Date");
    }else{
      var url =  rhreport + "/" + from + "/" +to;  
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
