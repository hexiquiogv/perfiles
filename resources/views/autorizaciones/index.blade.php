@extends('layouts.master')

@section('main-content')
<div class="m-2 p-1">
    <div class="card col-md-12 badge badge-light">
        <div class="d-flex justify-content-between mx-2 mt-2 mb-1 col-md-12">
            <div class="h4 pt-2">Autorizaciones de Ordenes de Servicio</div>
            <div class="d-flex justify-content-between col-md-3">
                <div class="d-flex flex-row col-md-11">
                    <span class="p-1 mt-2 h6">Buscar</span>
                    <input type="text" name="search" id="search" class="col-md-10 form-control mt-1">
                </div>
                <div class="d-flex flex-row">
                    <a href="{!! route('mantenimientos.menu') !!}" 
                        class="m-2 p-1 badge-info z-depth-2">
                        <i class="fa fa-undo fa-2x" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-block">            
        <div id="table-container" class="p-3 col-md-12">
            <table class="table table-striped col-md-12" cellspacing="0" id="autorizaciones_table">
                <thead class="">
                    <tr>
                        <th>Id</th>                        
                        <th>UUID</th>

                        <th>Unidad</th>
                        <th>Tipo Vehiculo</th>
                        <th>Marca</th>
                        <th>Linea</th>
                        <th>Placas</th>

                        <th>Empresa</th>
                        <th>Sucursal</th>
                        <th>Area</th>
                        <th>Chofer</th>

                        <th>Servicio(s)</th>

                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>                        
                            <td>{{ $item->uuid }}</td>

                            <td>{{ json_decode($item->orden->datos_vehiculo)->no_economico }}</td>
                            <td>{{ json_decode($item->orden->datos_vehiculo)->tipo_vehiculo }}</td>
                            <td>{{ json_decode($item->orden->datos_vehiculo)->marca }}</td>
                            <td>{{ json_decode($item->orden->datos_vehiculo)->linea }}</td>
                            <td>{{ json_decode($item->orden->datos_vehiculo)->placa }}</td>

                            <td>{{ json_decode($item->orden->datos_vehiculo)->empresa }}</td>
                            <td>{{ json_decode($item->orden->datos_vehiculo)->sucursal }}</td>
                            <td>{{ json_decode($item->orden->datos_vehiculo)->area }}</td>
                            <td>{{ json_decode($item->orden->datos_vehiculo)->chofer }}</td>

                            <td>{{ implode($item->orden->getServicios()) }}</td>

                            <td style="width:15%;">
                                <div class='row d-flex justify-content-center'>
                                    <a href='{{ route('reporte.download',$item->orden->uuid) }}' class='px-1' title='Ver Reporte' target='_blank'>
                                        <span class='badge purple text-white shadow'>
                                            <i class='fa fa-file fa-2x'></i>
                                        </span>
                                    </a>
                                    <a href='{{ route('cotizaciones.show',$item->orden->uuid) }}' class='px-1' title='Ver Reporte' target='_blank'>
                                        <span class='badge blue text-white shadow'>
                                            <i class='fa fa-paste fa-2x'></i>
                                        </span>
                                    </a>
                                    <a class='px-1' title='Autorizar'  
                                    href='{{ route('signaturepad',[
                                        'model_name'=>get_class($item),
                                        'model_id'=>$item->uuid,
                                        'title'=>"Autorización - ".$item->user->fullname,
                                        'back_url'=>route('autorizaciones')]) }}'>
                                        <span class='badge pink text-white shadow'>
                                            <i class='fa fa-google-wallet fa-2x'></i>
                                        </span>
                                    </a>
		 				        </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts2')
    <script type="text/javascript">
        $(document).ready(function(){
            var autorizaciones_table = $('#autorizaciones_table').DataTable({
                dom: '<"d-flex flex-row-reverse">ts<"d-flex justify-content-between" ip>r',
                order: [ 0, "desc" ]
            });
            $("#search").on('keyup', function() {
                $("#autorizaciones_table").DataTable().search( this.value ).draw();
            });
        });
    </script>
@endpush