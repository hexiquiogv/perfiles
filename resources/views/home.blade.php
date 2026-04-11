@extends('layouts.master')

@section('content')
    <div class="d-flex flex-wraper mt-4 pt-4">
        <div class="col-md-3 d-flex flex-column">
            <div class="col-12 d-flex justify-content-center">
                <a href="{{route('mantenimientos.menu')}}" title="Mantenimiento Vehicular">
                    <img src="{{asset('images/reporte.jpeg')}}" width="300px" class="m-1 p-1 z-depth-3 rounded">
                </a>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <span class="">Mantenimiento Vehicular</span>
            </div>
        </div>

        <div class="col-md-3 d-flex flex-column">
            <div class="col-12 d-flex justify-content-center">
                <a href="{{ route('vehiculos.index') }}" title="Plantilla Vehicular">
                    <img src="{{asset('images/vehiculos.jpeg')}}" width="300px" height="300px" class="m-1 p-1 z-depth-3 rounded">
                </a>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <span class="">Plantilla Vehicular</span>
            </div>
        </div>

        <div class="col-md-3 d-flex flex-column">
            <div class="col-12 d-flex justify-content-center">
                <a href="{{ route('personas.index') }}" title="Plantilla de Personal">
                    <img src="{{asset('images/empleados.jpeg')}}" width="300px" height="300px" class="m-1 p-1 z-depth-3 rounded">
                </a>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <span class="">Plantilla de Personal</span>
            </div>
        </div>

        <div class="col-md-3 d-flex flex-column">
            <div class="col-12 d-flex justify-content-center">
                <a href="{{ route('proveedores.index') }}" title="Proveedores">
                    <img src="{{asset('images/proveedores.jpeg')}}" width="300px" height="300px" class="m-1 p-1 z-depth-3 rounded">
                </a>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <span class="">Proveedores</span>
            </div>
        </div>
    </div>
@endsection
