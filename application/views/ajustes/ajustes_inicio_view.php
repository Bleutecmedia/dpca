<?php defined('BASEPATH') OR exit('No direct script access allowed');

switch ($opc) {
  case 1:
    # code...
    break;
  
  default:// Vista incial
    ?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <h1 class="m-0 text-dark"><i class="fas fa-cogs"></i>&nbsp;<?php echo lang('label_ajustes'); ?></h1>
          </div><!-- /.col-xl-6 col-lg-6 col-md-6 col-sm-6-->
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><i class="fas fa-tachometer-alt"></i>&nbsp;<a href="<?php echo base_url(); ?>"><?php echo lang('label_inicio'); ?></a></li>
              <li class="breadcrumb-item"><a href="javascript: void(0);" onclick="fn_cargar_ajax_g('ajustes','load_content',0)"><?php echo lang('label_ajustes'); ?></a></li>
            </ol>
          </div><!-- /.col-xl-6 col-lg-6 col-md-6 col-sm-6 -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div><!-- /.content-header -->

    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title"><i class="fas fa-cog"></i>&nbsp;AJUSTES DE LA APLICACIÓN</h5>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div><!-- /.card-header -->
          <div class="card-body">
            
            
          </div><!-- ./card-body -->

          <div class="card-footer">
            
          </div><!-- /.card-footer -->

        </div><!-- /.card -->

      </div><!-- /.col -->
    </div><!-- /.row -->
    <?php
    break;
}