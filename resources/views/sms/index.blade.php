@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Notification Setup</h3>
				</div>
				<div class="card-body">
					@if(session()->has('message'))
				    <div class="alert alert-success alert-dismissable" style="margin: 15px;">
						<a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong> {{ session('message') }} </strong>
					</div>
				@endif
					<form action=" {{ route('smsupdate') }}" method="post" class="form-horizontal">
					@csrf
					<table width="100%" class="table table-bordered table-striped">
          				<thead>
          					<tr> 
					            <th width="10%">SMS ID</th>
					            <th>SMS Text</th>
				          	</tr>
          				</thead>
          				<tbody> 
          					@foreach($notifications as $notification)
	          				<tr>
	          					<td>{{ $notification->sms_id }}</td>
	          					<input value="{{ $notification->id }}" type="hidden" name="id[]">
	          					<input value="{{ $notification->sms_id }}" type="hidden" name="sms_id[]">
	      						<td>
	      							<textarea rows="6" class="form-control" name="sms_text[]">{{ $notification->sms_text }}</textarea>
	      						</td>
	      					</tr>
	      					@endforeach
	      				</tbody>
    	  			</table>
    	  			<div class="form-group row">
						<div class="col-md-12 text-center">
							<input required="required" class="btn btn-info"
							type="submit"
							name="submit" value="Save"/>
						</div>
					</div>		
    	  			</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection