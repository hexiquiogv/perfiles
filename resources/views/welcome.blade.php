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
    <div class="container col-md-12 justify-content-between"> 
        
        <img src="{{asset('images/publicidad/imagen2.png')}}" class="p-4 z-depth-2" width="600px">
        <img src="{{asset('images/publicidad/imagen3.png')}}" class="mt-4 p-4 z-depth-2" width="300px">
        <img src="{{asset('images/publicidad/imagen1.png')}}" class="mt-4 p-4 z-depth-2" width="300px">
    </div>  
@endsection

@section('footer')
    @include('layouts.partials.footer')
@endsection
