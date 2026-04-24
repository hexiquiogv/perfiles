@extends('layouts.master')

@section('content')
    <div class="d-flex flex-wraper mt-4 pt-4">
        <div class="col-md-3 d-flex flex-column">
            <div class="col-12 d-flex justify-content-center">
                <a href="{{route('mantenimientos.index')}}" title="Reportes de Mantenimiento">
                    <img src="{{asset('images/ejecucion.png')}}" width="300px" height="300px" class="m-1 p-1 z-depth-3 rounded">
                </a>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <span class="">Reporte de Fallas/Mantenimiento</span>
            </div>
        </div>
        <div class="col-md-3 d-flex flex-column">
            <div class="col-12 d-flex justify-content-center">
                <a href="#" title="Ordenes de Servicio">
                    <img src="{{asset('images/orden_servicio.jpeg')}}" width="300px" height="300px" class="m-1 p-1 z-depth-3 rounded">
                </a>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <span class="">Ordenes de Servicio</span>
            </div>
        </div> 
        <div class="col-md-3 d-flex flex-column">
            <div class="col-12 d-flex justify-content-center">
                <a href="#" title="Cotizaciones">
                    <img src="{{asset('images/cotizaciones.jpeg')}}" width="300px" height="300px" class="m-1 p-1 z-depth-3 rounded">
                </a>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <span class="">Cotizaciones</span>
            </div>
        </div>        
        <div class="col-md-3 d-flex flex-column">
            <div class="col-12 d-flex justify-content-center">
                <a href="#" title="Autorización de Orden de Servicio">
                    <img src="{{asset('images/firma2.jpeg')}}" width="300px" height="300px" class="m-1 p-1 z-depth-3 rounded">
                </a>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <span class="">Autorización Orden de Servicio</span>
            </div>
        </div>
        <div class="col-md-3 d-flex flex-column">
            <div class="col-12 d-flex justify-content-center">
                <a href="#" title="Reparación/Servicio">
                    <img src="{{asset('images/taller.jpeg')}}" width="300px" height="300px" class="m-1 p-1 z-depth-3 rounded">
                </a>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <span class="">Reparación</span>
            </div>
        </div>
    </div>
@endsection
