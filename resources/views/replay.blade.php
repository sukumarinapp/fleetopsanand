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
               <div class="col-md-12">
        <form class="row form">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name">Name</label>
                    <select name="VNO" required="required" class="form-control selectpicker select2" id="VNO">
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
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="email">Start</label>
                    <input class="form-control" type="datetime-local" name="email" id="email" placeholder="someone@example.com" required="">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="username">End</label>
                    <input class="form-control" type="datetime-local" name="username" id="username" placeholder="eg. JDoe12" required="">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="">&nbsp;</label>
                   <input type="submit" name="submit"  value ="Replay" class="btn btn-primary form-control">
                </div>
            </div>
           
        </form>
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
