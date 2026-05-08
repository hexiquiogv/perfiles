<div id="table-container" class="p-3 col-12">
    <table class="table table-striped" cellspacing="0" width="100%" id="cotizaciones_table">
        <thead class="">
            <tr class="black white-text">
                <th>Id</th>
                <th>Proveedor</th>
                <th>Instalacion</th>
                <th>Monto</th>
            </tr>
        </thead>
    </table>
</div>

@push('scripts2')
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
                    {data:'proveedor.nombre_corto', name:'proveedor.nombre_corto'},
                    {data:'instalacion.nombre', name:'instalacion.nombre'},
                    {data:'monto', name:'monto', width:'40%'},                    
                ],
                order: [ 1, "desc" ]
            });

            $("#cotizaciones_search").on('keyup', function() {
                $("#cotizaciones_table").DataTable().search( this.value ).draw();
            });
        });
    </script>
@endpush