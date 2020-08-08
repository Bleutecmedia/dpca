<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('secciones/seccion_header_view');
$this->load->view('secciones/seccion_navbar_view');
$this->load->view('secciones/seccion_sidebar_view');
?>
	<!-- Content Wrapper. Contains page content -->
  	<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

        <div id="load_content">
          <!-- Content Header (Page header) -->
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                  <h1 class="m-0 text-dark"><i class="fas fa-home"></i>&nbsp;Inicio</h1>
                </div><!-- /.col-xl-6 col-lg-6 col-md-6 col-sm-6-->
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><i class="fas fa-tachometer-alt"></i>&nbsp;<a href="<?= base_url(); ?>">Inicio</a></li>
                  </ol>
                </div><!-- /.col-xl-6 col-lg-6 col-md-6 col-sm-6 -->
              </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </div><!-- /.content-header -->

          <?php 
          // Si el Usuario está Logueado...
          if($this->ion_auth->logged_in()){
            ?>

            <div class="row">
              <div class="col-12 col-sm-12 col-md-12">
                <a href="javascript: void(0);" class="btn btn-primary" onclick="fn_cargar_ajax_g('dialisis','load_content',0)"><i class="fas fa-plus"></i>&nbsp;Nueva</a>
              </div><!-- ./col-12 col-sm-12 col-md-12 -->
            </div><!-- ./row -->
            
            <div class="row mt-2">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h5 class="card-title">Bienvenido a <?= $this->config->item('app_name') ?>. Para empezar abra una Nueva.
                    </h5>

                    <div class="card-tools">

                    </div>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    <img class="img-fluid" src="<?= base_url('assets/img/header.png') ?>">
                  </div><!-- ./card-body -->

                  <div class="card-footer">

                  </div><!-- /.card-footer -->

                </div><!-- /.card -->
              </div><!-- /.col -->
            </div><!-- /.row -->
            <?php
          }else{
            // El usuario no está logueado
            ?>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h5 class="card-title">
                        <a href="<?= $loginURL ?>"><img src="<?= base_url('assets/img/btn_google_signin_dark_normal_web.png') ?>"></a>&nbsp;Inicia sesión y empieza a generar Sorteos.
                    </h5>

                    <div class="card-tools">

                    </div>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    <img class="img-fluid" src="<?= base_url('assets/img/header.png') ?>">
                  </div><!-- ./card-body -->

                  <div class="card-footer">

                  </div><!-- /.card-footer -->

                </div><!-- /.card -->
              </div><!-- /.col -->
            </div><!-- /.row -->
            <?php
          }
          ?>
        </div><!-- #load_content -->

      </div><!-- /.container-fluid -->
    </div><!-- /.content -->
  </div><!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5><i class="fas fa-cogs"></i>&nbsp;Opciones</h5>
      <p>Contenido</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->
<?php

$this->load->view('secciones/seccion_credits_view');
$this->load->view('secciones/seccion_footer_view');
