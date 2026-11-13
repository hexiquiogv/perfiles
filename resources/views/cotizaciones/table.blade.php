<div id="table-container" class="col-md-12" >
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
                    {data:'monto', name:'monto', width:'5%', class:'text-uppercase',
                        render: function(data,style,row,meta){
                            // Si se va a ordenar o filtrar, es mejor devolver el número puro o formateado según el tipo
                            let numero = parseFloat(data);

                            // Validar que sea un número válido
                            if (isNaN(numero)) return data;

                            return new Intl.NumberFormat('es-MX', {
                                    style: 'decimal',
                                    minimumFractionDigits: 2, // Mínimo de decimales (ej. 10 -> 10.00)
                                    maximumFractionDigits: 2  // Máximo de decimales (ej. 10.456 -> 10.46)
                                }).format(numero);
                                
                        }
                    },
                    {data: 'seleccionada', name:'seleccionada', class:'text-uppercase',
                        width:'15%',
                        render: function(data,style,row,meta){
                             return $("<div/>").html(data).text();
                        }
                    },
                    {data: 'acciones', name:'acciones', searchable:false, orderable:false,
                        width:'15%', class:'text-uppercase',
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