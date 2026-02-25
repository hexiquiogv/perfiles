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
                    <input type="hidden" id="pais_id" name="pais_id" value="{{old('pais_id',$instalacion->pais_id)}}">
                   <div class="d-flex flex-wrap col-12">

                        <div class="md-form col-11">
                            <label class="col-form-label active pl-3" style="margin-top: -8px;">
                            {{__('messages.instalacion')}}</label>
                            <input class="mt-3 col-12" name="nombre" id="nombre" 
                                    value="{{ old('nombre',$instalacion->nombre ?? '') }}" >
                        </div> 

                        <div class="md-form col-11">
                            <label class="col-form-label active pl-4" style="margin-top: -2px;">
                                Contacto
                            </label>
                            <select id="contacto_id" name="contacto_id" searchable="Buscar ..."
                                class="mdb-select md-form mt-1 col-12">
                            </select>
                        </div>                        

                        <div class="md-form col-11">
                            <label class="col-form-label active pl-3" style="margin-top: -8px;">Calle</label>
                            <input class="mt-3 col-12" id="calle" type="text" 
                                name="calle" value="{{ old('calle',$instalacion->calle) }}">
                        </div> 

                        <div class="md-form col-2">
                            <label class="col-form-label active pl-3" style="margin-top: -8px;">
                                No. Exterior</label>
                            <input class="mt-3 col-10" id="numero_exterior" type="text" name="numero_exterior" 
                                value="{{ old('numero_exterior',$instalacion->numero_exterior) }}">
                        </div> 

                        <div class="md-form col-2">
                            <label class="col-form-label active pl-3" style="margin-top: -8px;">
                                No. Interior</label>
                            <input class="mt-3 col-10" id="numero_interior" type="text" name="numero_interior" 
                                value="{{ old('numero_interior',$instalacion->numero_interior) }}">
                        </div> 

                        <div class="md-form col-7">
                            <label class="col-form-label active pl-3" style="margin-top: -8px;">* Colonia</label>
                            <input class="mt-3 col-12" id="colonia" type="text" 
                                name="colonia" value="{{ old('colonia',$instalacion->colonia) }}">
                        </div> 

                        <div class="md-form col-6">
                            <label class="col-form-label active pl-4" style="margin-top: -2px;">
                                Estado
                            </label>
                            <select id="estado_id" name="estado_id" searchable="Buscar ..."
                                class="mdb-select md-form mt-1 col-11">
                            </select>
                        </div>

                        <div class="md-form col-6">
                            <label class="col-form-label active pl-4" style="margin-top: -2px;">
                                Municipio
                            </label>
                            <select id="municipio_id" name="municipio_id" searchable="Buscar ..."
                                class="mdb-select md-form mt-1 col-11">
                            </select>
                        </div>

                        <div class="md-form col-6">
                            <label class="col-form-label active pl-4" style="margin-top: -2px;">
                                Poblacion
                            </label>
                            <select id="poblacion_id" name="poblacion_id" searchable="Buscar ..."
                                class="mdb-select md-form mt-1 col-11">
                            </select>
                        </div>

                        <div class="md-form col-2">
                            <label class="col-form-label active pl-3" style="margin-top: -8px;">
                                Código Postal</label>
                            <input class="mt-3 col-10" id="codigo_postal" type="text" name="codigo_postal" 
                                value="{{ old('codigo_postal',$instalacion->codigo_postal) }}">
                        </div> 
                        <div class="md-form col-4">
                            <label class="col-form-label active pl-3" style="margin-top: -8px;">Teléfono</label>
                            <input class="mt-3 col-8" id="telefono" type="text" 
                                name="telefono" value="{{ old('telefono',$instalacion->telefono ?? '') }}">
                        </div> 
                    </div>

                    @include('proveedores.buttons',['url' => route('contactos',$registro->id)])
                </form>
            </div>
        </div>
    </div>
    <br>
    <br>
@endsection

@push('scripts2')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#btn_save').on('click', function() {
                $('#client_topic_form').submit();
            });

            dynamicDropdown("/contactos_items/{{$registro->id}}", 
                    {{old('contacto_id',$instalacion->contacto_id ?? 0)}}, 'contacto_id');

            dynamicDropdown("/items/{{$instalacion->pais_id}}", 
                    {{old('estado_id',$instalacion->estado_id ?? 0)}}, 'estado_id');
            dynamicDropdown("/items/{{$instalacion->estado_id ?? 0}}", 
                    {{old('municipio_id',$instalacion->municipio_id ?? 0)}}, 'municipio_id');
            dynamicDropdown("/items/{{$instalacion->municipio_id ?? 0}}", 
                    {{old('poblacion_id',$instalacion->poblacion_id ?? 0)}}, 'poblacion_id');

            $('#estado_id').change(function(e){
                var optionId = $('select[name="estado_id"] option:selected').val();
                clearDropdown( $('select[name="municipio_id"]') );
                clearDropdown( $('select[name="poblacion_id"]') );  
                
                dynamicDropdown("/items/"+optionId, 0, 'municipio_id');  

            });

            $('#municipio_id').change(function(e){                
                var optionId = $('select[name="municipio_id"] option:selected').val();
                clearDropdown( $('select[name="poblacion_id"]') );  
                
                dynamicDropdown("/items/"+optionId, 0, 'poblacion_id');  

            });
        });    
    </script>
@endpush

