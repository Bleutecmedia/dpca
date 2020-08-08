<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('secciones/seccion_header_login_view'); ?>

<div class="login-box">
  <div class="card">
    <div class="login-logo m-3">
      <a href="<?php echo base_url(); ?>"><img class="img-fluid" src="<?php echo base_url(); ?>assets/img/logos/logo.png"></a>
    </div>
    <div class="card-body login-card-body">
      <h1><?php echo lang('forgot_password_heading');?></h1>

      <p class="login-box-msg"><?php echo sprintf(lang('forgot_password_subheading'), $identity_label); ?></p>
      <div class="text-danger" id="infoMessage"><?php echo $message;?></div>

      <?php 
      $identity['class']        = "form-control";
      $identity['placeholder']  = (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));

      echo form_open("auth/forgot_password"); ?>
      <div class="input-group mb-3">
        <?php echo form_input($identity); ?>
        <div class="input-group-append input-group-text">
          <span class="fas fa-envelope"></span>
        </div><!-- ./input-group-append  -->
      </div><!--  ./input-group -->
      
      <div class="row">
        <div class="col-8">
        </div><!-- /.col -->
        <div class="col-4">
          <?php echo form_submit('submit', lang('forgot_password_submit_btn'),'class="btn btn-primary btn-block btn-flat"' ); ?>
        </div><!-- /.col -->
      </div>

    <?php echo form_close(); ?>

    </div><!-- /.login-card-body -->
  </div><!-- ./card -->
</div><!-- /.login-box -->

<?php 
$this->load->view('secciones/seccion_footer_login_view');