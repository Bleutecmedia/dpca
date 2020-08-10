<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<!-- Navbar -->
	<nav class="main-header navbar navbar-expand navbar-dark navbar-purple">

		<!-- Left navbar links -->
	    <ul class="navbar-nav">
	      	<li class="nav-item">
	        	<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
	      	</li>
	      	<li class="nav-item d-none d-sm-inline-block">
	        	<a href="<?= base_url(); ?>" class="nav-link"><i class="fas fa-home"></i>&nbsp;Inicio</a>
	      	</li>
	      	<li class="nav-item d-none d-sm-inline-block">
	        	<a href="https://bleutecmedia.com" target="_blank" class="nav-link"><i class="fas fa-laptop-code"></i>&nbsp;Bleutecmedia</a>
	      	</li>
	      	<li class="nav-item d-none d-sm-inline-block">
	        	<a href="javascript: void(0);" onclick="openmodal('<?= base_url(); ?>/assets/docs/ayuda/site/index.html')" class="nav-link"><i class="fas fa-question-circle"></i>&nbsp;Ayuda</a>
	      	</li>
	      	
	    </ul>
	    <?php 
	    if(!$this->ion_auth->logged_in()){
	    	?>
	    	<!-- Right navbar links -->
	        <ul class="navbar-nav ml-auto">
                <li><a href="<?= base_url() ?>auth/login" class="btn btn-default"><i class="fas fa-user-nurse"></i>&nbsp;Usuario Local</a></li>
	          	<li><a href="<?= $loginURL ?>"><img src="<?= base_url('assets/img/btn_google_signin_dark_normal_web.png') ?>" width="85%"></a></li>
	        </ul>
	    	<?php
	    }else{
	    	?>
	    	<!-- Right navbar links -->
	        <ul class="navbar-nav ml-auto">
	          	<li><a href="javascript: void(0);" onclick="fn_logout()" class="btn btn-block btn-danger"><i class="fas fa-sign-out-alt"></i>&nbsp;Salir</a></li>
	        </ul>
	    	<?php
	    }
	    ?>
      </nav>
      <!-- /.navbar -->