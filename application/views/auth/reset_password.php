<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('secciones/seccion_header_login_view'); ?>

<div class="login-box">
  <!-- /.login-logo -->
  <div class="card">
    <div class="login-logo m-3">
      <a href="<?php echo base_url(); ?>"><img class="img-fluid" src="<?php echo base_url(); ?>assets/img/logos/logo.png"></a>
    </div>
    <div class="card-body login-card-body">
      	<h1><?php echo lang('reset_password_heading');?></h1>

      	<p class="login-box-msg"><?php echo lang('login_subheading'); ?></p>
      	<div class="text-danger" id="infoMessage"><?php echo $message; ?></div>

      	<?php 
      	$new_password['class']        = "form-control";
      	$new_password['placeholder']  = sprintf( lang('reset_password_new_password_label'), $min_password_length);

      	$new_password_confirm['class']        = "form-control";
      	$new_password_confirm['placeholder']  = lang('reset_password_new_password_confirm_label');

      	echo form_open('auth/reset_password/' . $code);
      	echo form_input($user_id);
		echo form_hidden($csrf); ?>
      	<div class="input-group mb-3">
        	<?php echo form_input($new_password); ?>
        	<div class="input-group-append input-group-text">
          		<span class="fas fa-lock"></span>
        	</div><!-- ./input-group-append  -->
      	</div><!--  ./input-group -->
      	<div class="input-group mb-3">
        	<?php echo form_input($new_password_confirm); ?>
        	<div class="input-group-append input-group-text">
          		<span class="fas fa-lock"></span>
        	</div><!-- ./input-group-append  -->
      	</div><!--  ./input-group -->

      	<div class="row">
        	<div class="col-6">
        	</div><!-- /.col -->
        	<div class="col-6">
        		<?php echo form_submit('submit', lang('reset_password_submit_btn'), 'class="btn btn-primary btn-block btn-flat"'); ?>
        	</div><!-- /.col -->
      	</div>

    	<?php echo form_close();?>
    	</div><!-- /.login-card-body -->
  	</div><!-- ./card -->
</div><!-- /.login-box -->

<?php 
$this->load->view('secciones/seccion_footer_login_view');