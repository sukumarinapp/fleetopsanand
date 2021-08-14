@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">

      		<div class="col-md-12">
			<div class="card card-info">
			<div class="card-header">
			<h3 class="card-title">User Account</h3>
      @if(Auth::user()->usertype == "Admin" || Auth::user()->BPA == true)
			<a href="{{ route('manager.create') }}" class="btn btn-secondary float-right"><i class="nav-icon fas fa-plus"></i>&nbsp; Add User</a>
      @endif
		    </div>
			<div class="card-body">
        @if(session()->has('message'))
          <div class="alert alert-success alert-dismissable" style="margin: 15px;">
              <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong> {{ session('message') }} </strong>
          </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
                <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong> {{ session('error') }} </strong>
            </div>
        @endif
			<table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>UAN</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Job Title</th>
            <th>Contact No</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
          	<tr>
          		<td>{{ $user->UAN }}</td>
              <td>{{ $user->name }}</td>
          		<td>{{ $user->UZS }}</td>
          		<td>{{ $user->email }}</td>
          		<td>{{ $user->UJT }}</td>
          		<td>{{ $user->UCN }}</td>
          		<td>
                @if(Auth::user()->usertype == "Admin" || Auth::user()->BPD == true)
                @if($user->UTV == 0)
                <form action="{{ route('manager.destroy', $user->id)}}" method="post">
                @endif
                    <a href="{{ route('manager.edit',$user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    @csrf
                    @method('DELETE')
                  @if($user->UTV == 0)  
                  <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" type="submit">Delete</button>
                  @else
                  <button class="btn btn-danger btn-sm disabled">Delete</button>
                  @endif
                @if($user->UTV == 0)  
                </form>
                @endif
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