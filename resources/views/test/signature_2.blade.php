@extends('layouts.master')

@section('custom_css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
  
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
   
    <script type="text/javascript" src="{{ asset('jquerySignature/js/jquery.signature.js') }}" ></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('jquerySignature/css/jquery.signature.csss') }}">
  
    <style>
        .kbw-signature { width: 100%; height: 200px;}
        #sig canvas{
            width: 100% !important;
            height: auto;
        }
    </style>
@endsection

@section('content')
    <!-- https://jsfiddle.net/szimek/d6a78gwq -->
    
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Firme sobre el recuadro</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
            <div class="wrapper">
                <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
            </div>
            </div>
              <div class="modal-footer">
            <button class="btn btn-primary" id="save">
              <i class="fa fa-save"></i> Guardar</button>
              <button class="btn btn-primary" id="clear">
                <i class="fa fa-eraser" ></i> Limpiar</button>
                  <a href="#" class="btn btn-primary pull-right" data-dismiss="modal" aria-label="Close">
                      <i class="fa fa-arrow-left" ></i> Regresar</a>
                </div>
          </div>
        </div>
    </div>
@endsection

@push('scripts2')   
    <script type="text/javascript"> 
          $(function() {
              
          });
    </script>
@endpush

@section('custom_scripts')
    <script src="{{ asset('jquerySignature/js/appSignature.js') }}"></script>
@endsection