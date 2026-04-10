<a id="open_firma_modal" class="black-text" data-toggle="modal" data-target="#firma">
</a>
<!-- Modal HTML -->
<div id="firma" class="modal">
    <div class="modal-dialog">
        <div class="modal-content container">
            <div class="modal-header">
                <span class="h5" id="firma_modal_titulo">Firmar documento</span>
                <button id="btn_closeFirmaModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="row">
                <div class="col-md-12 mt-5">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success  alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">×</button>  
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('signaturepad.upload') }}">
                        @csrf
                        <div class="col-md-12 d-flex flex-column">
                            <div id="sig" ></div>
                            <textarea id="signature64" name="signed" style="display: none"></textarea>
                        </div>
                        <div class="d-flex justify-content-end col-md-12">
                            <button id="clear" class="btn btn-danger btn-sm">Borrar</button>
                            <button class="btn btn-success btn-sm">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts2')
    <script type="text/javascript">
        $(document).ready(function() {
            var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});

            $("#firma_modal").on('click', function() {
                $('#clear').click(function(e) {
                    e.preventDefault();
                    sig.signature('clear');
                    $("#signature64").val('');
                });
                $("#open_firma_modal").trigger("click");
            });
        });

        function saveFirmaURL(input) {

            $('#save_image').removeAttr('hidden');
            $('#fileUploaded').attr('src', "");

            var formdata = false;
            if (window.FormData) {
                formdata = new FormData();
                }

            if (input.files && input.files[0]) {
                var file = input.files[0], reader;

                if (!!file.type.match(/image.*/)) {
                            if (window.FileReader) {
                    reader = new FileReader();
                    reader.onloadend = function (e) {
                        $('#fileUploaded').attr('src', e.target.result);
                    $('#fileUploaded').attr('style', 'width:98%;');
                                    };
                    reader.readAsDataURL(file);
                                }

                    if (formdata) {
                            formdata.append("image", file);
                    }
                }
            }
        }

    </script>
@endpush


