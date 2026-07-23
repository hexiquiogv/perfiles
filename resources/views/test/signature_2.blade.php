<html>
<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('jquerySignature/css/bootstrap.css') }}">
    <script type="text/javascript" src="{{ asset('jquerySignature/js/jquery.min.js') }}" ></script>
    <link type="text/css" href="{{ asset('jquerySignature/css/jquery-ui.css') }}" rel="stylesheet"> 
    <script type="text/javascript" src="{{ asset('jquerySignature/js/jquery-ui.min.js') }}" ></script>
    
    <script type="text/javascript" src="{{ asset('jquerySignature/js/jquery.signature.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('jquerySignature/css/jquery.signature.css') }}">
  
    <style>
        .kbw-signature { width: 100%; height: 200px;}
        #sig canvas{
            width: 100% !important;
            height: auto;
        }
    </style>
  
</head>
<body class="bg-dark">
<div class="container">
   <div class="row">
       <div class="col-md-6 offset-md-3 mt-5">
           <div class="card">
               <div class="card-header">
                   <h5>Firma de Documentos</h5>
               </div>
               <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success  alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">×</button>  
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('signaturepad.upload') }}">
                        @csrf
                        <div class="col-md-12 d-flex flex-column">
                            <label class="" for="">Firme en el recuadro y presione el botón de guardar</label>
                            <br/>
                            <div id="sig" ></div>
                            <br/>
                            <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                            <textarea id="signature64" name="signed" style="display: none"></textarea>
                        </div>
                        <br/>
                        <button class="btn btn-success">Save</button>
                    </form>
               </div>
           </div>
       </div>
   </div>
</div>
<script type="text/javascript">
    var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });
</script>
</body>
</html>