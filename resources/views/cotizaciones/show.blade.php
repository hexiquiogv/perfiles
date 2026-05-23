@extends('layouts.master')

@section('main-content')
<div class="p-2 m-2">
    <div class="card col-md-12 badge orange d-flex flex-row justify-content-between z-depth-2 rounded">
        <div class="pl-2 pt-3">
            <span class="h4 pt-1 pl-2">{{$title}}</span>
        </div>

        <div class="ml-auto d-flex flex-row p-2">
            <div class="ml-auto d-flex flex-row p-2">
                <a href="{!! route('autorizaciones') !!}" 
                        class="m-1 p-1 badge-info z-depth-2">
                    <i class="fa fa-undo fa-2x px-1" aria-hidden="true"></i>
                </a>
            </div>   
        </div>        
    </div> 
</div>

<div class="m-4 d-flex flex-row col-md-12">
    <div class="d-flex flex-column col-md-3">
        <div class="z-depth-3 rounded m-2 p-2 d-flex flex-column teal-text">
            <span class="p-2">No Economico : <span class="black-text">{{ json_decode($registro->datos_vehiculo)->no_economico }}</span></span>
            <span class="p-2">Placas : <span class="black-text">{{ json_decode($registro->datos_vehiculo)->placa }}</span></span>
            <span class="p-2">Kilometraje : <span class="black-text">{{ $registro->kilometraje }}</span></span>
            <span class="p-2">Tipo Vehículo : <span class="black-text">{{ json_decode($registro->datos_vehiculo)->tipo_vehiculo }}</span></span>
            <span class="p-2">Marca : <span class="black-text">{{ json_decode($registro->datos_vehiculo)->marca }}</span></span>
            <span class="p-2">Línea : <span class="black-text">{{ json_decode($registro->datos_vehiculo)->linea }}</span></span>
            <span class="p-2">Modelo : <span class="black-text">{{ json_decode($registro->datos_vehiculo)->modelo }}</span></span>
            <span class="p-2">Chofer : <span class="black-text">{{ json_decode($registro->datos_vehiculo)->chofer }}</span></span>
            <span class="p-2">Empresa : <span class="black-text">{{ json_decode($registro->datos_vehiculo)->empresa }}</span></span>
            <span class="p-2">Sucursal : <span class="black-text">{{ json_decode($registro->datos_vehiculo)->sucursal }}</span></span>
            <span class="p-2">Reporte : <span class="black-text">{{ $registro->descripcion_falla }}</span></span>
        </div>
    </div>
    <div class="d-flex flex-column col-md-8">
        <div>
            <label class="col-form-label active">Servicio(s) Requeridos</label>
            <br>
            <div id="servicios" class="d-flex flex-wrap col-md-12 readonly"></div>
        </div>

        <div class="form-row mt-4">
            <label class="col-md-3 active">Diagnóstico de Falla</label>
            <textarea class="col-md-12" id="diagnostico" type="textarea" name="diagnostico" readonly
            rows="4">{{$registro->diagnostico??''}}</textarea>
        </div>

        @include('cotizaciones.show_table')
    </div>


</div>

@endsection

@push('scripts2')
    <script type="text/javascript">
        $(document).ready(function() {
            dynamicCheckboxes("/items/{{ App\Models\Catalogo::MANTENIMIENTOS }}", 
                "{{ $registro->servicios }}",  "servicios", "checkbox", "col-md-4 disabled");

        });
    </script>
@endpush 




