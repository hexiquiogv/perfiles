<a id="cotizacion_link" type="hidden" data-toggle="modal" data-target="#cotizacion">
</a>
<div class="modal" id="cotizacion">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div id="modal-cotizacion-title" class="modal-title">
                    Cotización de Proveedor
                </div>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fa fa-window-close blue-text"></i>
                </button>
            </div>
            <div class="modal-footer col-md-12">
                <form method="POST" action="{{ route('cotizacion',$registro->uuid) }}" class="col-md-12">

                    @csrf
                    <div class="row">
                        <span class="teal-text col-md-3 mt-1">Proveedor</span>
                        <select class="mdb-select col-md-8" id="proveedor_id" searchable="Buscar ..."   
                            name="proveedor_id"></select>
                    </div> 
                    <div class="row">
                        <span class="teal-text col-md-3 mt-1">Instalación</span>
                        <select class="mdb-select col-md-8" id="instalacion_id"   
                            name="instalacion_id"></select>
                    </div> 

                    <div class="row">
                        <div class="col-md-3"><label class="active">Monto</label></div>
                        <input class="col-md-6 ml-3" id="monto" type="text" name="monto" value="">
                    </div> 

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">  
                            Cancelar <i class="fa fa-undo ml-1"></i></button>
                        <button type="submit" class="btn btn-sm btn-warning" >
                            Gardar <i class="fa fa-save ml-1"></i></button>
                    </div>
                 </form>
            </div>
        </div>
    </div>
</div>

@push('scripts2')
    <script type="text/javascript">
        $(document).ready(function() {
            dynamicDropdown("{{ route('items.proveedores') }}", 0, 'proveedor_id');
            
            $('#proveedor_id').change(function(e){
                var optionId = $('select[name="proveedor_id"] option:selected').val();
                clearDropdown( $('select[name="instalacion_id"]') );
                dynamicDropdown("/instalaciones_proveedor/"+optionId, 0, 'instalacion_id');  
            });

                      
        });
    </script>
@endpush 