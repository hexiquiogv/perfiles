<form class="md-form" method="post" action="{{ route('solicitud') }}">
	{{ csrf_field() }}
	<input type="hidden" name="step" value="{{$step}}"/>

	@if(false)
		<input type="hidden" name="pais_id" value="{{$academico->pais}}">
		<input type="hidden" name="obtencion_grado_id" value="{{$academico->obtencion_grado}}">
	@endif

	<div class="indigo lighten-1 p-2 white-text z-depth-3 rounded mb-0">
		<h5 class="card-title m-1">Revisión de Reporte</h5>
	</div>

	<div class="form-row">
		<div class="col-4 flex-col" > 
			<div class="md-form">
				<label class="active">País</label>	
			</div>
			<select class="mdb-select md-form colorful-select dropdown-primary"
				id="pais" name="pais">
			</select>
		</div>
		
		<div class="col-4"> 
			<div class="md-form px-2">
				<input type="text" id="institucion" name="institucion" class="form-control"
					value="">
				<label for="institucion">Institución</label>
			</div>
		</div>

		<div class="col-4"> 
			<div class="md-form px-2">
				<input type="text" id="campus" name="campus" class="form-control"
					value="">
				<label for="campus">Campus</label>
			</div>
		</div>
	</div>

	<div class="form-row">
		<div class="col-4"> 
			<div class="md-form px-2">
				<input type="text" id="licenciatura" name="licenciatura" class="form-control"
					value="">
				<label for="licenciatura">Licenciatura</label>
			</div>
		</div>

		<div class="col-4" > 
			<div class="md-form">
				<label class="active" >Fecha de inicio</label>	
			</div>
			<input type="date" name="fecha_inicio" id="fecha_inicio" class="datepicker mt-2"
				value=""/>
		</div>

		<div class="col-4" > 
			<div class="md-form">
				<label class="active" >Fecha de término</label>	
			</div>
			<input type="date" name="fecha_termino" id="fecha_termino" class="datepicker mt-2"
				value=""/>
		</div>
	</div>

	<div class="form-row">
		<div class="col-4"> 
			<div class="md-form">
				<label class="active" >Fecha de titulacion</label>	
			</div>
			<input type="date" name="fecha_titulacion" id="fecha_titulacion" class="datepicker mt-2"
				value=""/>
		</div>
		
		<div class="col-4" > 
			<div class="md-form">
				<label class="active">Modalidad</label>	
			</div>
			<select class="mdb-select md-form colorful-select dropdown-primary"
				id="obtencion_grado" name="obtencion_grado">
			</select>
			<div style="margin-top:-19px; font-size:.7rem; font-style: italic;"
				class="text-muted">
				* Modalidad de obtención de grado
			</div>
		</div>

		<div class="col-4"> 
			<div class="md-form">
				<label class="active" >Escala</label>	
			</div>
			<input type="text" name="escala" id="escala" class="form-control"
				value=""/>
		</div>
		
	</div>

	<div class="p-2 white-text d-flex flex-row-reverse">
    	<button class="ml-a btn btn-warning btn-sm z-depth-3">Guardar</button>
    </div>
</form>
			

@push('scripts2')
	<script type="text/javascript">
		$(document).ready(function() {
			
        });
	</script>
@endpush