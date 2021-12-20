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
              <li class="breadcrumb-item">Operations</li>
              <li class="breadcrumb-item"><a href="{{ route('fdriver.index') }}">Driver</a></li>
              <li class="breadcrumb-item">Edit Driver</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
			<div class="card-header">
			<h3 class="card-title">Edit Driver</h3>
			</div>

          <div class="card-body">
		    	@if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
                        <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong> {{ session('error') }} </strong>
                    </div>
                @endif
                <form onsubmit="return validate_amount()"  action="{{ route('fdriver.update',$driver->id) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                @csrf
                @method('PUT')
        
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
					<label for="DNM" class="col-sm-4 col-form-label"><span style="color:red">*</span>Driver Name</label>
					<div class="col-sm-8">
						<input required="required" value="{{ $driver->DNM }}" type="text" class="form-control" name="DNM" id="DNM" maxlength="30" placeholder="Driver Name">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="DSN" class="col-sm-4 col-form-label"><span style="color:red">*</span>Driver Surname</label>
					<div class="col-sm-8">
						<input required="required" value="{{ $driver->DSN }}" type="text" class="form-control" name="DSN" id="DSN" maxlength="30" placeholder="Driver Surname">
					</div>
				</div>
				<div clakss="form-group row">
					<label for="DNO" class="col-sm-4 col-form-label"><span style="color:red">*</span>License Number</label>
					<div class="col-sm-8">
						<input onkeyup="duplicateDNO( {{ $driver->id }} )" required="required" value="{{ $driver->DNO }}" type="text" class="form-control" name="DNO" id="DNO" maxlength="25" placeholder="License Number">
						<span id="dupDNO" style="color:red"></span>
					</div>
				</div>
				<div class="form-group row">
					<label for="DLD" class="col-sm-4 col-form-label"><span style="color:red"></span>License</label>
					<div class="col-sm-8">
                        <input accept="application/pdf,image/png, image/jpeg" name="DLD" type="file" id="DLD">
                        @php
	                    	$href="";
	                    	if($driver->DLD != ""){
	                    		echo "<a target='_blank' href='../../uploads/DLD/".$driver->DLD."'>View</a>";
	                    	}
                        @endphp
					</div>
				</div>
				<div class="form-group row">
					<label for="LEX" class="col-sm-4 col-form-label"><span style="color:red">*</span>License Expiry Date</label>
					<div class="col-sm-8">
                        <input required="required" value="{{ $driver->LEX }}" onkeydown="return false" type="date" name="LEX" id="LEX">
					</div>
				</div>
                <div class="form-group row">
					<label for="VCC" class="col-sm-4 col-form-label"><span style="color:red"></span>Contract</label>
					<div class="col-sm-8">
                        <input accept="application/pdf,image/png, image/jpeg" name="VCC" type="file" id="VCC">
                        @php
	                    	$href="";
	                    	if($driver->VCC != ""){
	                    		echo "<a target='_blank' href='../../uploads/VCC/".$driver->VCC."'>View</a>";
	                    	}
                        @endphp
					</div>
				</div>
				<div class="form-group row">
					<label for="CEX" class="col-sm-4 col-form-label"><span style="color:red">*</span>Contract Expiry Date</label>
					<div class="col-sm-8">
                        <input required="required" value="{{ $driver->CEX }}" onkeydown="return false" type="date" name="CEX" id="CEX">
					</div>
				</div>
 				<div class="form-group row">
					<label for="DCN" class="col-sm-4 col-form-label"><span style="color:red">*</span>Contact Number</label>
					<div class="col-sm-4">
						<input required="required" value="{{ $driver->DCN }}" type="text" class="form-control number" name="DCN" id="DCN" maxlength="15" placeholder="Contact Number">
						<!-- <input onkeyup="checkDCN({{ $driver->DCN }})" required="required" value="{{ $driver->DCN }}" type="text" class="form-control number" name="DCN" id="DCN" maxlength="15" placeholder="Contact Number"> -->
					</div>
					<div class="col-sm-4">
        <span id="dupContact" style="color:red"></span>
    </div>
				</div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
              	<div class="form-group row">
					<label for="VBM" class="col-sm-4 col-form-label"><span style="color:red"></span>Business Model</label>
					<div class="col-sm-8">
						 <select {{ ($driver->VBM == "Hire Purchase" ? "disabled":"") }} name="VBM" id="VBM" class="custom-select">
                <option {{ ($driver->VBM == "Ride Hailing" ? "selected":"") }} value="Ride Hailing" >Ride Hailing</option>
                <option {{ ($driver->VBM == "Rental" ? "selected":"") }} value="Rental" >Rental</option>
                <option {{ ($driver->VBM == "Hire Purchase" ? "selected":"") }} value="Hire Purchase" >Hire Purchase</option>
            </select>
					</div>
				</div>
          <div 
          @php
          	if($driver->VBM != "Ride Hailing") echo " style='display:none' ";
          @endphp 
          class="form-group row" id="rhdiv"  >
					<label for="PLF" class="col-sm-4 col-form-label"><span style="color:red"></span>RH platform</label>
					<div class="col-sm-8">
						 <select name="PLF[]" id="PLF" class="custom-select">
						  @php
							  foreach($rhplatforms as $rhplatform){
								echo "<option ";
								foreach($driver_platforms as $dp){
						            if($dp->PLF == $rhplatform->id) echo "selected ";
						        }
								echo "value='$rhplatform->id'>$rhplatform->RHN</option>";
			                  }
						  @endphp	
			            </select>
					</div>
				</div>
				
				<div 
				@php
        	if($driver->VBM == "Ride Hailing") echo " style='display:none' ";
        @endphp 
				class="form-group row" id="freqdiv">
					<label for="VPF" class="col-sm-4 col-form-label">Frequency</label>
					<div class="col-sm-8">
						 <select name="VPF" id="VPF" class="custom-select">
                         <option {{ ($driver->VPF == "Daily" ? "selected":"") }} value="Daily" >Daily</option>

                         <option {{ ($driver->VPF == "Weekly" ? "selected":"") }} value="Weekly" >Weekly</option>

                         <option {{ ($driver->VPF == "Monthly" ? "selected":"") }} value="Monthly" >Monthly</option>

                        </select>
					</div>

				</div>

			<div 
			@php
      	if($driver->VPF != "Weekly") echo " style='display:none' ";
      @endphp 
			class="form-group row" id="weekdaydiv">
					<label for="WDY" class="col-sm-4 col-form-label"><span style="color:red"></span>Weekday</label>
					<div class="col-sm-8">
						 <select name="WDY" id="WDY" class="custom-select">
               <option {{ ($driver->WDY == "0" ? "selected":"") }} value="0" >Sunday</option>
               <option {{ ($driver->WDY == "1" ? "selected":"") }} value="1" selected="selected">Monday</option>
               <option {{ ($driver->WDY == "2" ? "selected":"") }} value="2">Wednesday</option>
               <option {{ ($driver->WDY == "3" ? "selected":"") }} value="3">Thursday</option>
               <option {{ ($driver->WDY == "4" ? "selected":"") }} value="4">Tuesday</option>
               <option {{ ($driver->WDY == "5" ? "selected":"") }} value="5">Friday</option>
               <option {{ ($driver->WDY == "6" ? "selected":"") }} value="6">Saturday</option>
              </select>
					</div>
				</div>

					<div 
				 @php
        	if($driver->VPF != "Monthly") echo " style='display:none' ";
         @endphp 
					class="form-group row" id="monthdaydiv" >
					<label for="MDY" class="col-sm-4 col-form-label"><span style="color:red"></span>Day of Month</label>
					<div class="col-sm-8">
						 <select name="MDY" id="MDY" class="custom-select">
               <option {{ ($driver->MDY == "1" ? "selected":"") }} value="1" >01</option>
               @for ($i = 2; $i < 28; $i++)
							    <option {{ ($driver->MDY == $i ? "selected":"") }} value="{{ $i }}" >{{ str_pad($i, 2 , "0",STR_PAD_LEFT) }}</option>
							 @endfor
							 <option {{ ($driver->MDY == "31" ? "selected":"") }} value="31" >Last Day of Month</option>
              </select>
					</div>
				</div>

				 <div 
				 @php
        	if($driver->VBM == "Ride Hailing") echo " style='display:none' ";
         @endphp 
				 class="form-group row" id="paydatediv">
					<label for="VPD" class="col-sm-4 col-form-label"><span style="color:red"></span>First Payment Date</label>
					<div class="col-sm-8">
						<input onkeydown="return false"   value="{{ $driver->VPD }}" type="date" class="form-control" name="VPD" id="VPD" maxlength="50" placeholder="First Payment Date">
					</div>
				</div>
				
				<div 
				@php
        	if($driver->VBM == "Ride Hailing") echo " style='display:none' ";
        @endphp 
				class="form-group row" id="payamtdiv">
					<label for="VAM" class="col-sm-4 col-form-label"><span style="color:red"></span>Recurring Amount</label>
					<div class="col-sm-8">
						<input value="{{ $driver->VAM }}" type="text" class="form-control decimal" name="VAM" id="VAM" maxlength="10" placeholder="Payment Amount">
					</div>
				</div>
              </div>
            </div>
          </div>
         
        </div>

 				<div class="form-group row">
					<div class="col-md-12 text-center">
						<input required="required" class="btn btn-info"
						type="submit" id="save" name="submit" value="Update"/>
              <a href="{{ route('fdriver.index') }}" class="btn btn-info">Back</a>
					</div>
				</div>	

        </div>
				  </div>
    </section>
   
@endsection