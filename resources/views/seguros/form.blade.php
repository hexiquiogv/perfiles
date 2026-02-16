@extends('layouts.master')

@section('main-content')
<div class="p-2 m-2">
    <div class="card col-md-12 badge orange d-flex flex-row justify-content-between z-depth-2 rounded">
        <div class="pl-2 pt-3">
            <span class="h4 pt-1 pl-2">{{$title}}</span>
        </div>

        <div class="ml-auto d-flex flex-row p-2">
            <a href="{!! route('seguros.index') !!}" 
                    class="m-1 p-1 badge-info z-depth-2">
                <i class="fa fa-undo fa-2x" aria-hidden="true"></i>
            </a>
            @if(false and $registro->id > 0)
            <a id="camara_modal" class="upload_form_modal m-1 py-1 px-2 badge black z-depth-2" href="#">
                <i class="fa fa-camera fa-2x pt-1" aria-hidden="true"></i>
            </a>
            @endif
            <a href="#" class="m-1 badge-warning text-white p-1 z-depth-2"
                    onclick="document.getElementById('seguro_form').submit();">
                <i class="fa fa-save fa-2x" aria-hidden="true"></i>
            </a>
        </div>           
    </div> 
    <div class="mt-4">
        <form id="seguro_form" method="POST" action="{{ $route }}" class="ml-4">

            @csrf
            {{ method_field($method) }}
               
            <div class="form-row">  
                <div class="col-md-3">
                    <div class="md-form"><label class="active">Nombre de Plan</label></div>
                    <select class="mdb-select md-form" id="nombre_plan_id" searchable="Buscar ..."
                        name="nombre_plan_id"></select>
                </div>  
                <div class="col-md-2">
                    <div class="md-form"><label class="active">Clasificación de Plan</label></div>
                    <select class="mdb-select md-form" id="clasificacion_plan_id" searchable="Buscar ..."
                        name="clasificacion_plan_id"></select>
                </div>  
                <div class="md-form col-3">
                    <label class="col-form-label active pl-3" 
                        style="margin-top: -8px;">Número de Póliza</label>
                    <input class="mt-3 col-11" id="poliza" type="text" name="poliza" 
                        value="{{ old('poliza',$registro->poliza) }}">
                </div> 
                <div class="md-form col-2">
                    <label class="col-form-label active pl-3" 
                        style="margin-top: -8px;">Fecha emisión</label>
                    <input class="mt-3 col-11" id="fecha_emision" type="date" name="fecha_emision" 
                        value="{{ old('fecha_emision',
                                is_null($registro->fecha_emision) ? '' :
                                $registro->fecha_emision->format('Y-m-d')) }}">
                </div> 
                <div class="md-form col-2">
                    <label class="col-form-label active pl-3" 
                        style="margin-top: -8px;">Fecha terminacion</label>
                    <input class="mt-3 col-11" id="fecha_terminacion" type="date" name="fecha_terminacion" 
                        value="{{ old('fecha_terminacion',
                                is_null($registro->fecha_terminacion) ? '' :
                                $registro->fecha_terminacion->format('Y-m-d')) }}">
                </div>                 
            </div>

            <div class="form-row">   
                <div class="col-md-2">
                    <div class="md-form"><label class="active">Tipo de Seguro</label></div>
                    <select class="mdb-select md-form" id="tipo_seguro_id" searchable="Buscar ..."
                        name="tipo_seguro_id"></select>
                </div>  
                <div class="col-md-2">
                    <div class="md-form"><label class="active">Método de Pago</label></div>
                    <select class="mdb-select md-form" id="metodo_pago_id" 
                        name="metodo_pago_id"></select>
                </div>  
                <div class="col-md-2">
                    <div class="md-form"><label class="active">Forma de Pago</label></div>
                    <select class="mdb-select md-form" id="forma_pago_id" 
                        name="forma_pago_id"></select>
                </div>  
                <div class="col-md-3">
                    <div class="md-form"><label class="active">Contratante</label></div>
                    <select class="mdb-select md-form" id="contratante_id" searchable="Buscar ..."
                        name="contratante_id"></select>
                </div>  
                <div class="col-md-3">
                    <div class="md-form"><label class="active">Asegurado Principal</label></div>
                    <select class="mdb-select md-form" id="asegurado_principal_id" searchable="Buscar ..."
                        name="asegurado_principal_id"></select>
                </div>  
            </div>

            <div class="form-row">   
                <div class="md-form col-2">
                    <label class="col-form-label active pl-3" 
                        style="margin-top: -8px;">Suma Asegurada</label>
                    <input class="mt-3 col-11" id="suma_asegurada" type="text" name="suma_asegurada" 
                        value="{{ old('suma_asegurada',$registro->suma_asegurada) }}">
                </div>  
                <div class="md-form col-2">
                    <label class="col-form-label active pl-3" 
                        style="margin-top: -8px;">Suma Asegurada Convertida</label>
                    <input class="mt-3 col-11" id="suma_asegurada_convertida" type="text" name="suma_asegurada_convertida" 
                        value="{{ old('suma_asegurada_convertida',$registro->suma_asegurada_convertida) }}">
                </div>  
                <div class="md-form col-2">
                    <label class="col-form-label active pl-3" 
                        style="margin-top: -8px;">Prima Anual</label>
                    <input class="mt-3 col-11" id="prima_anual" type="text" name="prima_anual" 
                        value="{{ old('prima_anual',$registro->prima_anual) }}">
                </div>  
                <div class="md-form col-2">
                    <label class="col-form-label active pl-3" 
                        style="margin-top: -8px;">Prima Anual Convertida</label>
                    <input class="mt-3 col-11" id="prima_anual_convertida" type="text" name="prima_anual_convertida" 
                        value="{{ old('prima_anual_convertida',$registro->prima_anual_convertida) }}">
                </div>  
                <div class="md-form col-2">
                    <label class="col-form-label active pl-3" 
                        style="margin-top: -8px;">Deducible Convertido</label>
                    <input class="mt-3 col-11" id="deducible_convertido" type="text" name="deducible_convertido" 
                        value="{{ old('deducible_convertido',$registro->deducible_convertido) }}">
                </div>  
                <div class="col-md-2">
                    <div class="md-form"><label class="active">Estatus</label></div>
                    <select class="mdb-select md-form" id="estatus_id" searchable="Buscar"
                        name="estatus_id"></select>
                </div>   
            </div>

            <div class="form-row">
                <label class="col-md-3">Comentarios</label>
                <textarea class="col-md-12" id="comentarios" type="textarea" 
                name="comentarios" rows="4" >{{old('comentarios',$registro->comentarios??'')}}</textarea>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts2')
    <script type="text/javascript">
        $(document).ready(function() {
            
            dynamicDropdown("{{ route('items',App\Models\Catalogo::NOMBRE_PLAN) }}", 
                {{ old('nombre_plan_id',$registro->nombre_plan_id??0) }}, 'nombre_plan_id');
            dynamicDropdown("{{ route('items',App\Models\Catalogo::CLASIFICACION_PLAN) }}", 
                {{ old('clasificacion_plan_id',$registro->clasificacion_plan_id??0) }}, 'clasificacion_plan_id');
            dynamicDropdown("{{ route('items',App\Models\Catalogo::METODO_PAGO) }}", 
                {{ old('metodo_pago_id',$registro->metodo_pago_id??0) }}, 'metodo_pago_id');
            dynamicDropdown("{{ route('items',App\Models\Catalogo::TIPO_SEGURO) }}", 
                {{ old('tipo_seguro_id',$registro->tipo_seguro_id??0) }}, 'tipo_seguro_id');
            dynamicDropdown("{{ route('items',App\Models\Catalogo::FORMA_PAGO) }}", 
                {{ old('forma_pago_id',$registro->forma_pago_id??0) }}, 'forma_pago_id');

            dynamicDropdown("{{ route('personas.seguro') }}", 
                {{ old('contratante_id',$registro->contratante_id??0) }}, 'contratante_id');
            dynamicDropdown("{{ route('personas.seguro') }}", 
                {{ old('asegurado_principal_id',$registro->asegurado_principal_id??0) }}, 'asegurado_principal_id');

            dynamicDropdown("{{ route('items',App\Models\Catalogo::ESTATUS) }}", 
                {{ old('estatus_id',$registro->estatus_id??0) }}, 'estatus_id');



        });
  </script>
@endpush  
  


