@extends('layouts.master')

@section('content')
<div class="content">

    <div class="h4 z-depth-3 m-2 p-2 col-md-5">Reporte - {{$report->title}}</div>
    <span class="small m-2 p-2">{{$report->description}}</span>

    <form id="filter_report_form" action="{{ $route }}" method='POST'> 
        @csrf

        <div class="d-flex flex-wrap mt-5 col-md-12">                            
            @foreach( explode(',',$report->criterial_fields) as $field )
                @if(stripos($field,"fecha") === false)
                    <div class="d-flex flex-column p-2 col-md-3">
                        <label class="col-form-label teal-text">
                            {{__($field)}}
                        </label>
                        <div class="">
                            <input class="form-control" id="{{$field}}" 
                                type="text" name="{{$field}}" 
                                value = "{{ old('$field','') }}">
                        </div>
                    </div>
                @else
                    <div class="d-flex flex-column p-2 col-md-3">
                        <label class="col-form-label teal-text">
                            {{__($field)}} (inicio)
                        </label>
                        <div class="">
                            <input class="form-control" id="{{$field}}__inicio" 
                                type="date" name="{{$field}}__inicio" 
                                value = "{{ old($field.'__inicio','') }}">
                        </div>
                    </div>
                    <div class="d-flex flex-column p-2 col-md-3">
                        <label class="col-form-label teal-text">
                            {{__($field)}} (fin)
                        </label>
                        <div class="">
                            <input class="form-control" id="{{$field}}__fin" 
                                type="date" name="{{$field}}__fin" 
                                value = "{{ old($field.'__fin','') }}">
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="d-flex mt-5 col-md-12 justify-content-begin">
            <a href="#" class="m-1 badge badge-warning text-white p-2 z-depth-2"
                    onclick="document.getElementById('filter_report_form').submit();">
                <i class="fa fa-send fa-2x" aria-hidden="true"></i>
            </a>
        </div>

    </form>

</div>
@endsection
