@extends('layouts.master')

@section('content')
	<div class="col-md-12 d-flex flex-row">
		@include('proveedores.ficha')
		<div class="col-md-10 d-flex flex-column">
			<nav>
				<div class="nav nav-tabs md-tabs" id="nav-tab" role="tablist">
					@foreach($opciones as $tab)
						@if($tab == $opcion)
							<a class="nav-item nav-link active" href="#" role="tab" aria-selected="true">
						@else
							<a class="nav-item nav-link" role="tab" aria-selected="false"
							href="{{route($tab, $registro->id)}}">
						@endif
						{{__("supplier.tabs.$tab")}}</a>
					@endforeach
					<a class="nav-item nav-link ml-auto active " 
						href="{{route('proveedores.index')}}">
		                   <i class="fa fa-undo fa-1x" aria-hidden="true"></i>
					</a>
				</div>
			</nav>
			<div class="ml-4 mt-3">
				@include("proveedores.$opcion")
			</div>
		</div>
	</div>
@endsection

@push('scripts2')
    <script type="text/javascript">
        $(document).ready(function() {
        	$('#btn_save').on('click', function() {
                $('#client_topic_form').submit();
            });
        });
    </script>
@endpush