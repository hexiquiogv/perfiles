
<div class="indigo lighten-1 p-2 white-text z-depth-3 rounded mb-0">
	<h5 class="card-title m-1">Captura de Reporte de Falla / Mantenimiento</h5>
</div>

<form id="mantenimiento_form" method="POST" action="{{ $route }}">

    @csrf
    {{ method_field($method) }}
        
    <div class="form-row">  
        <div class="md-form col-2 mt-1 py-3">
            <label class="col-form-label active" style="margin-top: 10px;">Folio</label>
            <input class="mt-3 col-11" id="folio" type="text" name="folio" 
                value="{{ old('folio',$registro->folio ?? '') }}">
        </div> 
        <div class="md-form col-2 mt-1 py-3 ml-3">
            <label class="col-form-label active pl-3" style="margin-top: 10px;">Fecha reporte</label>
            <input class="mt-3 col-11" id="fecha_reporte" type="date" name="fecha_reporte" 
                value="{{ old('fecha_reporte',
                        is_null($registro->fecha_reporte) ? '' :
                        $registro->fecha_reporte->format('Y-m-d')) }}">
        </div>                 
        <div class="col-md-1 ml-2">
            <div class="md-form"><label class="active">Placa</label></div>
            <select class="mdb-select md-form" id="vehiculo_id" searchable="Buscar ..."
                name="vehiculo_id"></select>
        </div>  
        <div class="col-md-4">
            <div class="md-form"><label class="active">Chofer</label></div>
            <select class="mdb-select md-form" id="chofer_id" searchable="Buscar ..."
                name="chofer_id"></select>
        </div>  
        <div class="md-form col-2 mt-1 py-3">
            <label class="col-form-label active pl-3" style="margin-top: 10px;">Kilometraje</label>
            <input class="mt-3 col-11" id="kilometraje" type="text" name="kilometraje" 
                value="{{ old('kilometraje',$registro->kilometraje) }}">
        </div> 
    </div>

    <div class="form-row">  
        <div class="col-md-3">
            <div class="md-form"><label class="active">Tipo Vehiculo</label></div>
            <select class="mdb-select md-form disabled" id="tipo_vehiculo_id"></select>
        </div> 
        <div class="col-md-2">
            <div class="md-form"><label class="active">Marca</label></div>
            <select class="mdb-select md-form disabled" id="marca_id"></select>
        </div>  
        <div class="col-md-3">
            <div class="md-form"><label class="active">Linea</label></div>
            <select class="mdb-select md-form disabled" id="linea_id"></select>
        </div> 
        <div class="md-form col-1 mt-1 py-3">
            <label class="col-form-label active pl-3" style="margin-top: 10px;">Año</label>
            <input class="mt-3 col-11 readonly" id="modelo" type="text" value="">
        </div> 
        <div class="md-form col-2 mt-1 py-3 mx-3">
            <label class="col-form-label active pl-3" style="margin-top: 10px;">No Económico</label>
            <input class="mt-3 col-11 readonly" id="no_economico" type="text" value="">
        </div> 
    </div>

    <div class="form-row">  
        <div class="col-md-3">
            <div class="md-form"><label class="active">Empresa</label></div>
            <select class="mdb-select md-form disabled" id="empresa_id" searchable="Buscar ..."
                name="empresa_id"></select>
        </div> 
        <div class="col-md-4">
            <div class="md-form"><label class="active">Sucursal</label></div>
            <select class="mdb-select md-form disabled" id="sucursal_id" searchable="Buscar ..."
                name="sucursal_id"></select>
        </div>  
        <div class="col-md-4">
            <div class="md-form"><label class="active">Area</label></div>
            <select class="mdb-select md-form disabled" id="area_id" searchable="Buscar ..."
                name="area_id"></select>
        </div> 
    </div>

    <div class="dropdown-divider"></div>

    <div>
        <label class="col-form-label active">Seleccione el/los Servicio(s) Requeridos</label>
        <br>
        <div id="servicios" class="d-flex flex-wrap col-md-12"></div>
    </div>

    <div class="form-row mt-4">
        <label class="col-md-3 active">Descripción de Falla</label>
        <textarea class="col-md-12" id="descripcion_falla" type="textarea" 
        name="descripcion_falla" rows="4" >{{old('descripcion_falla',$registro->descripcion_falla??'')}}</textarea>
    </div>
</form>
  
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

            dynamicCheckboxes("/items/{{ App\Models\Catalogo::MANTENIMIENTOS }}", 
                "{{ $registro->servicios }}",  "servicios", "checkbox", "col-md-4");

            @if($registro->id >0 || Auth::check())
                $("#camara_modal").on('click', function() {
                    $("#open_camara_modal").trigger("click");
                });
                
                dynamicDropdown("{{ route('items',App\Models\Catalogo::DOCUMENT_TYPE ) }}", 
                    {{old('document_type_id',0)}}, 'document_type_id');

            @endif

        });
    </script>
@endpush 



