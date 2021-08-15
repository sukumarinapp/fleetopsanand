@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">

      		<div class="col-md-12">
			<div class="card card-info">
			<div class="card-header">
			<h3 class="card-title">Manage Driver</h3>
			<a href="{{ route('fdriver.create') }}" class="btn btn-secondary float-right"><i class="nav-icon fas fa-plus"></i>&nbsp; Add Driver</a>
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
            <th>Driver Name</th>
            <th>License #</th>
            <th>Contact #</th>
            <th>Business Model</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
            @foreach($drivers as $driver)
            <tr
            @if($driver->VNO == "")
              style="background-color: #FFC300;"
            @endif
            >
              <td>{{ $driver->DNM }} {{ $driver->DSN }}
              @if($driver->VNO !="")
                <br><small class="text-success">{{ $driver->VNO }}</small>
              @endif
              </td>
              <td>{{ $driver->DNO }}</td>
              <td>{{ $driver->DCN }}</td>
              <td>{{ $driver->VBM }}</td>
              <td>
                @if($driver->VNO == "")
                <form action="{{ route('fdriver.destroy', $driver->id)}}" method="post">
                @endif
                    <a href="{{ route('fdriver.edit',$driver->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    @csrf
                    @method('DELETE')
                  @if($driver->VNO == "")
                  <button onclick="return confirm('Do you want to perform delete operation?')" class="btn btn-danger btn-sm" type="submit">Delete</button>
                  @else
                  <button class="btn btn-danger btn-sm disabled" >Delete</button>
                  @endif
                @if($driver->VNO == "")
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