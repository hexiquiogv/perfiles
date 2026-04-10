@extends('layouts.master')

@section('content')
    <div class="d-flex flex-wraper">
        <div class="m-1 p-1 z-depth-3 rounded">
            <a href="{{route('mantenimientos.menu')}}" title="Mantenimiento Vehóculos">
                <img src="{{asset('images/check_list.jpeg')}}" width="300px">
            </a>
        </div>
        <div></div>
        <div></div>
        <div></div>
    </div>
@endsection
