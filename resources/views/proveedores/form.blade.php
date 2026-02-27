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
                
                <div class="d-flex flex-wrap col-12">
                    <div class="md-form col-11">
                        <label class="col-form-label active pl-3" style="margin-top: -8px;">Razón Social</label>
                        <input class="mt-3 col-12" id="razon_social" type="text" 
                            name="razon_social" value="{{ old('razon_social',$registro->razon_social) }}">
                    </div> 
                    <div class="md-form col-7">
                        <label class="col-form-label active pl-3" style="margin-top: -8px;">Nombre Corto</label>
                        <input class="mt-3 col-11" name="nombre_corto" id="nombre_corto" 
                                value="{{ old('nombre_corto',$registro->nombre_corto) }}" >
                    </div> 
                    <div class="md-form col-2">
                        <label class="col-form-label active pl-3" style="margin-top: -8px;">RFC</label>
                        <input class="mt-3 col-12" id="rfc" type="text" name="rfc" 
                            value="{{ old('rfc',$registro->rfc) }}">
                    </div> 
                    <div class="md-form col-6">
                        <label class="col-form-label active pl-4" style="margin-top: -2px;">
                            Giro Proveedor
                        </label>
                        <select id="giro_id" name="giro_id" searchable="Buscar ..."
                            class="mdb-select md-form mt-1 col-11">
                        </select>
                    </div>
                </div>

                <div class="d-flex flex-wrap col-12">
                    <label class="col-form-label active pl-4" style="margin-top: -2px;">
                            Servicios
                    </label>
                    <textarea class="col-md-12" id="servicios" type="textarea" 
                    name="servicios" rows="4" >{{old('servicios',$registro->servicios??'')}}</textarea>
                </div>

            </form>
        </div>
    </div> 
    <br>
    <br>
@endsection

@push('scripts2')
    <script type="text/javascript">
        $(document).ready(function() {
            dynamicDropdown("{{ route('items',App\Models\Catalogo::GIRO_PROVEEDOR) }}", 
                {{ old('giro_id',$registro->giro_id??0) }}, 'giro_id');
        });    
    </script>
@endpush