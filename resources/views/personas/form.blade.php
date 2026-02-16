@extends('layouts.master')

@section('main-content')
<div class="p-2 m-2">
    <div class="card col-md-12 badge orange d-flex flex-row justify-content-between z-depth-2 rounded">
        <div class="pl-2 pt-3">
            <span class="h4 pt-1 pl-2">{{$title}}</span>
        </div>

        <div class="ml-auto d-flex flex-row p-2">
            <a href="{!! route('personas.index') !!}" class="m-1 p-1 badge-info z-depth-2">
                <i class="fa fa-undo fa-2x" aria-hidden="true"></i>
            </a>
            <a href="#" class="m-1 badge-warning text-white p-1 z-depth-2"
                    onclick="document.getElementById('persona_form').submit();">
                <i class="fa fa-save fa-2x" aria-hidden="true"></i>
            </a>
        </div>           
    </div> 
    <div class="mt-4">
        <form id="persona_form" method="POST" action="{{ $route }}" class="ml-4">

            @csrf
            {{ method_field($method) }}

            <div class="form-row">  
                <div class="md-form col-3">
                    <label class="col-form-label active pl-3" 
                        style="margin-top: -8px;">Nombre</label>
                    <input class="mt-3 col-11" id="nombre" type="text" name="nombre" 
                        value="{{ old('nombre',$registro->nombre) }}">
                </div> 
                <div class="md-form col-3">
                    <label class="col-form-label active pl-3" 
                        style="margin-top: -8px;">Apellido Paterno</label>
                    <input class="mt-3 col-11" id="paterno" type="text" name="paterno" 
                        value="{{ old('paterno',$registro->paterno) }}">
                </div> 
                <div class="md-form col-3">
                    <label class="col-form-label active pl-3" 
                        style="margin-top: -8px;">Apellido materno</label>
                    <input class="mt-3 col-11" id="materno" type="text" name="materno" 
                        value="{{ old('materno',$registro->materno) }}">
                </div> 
                <div class="md-form col-2">
                    <label class="col-form-label active pl-3" 
                        style="margin-top: -8px;">Fecha nacimiento</label>
                    <input class="mt-3 col-11" id="fecha_nacimiento" type="date" name="fecha_nacimiento" 
                        value="{{ old('fecha_nacimiento',
                                is_null($registro->fecha_nacimiento) ? '' :
                                $registro->fecha_nacimiento->format('Y-m-d')) }}">
                </div> 
            </div>

            <div class="form-row">   
                <div class="col-md-2">
                    <div class="md-form"><label class="active">Sexo</label></div>
                    <select class="mdb-select md-form" id="sexo_id" 
                        name="sexo_id"></select>
                </div>  
                <div class="col-md-2">
                    <div class="md-form"><label class="active">Estado civil</label></div>
                    <select class="mdb-select md-form" id="estado_civil_id" 
                        name="estado_civil_id"></select>
                </div>  
                <div class="md-form col-2">
                    <label class="col-form-label active pl-3" 
                        style="margin-top: -8px;">Email</label>
                    <input class="mt-3 col-11" id="email" type="text" name="email" 
                        value="{{ old('email',$registro->email) }}">
                </div>  
                <div class="md-form col-2">
                    <label class="col-form-label active pl-3" 
                        style="margin-top: -8px;">Telefono</label>
                    <input class="mt-3 col-11" id="telefono" type="text" name="telefono" 
                        value="{{ old('telefono',$registro->telefono) }}">
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
            
            dynamicDropdown("{{ route('items',App\Models\Catalogo::ESTADO_CIVIL) }}", 
                {{ old('estado_civil_id',$registro->estado_civil_id??0) }}, 'estado_civil_id');
            dynamicDropdown("{{ route('items',App\Models\Catalogo::SEXO) }}", 
                {{ old('sexo_id',$registro->sexo_id??0) }}, 'sexo_id');
        
        });
  </script>
@endpush  
  


