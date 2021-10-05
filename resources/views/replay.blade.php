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
                 <select name="VNO" required="required" class="form-control selectpicker" id="VNO">
                @if($type == "admin")
                @foreach($usertree as $key => $manager)
                <optgroup label="{{ $manager['name'] }}">
                  @foreach($manager['client'] as $key2 => $client)
                  <optgroup label="&nbsp;&nbsp;{{ $client['name'] }}">
                    @foreach($client['vehicle'] as $key3 => $vehicle)
                    <option value="{{ $vehicle['VNO'] }}">&nbsp;&nbsp;&nbsp;&nbsp;{{ $vehicle['VNO'] }}</option>
                    @endforeach 
                    @endforeach
                    @foreach($manager['submanager'] as $key2 => $submanager)
                    <optgroup label="&nbsp;&nbsp;{{ $submanager['name'] }}">
                      @foreach($submanager['client'] as $key3 => $client)
                      <optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;{{ $client['name'] }}">
                        @foreach($client['vehicle'] as $key4 => $vehicle)
                        <option value="{{ $vehicle['VNO'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $vehicle['VNO'] }}</option>
                      @endforeach 
                    @endforeach    
                        @endforeach
                        @endforeach
                        @endif
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
