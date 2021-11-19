@extends('layouts.app')

@section('content')
@php
  function get_manager($id,$users){
    $name="";
    foreach($users as $user){
      if($user->id == $id){
        $name = $user->name . " " . $user->UZS;
        break;
      }
    }
    return $name;
  }
@endphp
<div class="container-fluid">
	<div class="row">

      		<div class="col-md-12">
     <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item">File</li>
              <li class="breadcrumb-item">Client</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
			<div class="card-header">
			<h3 class="card-title">Client Account</h3>
      @if(Auth::user()->usertype == "Admin" || Auth::user()->BPB == true)
			<a href="{{ route('client.create') }}" class="btn btn-secondary float-right"><i class="nav-icon fas fa-plus"></i>&nbsp; Add Client</a>
      @endif
		    </div>  
			<div style="overflow-x: auto;" class="card-body">
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
			<table id="example1" class="table table-bordered">
          <thead>
          <tr>
            <th >CAN</th>
            <th>Company Name</th>
            <th>Account Manager</th>
            <th>Contact Name</th>
            <th>Email</th>
            <th>Contact No</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            @if($user->usertype == "Client")
          	<tr 
              @if($user->UTV == 0)
                style="color: #FFC300;"
              @endif
            >
              <td>{{ $user->UAN }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ get_manager($user->parent_id,$parent) }}</td>
          		<td>{{ $user->CZN }}</td>
          		<td>{{ $user->email }}</td>
          		<td>{{ $user->UCN }}</td>
              <td>
                @if($user->UTV == 1)
                  Active
                @else
                  Inactive
                @endif
              </td>
          		<td>
                @if(Auth::user()->usertype == "Admin" || Auth::user()->BPE == true)
                @if($user->UTV == 0)
                <form action="{{ route('client.destroy', $user->id)}}" method="post">
                @endif  
                    <a href="{{ route('client.edit',$user->id) }}" class="btn btn-primary btn-xs">Edit</a>
                    @csrf
                    @method('DELETE')
                  @if($user->UTV == 0)  
                  <button onclick="return confirm('Do you want to perform delete operation?')" class="btn btn-danger btn-xs" type="submit">Delete</button>
                  @else
                  <button class="btn btn-danger btn-xs disabled">Delete</button>
                  @endif
                @if($user->UTV == 0)  
                </form>
                @endif
                @endif
              </td>
          	</tr>
            @endif
            @endforeach
          </tbody>
      </table>
			</div>
		</div>
		</div>
	</div>
</div>
@endsection