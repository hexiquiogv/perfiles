@extends('layouts.master')

@section('content')
    <div class="d-flex flex-wraper mt-4 pt-4">
        <div class="col-md-3 d-flex justify-content-center">
            <a href="{{route('mantenimientos.index')}}" title="Reportes de Mantenimiento" class="m-1 p-1 z-depth-3 rounded ">
                <img src="{{asset('images/ejecucion.png')}}" width="180px">
            </a>
        </div>
        <div class="col-md-3 d-flex justify-content-center">
            <a href="#" title="Autorización de Orden de Servicio" class="m-1 p-1 z-depth-3 rounded ">
                <img src="{{asset('images/firma2.jpeg')}}" width="300px">
            </a>
        </div>
        <div class="col-md-3 d-flex justify-content-center">
            <a href="#" title="Reparación/Servicio" class="m-1 p-1 z-depth-3 rounded ">
                <img src="{{asset('images/taller.jpeg')}}" width="300px">
            </a>
        </div>
        <div></div>
    </div>
@endsection
