@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Replay</h3>
            </div>
            <div class="card-body">
             <div class="form-group row">
               <label for="" class="col-sm-2 col-form-label">Track Replay</label>
               <div class="col-sm-6">
                 <select name="cars" required="required" class="form-control" id="cars">
                  <optgroup label="Swedish Cars">
                    <option value="volvo">Volvo</option>
                    <option value="saab">Saab</option>
                  </optgroup>
                  <optgroup label="German Cars">
                    <option value="mercedes">Mercedes</option>
                    <option value="audi">Audi</option>
                  </optgroup>
                </select>
              </div>
            <div class="col-sm-3">
               <button type="button" class="btn btn-primary">Replay</button>
            </div>
            </div>
          </div>
        </div>
      </div> 
    </div>
  </div> 
</div>
</div>
@endsection
<!-- @push('page_scripts')
<script>
  $(document).ready(function(){
    $('.select2').select2({
      theme: 'bootstrap4'
    });
  });
</script>
@endpush
-->
