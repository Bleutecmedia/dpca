<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$this->load->view('secciones/seccion_header_view');
$this->load->view('secciones/seccion_navbar_view');
$this->load->view('secciones/seccion_sidebar_view');

// Nueva instancia de Mobile Detect
$detect = new Mobile_Detect;

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
                  <h1 class="m-0 text-dark"><i class="fas fa-home"></i>&nbsp;Bienvenido</h1>
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
            
            <div class="row mt-2">
              <div class="col-md-12">

                <div class="card card-default card-tabs">
                  <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                      <li class="pt-2 px-3"><h3 class="card-title"><i class="fas fa-laptop-medical"></i>&nbsp;<b><?= $this->config->item('app_name') ?></b></h3></li>
                      <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-two-inicio-tab" data-toggle="pill" href="#custom-tabs-two-inicio" role="tab" aria-controls="custom-tabs-two-inicio" aria-selected="true"><?= $detect->isMobile() ? '<i class="fas fa-diagnoses"></i>&nbsp;' : '<i class="fas fa-diagnoses"></i>&nbsp;' ?>Control</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false"><?= $detect->isMobile() ? '<i class="fas fa-cog"></i>' : '<i class="fas fa-cog"></i>&nbsp;Ajustes' ?></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false"><?= $detect->isMobile() ? '<i class="far fa-address-book"></i>' : '<i class="far fa-address-book"></i>&nbsp;Reportes' ?></a>
                      </li>
                      
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="tab-content" id="custom-tabs-two-tabContent">
                      <div class="tab-pane fade active show" id="custom-tabs-two-inicio" role="tabpanel" aria-labelledby="custom-tabs-two-inicio-tab">
                        <?php 
                        for ($i = 0; $i < $conf->conf_intercambios; $i++) {
                          ?>
                          <div class="mt-2"><a href="javascript: void(0);" class="btn bg-navy"><i class="fas fa-notes-medical"></i>&nbsp;Intercambio #<?= ($i +1) ?></a></div>
                          <?php
                        }
                        ?>
                      </div>
                      <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                         Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
                      </div>
                      <div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
                         Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
                      </div>
                      
                    </div>
                  </div>
                  <!-- /.card -->
                </div>

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
                    <h5 class="card-title"><i class="fas fa-code-branch"></i>&nbsp;<?php echo lang('label_app_shorname'); ?> v<?= $this->config->item('app_version') ?></h5>

                    <div class="card-tools">

                    </div>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    
                    <div class="contentBox text-justify">
                      <h2>¿Qué es la diálisis peritoneal continua ambulatoria?</h2>
                        <p>La diálisis peritoneal continua ambulatoria (DPCA) se realiza para remover desechos, químicos y líquido adicional del cuerpo. Durante la DPCA, se coloca un líquido que se conoce como dializador dentro del abdomen a través de un catéter (una sonda delgada). El dializador saca los desechos, químicos y líquido adicional de la sangre a través del peritoneo. El peritoneo es un revestimiento delgado en el interior del abdomen. El peritoneo funciona como un filtro conforme pasan los desechos a través de este. El proceso de llenar y vaciar el abdomen con dializador se conoce como intercambio. Los intercambios podrían realizarse de 3 a 5 veces durante el día y una vez durante la noche.</p>
                      
                      <h2>¿Porqué necesito DPCA?</h2>
                        <p>Usted podría necesitar DPCA si sus riñones no funcionan bien o dejaron de funcionar. Los riñones remueven los desechos y el líquido adicional de la sangre y se eliminan del cuerpo a través de la orina. Cuando los riñones se dañan, no pueden eliminar los desechos apropiadamente. Eso puede provocar problemas graves en el cuerpo. Usted podría necesitar una DPCA si tiene insuficiencia renal aguda (de corta duración) o crónica (prolongada). Durante la insuficiencia renal aguda, usted podría necesitar DPCA solamente hasta que los riñones estén mejor. Si tiene insuficiencia renal crónica, usted necesitará tener intercambios de dializador por el resto de su vida.</p>
                      
                      <h2>¿Cómo se coloca el catéter para DPCA?</h2>
                        <p>Se realizará un procedimiento para colocar el catéter. Se le va a administrar medicamentos para relajarlo y para disminuir dolor. El médico realizará una incisión debajo o a un lado del ombligo, o un poco más abajo de las costillas. Él va a cortar a través del músculo y tejido para perforar el lugar donde se va a colocar el catéter. Se empujará el catéter hacia dentro del abdomen a través de esta perforación. El extremo del catéter podría colocarse justo debajo de la piel por 3 a 5 semanas. El médico le administrará un poco de líquido a través del catéter para ver si funciona bien. También podría colocar un medicamento anticoagulante para evitar que se obstruya el catéter. El catéter se sujetará en su lugar con puntos y el área se cubrirá con vendajes.</p>
                      
                      <h2>¿Cómo se realizan los intercambios para DPCA?</h2>
                      <div id="display-ad-injection-1" class="display-ad display-ad-injection display-ad-lazy display-ad-prebid display-ad-728 display-ad-728x90"></div><p>Los intercambios para DPCA deberían realizarse en una habitación con buena iluminación. No debería haber animales, caspa, vientos fuertes o abanicos en la habitación. Estos podrían aumentar el riesgo de una infección.</p>
                        <ul>
                          <li><b>Reúna sus instrumentos.</b> Coloque los siguientes utensilios en una mesa limpia cerca del área donde usted va a realizar el intercambio para DPCA:<ul>
                          <li>Bolsa de dializador y bolsa para desecho</li>
                          <li>Tubería en forma de Y</li>
                          <li>Base para IV (se usa para colgar la bolsa del dializador)</li>
                          <li>Guantes médicos desechables</li>
                          <li>Mascara médica para usar sobre el rostro mientras realiza la DPCA</li>
                          <li>Pinzas para la tubería</li>
                          <li>Jeringa de plástico nueva sin la aguja (si es necesario)</li></ul></li>
                          <li><b>Lávese las manos con agua y jabón.</b> Lávese las manos con jabón por lo menos 15 segundos antes de enjuagarlas. Séquese las manos con una toalla limpia o una toalla de papel. No toque la tubería o el catéter sin lavarse las manos y usar guantes. Mantenga las uñas de las manos cortas y limpias.</li>
                          <li><b>Póngase los guantes y la máscara.</b> Póngase la máscara para que le cubra la boca y la nariz. No toque nada, solamente el catéter y los utensilios después de ponerse los guantes.</li>
                          <li><b>Enjuague la tubería.</b> Enjuague la tubería con el líquido dializador antes del intercambio para ayudar a evitar infecciones. Conecte la parte inferior del tubo en forma de Y al catéter y conecte las otras 2 extremidades de la tubería a la bolsa de dializador y a la bolsa de desecho. Sujete con una pinza la tubería que está conectada al catéter que va dentro del abdomen. Esto va a cerrar la tubería para que el dializador no llegue al abdomen todavía. Permita que 100 mililitros (mL) de dializador fresco corran fuera de la bolsa para abajo de la tubería hacia la bolsa de desecho. Después de drenar los 100 mL de dializador, sujete la tubería que va a la bolsa de desecho con una pinza.</li>
                          <li><b>Permita que el dializador corra dentro del abdomen.</b> Cuelgue la bolsa a un nivel mas alto del abdomen. Remueva la pinza de la tubería que está conectada al catéter que va dentro del abdomen. Permita que el dializador restante corra dentro del abdomen. Esto no debería tomar mas de 10 minutos. Usted se puede acostar, sentar o estar de pie mientras el dializador ingresa. Una vez que todo el dializador esté en el abdomen, lávese las manos y póngase un par de guantes nuevos. Desconecte el catéter de la tubería. Cierre el catéter con la pinza. Mantenga el dializador en el abdomen de 3 a 5 horas en tiempo de espera.</li>
                          <li><b>Drene el dializador fuera del abdomen y dentro de la bolsa de desecho.</b><ul>
                          <li>Después del tiempo de espera, siga los pasos de lavarse las manos y ponerse la máscara. Asegúrese que los utensilios que usted necesita están cerca y listos para usarse. Conecte la tubería en forma de Y al catéter nuevamente. Haga esto de la misma forma que colocó el dializador en el abdomen. Sujete con una pinza la tubería que va al bolso de dializador para que esté cerrado. Cuelgue la bolsa a un nivel mas bajo que el abdomen. Remueva las pinzas de la tubería que conduce a la bolsa de desecho. Permita que el dializador drene del abdomen dentro de la bolsa de desecho.</li>
                          <li>Si el dializador no está saliendo debidamente, cambie la posición del cuerpo. Si esto no logra que el dializador comienza a drenar mejor, desconecte la extremidad de la tubería que está conectada al catéter. Use una jeringa para sacar cuidadosamente el dializador del abdomen. Debería tomar menos de 45 minutos para drenar el dializador fuera del abdomen. El dializador que sale fuera, debería estar claro. Después que ha salido todo el dializador, cierre la bolsa de desecho y deshágase de ella como se le indicó. Lávese las manos.</li>
                        </ul>
                      </li>
                      </ul>
                      <h2>¿Qué es la diálisis peritoneal automatizada?</h2>
                      <p>La diálisis peritoneal automatizada (DPA) es un tipo de diálisis que usa una máquina que se llama cicladora. Coloca el dializador dentro del abdomen y lo drena después de que el intercambio se completa. Usted podría realizar 1 intercambio que permite que la solución dializante permanezca en el abdomen durante el día. Por la noche, usted puede conectar el catéter a la cicladora para drenarlo. Los intercambios de diálisis peritoneal también se realizarán mientras usted duerme. Si usted duerme de 8 a 9 horas, la máquina podría realizar de 3 a 5 intercambios durante ese tiempo. Con DPA, usted no necesita dejar de hacer lo que está haciendo durante el día para hacer un intercambio. Pida más información a su médico acerca de la DPA.</p>
                      <h2>¿Necesito seguir una dieta especial?</h2>
                      <ul>
                      <li>Deberá limitar el fósforo y el sodio (sal). Dependiendo de sus niveles sanguíneos, podría ser necesario aumentar o reducir su consumo de potasio. Usted también necesitará proteína adicional, ya que la proteína se pierde con los intercambios. El dializador contiene azúcar, lo cual podría provocar que usted aumente de peso. Su dietista podría sugerir que reduzca la cantidad de calorías que consume a diario si aumenta de peso.</li>
                      <li>Es posible que usted también necesite limitar la ingesta de líquido si el cuerpo retiene líquido. Su médico le indicará la cantidad de líquido que puede ingerir cada día. Escriba la cantidad de líquido que ingiere cada día. Mida la cantidad de orina que usted elimina cada vez que va al baño. El médico podría pedirle que se pese cada día. Muéstrele la información al médico cuando tenga sus citas de seguimiento. Él le indicará si usted tiene demasiado o muy poco líquido en el cuerpo y lo que necesita hacer para corregirlo.</li>
                      </ul>
                      <div id="display-ad-injection-2" class="display-ad display-ad-injection display-ad-lazy display-ad-prebid display-ad-728 display-ad-728x90"></div><h2>¿Cuándo debo comunicarme con mi médico?</h2>
                      <ul>
                      <li>Esta saliendo pus o líquido del área de salida.</li>
                      <li>El dializador saliendo del abdomen se ve turbio.</li>
                      <li>El área de salida está mas grande de lo que estaba.</li>
                      <li>El dializador no está saliendo del abdomen durante el intercambio, incluso después de cambiar la posición y de usar una jeringa.</li>
                      <li>Usted tiene fiebre o escalofríos.</li>
                      <li>Tiene dolor sordo en el abdomen mientras hace un intercambio de diálisis.</li>
                      <li>Una nueva protuberancia creció en el abdomen desde que comenzó a hacer los intercambios para DPCA.</li>
                      <li>El área de salida del catéter esta enrojecida, sensible o dolorosa.</li>
                      <li>Usted tiene preguntas o inquietudes acerca de su condición o cuidado.</li>
                      </ul>
                      <h2>¿Cuándo debo buscar atención inmediata o llamar al 911?</h2>
                      <ul>
                      <li>Usted está estreñido.</li>
                      <li>Usted tiene dolor de estómago y está vomitando.</li>
                      <li>Usted tiene dificultad para respirar mientras realiza los intercambios.</li>
                      <li>El catéter tiene una grieta o agujero o se salió parte o completamente del abdomen.</li>
                      </ul>
                      <div class="text-right">
                        <b><a href="https://www.drugs.com/cg_esp/di%C3%A1lisis-peritoneal-continua-ambulatoria.html" target="_blank">Consultar fuente</a></b>
                      </div>
                    </div>

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