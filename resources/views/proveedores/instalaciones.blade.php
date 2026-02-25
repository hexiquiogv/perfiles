<div class="mt-3 row col-12 justify-content-between">
	<div class="p-1">
 		<a href="{{route('instalaciones.create',$registro->id)}}" class="d-flex flex-row text-default">
	    	<h5 class="m-1">{{__('messages.instalacion')}}</h5>
	    	<i class="fa fa-plus-circle fa-2x"></i>
	    </a>
 	</div>
 	<div class="d-flex flex-row pr-2">
        <span class="p-1 mt-1 h6">Buscar</span>
        <input type="text" name="search" id="instalaciones_search" class="col-sm-10 form-control">
    </div>
</div>

<div id="table-container" class=" col-12">
    <table class="table table-striped" cellspacing="0" width="100%" 
        id="instalaciones_table" data-form="deleteForm">
        <thead class="">
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Contacto</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>
</div>

@include ('layouts.partials.modal.confirm_deletion',['route'=>'instalaciones',
        'modal_question'=>'Esta seguro de querer eliminar el registro?']) 

</div>

@push('scripts2')
	@include('layouts.partials.modal.custom_script_delete')
    <script type="text/javascript">
    	$(document).ready(function() {
            var instalaciones_table = $('#instalaciones_table').DataTable({
                // autoWidth: false,
                responsive: !0,
                select: !0,
                searching: true,
                processing: true,
                serverSide: true,
                dom: '<"d-flex flex-row-reverse">t<"d-flex justify-content-between" ip>r',
                ajax: {
                    url: "{{ route('list.instalaciones',$registro->id) }}",
                },
                columns: [
                    {data:'id', name:'id', searchable:false},
                    {data:'nombre', name:'nombre', class:'nombre'},
                    {data:'direccion', name:'direccion'},
                    {data:'contacto.nombre', name:'contacto.nombre'},
                    {data:'telefono', name:'telefono', class:'telefono'},
                    {data: 'acciones', name:'acciones', searchable:false, orderable:false,
                        width:'5%',
                        render: function(data,style,row,meta){
                             return $("<div/>").html(data).text();
                         }
                    }
                ],
                order: [ 1, "desc" ]
            });

            $("#instalaciones_search").on('keyup', function() {
                $("#instalaciones_table").DataTable().search( this.value ).draw();
            });
        });

    </script>
@endpush