<div class="mt-3 row col-12 justify-content-between">
	<div class="p-1">
 		<a href="{{route('contactos.create',$registro->id)}}" class="d-flex flex-row text-default">
	    	<h5 class="m-1">Contactos</h5>
	    	<i class="fa fa-plus-circle fa-2x"></i>
	    </a>
 	</div>
 	<div class="d-flex flex-row pr-2">
        <span class="p-1 mt-1 h6">Buscar</span>
        <input type="text" name="search" id="contactos_search" class="col-sm-10 form-control">
    </div>
</div>

<div id="table-container" class=" col-12">
    <table class="table table-striped" cellspacing="0" width="100%" id="contactos_table"
    	data-form="deleteForm">
        <thead class="">
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Cargo</th>
                <th>Email</th>
                <th>Telefono</th>
                <th>Rep. Legal</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>
</div>

@include ('layouts.partials.modal.confirm_deletion',['route'=>'contactos',
        'modal_question'=>'Esta seguro de querer eliminar el registro?']) 

</div>

@push('scripts2')
	@include('layouts.partials.modal.custom_script_delete')
    <script type="text/javascript">
    	$(document).ready(function() {
            var contactos_table = $('#contactos_table').DataTable({
                // autoWidth: false,
                responsive: !0,
                select: !0,
                searching: true,
                processing: true,
                serverSide: true,
                dom: '<"d-flex flex-row-reverse">t<"d-flex justify-content-between" ip>r',
                ajax: {
                    url: "{{ route('list.contactos',$registro->id) }}",
                },
                columns: [
                    {data:'id', name:'id', searchable:false},
                    {data:'nombre', name:'nombre', class:'nombre'},
                    {data:'puesto', name:'puesto', class:'puesto'},
                    {data:'email', name:'email', class:'email'},
                    {data:'telefono', name:'telefono', class:'telefono'},
                    {data:'representante.name', name:'representante.name'},
                    {data: 'acciones', name:'acciones', searchable:false, orderable:false,
                        width:'5%',
                        render: function(data,style,row,meta){
                             return $("<div/>").html(data).text();
                         }
                    }
                ],
                order: [ 1, "desc" ]
            });

            $("#contactos_search").on('keyup', function() {
                $("#contactos_table").DataTable().search( this.value ).draw();
            });
        });

    </script>
@endpush