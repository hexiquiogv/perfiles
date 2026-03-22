@extends('layouts.master')

@section('content')

	<!-- Card -->
	<div class=" mt-3 p-5">

		<!-- Background color -->		

		<div class="p-2 col-md-12 row">
			<div class="col-md-3">
				@include('workflow.solicitud.steps')
			</div>
			<div class="col-md-8 m-2 p-3">
				@if("primero" == __("workflow.$step") )
					@include('workflow.solicitud.datos_generales',['route'=>route('solicitud'),'method'=>'post'])
				@elseif("segundo" == __("workflow.$step") )
					@include('workflow.solicitud.datos_academicos')
				@elseif("tercero" == __("workflow.$step") )
					@include('workflow.solicitud.documentos',['first'=>false])
				@elseif("cuarto" == __("workflow.$step") )
					@include('workflow.solicitud.encuesta')
				@elseif("quinto" == __("workflow.$step") )
					@include('workflow.solicitud.envio')
				@endif
			</div>
		</div>
		

	</div>
	<!-- Card -->
@endsection