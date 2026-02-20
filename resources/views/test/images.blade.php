@extends('layouts.master')

@section('custom_css')
	<link href="{{ asset('darkroom/darkroom.css') }}" rel="stylesheet">
@endsection

@section('content')
    @include("layouts.partials.camara.views.camaraModal")
@endsection

@section('custom_scripts')
	@include("layouts.partials.camara.js.upload_file_app")	
@endsection