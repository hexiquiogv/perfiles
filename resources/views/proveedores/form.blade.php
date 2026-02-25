@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row p-2 btn-light d-flex justify-content-between z-depth-2">
            <div class="pt-2 pl-2 h5"> {{$title}} </div>
            
            <div class="ml-auto">

                <a href="{!! route('proveedores.index') !!}" class="px-1">
                    <span class="badge badge-info text-white p-2 z-depth-2">
                        <i class="fa fa-undo fa-2x" aria-hidden="true"></i>
                    </span>
                </a>
                <a href="#" class="px-1" 
                    onclick="document.getElementById('proveedores_form').submit();">
                    <span class="badge badge-warning text-white p-2 z-depth-2">
                        <i class="fa fa-save fa-2x" aria-hidden="true"></i>
                    </span>
                </a>
            </div>
        </div>
        <div class="mt-4">
            <form id="proveedores_form" method="POST" action="{{ $route }}" class="ml-4">
                @csrf
                {{ method_field($method) }}
                
                <div class="row col-12">
                    <div class="col-8"> 
                        <div class="d-flex flex-row p-2">
                            <label class="col-md-3 col-form-label text-md-right">
                                Tipo de proveedor</label>
                            <div class="col-md-4">
                                @foreach ($tipo_proveedor as $tp )
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input 
                                            class="custom-control-input" 
                                            type="radio" 
                                            id="tipo_proveedor_{{$tp->id}}" 
                                            name="tipo_proveedor" 
                                            value={{$tp->id}}
                                            {{$tp->id == $proveedor->tipo_proveedor_id ? 'checked':''}}
                                            >
                                        <label class="custom-control-label" for="tipo_proveedor_{{$tp->id}}">{{$tp->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex flex-row p-2">
                            <label class="col-md-3 col-form-label text-md-right">
                                Primer apellido</label>
                            <div class="col-md-4">
                                <input class="form-control" id="primer_apellido" type="text" name="primer_apellido" 
                                    value = "{{ old('primer_apellido',$proveedor->primer_apellido) }}" {{ $readonly }} {{ $disabled }} >
                            </div>
                        </div>

                        <div class="d-flex flex-row p-2">
                            <label class="col-md-3 col-form-label text-md-right">
                                Segundo apellido</label>
                            <div class="col-md-4">
                                <input class="form-control" id="segundo_apellido" type="text" name="segundo_apellido" 
                                    value = "{{ old('segundo_apellido',$proveedor->segundo_apellido) }}" {{ $readonly }} {{ $disabled }} >
                            </div>
                        </div>

                        <div class="d-flex flex-row p-2">
                            <label class="col-md-3 col-form-label text-md-right">
                                Nombre</label>
                            <div class="col-md-4">
                                <input class="form-control" id="nombre" type="text" name="nombre" 
                                    value = "{{ old('nombre',$proveedor->nombre) }}" {{ $readonly }} {{ $disabled }} >
                            </div>
                        </div>

                        <div class="d-flex flex-row p-2">
                            <label class="col-md-3 col-form-label text-md-right">
                                RFC</label>
                            <div class="col-md-4">
                                <input class="form-control" id="rfc" type="text" name="rfc" 
                                    value = "{{ old('rfc',$proveedor->rfc) }}" {{ $readonly }} {{ $disabled }} >
                            </div>
                        </div>

                        <div class="d-flex flex-row p-2">
                            <label class="col-md-3 col-form-label text-md-right">
                                Razón Social</label>
                            <div class="col-md-4">
                                <input class="form-control" id="razon_social" type="text" name="razon_social" 
                                    value = "{{ old('razon_social',$proveedor->razon_social) }}"  
                                        {{ $readonly }} {{ $disabled }} >
                            </div>
                        </div>

                        <div class="d-flex flex-row p-2">
                            <label class="col-md-3 col-form-label text-md-right">
                                Nombre Corto</label>
                            <div class="col-md-4">
                                <input class="form-control" id="nombre_corto" type="text" name="nombre_corto" 
                                    value = "{{ old('nombre_corto',$proveedor->nombre_corto) }}"  {{ $readonly }} {{ $disabled }} >
                            </div>
                        </div>

                        <div class="d-flex flex-row p-2">
                            <label class="col-md-3 col-form-label text-md-right">
                                calle</label>
                            <div class="col-md-4">
                                <input class="form-control" id="calle" type="text" name="calle" 
                                    value = "{{ old('calle',$proveedor->calle) }}"  {{ $readonly }} {{ $disabled }} >
                            </div>
                        </div>

                        <div class="d-flex flex-row p-2">
                            <label class="col-md-3 col-form-label text-md-right">
                                Número interior</label>
                            <div class="col-md-4">
                                <input class="form-control" id="numero_interior" type="text" name="numero_interior" 
                                    value = "{{ old('numero_interior',$proveedor->numero_interior) }}"  {{ $readonly }} {{ $disabled }} >
                            </div>
                        </div>

                        <div class="d-flex flex-row p-2">
                            <label class="col-md-3 col-form-label text-md-right">
                                Nombre exterior</label>
                            <div class="col-md-4">
                                <input class="form-control" id="numero_exterior" type="text" name="numero_exterior" 
                                    value = "{{ old('numero_exterior',$proveedor->numero_exterior) }}"  {{ $readonly }} {{ $disabled }} >
                            </div>
                        </div>

                        <div class="d-flex flex-row p-2">
                            <label class="col-md-3 col-form-label text-md-right">
                                Colonia</label>
                            <div class="col-md-4">
                                <input class="form-control" id="colonia" type="text" name="colonia" 
                                    value = "{{ old('colonia',$proveedor->colonia) }}"  {{ $readonly }} {{ $disabled }} >
                            </div>
                        </div>

                        <div class="d-flex flex-row p-2">
                            <label class="col-md-3 col-form-label text-md-right">
                                Código postal</label>
                            <div class="col-md-4">
                                <input class="form-control" id="codigo_postal" type="text" name="codigo_postal" 
                                    value = "{{ old('codigo_postal',$proveedor->codigo_postal) }}"  {{ $readonly }} {{ $disabled }} >
                            </div>
                        </div>

                        <div class="d-flex flex-row p-2">
                            <label class="col-md-3 col-form-label text-md-right">
                                Entre calles</label>
                            <div class="col-md-4">
                                <input class="form-control" id="entre_calles" type="text" name="entre_calles" 
                                    value = "{{ old('entre_calles',$proveedor->entre_calles) }}"  {{ $readonly }} {{ $disabled }} >
                            </div>
                        </div>

                        <div class="d-flex flex-row p-2">
                            <label class="col-md-3 col-form-label text-md-right">
                                Número de Certificado</label>
                            <div class="col-md-4">
                                <input class="form-control" id="numero_certificado" type="text" name="numero_certificado" 
                                    value = "{{ old('numerto_certificado',$proveedor->numero_certificado) }}"  {{ $readonly }} {{ $disabled }} >
                            </div>
                        </div>

                        <div class="d-flex flex-row p-2">
                            <label class="col-md-3 col-form-label text-md-right">
                                Email</label>
                            <div class="col-md-4">
                                <input class="form-control" id="email" type="text" name="email" 
                                    value = "{{ old('email',$proveedor->email) }}"  {{ $readonly }} {{ $disabled }} >
                            </div>
                        </div>

                        <div class="d-flex flex-row p-2">
                            <label class="col-md-3 col-form-label text-md-right">
                                Teléfono</label>
                            <div class="col-md-4">
                                <input class="form-control" id="telefono" type="text" name="telefono" 
                                    value = "{{ old('telefono',$proveedor->telefono) }}"  {{ $readonly }} {{ $disabled }} >
                            </div>
                        </div>

                        <div class="d-flex flex-row p-2">
                            <label class="col-md-3 col-form-label text-md-right">
                                Giro</label>
                            <div class="col-md-4">
                                <input class="form-control" id="giro" type="text" name="giro" 
                                    value = "{{ old('giro',$proveedor->giro) }}"  {{ $readonly }} {{ $disabled }} >
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div> 
    <br>
    <br>
@endsection
