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
            <p>Please input the fueling code.</p> 
         
          </div>
            <div class="form-group row">
              <label for="VNO" class="col-sm-2"><span style="color:red">*</span>Fueling Code</label>
              <div class="col-sm-6">
                <input maxlength="4" type="text" class="form-control required="required" />
              </div>
              <div class="col-sm-4">
                <input required="required" class="btn btn-info"
                type="button" n ame="submit" value="Continue"/>
                <a href="{{ route('fuelsrch') }}" class="btn btn-info ">Cancel</a>
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
