@extends('layouts.master')

@section('content')
    <div class="col-md-12 d-flex flex-row">
        @include('proveedores.ficha')
        <div class="col-md-10 d-flex flex-column">
            <nav>
                <div class="nav nav-tabs md-tabs" id="nav-tab" role="tablist">
                    @foreach($opciones as $tab)
                        @if($tab == $opcion)
                            <a class="nav-item nav-link active" role="tab" aria-selected="true"
                                href="{{route($tab, $registro->id)}}">
                        @else
                            <a class="nav-item nav-link" role="tab" aria-selected="false"
                                href="{{route($tab, $registro->id)}}">
                        @endif
                        {{__("client_topics.$tab")}}</a>
                    @endforeach
                    <a class="nav-item nav-link ml-auto active " 
                        href="{{route('proveedores.index')}}">
                           <i class="fa fa-undo fa-1x" aria-hidden="true"></i>
                    </a>
                </div>
            </nav>
            <div class="ml-4 mt-3">
                <form id="client_topic_form" method="POST" action="{{ $route }}" class="ml-2">

                    @csrf
                    {{ method_field($method) }}
                    
                   <div class="d-flex flex-wrap col-12">
                        <div class="md-form col-7">
                            <label class="col-form-label active pl-3" style="margin-top: -8px;">Nombre</label>
                            <input class="mt-3 col-11" name="nombre" id="nombre" 
                                    value="{{ old('nombre',$contacto->nombre ?? '') }}" >
                        </div> 
                        <div class="md-form col-4">
                            <label class="col-form-label active pl-3" style="margin-top: -8px;">Puesto</label>
                            <input class="mt-3 col-12" id="puesto" type="text" name="puesto" 
                                value="{{ old('puesto',$contacto->puesto ?? '') }}">
                        </div> 
                        <div class="md-form col-4">
                            <label class="col-form-label active pl-3" style="margin-top: -8px;">Email</label>
                            <input class="mt-3 col-11" id="email" type="email" 
                                name="email" value="{{ old('email',$contacto->email ?? '') }}">
                        </div> 
                        <div class="md-form col-4">
                            <label class="col-form-label active pl-3" style="margin-top: -8px;">Teléfono</label>
                            <input class="mt-3 col-11" id="telefono" type="text" name="telefono" 
                                value="{{ old('telefono',$contacto->telefono ?? '') }}">
                        </div>
                        <div class="md-form col-3">
                            <label class="form-check-label active">Representante Legal</label>
                            <div id="representante_id" class="d-flex flex-row"></div>
                        </div> 
                    </div>

                    @include('proveedores.buttons',['url' => route('contactos',$registro->id)])
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts2')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#btn_save').on('click', function() {
                $('#client_topic_form').submit();
            });
            dynamicCheckboxes("/items/{{ App\Models\Catalogo::SI_NO }}", 
                {{old('representante_id',$contacto->representante_id??0)}}, 
                    'representante_id', type='radio');
        });
    </script>
@endpush

