@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Fueler</h3>
				</div>
				<div class="card-body">
					<div class="row">
            <p>The Fueler function helps to provide fuel for the driver. The amount of fuel to be issued is measured accordingly. To complete the process,please make sure the contact number of the driver is valid in the system.A “Fueling Code” will be sent to the driver’s phone via SMS after which he/she will in turn communicate to you as proof and confirmation that fuel was indeed received.</p> 
         
          </div>
						<div class="form-group row">
							<label for="VNO" class="col-sm-2"><span style="color:red">*</span>Vehicle</label>
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
								type="button" n ame="submit" value="Send Fueling Code"/>
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
	var fueler = "{{ url('fueler') }}";
	function load_vehicle(){
		var VNO = $("#VNO").val();
		if(VNO==""){
			alert("Please select a vehicle");
			return false;
		}
		var url =  fueler + "/" + VNO;
		window.location.href = url;
	}

	$(document).ready(function(){
		$('.select2').select2({
        	theme: 'bootstrap4'
    	});
	});


</script>
@endpush
