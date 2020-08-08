<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <h1 class="m-0 text-dark"><i class="fas fa-id-badge"></i>&nbsp;Términos y Condiciones</h1>
      </div><!-- /.col-xl-6 col-lg-6 col-md-6 col-sm-6-->
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><i class="fas fa-tachometer-alt"></i>&nbsp;<a href="<?php echo base_url(); ?>">Inicio</a></li>
          <li class="breadcrumb-item">&nbsp;<a href="javascript: void(0);">Legal</a></li>
          <li class="breadcrumb-item">&nbsp;<a href="javascript: void(0);">TOS</a></li>
        </ol>
      </div><!-- /.col-xl-6 col-lg-6 col-md-6 col-sm-6 -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div><!-- /.content-header -->

<div class="row">
  <div class="col-md-12">

    <div class="card">
      <div class="card-header">
        <h5 class="card-title"><i class="far fa-id-badge"></i>&nbsp;Térmonos y Condiciones de Uso de <?= $this->config->item('app_name') ?></h5>
        <div class="card-tools">

        </div>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>&nbsp;Debe LEER cuidadosamente y ACEPTAR la siguiente declaratoria.</div>
        <div class="text-justify">
              <div style="text-align: justify;">

              Es requisito necesario para la adquisición de los productos que se ofrecen en este sitio, que lea y acepte los Términos y Condiciones que a continuación se redactan. El uso de nuestros servicios, así como la compra de nuestros productos, implicará que usted ha leído y aceptado los Términos y Condiciones de Uso en el presente documento. Todos los productos que son ofrecidos por nuestro sitio web pudieran ser creados, cobrados, enviados o presentados por una página web y en tal caso estarían sujetas a sus propios Términos y Condiciones. En algunos casos, para adquirir un producto, será necesario el registro por parte del usuario, con ingreso de datos personales fidedignos y definición de una contraseña.

              El usuario puede elegir y cambiar la clave para su acceso de administración de la cuenta en cualquier momento, en caso de que se haya registrado y que sea necesario para la compra de alguno de nuestros productos, <?= $this->config->item('app_name') ?> no asume la responsabilidad en caso de que entregue dicha clave a terceros.

              Todas las compras y transacciones que se lleven a cabo por medio de este sitio web, están sujetas a un proceso de verificación y confirmación, el cual podría incluir la verificación del stock y disponibilidad de producto, validación de la forma de pago, validación de la factura (en caso de existir) y el cumplimiento de las condiciones requeridas por el medio de pago seleccionado. En algunos casos puede que se requiera una verificación por medio de correo electrónico o vía telefónica.

              Los precios de los productos ofrecidos en esta Tienda Online son válidos únicamente en las compras realizadas a través de este sitio web.

              <br><br>
              <strong>POLÍTICA DE REEMBOLSO Y GARANTÍA</strong><br>

              <?= $this->config->item('app_name') ?> le ofrece diferentes alternativas de contacto a través de los cuales se le atenderá para que usted recabe información suficiente y necesaria antes de realizar su compra, de la cual <strong>NO SE REALIZARÁ REEMBOLSO</strong> una vez efectuada la misma. Le pedimos que lea cuidadosamente antes de realizar su compra.
              <br><br>
              <strong>COMPROBACIÓN ANTIFRAUDE</strong><br>

              La compra del cliente puede ser aplazada para la comprobación antifraude. También puede ser suspendida por más tiempo para una investigación más rigurosa, para evitar transacciones fraudulentas.

              </div>
        </div>
      </div><!-- ./card-body -->

      <div class="card-footer">

      </div><!-- /.card-footer -->

    </div><!-- /.card -->
  </div><!-- /.col -->
</div><!-- /.row -->