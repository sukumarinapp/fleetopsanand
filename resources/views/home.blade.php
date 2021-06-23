@extends('layouts.app')
@section('content')
    <div class="container-fluid">
    	@php
    		echo date("d-M-Y h:i a");
    	@endphp
    </div>
@endsection
