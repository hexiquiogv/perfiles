@extends('layouts.master')

@section('content')
    <div class="">
        <div class="card col-md-12 badge badge-light d-flex flex-row justify-content-between">
            <div class="pl-2 pt-3 d-flex flex-row">
                <i class="fa fa-print fa-2x deep-orange-text"></i>
                <span class="h4 pl-2 black-text text-capitalize">
                    Reporte{{$registro->id > 0 ? " ({$registro->id})" : " Nuevo"}}
                </span>
            </div>
            
            <div class="ml-auto d-flex flex-row p-2">
                <a href="{!! route('reports.index') !!}" 
                        class="m-1 p-1 badge-info z-depth-2">
                    <i class="fa fa-undo fa-2x" aria-hidden="true"></i>
                </a>
                <a href="#" class="m-1 badge-warning text-white p-1 z-depth-2"
                        onclick="document.getElementById('reports_form').submit();">
                    <i class="fa fa-save fa-2x" aria-hidden="true"></i>
                </a>
            </div>           
        </div> 
            <form id="reports_form" method="POST" action="{{ $route }}">
                @csrf
                {{ method_field($method) }}
                
                <div class="d-flex flex-wrap m-2">
                    <div class="col-md-12 md-form">
                        <label class="label col-form-label active" style="margin-top: -8px;">
                            * Nombre</label>
                        <input type="text" id="title" name="title" 
                            class="form-control"
                            value="{{ old('title',$registro->title) }}">
                    </div>

                    <div class="col-12 flex-col" > 
                        <span class="cyan-text strong">Descripción</span>  
                        <textarea id="description" name="description" 
                            class="col-12 col-form" rows="5">{{ old('description',$registro->description ?? '')}}</textarea>
                    </div>

                    <div class="md-form col-md-2">
                        <label class="col-form-label active" style="margin-top: -8px;">
                            * Consulta
                        </label>
                        <select class="mdb-select" id="consulta_id" name="consulta_id"
                            required>
                        </select>
                    </div>

                    <div class="md-form col-md-2">
                        <label class="col-form-label active" style="margin-top: -8px;">
                            Estatus
                        </label>
                        <select class="mdb-select" id="status_id" name="status_id"
                            required>
                        </select>
                    </div>

                    <div class="md-form col-md-2">
                        <label class="active pl-3">Fecha Estatus</label>
                        <input class="form-control" id="fecha_status" type="date" 
                            value="{{old('fecha_status',$registro->fecha_status??'')}}"
                            name="fecha_status" >
                    </div>
                </div>

                @if($registro->id > 0 && !is_null($registro->columns))
                    <div class="m-2 col">
                        <div class="d-flex flex-row">
                            <span class="orange white-text strong z-depth-2 m-2 p-2">
                                Columnas a exportar 
                            </span>  

                            <div class="p-3">
                                <input class="form-check-input" type="checkbox" 
                                    value="Seleccionar todas columnas" 
                                    id="columns_check_all"
                                    aria-expanded="false" > 
                                <label class="form-check-label" 
                                        for="columns_check_all">
                                    Seleccionar todas columnas
                                </label>
                            </div>
                        </div>

                        <div id="columns" name="columns" 
                            class="d-flex flex-wrap col-md-12 mt-2"></div>
                    </div>
                @endif
                @if($registro->id > 0 && !is_null($registro->criterial_fields))
                    <div class="m-2 col">
                        <div class="d-flex flex-row">
                            <span class="cyan white-text strong z-depth-2 m-2 p-2">
                                Columnas a usar para filtrar
                            </span>  

                            <div class="p-3">
                                <input class="form-check-input" type="checkbox" 
                                    value="Seleccionar todas columnas" 
                                    id="criterial_fields_check_all"
                                    aria-expanded="false" > 
                                <label class="form-check-label" 
                                        for="criterial_fields_check_all">
                                    Seleccionar todas columnas
                                </label>
                            </div>
                        </div>
                        <div id="criterial_fields" name="criterial_fields" 
                            class="d-flex flex-wrap col-md-12 mt-2"></div>
                    </div>
                @endif
            </form>
        </div>
    <br>
    <br>

@endsection

@push('scripts2')
<script type="text/javascript">        
    $(document).ready(function() {

        dynamicDropdown("{{route('items',App\Models\Catalogo::STATUS_REPORT)}}", 
            {{ old('status_id',$registro->status_id ?? 0) }}, 'status_id');

        dynamicDropdown("{{route('consultas.items')}}", 
            {{ old('consulta_id',$registro->consulta_id ?? 0) }}, 'consulta_id');

        @if($registro->id > 0 && !is_null($registro->columns))
            $("#columns_check_all").change( function(event) {
                let value = $(this).is(":checked");
                $("input[type=checkbox][name='columns[]'").prop("checked", value);
            });  

            dynamicCheckboxes("{{route("report.model.columns",$registro->id)}}", 
                "{{$registro->columns}}", 
                "columns", "checkbox", "col-md-2 columns");
        @endif
        @if($registro->id > 0 && !is_null($registro->criterial_fields))
            $("#criterial_fields_check_all").change( function(event) {
                let value = $(this).is(":checked");
                $("input[type=checkbox][name='criterial_fields[]'").prop("checked", value);
            }); 

            dynamicCheckboxes("{{route("report.model.columns",$registro->id)}}", 
                "{{$registro->criterial_fields}}",
                "criterial_fields","checkbox","col-md-2 criterial_fields");
        @endif

        $("select[name=model_id]").change(function(e){
            $("#reports_form").submit();
        });
    });
</script>
@endpush