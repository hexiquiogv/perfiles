@extends('layouts.master')

@section('content')
<div class="">
    <div class="card col-md-12 badge badge-light">
        <div class="d-flex flex-row mx-2 mt-2 mb-1">
            <div class="h4 pt-1"><i class="fa fa-th-large green-text fa-1x"></i> Consultas</div>
            <div class="pt-1">
                <a href="{{route('consultas.create')}}" style="margin-top: -2px;" 
                    title="Agregar Consultas"
                    class="text-success text-capitalize mx-2 justify-vertical">
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
            <table class="table table-striped" cellspacing="0" 
                width="100%" id="consultas_table" data-form="deleteForm">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Fuente de Datos</th>
                        <th>Nombre</th>
                        <th>Vista</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>User</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@include ('layouts.partials.modal.confirm_deletion',['route'=>'consultas',
        'modal_question'=>'Esta seguro de querer eliminar el registro?']) 
@endsection

@push('scripts2')
    @include('layouts.partials.modal.custom_script_delete')
    <script type="text/javascript">
        $(document).ready(function(){
            var consultas_table = $('#consultas_table').DataTable({
                    // autoWidth: false,
                    responsive: !0,
                    searching: true,
                    processing: true,
                    serverSide: true,
                    //stateSave: true, 
                    dom: '<"d-flex flex-row-reverse">t<"d-flex justify-content-between"ip>',
                    ajax: {
                        url: "{{route('consultas.list')}}",
                    },
                    
                    //scrollX: false,
                    columns: [
                        {data:'id', name:'id', searchable:false},
                        {data:'origen.name', name:'origen.name', class:'text-uppercase'},
                        {data:'title', name:'title', class:'text-uppercase nombre'},
                        {data:'vista', name:'vista', class:'text-uppercase'},
                        {data:'description', name:'description', class:'text-lowercase'},
                        {data:'updated_at', name:'updated_at',
                            width:'12%',
                            render: function(data,style,row,meta){
                                if (data == null) return "";
                                return data.substring(0,10);
                            }
                        },
                        {data:'user.fullname', name:'user.fullname', class:'text-lowercase'},
                        {data:'status.name', name:'status.name', class:'text-lowercase'},
                        {data: 'acciones', name:'acciones', searchable:false, orderable:false, width:'18%',
                             render: function(data,style,row,meta){
                                 return $("<div/>").html(data).text();
                             }
                        }
                    ],
                    order: [ 1, "desc" ]
            });

            $("#search").on('keyup', function() {
                $("#consultas_table").DataTable().search( this.value ).draw();
            });
        });
    </script>
@endpush