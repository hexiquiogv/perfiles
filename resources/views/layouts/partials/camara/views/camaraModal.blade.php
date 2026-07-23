<a id="open_camara_modal" style="display:none;" data-toggle="modal" data-target="#camara">
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

                <div class="modal-body">
                    <div id="d-flex flex-column">
                        <div class="col-md-6">
                            <div class="md-form"><label class="active">Tipo de Documento</label></div>
                            <select class="mdb-select md-form" id="document_type_id" 
                                name="document_type_id"></select>
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
                                Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@section('custom_scripts')
    @include('layouts.partials.camara.js.upload_file_app')   
@endsection

@push('scripts2')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#camara_modal").on('click', function() {
                $("#open_camara_modal").click();
            });
            
            dynamicDropdown("{{ route('items',App\Models\Catalogo::DOCUMENT_TYPE ) }}", 
                {{old('document_type_id',0)}}, 'document_type_id');

        });
    </script>
@endpush
