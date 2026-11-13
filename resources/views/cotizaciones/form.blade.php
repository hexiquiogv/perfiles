@extends('layouts.master')

@section('main-content')
<div class="p-2 m-2">
    <div class="card col-md-12 badge orange d-flex flex-row justify-content-between z-depth-2 rounded">
        <div class="pl-2 pt-3">
            <span class="h4 pt-1 pl-2">{{$title}}</span>
        </div>

        <div class="ml-auto d-flex flex-row p-2">
            <div class="ml-auto d-flex flex-row p-2">
                <a href="#" id="add_cotizacion" title="Agregar Cotización"
                        class="m-1 p-1 badge-success z-depth-2">
                    <i class="fa fa-plus fa-2x px-1" aria-hidden="true"></i>
                </a>
            </div>   
            <div class="ml-auto d-flex flex-row p-2">
                <a href="{!! route('cotizaciones') !!}" 
                        class="m-1 p-1 badge-info z-depth-2">
                    <i class="fa fa-undo fa-2x px-1" aria-hidden="true"></i>
                </a>
            </div>   
        </div>        
    </div> 
</div>

<div class="m-4 d-flex flex-row col-md-12">
    <div class="d-flex flex-column col-md-3 teal-text">
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
    <div class="d-flex flex-column col-md-4 z-depth-3 rounded p-2">
        <form id="mantenimiento_form" method="POST" action="{{ $route }}">
            @csrf
            {{ method_field($method) }}
                
            <div class="m-2">
                <label class="col-form-label active">Seleccione el/los Servicio(s) Requeridos</label>
                <br>
                <div id="servicios" class="d-flex flex-wrap col-md-12"></div>
            </div>

            <div class="m-2">
                <label class="col-form-label active">Diagnóstico de Falla</label>
                <textarea class="col-md-12 p-2" id="diagnostico" type="textarea" name="diagnostico" 
                rows="4">{{old('diagnostico',$registro->diagnostico??'')}}</textarea>
            </div>

            <div class="m-2 d-flex justify-content-end">
                <a class="m-1 badge-warning text-white p-1 z-depth-2 "
                        onclick="document.getElementById('mantenimiento_form').submit();">
                    <i class="fa fa-save fa-2x" aria-hidden="true"></i>
                </a>
            </div>
        </form>
    </div>
        
    <div class="d-flex flex-column col-md-4">
        @include('cotizaciones.table')
    </div>


</div>

@include('cotizaciones.proveedor')

@endsection

@push('scripts2')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#add_cotizacion').on('click', function() {
            //     old_url = $('#confirm_modal_deletion_buttons_form').attr('action');
            //     new_url = old_url.replace('confirm_deletion_item_id',catalogo_id);
            //     $('#confirm_modal_deletion_buttons_form').attr('action', new_url);
                $('#cotizacion_link').trigger('click');
            });

            dynamicDropdown("{{ route('personal') }}", 
                {{ old('chofer_id',$registro->chofer_id??0) }}, 'chofer_id');
            dynamicDropdown("{{ route('flotilla') }}", 
                {{ old('vehiculo_id',$registro->vehiculo_id??0) }}, 'vehiculo_id');
            
            dynamicCheckboxes("/items/{{ App\Models\Catalogo::MANTENIMIENTOS }}", 
                "{{ $registro->servicios }}",  "servicios", "checkbox", "col-md-4");
        });
    </script>
@endpush 




