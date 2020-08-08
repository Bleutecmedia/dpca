<?php defined('BASEPATH') OR exit('No direct script access allowed');

switch ($opc) {
	case 1:
		# code...
		break;
	
	default:// Vista incial de los Ajustes
		?>
		<!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-id-card-alt"></i>&nbsp;<?= lang('label_perfil'); ?></h1>
              </div><!-- /.col-xl-6 col-lg-6 col-md-6 col-sm-6-->
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><i class="fas fa-tachometer-alt"></i>&nbsp;<a href="<?= base_url(); ?>"><?= lang('label_inicio'); ?></a></li>
                  <li class="breadcrumb-item"><a href="javascript: void(0);" onclick="fn_cargar_ajax_g('perfil','load_content',0)"><?= lang('label_perfil'); ?></a></li>
                </ol>
              </div><!-- /.col-xl-6 col-lg-6 col-md-6 col-sm-6 -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div><!-- /.content-header -->

        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">MI PERFIL DE USUARIO</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <?php 
                if( isset($user) && $user ){
                  //Variables del formulario del usuario
                  $username  = array(
                    'name'        =>  'username',
                    'id'          =>  'username',
                    'autofocus'   =>  'autofocus',
                    'placeholder' =>  lang('label_username'),
                    'minlength'   =>  '5',
                    'maxlength'   =>  '60',
                    'tabindex'    =>  '1',
                    'class'       =>  'form-control validate[required],ajax[validaUsername]]',
                    'value'       =>  $user->username
                  );

                  $first_name = array(
                    'name'          => 'first_name',
                    'id'            => 'first_name',
                    'placeholder'   => lang('label_nombre'),
                    'maxlength'     =>  '50',
                    'tabindex'      =>  '2',
                    'class'         => 'form-control validate[required]',
                    'value'         =>  $user->first_name
                  );

                  $last_name = array(
                    'name'          =>  'last_name',
                    'id'            =>  'last_name',
                    'placeholder'   =>  lang('label_apellidos'),
                    'maxlength'     =>  '50',
                    'tabindex'      =>  '3',
                    'class'         => 'form-control validate[required]',
                    'value'         =>  $user->last_name
                    );

                  $email = array(
                    'name'            =>  'email',
                    'id'              =>  'email',
                    'placeholder'     =>  lang('label_email'),
                    'class'           =>  'form-control validate[required,custom[email],ajax[validaEmail]]',
                    'tabindex'        =>  '4',
                    'data-inputmask'  =>  "'alias': 'email'",
                    'value'           =>  $user->email
                  );

                  $phone = array(
                    'name'            =>  'phone',
                    'id'              =>  'phone',
                    'placeholder'     =>  lang('label_telefono'),
                    'maxlength'       =>  '50',
                    'tabindex'        =>  '5',
                    'class'           =>  'form-control validate[required,custom[phone]',
                    'data-inputmask'  =>  "'mask': '(999) 999-9999'",
                    'value'           =>  $user->phone
                  );

                  $cellphone = array(
                    'name'            =>  'cellphone',
                    'id'              =>  'cellphone',
                    'placeholder'     =>  lang('label_ingresa').lang('label_telefono_cel'),
                    'maxlength'       =>  '20',
                    'tabindex'        =>  '6',
                    'class'           =>  'form-control validate[required,custom[phone]',
                    'data-inputmask'  =>  "'mask': '(999) 999-9999'",
                    'value'           =>  $user->cellphone
                  );

                  $company = array(
                    'name'            =>  'company',
                    'id'              =>  'company',
                    'placeholder'     =>  lang('label_empresa'),
                    'maxlength'       =>  '50',
                    'tabindex'        =>  '6',
                    'class'           => 'form-control validate[required]',
                    'value'           =>  $user->company
                  );

                  echo validation_errors();
                  echo form_open('perfil/datos','name="perfil" id="perfil" class="form-horizontal"'); 
                  echo form_hidden('id',1); // Para entrar a la opción if = 1 de la función del controlador
                  echo form_hidden('accion',3); // 1-> Nuevo usuario, 2-> Editar Usuario, 3-> Editr Perfil
                  ?>
                  <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <h4><i class="fas fa-user-tag"></i>&nbsp;<?php echo lang('label_datos_acceso'); ?></h4>
                    </div><!-- /.col-xs-12 col-sm-12 col-md-12 -->
                  </div><!-- ./row -->

                  <div class="row">
                    <div class="col-4">
                      <label for="username"><?php echo lang('label_username'); ?></label><br>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                        </div>
                        <?php echo form_input($username); ?>
                       </div><!-- ./input-group -->
                    </div><!-- ./col -->

                     <div class="col-4">
                      <label for="first_name"><?php echo lang('label_nombre'); ?></label><br>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-tags"></i></span>
                        </div>
                        <?php echo form_input($first_name); ?>
                       </div><!-- ./input-group -->
                    </div><!-- ./col -->

                    <div class="col-4">
                      <label for="last_name"><?php echo lang('label_apellidos'); ?></label><br>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-tags"></i></span>
                        </div>
                        <?php echo form_input($last_name); ?>
                       </div><!-- ./input-group -->
                    </div><!-- ./col -->
                  </div><!-- ./row -->

                   <div class="row">
                    <div class="col-4">
                      <label for="email"><?php echo lang('label_email'); ?></label><br>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-envelope-open-text"></i></span>
                        </div>
                        <?php echo form_input($email); ?>
                       </div><!-- ./input-group -->
                    </div><!-- ./col -->

                     <div class="col-4">
                      <label for="phone"><?php echo lang('label_telefono'); ?></label><br>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-phone-square"></i></span>
                        </div>
                        <?php echo form_input($phone); ?>
                       </div><!-- ./input-group -->
                    </div><!-- ./col -->

                    <div class="col-4">
                      <label for="phone"><?php echo lang('label_telefono_cel'); ?></label><br>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-mobile"></i></span>
                        </div>
                        <?php echo form_input($cellphone); ?>
                       </div><!-- ./input-group -->
                    </div><!-- ./col -->
                  </div><!-- ./row -->

                  <div class="row">
                    <div class="col-8">
                      <label for="company"><?php echo lang('label_empresa'); ?></label><br>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-building"></i></span>
                        </div>
                        <?php echo form_input($company); ?>
                       </div><!-- ./input-group -->
                    </div><!-- ./col -->

                    <div class="col-4">
                     <br>
                     <?php 
                     if(!$this->config->item('app_demo')){
                      ?><button type="button" id="guardaperfil" class="btn btn-primary btn-block"><i class="fas fa-save"></i>&nbsp;Guardar ajustes</button><?php
                     }else{
                      ?><button type="button" class="btn btn-primary btn-block disabled"><i class="fas fa-save"></i>&nbsp;Guardar ajustes</button>
                      <p class="text-danger">* No se pueden hacer ajustes en la DEMO</p><?php
                     }
                     ?>
                      
                    </div><!-- ./col -->
                  </div><!-- ./row -->
                  <?php echo form_close(); ?>

                  <script type="text/javascript">
                    $(function(){
                      $.extend($.validationEngineLanguage.allRules,{
                        "validaEmail":{
                          "url": "<?php echo base_url(); ?>perfil/validate",
                          "extraData": "id=1&item1=<?php echo $user->id; ?>",
                          "alertTextOk": "* <?php echo lang('label_email_ok'); ?>",
                          "alertText": "* <?php echo lang('label_email_no'); ?>",
                          "alertTextLoad": "* <?php echo lang('label_validating'); ?>"
                        },
                        "validaUsername":{
                          "url": "<?php echo base_url(); ?>perfil/validate",
                          "extraData": "id=2&item1=<?php echo $user->id; ?>",
                          "alertTextOk": "* <?php echo lang('label_username_ok'); ?>",
                          "alertText": "* <?php echo lang('label_username_no'); ?>",
                          "alertTextLoad": "* <?php echo lang('label_validating'); ?>"
                        }
                      });

                      $(":input").inputmask();
                      $("#perfil").validationEngine('attach',{promptPosition : "topLeft", scroll: true }, {focusFirstField : true });
                      
                      // fix double submit
                      $("#guardaperfil").on('click', function (event) {  
                        event.preventDefault();
                        var el = $(this);
                        el.prop('disabled', true);
                        
                        setTimeout(function() {
                          $('#perfil').submit();
                        }, 200);
                        setTimeout(function(){el.prop('disabled', false); }, 2000);
                      });

                      var options = { 
                        target:       '#div_oculto', 
                        beforeSubmit:   showRequest, 
                        success:        showResponse,
                        dataType:       'html',
                        timeout:        3000 
                      };

                      $('#perfil').ajaxForm(options);

                    });// FUNCTION

                    function showRequest(formData, jqForm, options) { 
                      var queryString = $.param(formData); 
                      $("#perfil").prop('disabled', true);
                    } 
                   
                    function showResponse(responseText, statusText, xhr, $form){ 
                      if(responseText == 1){
                        const Toast = Swal.mixin({
                          toast: true,
                          position: 'top-end',
                          showConfirmButton: false,
                          timer: 3000
                        });

                        Toast.fire({
                          type: 'success',
                          title: 'Se ha procesado su solicitud correctamente'
                        })

                        fn_cargar_ajax_g('perfil','load_content',0)
                      }else{
                        Swal.fire({
                          type: 'error',
                          title: 'Ooops!',
                          text: 'Hubo un error, vuelva a intentarlo...',
                          animation: false,
                          customClass: 'animated shake'
                        });
                      }
                      $("#perfil").prop('disabled', false);
                    }
                  </script>
                  <?php
                }else{
                  ?><div class="alert alert-danger" role="alert"><i class="fas fa-exclamation-circle"></i>&nbsp;No hay datos del Perfil que gestionar.</div><?php
                }
                ?>
            </div><!-- /.card -->
          </div><!-- /.col -->
        </div><!-- /.row -->
		<?php
		break;
}