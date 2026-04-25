@extends('layouts.master')

@section('main-content')
<div class="my-4 py-4"></div>
<div class="m-2 p-1">
    <div class="card col-md-12 badge badge-light">
        <div class="d-flex flex-row mx-2 mt-2 mb-1">
            <div class="h4 pt-1">Ordenes de Servicio</div>
            <div class="d-flex flex-row ml-auto pr-2">
                <span class="p-1 mt-1 h6">Buscar</span>
                <input type="text" name="search" id="search" class="col-sm-10 form-control">
            </div>
        </div>
    </div>
    <div class="card-block">            
        <div id="table-container" class="p-3 col-md-12">
            <table class="table table-striped col-md-12" cellspacing="0" 
            id="mantenimientos_table" data-form="deleteForm">
                <thead class="">
                    <tr>
                        <th>Id</th>                        
                        <th>UUID</th>

                        <th>Folio</th>                        
                        <th>Unidad</th>
                        <th>Tipo Vehiculo</th>
                        <th>Marca</th>
                        <th>Linea</th>
                        <th>Placas</th>

                        <th>Empresa</th>
                        <th>Sucursal</th>
                        <th>Area</th>
                        <th>Chofer</th>

                        <th>Servicio(s)</th>

                        <th>Fecha Reporte</th>
                        <th>Fecha Estatus</th>
                        
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@push('scripts2')
    <script type="text/javascript">
        $(document).ready(function(){
            var mantenimientos_table = $('#mantenimientos_table').DataTable({
                responsive: !0,
                select: !0,
                searching: true,
                processing: true,
                serverSide: false,
                dom: '<"d-flex flex-row-reverse">t<"d-flex justify-content-between" ip>r',
                ajax: {
                        url: "{!! route('ordenes.list') !!}",
                },
                
                //scrollX: false,
                columns: [
                    {data:'id', name:'id', searchable:false, orderable:true, width:'8%'},
                    {data:'uuid', name:'uuid', orderable:false, visible:false},

                    {data:'folio', name:'folio'},
                    {data:'no_economico', name:'no_economico'},
                    {data:'tipo_vehiculo', name:'tipo_vehiculo', class:'text-capitalize'},
                    {data:'marca', name:'marca', class:'text-capitalize'},
                    {data:'linea', name:'linea', class:'text-capitalize'},
                    {data:'placa', name:'placa', class:'text-uppercase'},

                    {data:'empresa', name:'empresa', class:'text-uppercase'},
                    {data:'sucursal', name:'sucursal', class:'text-uppercase'},
                    {data:'area', name:'area', class:'text-uppercase'},
                    {data:'chofer', name:'chofer', class:'text-uppercase', orderable:true, visible:true},

                    {data:'servicios', name:'servicios', class:'text-capitalize'},
                    
                    {data:'fecha_reporte', name:'fecha_reporte'},
                    {data:'fecha_estatus', name:'fecha_estatus'},
                    
                    {data:'estatus.name', name:'estatus.name', class:'text-uppercase'},
                    {data: 'acciones', name:'acciones', searchable:false, orderable:false,
                        width:'15%',
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