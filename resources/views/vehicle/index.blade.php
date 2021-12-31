@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
  		<div class="col-md-12">
      <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item">Operations</li>
              <li class="breadcrumb-item">Fleet Manager</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
			<div class="card-header">
			<h3 class="card-title">Fleet Manager</h3>
			<a href="{{ route('vehicle.create') }}" class="btn btn-secondary float-right"><i class="nav-icon fas fa-plus"></i>&nbsp; Add Vehicle</a>
		    </div>
			<div style="overflow-x: auto;" class="card-body">
        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
                <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong> {{ session('error') }} </strong>
            </div>
        @endif
        @if(session()->has('message'))
          <div class="alert alert-success alert-dismissable" style="margin: 15px;">
              <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong> {{ session('message') }} </strong>
          </div>
        @endif
        <div class="card-body" style="overflow-x: auto;" >
			<table id="example1" class="display table table-bordered" cellspacing="0" width="100%">
          <thead>
          <tr>
            <th>CAN</th>
            <th>Vehicle Reg# 

            </th>
            <th>ID</th>
            <th>Make</th>
            <th>Model</th>
            <th>Color</th>
            <th>Status</th>
            <th style="width: 150px">Assign/Remove</th>
            <th style="width: 150px">Action</th>
          </tr>
          </thead> 
          <tbody>
            @foreach($vehicles as $vehicle)
            <tr>
              <td>{{ $vehicle->CAN }}<br><small class="text-success">{{ $vehicle->name }}</small></td>
              <td>
                @php
                if($vehicle->VTV == 0){
                   echo "<span><img src='inactive.jpg'></span>";
                }else if($vehicle->VTV == 1 && $vehicle->DNM ==""){
                  echo "<span><img src='parked.jpg'></span>";
                }else{
                  if($vehicle->offline == 0){
                    echo "<span><img src='online.jpg'></span>";
                  }else{
                    echo "<span><img src='offline.jpg'></span>";
                  }
                }
                @endphp
                {{ $vehicle->VNO }} 
                @if($vehicle->DNM !="")
                <br><small class="text-success"><a href="{{ route('fdriver.edit',$vehicle->did) }}">{{ $vehicle->DNM }} 
                  {{ $vehicle->DSN }}</a> - {{ $vehicle->VBM }}</small>
                @endif
              </td>
              <td>{{ $vehicle->TID }}</td>
              <td>{{ $vehicle->VMK }}</td>
              <td>{{ $vehicle->VMD }}</td>
              <td>{{ $vehicle->VCL }}</td>
              <td>
                @if($vehicle->VTV == 1)
                  Active
                @else
                  Inactive
                @endif
              </td>
              <td>
                    @if(Auth::user()->usertype == "Admin" || Auth::user()->BPF == true)
                      @if($vehicle->driver_id == "")
                        @if($vehicle->VTV == 1)
                          <a href="{{ route('assignvehicle',$vehicle->id) }}" class="btn btn-info btn-xs">Assign Vehicle</a>
                        @else
                          <button class="btn btn-info btn-xs disabled" >Assign Vehicle</button>
                        @endif
                      @else
                        @if($vehicle->DECL == 0)
                        <button class="btn btn-primary btn-xs disabled" >  Payment Pending</button>
                        @else
                        <a href="{{ route('removevehicle',$vehicle->id) }}" class="btn btn-danger btn-xs">Unassign Vehicle</a>
                        @endif
                      @endif
                    @endif
               </td>
               <td>   
                @if($vehicle->VTV == 0 && $vehicle->DNM == "")
                <form action="{{ route('vehicle.destroy', $vehicle->id)}}" method="post">
                @endif
                    @if($vehicle->DECL == 0)
                        <button class="btn btn-primary btn-xs disabled" >Edit</button>
                    @else
                    <a href="{{ route('vehicle.edit',$vehicle->id) }}" class="btn btn-primary btn-xs">Edit</a>
                    @endif
                    @csrf
                    @method('DELETE')
                    @if($vehicle->VTV == 0 && $vehicle->DNM == "")
                    <button onclick="return confirm('Do you want to perform delete operation?')" class="btn btn-danger btn-xs" type="submit">Delete</button>
                    @else
                    <button class="btn btn-danger btn-xs disabled" >Delete</button>
                    @endif
                @if($vehicle->VTV == 0 && $vehicle->DNM == "")                
                </form>
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
	</div>
</div>
@endsection