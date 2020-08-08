<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('secciones/seccion_header_login_view');
?>

<div class="login-box">
 
  
  <div class="card">
     <!-- /.login-logo -->
    <div class="login-logo m-3">
      <a href="<?php echo base_url(); ?>"><img class="img-fluid" src="<?php echo base_url(); ?>assets/img/logos/logo.png"></a>
    </div>

    <div class="card-body login-card-body">
      <h1><?php echo lang('login_heading'); ?></h1>

      <p class="login-box-msg"><?php echo lang('login_subheading'); ?></p>
      <div class="text-danger" id="infoMessage"><?php echo $message; ?></div>

      <?php 
      $identity['class']        = "form-control";
      $identity['placeholder']  = lang('login_identity_label');

      $password['class']        = "form-control";
      $password['placeholder']  = lang('login_password_label');

      // Si está activada la demo, llenamos los datos de acceso
      if($this->config->item('app_demo')){
        $identity['value']    = 'admin';
        $password['value']    = 'admin123';
      }

      echo form_open("auth/login"); ?>
      <div class="input-group mb-3">
        <?php echo form_input($identity); ?>
        <div class="input-group-append input-group-text">
          <span class="fas fa-envelope"></span>
        </div><!-- ./input-group-append  -->
      </div><!--  ./input-group -->
      <div class="input-group mb-3">
        <?php echo form_input($password); ?>
        <div class="input-group-append input-group-text">
          <span class="fas fa-lock"></span>
        </div><!-- ./input-group-append  -->
      </div><!--  ./input-group -->

      <div class="row">
        <div class="col-6">
          <div class="icheck-primary">
            <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
            <label for="remember">
              <?php echo lang('login_remember_label', 'remember'); ?>
            </label>
          </div>
        </div><!-- /.col -->
        <div class="col-6">
          <?php echo form_submit('submit',lang('login_submit_btn'), 'class="btn btn-primary btn-block btn-flat"' ); ?>
        </div><!-- /.col -->
      </div>

    <?php echo form_close();?>

      <hr>
      <?php 
      if(!$this->config->item('app_demo') && $this->config->item('app_membresia') ){
        ?>
        <p class="mt-2 text-center">
          <a href="<?php echo base_url(); ?>auth/forgot_password"><i class="fas fa-question-circle"></i>&nbsp;<?php echo lang('login_forgot_password');?></a>
        </p>
        <?php
      }
      ?>
      <p class="text-center"><a href="<?php echo $this->config->item('tienda_url_shop'); ?>" target="_blank"><i class="fas fa-shopping-cart"></i>&nbsp;Comprar una Membresía</a></p>

    </div><!-- /.login-card-body -->
  </div><!-- ./card -->
</div><!-- /.login-box -->

<?php 
$this->load->view('secciones/seccion_footer_login_view');