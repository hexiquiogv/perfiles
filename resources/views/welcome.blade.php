@extends('layouts.master')

@section('custom_css')
    <style type="text/css">
        #footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }   
    </style>
@endsection

@section('content')
    Perfiles y Herrajes de Saltillo
@endsection

@section('footer')
    @include('layouts.partials.footer')
@endsection
