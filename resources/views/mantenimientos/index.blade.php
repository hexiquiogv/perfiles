@extends('layouts.master')

@section('main-content')
<div class="m-2 p-1">
    <div class="card col-md-12 badge badge-light">
        <div class="d-flex flex-row mx-2 mt-2 mb-1">
            <div class="h4 pt-1">Mantenimiento Vehicular</div>
            <div class="pt-1">
                <a href="{{route('mantenimientos.create')}}" 
                    class="text-success text-capitalize mx-2 justify-vertical" 
                    style="margin-top: -2px;" title='Mantenimiento Vehicular'>
                    <i class="fa fa-plus-circle fa-2x pt-1"></i> 
                </a>
            </div>
            <div class="d-flex flex-row ml-auto pr-2">
                <span class="p-1 mt-1 h6">Buscar</span>
                <input type="text" name="search" id="search" class="col-sm-10 form-control">
            </div>
        </div>
    </div>
    <div class="card-block">            
        <div id="table-container" class="p-3 col-12">
            <table class="table table-striped" cellspacing="0" width="100%" 
            id="mantenimientos_table" data-form="deleteForm">
                <thead class="">
                    <tr>
                        <th>Id</th>                        
                        <th>UUID</th>
                        <th>Folio</th>
                        <th>Nombre</th>                        
                        <th>Paterno</th>
                        <th>Materno</th>
                        <th>Chofer</th>
                        <th>Unidad</th>
                        <th>Nombre de Plan</th>
                        <th>Tipo de Seguro</th>
                        <th>Fecha Emisión</th>
                        <th>Clasificación de Plan</th>
                        <th>Días para Vencimiento</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@include ('layouts.partials.modal.confirm_deletion',['route'=>'mantenimientos',
        'modal_question'=>'Esta seguro de querer eliminar el registro?']) 
@endsection

@push('scripts2')
    @include('layouts.partials.modal.custom_script_delete')
    <script type="text/javascript">
        $(document).ready(function(){
            var mantenimientos_table = $('#mantenimientos_table').DataTable({
                // autoWidth: false,
                responsive: !0,
                select: !0,
                searching: true,
                processing: true,
                serverSide: false,
                // stateSave -  preserva el estado del datatable, cuando el usuario regresa
                //              le muestra el datatable en el mismo estado 
                dom: '<"d-flex flex-row-reverse">t<"d-flex justify-content-between" ip>r',
                ajax: {
                        url: "{!! route('seguros.list') !!}",
                },
                
                //scrollX: false,
                columns: [
                    {data:'id', name:'id', searchable:false, orderable:true, width:'5%'},
                    {data:'uuid', name:'uuid', orderable:false},
                    {data:'fullname', name:'fullname', class:'text-capitalize',
                        searchable:false, orderable:true, visible:true},
                    {data:'contratante.nombre', name:'contratante.nombre', class:'text-capitalize',
                        searchable:true, orderable:false, visible:false},
                    {data:'contratante.paterno', name:'contratante.paterno', class:'text-capitalize',
                        searchable:true, orderable:false, visible:false},
                    {data:'contratante.materno', name:'contratante.materno', class:'text-capitalize',
                        searchable:true, orderable:false, visible:false},
                    {data:'poliza', name:'poliza', class:'text-capitalize nombre',
                        searchable:true, orderable:true},
                    {data:'nombre_plan.name', name:'nombre_plan.name', class:'text-capitalize'},
                    {data:'tipo_seguro.name', name:'tipo_seguro.name', class:'text-capitalize'},
                    {data:'fecha_emision', name:'fecha_emision',
                        render: function(data,style,row,meta){
                            if (data == null) return "";
                            return data.substring(0,10);
                        }
                    },
                    {data:'clasificacion_plan.name', name:'clasificacion_plan.name', class:'text-capitalize'},
                    {data:'dias_vencimiento', name:'dias_vencimiento', class:'text-capitalize'},
                    {data:'estatus.name', name:'estatus.name', class:'text-capitalize'},
                    {data: 'acciones', name:'acciones', searchable:false, orderable:false,
                        width:'10%',
                        render: function(data,style,row,meta){
                             return $("<div/>").html(data).text();
                        }
                    }
                ],
                order: [ 0, "desc" ]
            });
        });

        $("#search").on('keyup', function() {
            $("#mantenimientos_table").DataTable().search( this.value ).draw();
        });
    </script>
@endpush