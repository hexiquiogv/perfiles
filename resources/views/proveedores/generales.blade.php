<form id="client_topic_form" method="POST" action="{{ $route }}" class="ml-2">

    @csrf
    {{ method_field($method) }}
    
   <div class="d-flex flex-wrap col-12">
        <div class="md-form col-7">
            <label class="col-form-label active pl-3" style="margin-top: -8px;">Nombre Corto</label>
            <input class="mt-3 col-11" name="nombre_corto" id="nombre_corto" 
                    value="{{ old('nombre_corto',$registro->nombre_corto) }}" >
        </div> 
        <div class="md-form col-4">
            <label class="col-form-label active pl-3" style="margin-top: -8px;">RFC</label>
            <input class="mt-3 col-12" id="rfc" type="text" name="rfc" 
                value="{{ old('rfc',$registro->rfc) }}">
        </div> 
        <div class="md-form col-11">
            <label class="col-form-label active pl-3" style="margin-top: -8px;">Razón Social</label>
            <input class="mt-3 col-12" id="razon_social" type="text" 
                name="razon_social" value="{{ old('razon_social',$registro->razon_social) }}">
        </div> 
    </div>

    @include('proveedores.buttons',['url' => url()->current()])

</form>