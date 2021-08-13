   @extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">

      		<div class="col-md-12">
			<div class="card card-info">
			<div class="card-header">
			<h3 class="card-title">Manage Vehicle</h3>
			<a href="{{ route('vehicle.create') }}" class="btn btn-secondary float-right"><i class="nav-icon fas fa-plus"></i>&nbsp; Add Vehicle</a>
		    </div>
			<div class="card-body">
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
			<table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>CAN</th>
            <th>Vehicle Reg#</th>
            <th>ID</th>
            <th>Make</th>
            <th>Model</th>
            <th>Color</th>
            <th style="width: 100px">Assign/Remove</th>
            <th style="width: 100px">Action</th>
          </tr>
          </thead>
          <tbody>
            @foreach($vehicles as $vehicle)
            <tr>
              <td>{{ $vehicle->CAN }} {{ $vehicle->name }}</td>
              <td>{{ $vehicle->VNO }}
                @if($vehicle->DNM !="")
                <br><small class="text-success">{{ $vehicle->DNM }} 
                  {{ $vehicle->DSN }} - {{ $vehicle->VBM }}</small>
                @endif
              </td>
              <td>{{ $vehicle->TID }}</td>
              <td>{{ $vehicle->VMK }}</td>
              <td>{{ $vehicle->VMD }}</td>
              <td>{{ $vehicle->VCL }}</td>
              <td>
                    @if(Auth::user()->usertype == "Admin" || Auth::user()->BPF == true)
                      @if($vehicle->driver_id == "")
                        <a href="{{ route('assignvehicle',$vehicle->id) }}" class="btn btn-info btn-sm">Assign Driver</a>
                      @else
                        <a href="{{ route('removevehicle',$vehicle->id) }}" class="btn btn-danger btn-sm">Remove Driver</a>
                      @endif
                    @endif
               </td>
               <td>   
                @if($vehicle->VTV == 0 && $vehicle->DNM == "")
                <form action="{{ route('vehicle.destroy', $vehicle->id)}}" method="post">
                @endif
                    <a href="{{ route('vehicle.edit',$vehicle->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    @csrf
                    @method('DELETE')
                    @if($vehicle->VTV == 0 && $vehicle->DNM == "")
                    <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                    @else
                    <button class="btn btn-danger btn-sm disabled" >Delete</button>
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
@endsection