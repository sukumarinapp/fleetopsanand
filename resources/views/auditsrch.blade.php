@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Driver Sales Auditing</h3>
				</div>
				<div class="card-body">
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
								<input onclick="load_vehicle()" required="required" class="btn btn-info"
								type="button" n ame="submit" value="Load Vehicle Details"/>
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
	var auditing = "{{ url('auditing') }}";
	function load_vehicle(){
		var VNO = $("#VNO").val();
		var url =  auditing + "/" + VNO;
		window.location.href = url;
	}

	$(document).ready(function(){
		$('.select2').select2({
        	theme: 'bootstrap4'
    	});
	});


</script>
@endpush
