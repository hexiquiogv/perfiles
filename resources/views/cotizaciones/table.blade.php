<div id="table-container" class="p-4 col-12 my-4" >
    <table class="table table-striped" cellspacing="0" width="100%" id="cotizaciones_table"
        data-form="deleteForm">
        <thead class="">
            <tr class="black white-text">
                <th>Id</th>
                <th>Proveedor</th>
                <th>Instalacion</th>
                <th>Monto</th>
                <th>Seleccionada</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>
    <br><br>
</div>

@include ('layouts.partials.modal.confirm_deletion',['route'=>'cotizaciones',
        'modal_question'=>'Esta seguro de querer eliminar el registro?']) 

@push('scripts2')
    @include('layouts.partials.modal.custom_script_delete')
    <script type="text/javascript">
        $(document).ready(function(){
            var cotizaciones_table = $('#cotizaciones_table').DataTable({
                // autoWidth: false,
                responsive: !0,
                select: !0,
                searching: true,
                processing: true,
                serverSide: true,
                // stateSave -  preserva el estado del datatable, cuando el usuario regresa
                //              le muestra el datatable en el mismo estado 
                dom: '<"d-flex flex-row-reverse">t<"d-flex justify-content-between">r',
                ajax: {
                        url: "{!! route('orden_servicio_cotizaciones.list',$registro->uuid) !!}",
                },
                
                //scrollX: false,
                columns: [
                    {data:'id', name:'id', searchable:false, orderable:true, visible:false},
                    {data:'proveedor.nombre_corto', name:'proveedor.nombre_corto', class:'nombre text-uppercase'},
                    {data:'instalacion.nombre', name:'instalacion.nombre', class:'text-uppercase'},
                    {data:'monto', name:'monto', width:'5%'}, 
                    {data: 'seleccionada', name:'seleccionada', class:'text-uppercase',
                        width:'15%',
                        render: function(data,style,row,meta){
                             return $("<div/>").html(data).text();
                        }
                    },
                    {data: 'acciones', name:'acciones', searchable:false, orderable:false,
                        width:'15%',
                        render: function(data,style,row,meta){
                             return $("<div/>").html(data).text();
                        }
                    }                   
                ],
                order: [ 1, "desc" ]
            });

            $("#cotizaciones_search").on('keyup', function() {
                $("#cotizaciones_table").DataTable().search( this.value ).draw();
            });
        });
    </script>
@endpush