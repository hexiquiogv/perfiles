<a id="open_camara_modal" class="black-text" data-toggle="modal" data-target="#camara">
</a>
<!-- Modal HTML -->
<div id="camara" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="h5" id="camara_modal_titulo">Subir documento</span>
                <button id="btn_closeUploadFileModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id='upload_image_form' action={{route('media.store')}} 
                enctype="multipart/form-data" method='POST'> 

                @csrf

                <input type="hidden" name="back_url" value={{$back_url}}>
                <input type="hidden" name="model_id" value={{$model_id}}>
                <input type="hidden" name="model_name" value={{$model_name}}>
                <input type="hidden" name="extras" value="">

                <div class="modal-body">
                    <div id="d-flex flex-column">
                        <div class="col-md-6">
                            <div class="md-form"><label class="active">Tipo de Documento</label></div>
                            <select class="mdb-select md-form" id="document_type_id" 
                                name="document_type_id"></select>
                        </div> 

                        <div id="factura_section" style="display: none;">
                            <div class="row">     
                                <div class="col-md-11 d-flex flex-column">
                                    <div class="md-form ml-3"><label class="active">Número de Factura</label></div>
                                    <input class="ml-3 form-control" id="factura" type="text" name="factura" value="">
                                </div>  
                            </div>
                            <div class="row">     
                                <div class="col-md-11 d-flex flex-column">
                                    <div class="md-form  ml-3"><label class="active">Monto</label></div>
                                    <input class="ml-3 form-control" id="Monto" type="text" name="monto" value=""
                                        placeholder="0.00">
                                </div>  
                            </div>
                            <br>
                        </div>
                        
                    </div>                    

                    <div class="file-field">
                        <div class="btn btn-primary">
                            <span>Subir Archivo/Tomar Foto</span>
                            <input type="file" id="uploadFile" name="uploadFile">
                        </div>
                        <div class="file-path-wrapper pt-1">
                           <input class="file-path validate" type="text" 
                           placeholder="Selecciona el documento">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <div class="form-group">
                        <button class='btn btn-primary' id='save_image' type="submit">
                                Guardar Archivo
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts2')
    @include('layouts.partials.camara.js.upload_file_app')    

    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="document_type_id"]').change(function(e){
                var document_type = $('select[name="document_type_id"] option:selected').text();
                $('#monto').val('');
                $('#factura').val('');
                $('#monto').prop('required', false);
                $('#factura').prop('required', false);
                if (document_type.trim() == "factura (pdf)"){                    
                    $('#monto').prop('required', true);
                    $('#factura').prop('required', true);
                    $('#factura_section').show();
                } else{
                    $('#factura_section').hide();
                }
                    
            });
        });
    </script>
@endpush

