<!-- Vertical Steppers -->
<div class="row mt-1">
  <div class="col-md-12">

    <!-- Stepers Wrapper -->
    <ul class="stepper stepper-vertical">

      <!-- First Step -->
      <li id="1">
        <!--Section Title -->
        <a name="step_button" href="#!">
          <span class="step-circle btn-floating btn-light btn-sm p-2" 
            style="margin-left: -4px;">1</span>
          <span class="label py-3">Captura de Reporte de Falla</span>
        </a>
        <!-- Section Description -->
        <div class="step-content grey lighten-3" style="display:none;">
          <p>Deberá completar el formulario para poder avanzar en el proceso de 
            reporte de falla o solicitud de mantenimiento.</p>
          <p>No olvide presionar el boton <span class="orange-text">Guardar</span> 
            antes de salir del sistema, de esta manera podrá continuar en otro momento con el llenado de el mismo.</p>
        </div>
      </li>

      <!-- Second Step -->
      <li id="2">
        <!--Section Title -->
        <a name="step_button" href="#!">
          <span class="step-circle btn-floating btn-light btn-sm p-2" style="margin-left: -4px;">2</span>
          <span class="label py-3">Revisión de Reporte</span>
        </a>
        <!-- Section Description -->
        <div class="step-content grey lighten-3" style="display:none;">
          <p>Se verificará el tipo de servicio requerido contra lo que se va a realizar.</p>
        </div>
      </li>

      <!-- Third Step -->
      <li id="3">
        <a name="step_button" href="#!">
          <span class="step-circle btn-floating btn-light btn-sm p-2" style="margin-left: -4px;">3</span>
          <span class="label py-3">Cotizaciones</span>
        </a>
        <!-- Section Description -->
        <div class="step-content grey lighten-3" style="display:none;">
          <p>Deberá capturar el o los presupuestos</p>
        </div>
      </li>

      <!-- Fourth Step -->
      <li id="4">
        <a name="step_button" href="#!">
          <span class="step-circle btn-floating btn-light btn-sm p-2" style="margin-left: -4px;">4</span>
          <span class="label py-3">Autorización</span>
        </a>
        <!-- Section Description -->
        <div class="step-content grey lighten-3" style="display:none;">
          <p>Se realizará la autorización por parte de la Dirección</p>
        </div>
      </li>

      <!-- Fifth Step -->
      <li id="5">
        <a name="step_button" href="#!">
          <span class="step-circle btn-floating btn-light btn-sm p-2" style="margin-left: -4px;">5</span>
          <span class="label py-3">Descargar reporte para taller</span>
        </a>
      </li>

    </ul>
    <!-- /.Stepers Wrapper -->

  </div>
</div>

@push('scripts2')
  <script type="text/javascript">
      $(document).ready(function () {
          let step = '{{ $step }}';
          item = $('li[id='+step+'] a > span.step-circle');
          item.removeClass('btn-light');
          item.addClass('btn-success');
          
          step_content = $('li[id='+step+']').children('div.step-content');
          step_content.attr('style','display: display');
      });  

      $("a[name=step_button]").click(function() {          
          $step_selected = $( this ).parent().attr('id');
          if ($step_selected <= {{ $status_id }}){
            $(location).attr('href', '/solicitud?step='+$step_selected)       
          }
      });
  </script>
@endpush