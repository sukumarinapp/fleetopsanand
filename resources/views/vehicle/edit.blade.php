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
              <li class="breadcrumb-item"><a href="{{ route('vehicle.index') }}">vehicle</a></li>
              <li class="breadcrumb-item">Edit Vehicle</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
				<div class="card-header">
			@if($online == 1)
				 <img align="left" src="/online.jpg" />
			@else
				 <img align="left" src="/offline.jpg" /> 
			@endif
			<h3 class="card-title" >&nbsp;Edit Vehicle</h3>
				</div>
			

          <div class="card-body">
		    	@if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
                        <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong> {{ session('error') }} </strong>
                    </div>
                @endif
                <form action="{{ route('vehicle.update',$vehicle->id) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                @csrf
                @method('PUT')
            <div class="row">
              <div class="col-md-6">
              	<div class="form-group row">
					<label for="CAN" class="col-sm-4 col-form-label"><span style="color:red">*</span>Customer Account #</label>
					<div class="col-sm-8">
						<select required="required" class="form-control select2" name="CAN" id="CAN" >
						@foreach($clients as $client)
	                     	<option {{ ($vehicle->CAN == $client->UAN ? "selected":"") }} value="{{ $client->UAN }}" >{{ $client->UAN }}-{{ $client->name }}</option>
	                     @endforeach
						</select>
					</div>
				</div>
                 <div class="form-group row">
					<label for="VNO" class="col-sm-4 col-form-label"><span style="color:red">*</span>Vehicle Reg. No.</label>
					<div class="col-sm-8">
						<input onkeyup="duplicateVNO( {{ $vehicle->id }} )" value="{{ $vehicle->VNO }}" required="required" type="text" class="form-control" name="VNO" id="VNO" maxlength="50" placeholder="Vehicle Reg. No.">
						<span id="dupVNO" style="color:red"></span>
					</div>
				</div>
				<div class="form-group row">
					<label for="VID" class="col-sm-4 col-form-label"><span style="color:red">*</span>Insurance</label>
					<div class="col-sm-8">
                        <input accept="application/pdf,image/png, image/jpeg" name="VID" type="file" id="VID">
                        @php
	                    	$href="";
	                    	if(trim($vehicle->VID) != ""){
	                    		echo "<a target='_blank' href='../../uploads/VID/".$vehicle->VID."'>View</a>";
	                    	}
                        @endphp
					</div>
				</div>
				<div class="form-group row">
					<label for="VRD" class="col-sm-4 col-form-label"><span style="color:red">*</span>Roadworthy Cert</label>
					<div class="col-sm-8">
                        <input accept="application/pdf,image/png, image/jpeg" name="VRD" type="file" id="VRD">
                        @php
	                    	$href="";
	                    	if($vehicle->VRD != ""){
	                    		echo "<a target='_blank' href='../../uploads/VRD/".$vehicle->VRD."'>View</a>";
	                    	}
                        @endphp
					</div>
				</div>
				<div class="form-group row">
					<label for="VMK" class="col-sm-4 col-form-label"><span style="color:red"></span>Make</label>
					<div class="col-sm-8">
						<input value="{{ $vehicle->VMK }}" type="text" class="form-control" name="VMK" id="VMK" maxlength="50" placeholder="Make">
					</div>
				</div>
				<div class="form-group row">
					<label for="VMD" class="col-sm-4 col-form-label"><span style="color:red"></span>Model</label>
					<div class="col-sm-8">
						<input value="{{ $vehicle->VMD }}" type="text" class="form-control" name="VMD" id="VMD" maxlength="50" placeholder="Model">
					</div>
				</div>
				<div class="form-group row">
					<label for="VCL" class="col-sm-4 col-form-label"><span style="color:red"></span>Color</label>
					<div class="col-sm-8">
						<input value="{{ $vehicle->VCL }}" type="text" class="form-control" name="VCL" id="VCL" maxlength="50" placeholder="Color">
					</div>
				</div>
				<div class="form-group row">
					<label for="ECY" class="col-sm-4 col-form-label"><span style="color:red">*</span>RH – Engine Capacity (Litres)</label>
					<div class="col-sm-8">
						<input value="{{ $vehicle->ECY }}" required="required" type="text" class="form-control decimal" name="ECY" id="ECY" maxlength="10" placeholder="Engine Capacity">
					</div>
				</div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
			  
			  
			  
			  
			  
              <div class="col-md-6">
                 <div class="form-group row">
					<label for="VFT" class="col-sm-4 col-form-label"><span style="color:red">*</span>RH – Tank Capacity (Litres)</label>
					<div class="col-sm-8">
						<input value="{{ $vehicle->VFT }}" required="required" type="text" class="form-control decimal" name="VFT" id="VFT" maxlength="10" placeholder="Tank Capacity">
					</div>
				</div>
				 <div class="form-group row">
					<label for="VFC" class="col-sm-4 col-form-label"><span style="color:red">*</span>RH – Fueling Cap (Litres)</label>
					<div class="col-sm-8">
						<input value="{{ $vehicle->VFC }}" required="required" type="text" class="form-control decimal" name="VFC" id="VFC" maxlength="10" placeholder="Fueling Cap (%)">
					</div>
				</div>
				           <div class="form-group row">
					<label for="TSN" class="col-sm-4 col-form-label"><span style="color:red">*</span>Tracker Device SN</label>
					<div class="col-sm-8">
						<input onkeyup="duplicateDeviceSN( {{ $vehicle->TSN }} )" value="{{ $vehicle->TSN }}" required="required" type="text" class="form-control" name="TSN" id="TSN" maxlength="50" placeholder="Tracker Device SN">
						<span id="dupTSN" style="color:red"></span>
					</div>
				</div>
				<div class="form-group row">
					<label for="TID" class="col-sm-4 col-form-label"><span style="color:red">*</span>Tracker ID</label>
					<div class="col-sm-8">
						<input onkeyup="duplicateTrackerID( {{ $vehicle->TID }} )" value="{{ $vehicle->TID }}" required="required" type="text" class="form-control" name="TID" id="TID" maxlength="50" placeholder="Tracker ID">
					</div>
				</div>
				<div class="form-group row">
					<label for="TSM" class="col-sm-4 col-form-label"><span style="color:red">*</span>Tracker SIM No.</label>
					<div class="col-sm-8">
						<input onkeyup="duplicateTrackerSIM( {{ $vehicle->TSM }} )" value="{{ $vehicle->TSM }}" required="required" type="text" class="form-control" name="TSM" id="TSM" maxlength="50" placeholder="Tracker SIM No.">
						<span id="dupTSM" style="color:red"></span>
					</div>
				</div>
				<div class="form-group row">
					<label for="TIP" class="col-sm-4 col-form-label"><span style="color:red">*</span>Terminal IP Address</label>
					<div class="col-sm-8">
						<input value="{{ $vehicle->TIP }}" required="required" type="text" class="form-control" name="TIP" id="TIP" maxlength="50" placeholder="Terminal IP Address">
					</div>
				</div>
				<div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                     <div class="form-group row">
					<label for="VZC1" class="col-sm-6 col-form-label"><span style="color:red">*</span>Buzzer (On)</label>
					<div class="col-sm-6">
						<input value="{{ $vehicle->VZC1 }}" required="required" type="text" class="form-control" name="VZC1" id="VZC1" maxlength="50" placeholder="Code">
					</div>
				</div>
                    </div>
                    <div class="col-sm-6">
                     <div class="form-group row">
					<label for="VZC0" class="col-sm-6 col-form-label"><span style="color:red">*</span>Buzzer (Off)</label>
					<div class="col-sm-6">
						<input value="{{ $vehicle->VZC0 }}" required="required" type="text" class="form-control" name="VZC0" id="VZC0" maxlength="50" placeholder="Code">
					</div>
				</div>
                    </div>
                  </div>
                	<div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                     <div class="form-group row">
					<label for="VBC1" class="col-sm-6 col-form-label"><span style="color:red">*</span>Blocking (On)</label>
					<div class="col-sm-6">
						<input value="{{ $vehicle->VBC1 }}" required="required" type="text" class="form-control" name="VBC1" id="VBC1" maxlength="50" placeholder="Code">
					</div>
				</div>
                    </div>
                    <div class="col-sm-6">
                     <div class="form-group row">
					<label for="VBC0" class="col-sm-6 col-form-label"><span style="color:red">*</span>Blocking (Off):</label>
					<div class="col-sm-6">
						<input value="{{ $vehicle->VBC0 }}" required="required" type="text" class="form-control" name="VBC0" id="VBC0" maxlength="50" placeholder="Code">
					</div>
				</div>
                    </div>
                  </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
             <div class="form-group row">
             	 <div class="col-sm-6">
           <div class="form-check" style="float: left !important">
                        <input {{ ($vehicle->VTV == "1" ? "checked":"") }} value="1" type="checkbox" name="VTV" class="form-check-input" id="VTV">
                        <label class="form-check-label text-success" for="VTV"><b>Activate Vehicle</b></label>
                      </div>
          </div>
          </div>
        	<div class="form-group row">
					<div class="col-md-12 text-center">
						<input id="save" required="required" class="btn btn-info" type="submit" name="submit" value="Update"/>
              <a href="{{ route('vehicle.index') }}" class="btn btn-info">Back</a>
					</div>
				</div>	
        
        <!-- SELECT2 EXAMPLE -->
        
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
         </div>
        </div>
 			        </div>
				  </div>
    </section>
   
@endsection
@push('page_scripts')
<script>
  $(document).ready(function(){
    $('.select2').select2({
      theme: 'bootstrap4'
    });
  });
</script>
@endpush