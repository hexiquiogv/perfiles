@extends('layouts.master')

@section('main-content')
<div class="m-2 p-1">
    <div class="card col-md-12 badge badge-light">
        <div class="d-flex flex-row mx-2 mt-2 mb-1">
            <div class="h4 pt-1">Agregar Persona</div>
            <div class="pt-1">
                <a href="{{route('personas.create')}}" 
                    class="text-success text-capitalize mx-2 justify-vertical" 
                    style="margin-top: -2px;" title='Agregar Persona'>
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
            id="personas_table" data-form="deleteForm">
                <thead class="">
                    <tr>
                        <th>Id</th>                        
                        <th>UUID</th>
                        <th>Nombre</th>                        
                        <th>Paterno</th>
                        <th>Materno</th>
                        <th>Nombre</th>
                        <th>Polizas</th>
                        <th>Sexo</th>
                        <th>Estado Civil</th>
                        <th>Fecha Nacimiento</th>
                        <th>Email</th>
                        <th>Telefono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@include ('layouts.partials.modal.confirm_deletion',['route'=>'personas',
        'modal_question'=>'Esta seguro de querer eliminar el registro?']) 
@endsection

@push('scripts2')
    @include('layouts.partials.modal.custom_script_delete')
    <script type="text/javascript">
        $(document).ready(function(){
            var personas_table = $('#personas_table').DataTable({
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
                        url: "{!! route('personas.list') !!}",
                },
                
                //scrollX: false,
                columns: [
                    {data:'id', name:'id', searchable:false, orderable:true, width:'5%'},
                    {data:'uuid', name:'uuid', orderable:false},
                    {data:'nombre', name:'nombre', class:'text-capitalize', visible:false},
                    {data:'paterno', name:'paterno', class:'text-capitalize', visible:false},
                    {data:'materno', name:'materno', class:'text-capitalize', visible:false},
                    {data:'fullname', name:'fullname', class:'text-capitalize', searchable:false},
                    {data:'polizas', name:'polizas', orderable:false,
                        width:'10%',
                        render: function(data,style,row,meta){
                             return $("<div/>").html(data).text();
                        }
                    },
                    {data:'sexo.name', name:'sexo.name', class:'text-capitalize'},
                    {data:'estado_civil.name', name:'estado_civil.name', class:'text-capitalize'},
                    {data:'fecha_nacimiento', name:'fecha_nacimiento',
                        render: function(data,style,row,meta){
                            if (data == null) return "";
                            return data.substring(0,10);
                        }
                    },
                    {data:'email', name:'email'},
                    {data:'telefono', name:'telefono'},
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
            $("#personas_table").DataTable().search( this.value ).draw();
        });
    </script>
@endpush