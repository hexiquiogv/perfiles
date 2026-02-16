@extends('layouts.master')

@section('content')
<div class="">
    <div class="card col-md-12 badge badge-light">
        <div class="d-flex flex-row m-2 justify-content-between">
            <div class="h4 pt-1"><i class="fa fa-th-large green-text fa-1x"></i> Consultas</div>
            <div class="d-flex flex-row">
                <div class="d-flex flex-row p-2 mr-2">
                    <span class="p-1 mt-1 h6">Buscar</span>
                    <input type="text" name="search" id="search" class="col-sm-10 form-control">
                </div>
                <div class="d-flex flex-row">
                    <a href="#" class="badge badge-warning z-depth-2 p-2 m-2" 
                        onclick="document.getElementById('review_form').submit();">
                        <i class="fa fa-download fa-2x"></i>
                    </a>
                    <a href="{!! route('consultas.index') !!}" class="m-2 p-2 badge-info z-depth-2">
                        <i class="fa fa-undo fa-2x" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-block">            
        <div id="table-container" class="p-3 col-12">       
            <form id="review_form" method="POST" action="{{route('export.review',$consulta->id)}}">
                @csrf
                
                <table class="table table-striped" cellspacing="0" width="100%" id="review_table" >
                    <thead>
                        <tr style="background-color:rgb(172, 100, 52);">
                            <th></th>
                            @foreach($consulta->fields as $field)
                                @if($field->Field != "primary_key")
                                    <th>{{$field->Field}}</th>
                                @endif
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td style="width:10px;">
                                <input type="checkbox" class="form-check-input with-gap" 
                                id="select_item_{{$loop->iteration}}" 
                                name="select_item[]"
                                value="{{$item["primary_key"]}}">
                                <label class="form-check-label" for="select_item_{{$loop->iteration}}">
                                </label>
                            </td>
                            @foreach($consulta->fields as $field)
                                @if($field->Field != "primary_key")
                                    <td>{{$item[$field->Field]}}</td>
                                @endif
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background-color:rgb(172, 100, 52);">
                            <th></th>
                            @foreach($consulta->fields as $field)
                                @if($field->Field != "primary_key")
                                    <th>{{$field->Field}}</th>
                                @endif
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts2')
    <script type="text/javascript">
        $(document).ready(function(){
            var review_table = $('#review_table').DataTable({
                    stateSave: true,
                    responsive: !0,
                    searching: true,
                    scrollX: true,
                    dom: '<"d-flex flex-row-reverse">t<"d-flex justify-content-between"ip>',
            });

            $("#search").on('keyup', function() {
                $("#review_table").DataTable().search( this.value ).draw();
            });
        });
    </script>
@endpush