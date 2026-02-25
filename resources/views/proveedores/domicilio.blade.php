<form id="client_topic_form" method="POST" class="ml-2" action="{{ $route }}">

    @csrf    

    <input type="hidden" id="pais_id" name="pais_id" value="{{old('pais_id',$domicilio->pais_id??154)}}">
   
    <div class="d-flex flex-wrap col-12">
        <div class="md-form col-11">
            <label class="col-form-label active pl-3" style="margin-top: -8px;">Calle</label>
            <input class="mt-3 col-12" id="calle" type="text" 
                name="calle" value="{{ old('calle',$domicilio->calle) }}">
        </div> 

        <div class="md-form col-2">
            <label class="col-form-label active pl-3" style="margin-top: -8px;">
                No. Exterior</label>
            <input class="mt-3 col-10" id="numero_exterior" type="text" name="numero_exterior" 
                value="{{ old('numero_exterior',$domicilio->numero_exterior) }}">
        </div> 

        <div class="md-form col-2">
            <label class="col-form-label active pl-3" style="margin-top: -8px;">
                No. Interior</label>
            <input class="mt-3 col-10" id="numero_interior" type="text" name="numero_interior" 
                value="{{ old('numero_interior',$domicilio->numero_interior) }}">
        </div> 

        <div class="md-form col-7">
            <label class="col-form-label active pl-3" style="margin-top: -8px;">* Colonia</label>
            <input class="mt-3 col-12" id="colonia" type="text" 
                name="colonia" value="{{ old('colonia',$domicilio->colonia) }}">
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
                value="{{ old('codigo_postal',$domicilio->codigo_postal) }}">
        </div> 
    </div>

    @include('proveedores.buttons',['url' => route('domicilio',$registro->id)])

</form>

@push('scripts2')
    <script type="text/javascript">
        $(document).ready(function() {
            dynamicDropdown("/items/154", {{old('estado_id',$domicilio->estado_id ?? 0)}}, 'estado_id');
            dynamicDropdown("/items/{{$domicilio->estado_id ?? 0}}", 
                    {{old('municipio_id',$domicilio->municipio_id ?? 0)}}, 'municipio_id');
            dynamicDropdown("/items/{{$domicilio->municipio_id ?? 0}}", 
                    {{old('poblacion_id',$domicilio->poblacion_id ?? 0)}}, 'poblacion_id');

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