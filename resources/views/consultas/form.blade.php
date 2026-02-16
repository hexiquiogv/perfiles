@extends('layouts.master')

@section('content')
    <div class="">
        <div class="card col-md-12 badge badge-light d-flex flex-row justify-content-between">
            <div class="pl-2 pt-3 d-flex flex-row">
                <i class="fa fa-th-large green-text fa-2x"></i>
                <span class="h4 pl-2 black-text text-capitalize">
                    Consulta {{$registro->id > 0 ? " ({$registro->id})" : " Nueva"}}
                </span>
            </div>
            
            <div class="ml-auto d-flex flex-row p-2">
                <a href="{!! route('consultas.index') !!}" 
                        class="m-1 p-1 badge-info z-depth-2">
                    <i class="fa fa-undo fa-2x" aria-hidden="true"></i>
                </a>
                <a href="#" class="m-1 badge-warning text-white p-1 z-depth-2"
                        onclick="document.getElementById('consultas_form').submit();">
                    <i class="fa fa-save fa-2x" aria-hidden="true"></i>
                </a>
            </div>           
        </div> 
        <form id="consultas_form" method="POST" action="{{ $route }}">
            @csrf
            {{ method_field($method) }}
            
            <div class="d-flex flex-wrap m-2">
                <div class="col-md-4 md-form">
                    <label class="label col-form-label active" style="margin-top: -8px;">
                        * Nombre de Consulta</label>
                    <input type="text" id="title" name="title" required class="form-control"
                        value="{{ old('title',$registro->title) }}">
                </div>

                <div class="col-md-4 md-form">
                    <label class="label col-form-label active" style="margin-top: -8px;">
                        * Nombre de Vista</label>
                    <input type="text" id="vista" name="vista" required class="form-control"
                        value="{{ old('vista',$registro->vista) }}">
                </div>

                 <div class="col-md-4 d-flex flex-column p-2">
                    <span class="teal-text small"> * Origen</span>
                    <select class="mdb-select col-md-12" id="origen_informacion_id" 
                        name="origen_informacion_id" required>
                    </select>
                </div>

                <div class="col-12 flex-col" > 
                    <span class="teal-text small strong">Descripción</span>  
                    <textarea id="description" name="description" class="col-12 col-form" 
                        rows="2">{{ old('description',$registro->description ?? '')}}</textarea>
                </div>

                <div class="col-12 flex-col mt-4" > 
                    <span class="teal-text small strong">Script de Consulta</span>  
                    <textarea id="sql_script" name="sql_script" class="col-12 col-form" 
                        rows="6">{{ old('sql_script',$registro->sql_script ?? '')}}</textarea>
                </div>
                <div class="md-form col-md-2">
                    <label class="col-form-label active" style="margin-top: -8px;">
                        Estatus
                    </label>
                    <select class="mdb-select" id="status_id" name="status_id"
                        required>
                    </select>
                </div>
            </div>
        </form>
        <div class="m-4">
            <span>
                <span class="h5">Nota:</span> Si se trata de una 
                <span class="h5">vista</span>, 
                no olvide definir un campo adicional llamado 
                <span class="h5">primary_key</span>
            </span>
        </div>
    </div>
    <br>
    <br>

@endsection

@push('scripts2')
<script type="text/javascript">        
    $(document).ready(function() {

        $(document).ready(function() {
            dynamicDropdown("{{route('items',App\Models\Catalogo::ORIGEN_INFORMACION)}}", 
                {{ old('origen_informacion_id',$registro->origen_informacion_id ?? 0) }}, 'origen_informacion_id');

            dynamicDropdown("{{route('items',App\Models\Catalogo::STATUS_REPORT)}}", 
                {{ old('status_id',$registro->status_id ?? 0) }}, 'status_id');
        });

    });
</script>
@endpush