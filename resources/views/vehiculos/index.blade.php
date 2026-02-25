@extends('layouts.master')

@section('main-content')
<div class="m-2 p-1">
    <div class="card col-md-12 badge badge-light">
        <div class="d-flex flex-row mx-2 mt-2 mb-1">
            <div class="h4 pt-1">Agregar Vehículo</div>
            <div class="pt-1">
                <a href="{{route('vehiculos.create')}}" 
                    class="text-success text-capitalize mx-2 justify-vertical" 
                    style="margin-top: -2px;" title='Agregar Vehículo'>
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
            id="vehiculos_table" data-form="deleteForm">
                <thead class="">
                    <tr>
                        <th>Id</th>                        
                        <th>UUID</th>

                        <th>No Economico</th>
                        <th>Tipo Vehículo</th>
                        <th>Marca</th>
                        <th>Línea</th>
                        <th>Modelo</th>
                        <th>Placas</th>

                        <th>Sucursal</th>
                        <th>Area</th>

                        <th>Chofer</th>
                        <th>Nombre</th>                        
                        <th>Paterno</th>
                        <th>Materno</th>
                        
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@include('layouts.partials.modal.confirm_deletion',['route'=>'vehiculos',
        'modal_question'=>'Esta seguro de querer eliminar el registro?']) 
@endsection

@push('scripts2')
    @include('layouts.partials.modal.custom_script_delete')
    <script type="text/javascript">
        $(document).ready(function(){
            var vehiculos_table = $('#vehiculos_table').DataTable({
                responsive: !0,
                select: !0,
                searching: true,
                processing: true,
                serverSide: false,
                dom: '<"d-flex flex-row-reverse">t<"d-flex justify-content-between" ip>r',
                ajax: {
                        url: "{!! route('vehiculos.list') !!}",
                },
                
                //scrollX: false,
                columns: [
                    {data:'id', name:'id', searchable:false, orderable:true, width:'5%'},
                    {data:'uuid', name:'uuid', orderable:false},
                    {data:'no_economico', name:'no_economico', orderable:false},
                    {data:'tipo_vehiculo.name', name:'tipo_vehiculo.name', class:'text-capitalize'},
                    {data:'marca.name', name:'marca.name', class:'text-capitalize'},
                    {data:'linea.name', name:'linea.name', class:'text-capitalize'},
                    {data:'modelo', name:'modelo', class:'text-capitalize'},
                    {data:'placa', name:'placa', class:'text-capitalize'},

                    {data:'sucursal.name', name:'sucursal.name', class:'text-capitalize'},
                    {data:'area.name', name:'area.name', class:'text-capitalize'},

                    {data:'fullname', name:'fullname', class:'text-capitalize',
                        searchable:false, orderable:true, visible:true},
                    {data:'persona.nombre', name:'persona.nombre', class:'text-capitalize',
                        searchable:true, orderable:false, visible:false},
                    {data:'persona.paterno', name:'persona.paterno', class:'text-capitalize',
                        searchable:true, orderable:false, visible:false},
                    {data:'persona.materno', name:'persona.materno', class:'text-capitalize',
                        searchable:true, orderable:false, visible:false},                    
                 
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
            $("#vehiculos_table").DataTable().search( this.value ).draw();
        });
    </script>
@endpush