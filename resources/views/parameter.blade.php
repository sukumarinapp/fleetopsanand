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
              <li class="breadcrumb-item">Parameter Settings</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
			<div class="card-header">
			<h3 class="card-title">Parameter Settings</h3>
			</div>
            <form action="{{ route('paramupdate') }}" method="post" class="form-horizontal">
        	@csrf
			<div class="card-body">
				@if(session()->has('message'))
				    <div class="alert alert-success alert-dismissable" style="margin: 15px;">
						<a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong> {{ session('message') }} </strong>
					</div>
				@endif
				<div class="form-group row">
					<label for="CWI_Z" class="col-sm-2 col-form-label"><span style="color:red">*</span>CWI_Z</label>
					<div class="col-sm-10">
						<input value="{{ $tbl494->CWI_Z }}" required="required" type="text" class="form-control decimal" name="CWI_Z" id="CWI_Z" maxlength="20" placeholder="CWI_Z">
					</div>
				</div>
				<div class="form-group row">
					<label for="CWI_d" class="col-sm-2 col-form-label"><span style="color:red">*</span>CWI_d</label>
					<div class="col-sm-10">
						<input value="{{ $tbl494->CWI_d }}" required="required" type="text" class="form-control decimal" name="CWI_d" id="CWI_d" maxlength="20" placeholder="CWI_d">
					</div>
				</div>
				<div class="form-group row">
					<label for="CCEI_a" class="col-sm-2 col-form-label"><span style="color:red">*</span>CCEI_a</label>
					<div class="col-sm-10">
						<input value="{{ $tbl494->CCEI_a }}" required="required" type="text" class="form-control decimal" name="CCEI_a" id="CCEI_a" maxlength="20" placeholder="CCEI_a">
					</div>
				</div>
				<div class="form-group row">
					<label for="CCEI_b" class="col-sm-2 col-form-label"><span style="color:red">*</span>CCEI_b</label>
					<div class="col-sm-10">
						<input value="{{ $tbl494->CCEI_b }}" required="required" type="text" class="form-control decimal" name="CCEI_b" id="CCEI_b" maxlength="20" placeholder="CCEI_b">
					</div>
				</div>
				<div class="form-group row">
					<label for="CCEI_taSe" class="col-sm-2 col-form-label"><span style="color:red">*</span>CCEI_taSe</label>
					<div class="col-sm-10">
						<input value="{{ $tbl494->CCEI_taSe }}" required="required" type="text" class="form-control decimal" name="CCEI_taSe" id="CCEI_taSe" maxlength="20" placeholder="CCEI_taSe">
					</div>
				</div>
				<div class="form-group row">
					<label for="CCEI_n" class="col-sm-2 col-form-label"><span style="color:red">*</span>CCEI_n</label>
					<div class="col-sm-10">
						<input value="{{ $tbl494->CCEI_n }}" required="required"  type="text" class="form-control decimal" name="CCEI_n" id="CCEI_n" maxlength="20" placeholder="CCEI_n">
					</div>
				</div>
				<div class="form-group row">
					<label for="CCEI_Xb" class="col-sm-2 col-form-label"><span style="color:red">*</span>CCEI_Xb</label>
					<div class="col-sm-10">
						<input value="{{ $tbl494->CCEI_Xb }}" required="required"  type="text" class="form-control decimal" name="CCEI_Xb" id="CCEI_Xb" maxlength="20" placeholder="CCEI_Xb">
					</div>
				</div>
				<div class="form-group row">
					<label for="CCEI_Sxx" class="col-sm-2 col-form-label"><span style="color:red">*</span>CCEI_Sxx</label>
					<div class="col-sm-10">
						<input value="{{ $tbl494->CCEI_Sxx }}" required="required"  type="text" class="form-control decimal" name="CCEI_Sxx" id="CCEI_Sxx" maxlength="20" placeholder="CCEI_Sxx">
					</div>
				</div>
				<div class="form-group row">
					<label for="Fuel Price (Local Currency)" class="col-sm-4 col-form-label"><span style="color:red">*</span>Fuel Price (Local Currency)</label>
					<div class="col-sm-8">
						<input value="{{ $tbl494->FPR }}" required="required"  type="text" class="form-control decimal" name="FPR" id="FPR" maxlength="20" placeholder="FPR">
					</div>
				</div>
                <div class="form-group row">
                    <label for="No Work Min. Mileage (Km)" class="col-sm-4 col-form-label"><span style="color:red">*</span>No Work Min. Mileage (Km)</label>
                    <div class="col-sm-8">
                        <input value="{{ $tbl494->NWM }}" required="required"  type="text" class="form-control decimal" name="NWM" id="NWM" maxlength="20" placeholder="NWM">
                    </div>
                </div>				
				<div class="form-group row">
					<div class="col-md-12 text-center">
						<input required="required" class="btn btn-info"
						type="submit"
						name="submit" value="Save"/>
					</div>
				</div>			
			</div>
			</form>
		</div>
		</div>
	</div>
</div>
@endsection