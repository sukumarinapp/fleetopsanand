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
              <li class="breadcrumb-item"><a href="#">Help</a></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
			<div class="card-header">
			<h3 class="card-title">Help</h3>
			</div>
            
		</div>
		</div>
	</div>
</div>
@endsection