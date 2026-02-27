@extends('layouts.master')

@section('main-content')
<div class="p-2 m-2">
    <div class="card col-md-12 badge orange d-flex flex-row justify-content-between z-depth-2 rounded">
        <div class="pl-2 pt-3">
            <span class="h4 pt-1 pl-2">{{$title}}</span>
        </div>

        <div class="ml-auto d-flex flex-row p-2">
            <a href="{!! route('vehiculos.index') !!}" 
                    class="m-1 p-1 badge-info z-depth-2">
                <i class="fa fa-undo fa-2x" aria-hidden="true"></i>
            </a>
            @if(false and $registro->id > 0)
            <a id="camara_modal" class="upload_form_modal m-1 py-1 px-2 badge black z-depth-2" href="#">
                <i class="fa fa-camera fa-2x pt-1" aria-hidden="true"></i>
            </a>
            @endif
            <a href="#" class="m-1 badge-warning text-white p-1 z-depth-2"
                    onclick="document.getElementById('vehiculo_form').submit();">
                <i class="fa fa-save fa-2x" aria-hidden="true"></i>
            </a>
        </div>           
    </div> 
    <div class="mt-4">
        <form id="vehiculo_form" method="POST" action="{{ $route }}" class="ml-4">

            @csrf
            {{ method_field($method) }}
               
            <div class="form-row">  
                <div class="col-md-2">
                    <div class="md-form"><label class="active">Tipo de Vehículo</label></div>
                    <select class="mdb-select md-form" id="tipo_vehiculo_id" searchable="Buscar ..."
                        name="tipo_vehiculo_id"></select>
                </div>  
                <div class="col-md-2">
                    <div class="md-form"><label class="active">Marca</label></div>
                    <select class="mdb-select md-form" id="marca_id" searchable="Buscar ..."
                        name="marca_id"></select>
                </div>  
                <div class="col-md-2">
                    <div class="md-form"><label class="active">Línea</label></div>
                    <select class="mdb-select md-form" id="linea_id" searchable="Buscar ..."
                        name="linea_id"></select>
                </div>    
                <div class="md-form col-2 mt-1 p-3">
                    <label class="col-form-label active pl-3" style="margin-top: 10px;">Modelo (Año)</label>
                    <input class="mt-3 col-11" id="modelo" type="number" name="modelo" 
                        value="{{ old('modelo',$registro->modelo) }}">
                </div>    
                <div class="md-form col-3 mt-1 p-3">
                    <label class="col-form-label active pl-3" style="margin-top: 10px;">No Serie</label>
                    <input class="mt-3 col-11" id="numero_serie" type="text" name="numero_serie" 
                        value="{{ old('numero_serie',$registro->numero_serie) }}">
                </div>                        
            </div>

            <div class="form-row">   
                <div class="md-form col-2 mt-1 py-3">
                    <label class="col-form-label active pl-3" style="margin-top: 10px;">No Económico</label>
                    <input class="mt-3 col-11" id="no_economico" type="text" name="no_economico" 
                        value="{{ old('no_economico',$registro->no_economico) }}">
                </div> 
                <div class="md-form col-2 mt-1 p-3">
                    <label class="col-form-label active pl-3" style="margin-top: 10px;">Placas</label>                    
                    <input class="mt-3 col-11" id="placa" type="text" name="placa" 
                        value="{{ old('placa',$registro->placa) }}">
                </div> 
                <div class="col-md-2">
                    <div class="md-form"><label class="active">Color</label></div>
                    <select class="mdb-select md-form" id="color_id" searchable="Buscar ..."
                        name="color_id"></select>
                </div> 
                <div class="col-md-5">
                    <div class="md-form"><label class="active">Chofer</label></div>
                    <select class="mdb-select md-form" id="chofer_id" searchable="Buscar ..."
                        name="chofer_id"></select>
                </div>  
                
            </div>

            <div class="form-row">  
                <div class="col-md-3">
                    <div class="md-form"><label class="active">Sucursal</label></div>
                    <select class="mdb-select md-form" id="sucursal_id" searchable="Buscar ..."
                        name="sucursal_id"></select>
                </div>  
                <div class="col-md-3">
                    <div class="md-form"><label class="active">Area</label></div>
                    <select class="mdb-select md-form" id="area_id" searchable="Buscar ..."
                        name="area_id"></select>
                </div> 
                <div class="col-md-2">
                    <div class="md-form"><label class="active">Estatus</label></div>
                    <select class="mdb-select md-form" id="estatus_id" searchable="Buscar"
                        name="estatus_id"></select>
                </div>   
            </div>

            <div class="form-row">
                <label class="col-md-3">Comentarios</label>
                <textarea class="col-md-12" id="observaciones" type="textarea" 
                name="observaciones" rows="4" >{{old('observaciones',$registro->observaciones??'')}}</textarea>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts2')
    <script type="text/javascript">
        $(document).ready(function() {
            
            dynamicDropdown("{{ route('items',App\Models\Catalogo::TIPO_VEHICULO) }}", 
                {{ old('tipo_vehiculo_id',$registro->tipo_vehiculo_id??0) }}, 'tipo_vehiculo_id');

            dynamicDropdown("{{ route('items',App\Models\Catalogo::MARCA) }}", 
                {{ old('marca_id',$registro->marca_id??0) }}, 'marca_id');
            dynamicDropdown("{{ route('items',".($registro->marca_id??0).") }}", 
                {{ old('linea_id',$registro->linea_id??0) }}, 'linea_id');

            dynamicDropdown("{{ route('items',App\Models\Catalogo::SUCURSAL) }}", 
                {{ old('sucursal_id',$registro->sucursal_id??0) }}, 'sucursal_id');
            dynamicDropdown("{{ route('items',".($registro->sucursal_id??0).") }}", 
                {{ old('area_id',$registro->area_id??0) }}, 'area_id');

            $('#marca_id').change(function(e){
                var optionId = $('select[name="marca_id"] option:selected').val();
                clearDropdown( $('select[name="linea_id"]') );
                dynamicDropdown("/items/"+optionId, 0, 'linea_id');  
            });

            $('#sucursal_id').change(function(e){
                var optionId = $('select[name="sucursal_id"] option:selected').val();
                clearDropdown( $('select[name="area_id"]') );
                dynamicDropdown("/items/"+optionId, 0, 'area_id');  
            });

            dynamicDropdown("{{ route('items',App\Models\Catalogo::COLOR) }}", 
                {{ old('color_id',$registro->color_id??0) }}, 'color_id');

            dynamicDropdown("{{ route('items',App\Models\Catalogo::ESTATUS) }}", 
                {{ old('estatus_id',$registro->estatus_id??0) }}, 'estatus_id');

        });
  </script>
@endpush  
  


