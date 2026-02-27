@extends('layouts.master')

@section('content')


    <div class="container">
        <div class="card col-md-12 badge badge-light">
            <div class="d-flex flex-row mx-2 mt-2 mb-1">
                <div class="h4 pt-1">Proveedores</div>
                <div class="pt-1">
                    <a href="{{route('proveedores.create')}}" 
                        class="text-success text-capitalize mx-2 justify-vertical" 
                        style="margin-top: -2px;" title="Agregar Proveedor">
                        <i class="fa fa-plus-circle fa-2x pt-1"></i> 
                    </a>
                </div>
                <div class="d-flex flex-row ml-auto pr-2">
                    <span class="p-1 mt-1 h6">Buscar</span>
                    <input type="text" name="search" id="search" class="col-sm-10 form-control">
                </div>
            </div>
        </div>
            
        <div>
            <table class="table table-striped" cellspacing="0" width="100%" 
                id="proveedores_table" data-form="deleteForm">
                    <thead class="">
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Razón Social</th>
                            <th>RFC</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
            </table>
        </div>
    </div>

    @include ('layouts.partials.modal.confirm_deletion',['route'=>'proveedores',
        'modal_question'=>'Esta seguro de querer eliminar el registro?']) 

@endsection



@push('scripts2')
    @include('layouts.partials.modal.custom_script_delete')
    <script type="text/javascript">

        var proveedores_table = $('#proveedores_table').DataTable({
            responsive: !0,
            select: !0,
            searching: true,
            processing: true,
            serverSide: true,
            dom: '<"d-flex flex-row-reverse">t<"d-flex justify-content-between" ip>r',
            ajax: {
                    url: "{{route('list.proveedores')}}",
            },
            
            //scrollX: false,
            columns: [
                {data:'id', name:'id', searchable:false, orderable:true, 
                    class:'text-uppercase', width:'1%'},
                {data:'nombre_corto', name:'nombre', class:'text-uppercase'},
                {data:'razon_social', name:'razon_social', class:'text-uppercase nombre'},
                {data:'rfc', name:'rfc', class:'text-uppercase'},
                {data: 'estatus.name',name:'estatus', class: 'text-uppercase nombre'},
                {data:'acciones', name:'acciones', searchable:false, orderable:false,
                    class:'text-uppercase', width:'10%',
                    render: function(data,style,row,meta){
                        return $("<div/>").html(data).text();
                    }
                }
            ],
            order: [ 0, "asc" ]
        });

        $("#search").on('keyup', function() {
            $("#proveedores_table").DataTable().search( this.value ).draw();
        });
    </script>
@endpush

