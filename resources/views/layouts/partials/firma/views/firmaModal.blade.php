<a id="open_firma_modal" class="black-text" data-toggle="modal" data-target="#firma">
</a>
<!-- Modal HTML -->
<div id="firma" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="h5" id="firma_modal_titulo">Firmar documento</span>
                <button id="btn_closeFirmaModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('signaturepad.upload') }}">
                @csrf
                <div class="col-md-12">
                    <label class="" for="">Firmar en el recuadro:</label>
                    <br/>
                    <div id="sig" ></div>
                    <br/>
                    <button id="clear" class="btn btn-danger btn-sm">Borrar</button>
                    <textarea id="signature64" name="signed" style="display: none"></textarea>
                </div>
                <br/>
                <button class="btn btn-success">Guardar</button>
                <a class="btn btn-warning" href="{{ route('welcome') }}">Cancelar</a>
            </form>
        </div>
    </div>
</div>

@section('custom_css')
    @include('layouts.partials.firma.css.firma_modal_css')
@endsection

@push('scripts2')
    @include('layouts.partials.firma.js.firma_app')    

    <script type="text/javascript">
        $(document).ready(function() {
            $("#firma_modal").on('click', function() {
                $("#open_firma_modal").trigger("click");
            });
        });
    </script>
@endpush
