 @extends('layouts.driver')
@section('content')
<div class="container" >
  <div class="row justify-content-center">
  <div class="col-md-12 text-center">
    <h3 style="color: lightgray">Collection Note</h3>
  </div>
</div>
  <div class="card card-danger">
    <div class="card-header">
      <h3 class="card-title">No pending collection note found.</h3>
    </div>
    <div class="card-body">
       
    </div>
    <nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">      
          <a href="{{ route('driver') }}" class="btn btn-info">OK</a>&nbsp;
         
      </nav>
  </div>
</div>
@endsection 