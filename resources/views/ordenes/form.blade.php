@extends('layouts.master')

@section('main-content')
<div class="p-2 m-2">
    <div class="card col-md-12 badge orange d-flex flex-row justify-content-between z-depth-2 rounded">
        <div class="pl-2 pt-3">
            <span class="h4 pt-1 pl-2">{{$title}}</span>
        </div>

        <div class="ml-auto d-flex flex-row p-2">
            <a href="{!! route('mantenimientos.index') !!}" 
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

<div class="m-4">
    <form id="mantenimiento_form" method="POST" action="{{ $route }}">

        @csrf
        {{ method_field($method) }}
            
        <div class="form-row">  
            <div class="md-form col-2 mt-1 py-3">
                <label class="col-form-label active" style="margin-top: 10px;">Folio</label>
                <input class="mt-3 col-11" id="folio" type="text" name="folio" {{ $readonly }} 
                    value="{{ old('folio',$registro->folio ?? '') }}">
            </div> 
            <div class="md-form col-2 mt-1 py-3 ml-3">
                <label class="col-form-label active pl-3" style="margin-top: 10px;">Fecha reporte</label>
                <input class="mt-3 col-11" id="fecha_reporte" type="date" name="fecha_reporte" {{ $readonly }}
                    value="{{ old('fecha_reporte',
                            is_null($registro->fecha_reporte) ? '' :
                            $registro->fecha_reporte->format('Y-m-d')) }}">
            </div>                 
            <div class="col-md-1 ml-2">
                <div class="md-form"><label class="active">Placa</label></div>
                <select class="mdb-select md-form" id="vehiculo_id" searchable="Buscar ..." {{ $readonly }}
                    name="vehiculo_id"></select>
            </div>  
            <div class="col-md-4">
                <div class="md-form"><label class="active">Chofer</label></div>
                <select class="mdb-select md-form" id="chofer_id" readonly disabled
                    name="chofer_id"></select>
            </div>  
            <div class="md-form col-2 mt-1 py-3">
                <label class="col-form-label active pl-3" style="margin-top: 10px;">Kilometraje</label>
                <input class="mt-3 col-11" id="kilometraje" type="text" name="kilometraje" {{ $readonly }}
                    value="{{ old('kilometraje',$registro->kilometraje) }}">
            </div> 
        </div>

        <div class="form-row">  
            <div class="col-md-3">
                <div class="md-form"><label class="active">Tipo Vehiculo</label></div>
                <select class="mdb-select md-form " id="tipo_vehiculo_id" readonly   ></select>
            </div> 
            <div class="col-md-2">
                <div class="md-form"><label class="active">Marca</label></div>
                <select class="mdb-select md-form " id="marca_id" readonly  ></select>
            </div>  
            <div class="col-md-3">
                <div class="md-form"><label class="active">Linea</label></div>
                <select class="mdb-select md-form " id="linea_id" readonly  ></select>
            </div> 
            <div class="md-form col-1 mt-1 py-3">
                <label class="col-form-label active pl-3" style="margin-top: 10px;">Año</label>
                <input class="mt-3 col-11 " id="modelo" type="text" value="" readonly  >
            </div> 
            <div class="md-form col-2 mt-1 py-3 mx-3">
                <label class="col-form-label active pl-3" style="margin-top: 10px;">No Económico</label>
                <input class="mt-3 col-11 " id="no_economico" type="text" value="" readonly  >
            </div> 
        </div>

        <div class="form-row">  
            <div class="col-md-3">
                <div class="md-form"><label class="active">Empresa</label></div>
                <select class="mdb-select md-form " id="empresa_id" searchable="Buscar ..." readonly  
                    name="empresa_id"></select>
            </div> 
            <div class="col-md-4">
                <div class="md-form"><label class="active">Sucursal</label></div>
                <select class="mdb-select md-form " id="sucursal_id" searchable="Buscar ..." readonly  
                    name="sucursal_id"></select>
            </div>  
            <div class="col-md-4">
                <div class="md-form"><label class="active">Area</label></div>
                <select class="mdb-select md-form " id="area_id" searchable="Buscar ..." readonly  
                    name="area_id"></select>
            </div> 
        </div>

        <div class="dropdown-divider"></div>

        <div>
            <label class="col-form-label active">Seleccione el/los Servicio(s) Requeridos</label>
            <br>
            <div id="servicios" class="d-flex flex-wrap col-md-12"></div>
        </div>

        <div class="form-row mt-4">
            <label class="col-md-3 active">Descripción de Falla</label>
            <textarea class="col-md-12" id="descripcion_falla" type="textarea" 
            name="descripcion_falla" rows="4" >{{old('descripcion_falla',$registro->descripcion_falla??'')}}</textarea>
        </div>

    </form>
</div>

@endsection

@push('scripts2')
    <script type="text/javascript">
        $(document).ready(function() {
            dynamicDropdown("{{ route('personal') }}", 
                {{ old('chofer_id',$registro->chofer_id??0) }}, 'chofer_id');
            dynamicDropdown("{{ route('flotilla') }}", 
                {{ old('vehiculo_id',$registro->vehiculo_id??0) }}, 'vehiculo_id');
            
            getVehiculo({{ $registro->vehiculo_id }});

            dynamicCheckboxes("/items/{{ App\Models\Catalogo::MANTENIMIENTOS }}", 
                "{{ $registro->servicios }}",  "servicios", "checkbox", "col-md-4");
        });
    </script>
@endpush 




