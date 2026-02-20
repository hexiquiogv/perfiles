@extends('layouts.master')

@section('custom_css')
    <script src="{{ asset('jquerySignature/js/signature_pad.js') }}"></script>
    <style>
        .wrapper {
          position: relative;
          width: 400px;
          height: 200px;
          -moz-user-select: none;
          -webkit-user-select: none;
          -ms-user-select: none;
          user-select: none;
        }
        img {
          position: absolute;
          left: 0;
          top: 0;
        }

        .signature-pad {
          position: absolute;
          left: 0;
          top: 0;
          width:400px;
          height:200px;
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