@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Settings</a></li>
              <li class="breadcrumb-item">RH Platform Settings</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
			<div class="card-header">
			<h3 class="card-title">RH Platform Settings</h3>
			<a href="{{ route('rhplatform.create') }}" class="btn btn-secondary float-right"><i class="nav-icon fas fa-plus"></i>&nbsp; Add RH Platform</a>
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
			<table id="example1" class="table table-bordered">
          <thead>
          <tr>
            <th>Company Name</th>
            <th>BR (Mileage)</th>
            <th>BR (Minute)</th>
            <th>BR (Start-up)</th>
            <th>Service Fees (%)</th>
            <th>Note</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          	@foreach($rhplatforms as $rhplatform)
          	<tr>
          		<td>{{ $rhplatform->RHN }}</td>
          		<td>{{ $rhplatform->RML }}</td>
          		<td>{{ $rhplatform->RMN }}</td>
          		<td>{{ $rhplatform->RMS }}</td>
          		<td>{{ $rhplatform->RHF }}</td>
          		<td>{{ $rhplatform->RHT }}</td>
          		<td>{{ $rhplatform->status }}</td>
          		
          		@if($rhplatform->can_delete == "0")
          			<td><a href="{{ route('rhplatform.edit', $rhplatform->id) }}" class="btn btn-primary btn-xs">Edit</a>&nbsp;Default</td>
          		@else
          			 <td>   
                <form action="{{ route('rhplatform.destroy', $rhplatform->id)}}" method="post">
                    <a href="{{ route('rhplatform.edit', $rhplatform->id) }}" class="btn btn-primary btn-xs">Edit</a>
                    @csrf
                    @method('DELETE')
                  <button onclick="return confirm('Do you want to perform delete operation?')" class="btn btn-danger btn-xs" type="submit">Delete</button>
                </form>
              </td>
          		@endif
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

