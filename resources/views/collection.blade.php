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
                <h4>Total Sales</h4>

                <h6>GHC {{ $total_sale }}</h6>
              </div>
              <div class="icon">
                <i class="far fa-money-bill-alt"></i>
              </div>
 <a class="small-box-footer"><h6>&nbsp;&nbsp;</h6></a>

            </div>
          </div>
          <div class="col-md-3">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h4>RT Sales</h4>

                <h6>GHC {{ $rt_sale }}</h6>
              </div>
               <div class="icon">
                <i class="fas fa-chart-line"></i>
              </div>
           <a class="small-box-footer"><h6>Sold : {{ $rt_sold }}</h6></a>

            </div>
          </div>
          <div class="col-md-3">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h4>HP Sales</h4>

                <h6>GHC {{ $hp_sale }}</h6>
              </div>
               <div class="icon">
                <i class="fas fa-chart-line"></i>
              </div>
          <a class="small-box-footer"><h6>Sold : {{ $hp_sold }}</h6></a>

            </div>
          </div>
          <div class="col-md-3">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h4>RH Sales</h4>

                <h6>GHC {{ $rh_sale }}</h6>
              </div>
               <div class="icon">
                <i class="fas fa-chart-line"></i>
              </div>
             <a class="small-box-footer"><h6>Sold : {{ $rh_sold }}</h6></a>

            </div>
          </div>
    </div>
    
    <div class="table-responsive" >
      <table id="example1" class="table table-bordered">
        <thead>
          <tr>
            <th>Date</th>
            <th>Dec No</th>
            <th>CAN</th>
            <th>VNO</th>
            <th>VBM</th>
            <th>Contact#</th>
            <th>Receipt No</th>
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
            @if($sale->RST == 1)
              <td>{{ $sale->RNO }}</td>
            @else
              <td>&nbsp;</td>
            @endif
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
<script type="text/javascript" language="javascript" src="{{ asset('js/Chart.min.js') }}"></script>
<script>
  var pieData  = {
    labels: [
    'RT Sales',
    'HP Sales',
    'RH Sales',
    ],
    datasets: [
    {
      data: [{{ $rt_sale }},{{ $hp_sale }},{{ $rh_sale }}],
      backgroundColor : ['#4CAF50', '#1976D2', '#2196F3'],
    }
    ]
  }  
  var pieData2  = {
    labels: [
    'RT Sold',
    'HP Sold',
    'RH Sold',
    ],
    datasets: [
    {
      data: [{{ $rt_sold }},{{ $hp_sold }},{{ $rh_sold }}],
      backgroundColor : ['#4CAF50', '#1976D2', '#2196F3'],
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
