@extends('layouts.master')

@section('main-content')
<div class="p-2 m-2">
    <div class="card col-md-12 badge orange d-flex flex-row justify-content-between z-depth-2 rounded">
        <div class="pl-2 pt-3">
            <span class="h4 pt-1 pl-2">{{$title}}</span>
        </div>

        <div class="ml-auto d-flex flex-row p-2">
            <a href="{!! route('mantenimientos.index') !!}" 
                    class="m-1 p-1 badge-info z-depth-2">
                <i class="fa fa-undo fa-2x" aria-hidden="true"></i>
            </a>
            @if($registro->id > 0)
            <a id="camara_modal" class="upload_form_modal m-1 py-1 px-2 badge black z-depth-2" href="#">
                <i class="fa fa-camera fa-2x pt-1" aria-hidden="true"></i>
            </a>
            <a class="m-1 py-1 px-2 badge green z-depth-2" target="_blank"
                href="{{ route('signaturepad',['model_name'=>get_class($registro),'model_id'=>$registro->uuid]) }}">
                <i class="fa fa-send fa-2x pt-1" aria-hidden="true"></i>
            </a>
            @endif
            <a href="#" class="m-1 badge-warning text-white p-1 z-depth-2"
                    onclick="document.getElementById('mantenimiento_form').submit();">
                <i class="fa fa-save fa-2x" aria-hidden="true"></i>
            </a>
        </div>           
    </div> 
</div>

<div class="m-4">
    @include('mantenimientos.form', ['readonly'=>'','disabled'=>''])
</div>

<div class="d-flex flex-wrap">
    <div class="col-lg-9">
        @includeWhen($registro->id ?? 0 > 0, 'layouts.partials.camara.views.show_media')
    </div>
</div>

@includeWhen($registro->id ?? 0 > 0, 'layouts.partials.camara.views.camaraModal', ['back_url'=>$back_url, 
        'model_name'=>get_class($registro),'model_id'=>$registro->uuid ])  

@endsection

@push('scripts2')
    <script type="text/javascript">
        $(document).ready(function() {
            dynamicDropdown("{{ route('personal') }}", 
                {{ old('chofer_id',$registro->chofer_id??0) }}, 'chofer_id');
            dynamicDropdown("{{ route('flotilla') }}", 
                {{ old('vehiculo_id',$registro->vehiculo_id??0) }}, 'vehiculo_id');
            
            getVehiculo({{ $registro->vehiculo_id }});

            $('#vehiculo_id').change(function(e){
                var optionId = $('select[name="vehiculo_id"] option:selected').val();

                getVehiculo(optionId);
            });

            

            @if($registro->id > 0 || Auth::check())
                $("#camara_modal").on('click', function() {
                    $("#open_camara_modal").trigger("click");
                });
                
                dynamicDropdown("{{ route('items',App\Models\Catalogo::DOCUMENT_TYPE ) }}", 
                    {{old('document_type_id',0)}}, 'document_type_id');

            @endif

        });
    </script>
@endpush 



