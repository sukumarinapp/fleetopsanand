@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">
					@php
					if(request()->segment(1) == "workflow"){
						echo "WorkFlow Manager";
					}else if(request()->segment(1) == "auditing"){
						echo "Sales Auditing";
					}
					@endphp
					</h3>
				</div>
				<div class="card-body">
					@php
					if(request()->segment(1) == "workflow"){
					@endphp
						<form action="{{ route('workflow1') }}" method="post">
					@php
					}else if(request()->segment(1) == "auditing"){
					@endphp
						<form action="{{ route('auditing1') }}" method="post">
					@php		
					}
					@endphp
						@csrf
						<div class="form-group row">
							<label for="VNO" class="col-sm-2 col-form-label"><span style="color:red">*</span>Vehicle</label>
							<div class="col-sm-6">
								<select required="required" name="VNO" id="VNO" class="form-control select2" >
									<option value="">Search Vehicle</option>
									@foreach($vehicles as $vehicle)
									<option value="{{ $vehicle->id }}" >{{ $vehicle->VNO }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-sm-4">
								<input required="required" class="btn btn-info"
								type="submit"
								name="submit" value="Load Vehicle Details"/>
							</div>
						</div>
					</form>
				</div>
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
<script>
	$(document).ready(function(){
		$('.select2').select2({
        	theme: 'bootstrap4'
    	});
	});


</script>
@endpush
