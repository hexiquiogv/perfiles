<div class="indigo lighten-1 p-2 white-text z-depth-3 rounded mb-0 mb-5">
	<h5 class="card-title m-1">Cotizaciones</h5>
</div>

<div class="col-12">
	
</div>

<form class="md-form" method="post" action="#" >
	{{ csrf_field() }}
	<input type="hidden" name="step" value="{{$step}}"/>
	<div class="p-2 white-text d-flex flex-row-reverse">
    	<button class="ml-a btn btn-warning btn-sm z-depth-3">Guardar</button>
    </div>
</form>

@include('layouts.partials.camara.views.camaraModal', ['back_url'=>"#", 
	 'model_name'=>get_class(Auth::user()), 'model_id'=>Auth::id() ])

@push('scripts2')
  <script type="text/javascript">
      $(document).ready(function() {

            $(".upload_form_modal").on('click', function() {
            	$tipo_documento = $(this).attr("tipo_documento");
            	$descripcion = $(this).attr("descripcion");
            	$("#camara_modal_titulo").text( $descripcion );
            	$("#upload_image_form").attr("action","{{route('media.store')}}");
            	$("#upload_image_form > input[name=extras]").val($tipo_documento);
                $("#open_camara_modal").trigger("click");
            });

        });
  </script>
@endpush  