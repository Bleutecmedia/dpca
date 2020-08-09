<?php defined('BASEPATH') OR exit('No direct script access allowed');

switch ($opc) {
  case 1:
    # code...
    break;
  
  default:// Vista incial
    ?>
    <h4><i class="fas fa-cog"></i>&nbsp;Ajustes Generales</h4>
    <?php 
    if(isset($conf) && $conf){
        // Nombre del Paciente
        $paciente = array(
          'name'        => 'paciente',
          'id'          => 'paciente',
          'tabindex'    =>  '1',
          'class'       =>  'form-control validate[required]',
          'placeholder' =>  'Nombre del Paciente',
          'value'       =>  $conf->conf_paciente
        );

        // Nombre del Paciente
        $intercambios = array(
          'name'          => 'intercambios',
          'id'            => 'intercambios',
          'tabindex'      =>  '2',
          'class'         =>  'form-control validate[required]',
          'placeholder'   =>  'Intercambios al día',
          'data-inputmask'=>   "'alias': 'integer'",
          'value'         =>  $conf->conf_intercambios
        );

      echo form_open('ajustes/generales','name="ajustesa" id="ajustesa" class="form-horizontal"'); 
      ?>
      <div class="row">
        <div class="col-sm-12 col-md-12 col-xl-6 col-lg-6">
          <label for="paciente">&nbsp;Nombre del Paciente:</label><br>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
            </div>
            <?php echo form_input($paciente); ?>
         </div><!-- ./input-group -->
        </div><!-- ./col-sm-12 col-md-12 col-xl-6 col-lg-6 -->
        <div class="col-sm-12 col-md-12 col-xl-4 col-lg-4">
          <label for="intercambios">&nbsp;Intercambios por día:</label><br>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
            </div>
            <?php echo form_input($intercambios); ?>
         </div><!-- ./input-group -->
        </div><!-- ./col-sm-12 col-md-12 col-xl-4 col-lg-4 -->
        <div class="col-sm-12 col-md-12 col-xl-2 col-lg-2">
          <label>&nbsp;</label><br>
          <button type="button" id="sendforma" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;Guardar Datos</button>
        </div><!-- ./col-sm-12 col-md-12 col-xl-2 col-lg-2 -->
      </div><!-- ./row -->
      <?php echo form_close(); ?>

      <script type="text/javascript">
        $(function(){
          $(":input").inputmask();
          $("#ajustesa").validationEngine(
            'attach',
            {
             onFieldFailure: function(form, status){
                var elm = $('#sendforma');
                elm.prop('disabled', false);
                elm.html( elm.data('original-text') );
              }
            },
            {
              promptPosition : "bottomLeft", 
              scroll: true 
            }, 
            {
              focusFirstField : true 
            });

          var options = {
            target:         '#div_oculto',
            beforeSubmit:   showRequest,
            success:        showResponse,
            dataType:       'html',
            timeout:        3000
          };

          $('#ajustesa').ajaxForm(options);

          var elm = $('#sendforma');

          elm.on('click',function(event){
            event.preventDefault();

            var loadingText = '<i class="fas fa-sync-alt fa-spin"></i> Guardando datos...';
            if (elm.html() !== loadingText) {
              elm.data( 'original-text', elm.html() );
              elm.html(loadingText);
            }

            elm.prop('disabled', true);
              setTimeout(function() {
                $("#ajustesa").submit();
              }, 500);
          })
          
        }); // function

        function showRequest(formData, jqForm, options) {
          var queryString = $.param(formData);

        }

        function showResponse(responseText, statusText, xhr, $form){
          var elm = $("#sendforma");
          elm.prop('disabled', false);
          elm.html( elm.data('original-text') );

          if(responseText > 0){
            fn_success('Datos actualizados correctamente.');
            setTimeout(function(){ location.href="<?= base_url(); ?>"; }, 3000);
          }else{
            fn_error();
          }//enf if(responseText)
        }
      </script>
      <?php
    }else{
      ?><p class="text-danger"><i class="fas fa-exclamation-circle"></i>&nbsp;No hay ajustes que modificar.</p><?php
    }
    break;
}