@extends('layouts.master')

@section('main-content')
<div class="p-2 m-2">
    <div class="card col-md-12 badge orange d-flex flex-row justify-content-between z-depth-2 rounded">
        <div class="pl-2 pt-3">
            <span class="h4 pt-1 pl-2">{{$title}}</span>
        </div>

        <div class="ml-auto d-flex flex-row p-2">
            <a href="{!! route('taller') !!}" 
                    class="m-1 p-1 badge-info z-depth-2">
                <i class="fa fa-undo fa-2x" aria-hidden="true"></i>
            </a>
            <a href="#" class="m-1 badge-warning text-white p-1 z-depth-2"
                    onclick="document.getElementById('mantenimiento_form').submit();">
                <i class="fa fa-save fa-2x" aria-hidden="true"></i>
            </a>
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
        <form id="mantenimiento_form" method="POST" action="{{ $route }}">
            @csrf
            {{ method_field($method) }}
                
            <div>
                <label class="col-form-label active">Seleccione el/los Servicio(s) Requeridos</label>
                <br>
                <div id="servicios" class="d-flex flex-wrap col-md-12"></div>
            </div>

            <div class="form-row mt-4">
                <label class="col-md-3 active">Diagnóstico de Falla</label>
                <textarea class="col-md-12" id="diagnostico" type="textarea" name="diagnostico" disabled
                rows="4">{{old('diagnostico',$registro->diagnostico??'')}}</textarea>
            </div>

            <div class="d-flex flex-wrape col-md-12">
                <div class="md-form col-2 mt-1 py-3">
                    <label class="col-form-label active pl-3" style="margin-top: 10px;">Programado </label>
                    <input class="mt-3 col-11" id="programado_para_ingreso" type="date" name="programado_para_ingreso" 
                        value="{{ old('programado_para_ingreso',
                                is_null($registro->programado_para_ingreso) ? '' :
                                $registro->programado_para_ingreso->format('Y-m-d')) }}">
                </div>
                <div class="md-form col-2 mt-1 py-3">
                    <label class="col-form-label active pl-3" style="margin-top: 10px;">Fecha ingreso</label>
                    <input class="mt-3 col-11" id="fecha_ingresado" type="date" name="fecha_ingresado" 
                        value="{{ old('fecha_ingresado',
                                is_null($registro->fecha_ingresado) ? '' :
                                $registro->fecha_ingresado->format('Y-m-d')) }}">
                </div>  
                <div class="md-form col-2 mt-1 py-3">
                    <label class="col-form-label active pl-3" style="margin-top: 10px;">Fecha entregado</label>
                    <input class="mt-3 col-11" id="fecha_entregado" type="date" name="fecha_entregado" 
                        value="{{ old('fecha_entregado',
                                is_null($registro->fecha_entregado) ? '' :
                                $registro->fecha_entregado->format('Y-m-d')) }}">
                </div>  
                <div class="col-md-4">
                    <div class="md-form"><label class="active">Regreso a garantía?</label></div>
                    <select class="mdb-select md-form" id="garantia_id" 
                        name="garantia_id"></select>
                </div>
            </div> 

            <div class="form-row">
                <label class="col-md-3">Comentarios</label>
                <textarea class="col-md-12" id="comentarios_taller" type="textarea" 
                name="comentarios_taller" rows="4" >{{old('comentarios_taller',$registro->comentarios_taller??'')}}</textarea>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts2')
    <script type="text/javascript">
        $(document).ready(function() {
            dynamicDropdown("{{ route('items',App\Models\Catalogo::SI_NO) }}", 
                {{ old('garantia_id',$registro->garantia_id??0) }}, 'garantia_id');
            
            getVehiculo({{ $registro->vehiculo_id }});

            dynamicCheckboxes("/items/{{ App\Models\Catalogo::MANTENIMIENTOS }}", 
                "{{ $registro->servicios }}",  "servicios", "checkbox", "col-md-4 disabled");
        });
    </script>
@endpush 




