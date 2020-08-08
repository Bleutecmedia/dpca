<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <h1 class="m-0 text-dark"><i class="fas fa-id-badge"></i>&nbsp;Privacidad de Datos</h1>
      </div><!-- /.col-xl-6 col-lg-6 col-md-6 col-sm-6-->
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><i class="fas fa-tachometer-alt"></i>&nbsp;<a href="<?php echo base_url(); ?>">Inicio</a></li>
          <li class="breadcrumb-item">&nbsp;<a href="javascript: void(0);">Legal</a></li>
          <li class="breadcrumb-item">&nbsp;<a href="javascript: void(0);">Privacidad</a></li>
        </ol>
      </div><!-- /.col-xl-6 col-lg-6 col-md-6 col-sm-6 -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div><!-- /.content-header -->

<div class="row">
  <div class="col-md-12">

    <div class="card">
      <div class="card-header">
        <h5 class="card-title"><i class="far fa-id-badge"></i>&nbsp;Privacidad de Datos Personales de <?= $this->config->item('app_name') ?></h5>
        <div class="card-tools">

        </div>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>&nbsp;Debe LEER cuidadosamente y ACEPTAR la siguiente declaratoria.</div>
        <div class="text-justify">
          <div style="text-align: justify;">
            <div class="policy-text">
            <div class="wp-suggested-text hide-privacy-policy-tutorial">
            <h2>Quiénes somos</h2>
            La dirección de nuestra web es: https://bleutecmedia.com.
            <h2>Qué datos personales recogemos y por qué los recogemos</h2>
            <h3>Comentarios</h3>
            Cuando los visitantes dejan comentarios en la web, recopilamos los datos que se muestran en el formulario de comentarios, así como la dirección IP del visitante y la cadena de agentes de usuario del navegador para ayudar a la detección de spam.

            Una cadena anónima creada a partir de tu dirección de correo electrónico (también llamada hash) puede ser proporcionada al servicio de Gravatar para ver si la estás usando. La política de privacidad del servicio Gravatar está disponible aquí: https://automattic.com/privacy/. Después de la aprobación de tu comentario, la imagen de tu perfil es visible para el público en el contexto de su comentario.
            <h3>Medios</h3>
            Si subes imágenes a la web deberías evitar subir imágenes con datos de ubicación (GPS EXIF) incluidos. Los visitantes de la web pueden descargar y extraer cualquier dato de localización de las imágenes de la web.
            <h3>Formularios de contacto</h3>
            <h3>Cookies</h3>
            Si dejas un comentario en nuestro sitio puedes elegir guardar tu nombre, dirección de correo electrónico y web en cookies. Esto es para tu comodidad, para que no tengas que volver a rellenar tus datos cuando dejes otro comentario. Estas cookies tendrán una duración de un año.

            Si tienes una cuenta y te conectas a este sitio, instalaremos una cookie temporal para determinar si tu navegador acepta cookies. Esta cookie no contiene datos personales y se elimina al cerrar el navegador.

            Cuando inicias sesión, también instalaremos varias cookies para guardar tu información de inicio de sesión y tus opciones de visualización de pantalla. Las cookies de inicio de sesión duran dos días, y las cookies de opciones de pantalla duran un año. Si seleccionas "Recordarme", tu inicio de sesión perdurará durante dos semanas. Si sales de tu cuenta, las cookies de inicio de sesión se eliminarán.

            Si editas o publicas un artículo se guardará una cookie adicional en tu navegador. Esta cookie no incluye datos personales y simplemente indica el ID del artículo que acabas de editar. Caduca después de 1 día.
            <h3>Contenido incrustado de otros sitios web</h3>
            Los artículos de este sitio pueden incluir contenido incrustado (por ejemplo, vídeos, imágenes, artículos, etc.). El contenido incrustado de otras web se comporta exactamente de la misma manera que si el visitante hubiera visitado la otra web.

            Estas web pueden recopilar datos sobre ti, utilizar cookies, incrustar un seguimiento adicional de terceros, y supervisar tu interacción con ese contenido incrustado, incluido el seguimiento de tu interacción con el contenido incrustado si tienes una cuenta y estás conectado a esa web.
            <h3>Analítica</h3>
            Almacenamos datos estadísticos para mejorar nuestros productos y servicios, los cuales pueden incluir:
            <ul>
              <li>La dirección IP.</li>
              <li>El agente del navegador.</li>
              <li>El tipo de Sistema Oparativo.</li>
            </ul>
            <h2>Con quién compartimos tus datos</h2>
            <?= $this->config->item('app_name') ?> no coparte con terceros no asociados

            Todos los datos recolectados de los usuarios, son de uso exclusivamente interno. Toda vez que se recabe información del usuario como parte de la relación directa con este, en respeto a la privacidad y confidencialidad de los usuarios, <?= $this->config->item('app_name') ?> no cederá ni transferirá esa información personal a ningún tercero que no esté autorizados o que no sea parte de él o de Bleutecmedia Software. Únicamente se compartirá con terceros la información personal de los usuarios, en los siguientes casos:
            <ul>
              <li>Cuando exista obligación legal de hacerlo.</li>
              <li>Cuando exista una orden emanada de un Tribunal de Justicia competente.</li>
            </ul>
            <h2>Cuánto tiempo conservamos tus datos</h2>
            Si dejas un comentario, el comentario y sus metadatos se conservan indefinidamente. Esto es para que podamos reconocer y aprobar comentarios sucesivos automáticamente en lugar de mantenerlos en una cola de moderación.

            De los usuarios que se registran en nuestra web (si los hay), también almacenamos la información personal que proporcionan en su perfil de usuario. Todos los usuarios pueden ver, editar o eliminar su información personal en cualquier momento (excepto que no pueden cambiar su nombre de usuario). Los administradores de la web también pueden ver y editar esa información.
            <h2>Qué derechos tienes sobre tus datos</h2>
            Si tienes una cuenta o has dejado comentarios en esta web, puedes solicitar recibir un archivo de exportación de los datos personales que tenemos sobre ti, incluyendo cualquier dato que nos hayas proporcionado. También puedes solicitar que eliminemos cualquier dato personal que tengamos sobre ti. Esto no incluye ningún dato que estemos obligados a conservar con fines administrativos, legales o de seguridad.
            <h2>Dónde enviamos tus datos</h2>
            Los datos de los usuarios son almacenados en medios seguros, en dónde terceros no están autorizados. Los comentarios de los visitantes puede que los revise un servicio de detección automática de spam.

            </div>
            </div>
            </div>
        </div>
      </div><!-- ./card-body -->

      <div class="card-footer">

      </div><!-- /.card-footer -->

    </div><!-- /.card -->
  </div><!-- /.col -->
</div><!-- /.row -->