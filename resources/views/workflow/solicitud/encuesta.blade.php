<form class="md-form" method="post" action="{{ route('solicitud') }}">
	{{ csrf_field() }}
	<input type="hidden" name="step" value="{{$step}}"/>
	<input type="hidden" name="medio_difusion_id" value="{{$encuesta->medio_difusion}}"/>

	<div class="indigo lighten-1 p-2 white-text z-depth-3 rounded mb-0">
		<h5 class="card-title m-1">Información Adicional</h5>
	</div>

	<div class="form-row">
		<div class="col-12" > 
			<div class="md-form">
				<label class="active">
					¿Cómo se enteró del programa de postgrado del CIMA?
				</label>	
			</div>
			<select class="mdb-select md-form colorful-select dropdown-primary"
				id="medio_difusion" name="medio_difusion">
			</select>
		</div>
	</div>

	<div class="form-row">
		<div class="col-12"> 
			<div class="md-form">
				<div style="margin-top:-5px; font-size:.9rem; font-style: italic;" class="text-muted">
					Campo Científico de Interés
				</div>
		  		<textarea id="area_interes" name="area_interes" rows="10" class="form-control col-12 p-2">
		  			{{ trim($encuesta->area_interes) }}
		  		</textarea>
		  		<div style="margin-top:-5px; font-size:.7rem; font-style: italic;" class="text-muted">
					Especifique con el mayor detalle el campo científico de su interés (máximo 4000 caracteres)
				</div>
			</div>
		</div>
	</div>

	<div class="form-row">
		<div class="col-12"> 
			<div class="md-form">
				<div style="margin-top:-5px; font-size:.9rem; font-style: italic;" class="text-muted">
						Experiencia en Campo Científico de Interés
				</div>
		  		<textarea id="experiencia" name="experiencia" rows="10" class="form-control col-12 p-2">
		  			{{ trim($encuesta->experiencia) }}
		  		</textarea>
		  		<div style="margin-top:-5px; font-size:.7rem; font-style: italic;" class="text-muted">
					Describa su experiencia en el campo mencionado (máximo 4000 caracteres)
				</div>
			</div>
		</div>
	</div>

	<div class="form-row">
		<div class="col-12"> 
			<div class="md-form">
				<div style="margin-top:-5px; font-size:.9rem; font-style: italic;" class="text-muted">
						Planes profesionales
				</div>
		  		<textarea id="planes_profesionales" name="planes_profesionales" rows="10" 
		  			class="form-control col-12 p-2">
		  			{{ trim($encuesta->planes_profesionales) }}
		  		</textarea>
		  		<div style="margin-top:-5px; font-size:.7rem; font-style: italic;" class="text-muted">
					Explique sus planes profesionales a corto y largo plazo (máximo 4000 caracteres)
				</div>
			</div>
		</div>
	</div>

	<div class="form-row">
		<div class="col-12"> 
			<div class="md-form">
				<div style="margin-top:-5px; font-size:.9rem; font-style: italic;" class="text-muted">
						¿Porqué decidió estudiar el posgrado en el CIMA?
				</div>
		  		<textarea id="motivo_eleccion" name="motivo_eleccion" rows="10" 
		  			class="form-control col-12 p-2">
	  				{{ trim($encuesta->motivo_eleccion) }}
	  			</textarea>
		  		<div style="margin-top:-5px; font-size:.7rem; font-style: italic;" class="text-muted">
					(máximo 4000 caracteres)
				</div>
			</div>
		</div>
	</div>

	<div class="p-2 white-text d-flex flex-row-reverse">
    	<button class="ml-a btn btn-warning btn-sm z-depth-3">Guardar</button>
    </div>
</form>
			

@push('scripts2')
	<script type="text/javascript">
		$(document).ready(function() {
        	dynamicDropdown('/api/medio_difusion', $("[name='medio_difusion_id']").val(), 
        		'medio_difusion');
        });
	</script>
@endpush