<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Reportes extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		//Comprobamos usuario logueado
        if (!$this->ion_auth->logged_in()){
			header('Location: '.base_url('auth/login'), true, 302);
			exit;
        }
        
        //Para evitar el acceso directo que no sea via ajax 
		if (!$this->input->is_ajax_request()) {
            header('Location: '.base_url(), true, 302);
            exit;
        }

        // Obtenemos la Configuración del Sitio
		$data['conf'] 		=	$this->ajustes_model->m_app(); //Configuración del Sitio
		
		// Cargamos la vista para deplegar el Inicio de la Aplicación
		$data['opc']	=	0;
		$this->load->view('reportes/reportes_inicio_view',$data);

	}// End index



	public function fixture(){
		// Función del Controlador para generar Cotización de Insumos en PDF

		//Comprobamos usuario logueado
        if (!$this->ion_auth->logged_in()){
			header('Location: '.base_url('auth/login'), true, 302);
			exit;
        }
        
        //Para evitar el acceso directo que no sea via ajax 
		if (!$this->input->is_ajax_request()) {
            header('Location: '.base_url(), true, 302);
            exit;
        }

        // Cargamos el Modelo de datos necesario
        $this->load->model('torneos_model');

        // Obtenemos los ajustes del Usuario
        $conf 			=	$this->ajustes_model->m_app();
        $datos['conf'] 	=	$conf;

        // Capturamos ID del Usuario logueado
        $userid 		=	$this->session->userdata('user_id');

        // Obtenemos los datos del Torneo actual activo
        $c1['userid']	=	$userid;
        $torneo		    =	$this->torneos_model->m_actual(0,$c1);

       	// Si hay datos del Torneo, podemos continuar
       	if( $torneo ){
       		
       		// Pasamos ID del Torneo al Modelo
       		$c1['torid']		=	$torneo->torid;

       		// Pasamos los datos a la vista del Reporte
       		$datos['torneo']	=	$torneo;

       		// Si el Torneo está abierto y está en Etapa de Encuentros
       		if($torneo->tor_status == 2 && $torneo->tor_etapa == 2 ){
				// Obtenemos la lista de los Partidos
				$c1['ban']		   	=	5;
                $c1['etapa']       	=    $torneo->tor_etapa_actual - 1;
				$partidos  			=	$this->torneos_model->m_actual(1,$c1);

				// Pasamos los datos de los Partidos a la vista del Reporte
				$datos['partidos']	=	$partidos;

				/*
				* Parámetros que recibe la función a través de $p1 desde donde sea llamada:
				* 	-	pdf_path_a 		=>  ( FCPATH ) Ruta absolucta donde se ubicará el archivo en el servidor (para referencia interna)
				* 	-	pdf_path_r 		=>	( base_url() ) Rula relativa donde se ubicará el archivo en el servidor (para acceso públlico)
				*	-	pdf_filename	=>	Nombre completo del archivo
				*	-	pdf_folio 		=>	Folio del PDF
				*	-	pdf_template 	=>	Vista que contiene la plantilla del Reporte
				* 	- 	pdf_depto 		=>	Nombre del Área o Departamento que realiza el Reporte
				*	- 	pdf_process 	=>	Nombre del Proceso al que hace referencia el Reporte
				*	- 	pdf_title 		=>	Título del PDF (para usarse como metadato del archivo)
				*	- 	pdf_tags 		=>	Lista de tags para los metadatos del archivo
				* 	- 	pdf_accion 		=>	La acción a realizar con el PDF generado.
				*							D => Descargar, F => Guardar en el directorio
				*   -  	datos 			=>	Datos a procesar en la vista
				* 	-	pdf_delete 		=>	1 -> Se elimina y se vuelve a crear, 0 -> No se Elimina
				*/

		        // Ajustes 
		        $p1 	=	array(
		        	'pdf_path_a'		=>	 FCPATH . 'assets/uploads/files/fixture/',
		        	'pdf_path_r'		=>	 base_url() . 'assets/uploads/files/fixture/',
		        	'pdf_filename'		=>	'fixture_t'.$torneo->tor_folio,
		        	'pdf_template'		=>	"reportes/reportes_fixture_view",
		        	'pdf_depto'			=>	$conf->company,
		        	'pdf_process'		=>	$torneo->tor_nombre,
		        	'pdf_title'			=>	"LISTA DE COTEJOS",
		        	'pdf_tags'			=>	"reporte, fixture, cotejos",
		        	'pdf_accion'		=>	"F",
		        	'datos'				=>	$datos,
		        	'pdf_delete'		=>	1
		        );

		        // Llamamos la función que genera el PDF con la libreía mPDF v8.x
		        $this->_pdf($p1);

       		}else{
	       		echo 0; // Response error
	       	}
	    }else{
       		echo 0; // Response error
       	}

	}// End test



	public function _pdf($p1=""){
		// Función del Controlador para generar PDF con mPDF v8.x

		/*
		* Parámetros que recibe la función a través de $p1 desde donde sea llamada:
		* 	-	pdf_path_a 		=>  ( FCPATH ) Ruta absolucta donde se ubicará el archivo en el servidor (para referencia interna)
		* 	-	pdf_path_r 		=>	( base_url() ) Rula relativa donde se ubicará el archivo en el servidor (para acceso públlico)
		*	-	pdf_filename	=>	Nombre completo del archivo
		*	-	pdf_folio 		=>	Folio del PDF
		*	-	pdf_template 	=>	Vista que contiene la plantilla del Reporte
		* 	- 	pdf_depto 		=>	Nombre del Área o Departamento que realiza el Reporte
		*	- 	pdf_process 	=>	Nombre del Proceso al que hace referencia el Reporte
		*	- 	pdf_title 		=>	Título del PDF (para usarse como metadato del archivo)
		*	- 	pdf_tags 		=>	Lista de tags para los metadatos del archivo
		* 	- 	pdf_accion 		=>	La acción a realizar con el PDF generado.
		*							D => Descargar, F => Guardar en el directorio
		*   -  	datos 			=>	Datos a procesar en la vista
		* 	-	pdf_delete 		=>	1 -> Se elimina y se vuelve a crear, 0 -> No se Elimina
		*/

		// Obtenemos el array con los Ajustes de la Configuración de la Aplicación
		$conf			=	$this->ajustes_model->m_app();

		// Verificamos si existe, si es así, eliminamos archivo PDF antes de generar el actual
	    $pdfFilePath = $p1['pdf_path_a'].$p1['pdf_filename'].'.pdf';
	    if( read_file($pdfFilePath) == TRUE && $p1['pdf_delete'] ){ //Si existe el archivo, y se indicó que se debe volver a crear...
			chmod($pdfFilePath, 0777);
			unlink($pdfFilePath);
		}

		// Cargamos la Vista que contiene el HTML para renderizar el PDF, mandándole los datos (array $data() )
		$html = $this->load->view($p1['pdf_template'],$p1,true);
		
		//Verificamos si el archivo existe, para evitar volver a crearlo y gastar recursos 
		if (file_exists($pdfFilePath) == FALSE){	
			//Datos a mostrar en el Header del documento
			$header = array (
			  'odd' => array (
				    'L' => array (
				      'content' 	=> 	mb_strtoupper( $p1['pdf_depto'] ),
				      'font-size' 	=> 	8,
				      'font-style' 	=> 	'B',
				      'color'		=>	'#1c5d79'
				    ),
				    'C' => array (
				      'content' 	=> 	mb_strtoupper( $p1['pdf_process'] ),
				      'font-size' 	=> 	8,
				      'font-style' 	=> 	'B',
				      'color'		=>	'#1c5d79'
				    ),
				    'R' => array (
				      'content' 	=> 	mb_strtoupper( $p1['pdf_title'] ),
				      'font-size' 	=> 	8,
				      'font-style' 	=> 	'B',
				      'color'		=>	'#1c5d79'
				    ),
				    'line' => 1,
			  ),
			  'even' => array ()
			);

			//Datos a mostrar en el Footer del documento
			$footer = array (
			  'odd' => array (
				    'L' => array (
				      'content' 	=> 	'<font color="green">FECHA Y HORA</font>: {DATE Y-m-d H:i:s }',
				      'font-size' 	=> 	8,
				      'font-style' 	=> 	'B',
				      'color'		=>	'#1c5d79'
				    ),
				    'C' => array (
				      'content' 	=> 	'PÁGINA {PAGENO}/{nbpg}',
				      'font-size' 	=> 	8,
				      'font-style' 	=> 	'B',
				      'color'		=>	'#1c5d79'
				    ),
				    'R' => array (
				      'content' 	=> 	'<font color="red">https://bleutecmedia.com</font>',
				      'font-size' 	=> 	8,
				      'font-style' 	=> 	'B',
				      'color'		=>	'#1c5d79'
				    ),
				    'line' => 1,
			  ),
			  'even'  => array ()
			);

			// Aumentamos la memoria necesaria, si esta es baja
		    ini_set('memory_limit','64M');

		    // Cargamos la librería mPDF ubicada en '/application/libreries/Pdf.php'
		    $this->load->library('pdf');

		    // Renderizamos el PDF con la función LOAD de la librería
		    // Lo que obtiene los ajustes iniciales del documento (margen, orientación, tamaño, etc)
		    $pdf = $this->pdf->load();

		    // Especificamos la Fuente del PDF
		    $pdf->SetFont( 'Arial', 'B', 18 );

		    // Especificamos el color RGB de la Fuente del PDF 
		    $pdf->SetTextColor(100,149,237);

		    // Escribimos el ENCABEZADO y el PIE de páginas
		    $pdf->SetHeader($header);
		    $pdf->SetFooter($footer);

		    // Especificamos qué podemos permitir en el PDF creado.
		    // En este caso sólo permitir la Impresión del PDF
			$pdf->SetProtection( array('print') );

			// Cuando el archivo se abre en Adobe Reader, especificamos que se muestre en modo Página completa. 
			$pdf->SetDisplayMode('fullpage');

			// Se define que el archivo PDF creado resulte ya comprimido. 
			$pdf->SetCompression(true);

	     	// Para colocar Marca de agua de Texto
		    //$pdf->SetWatermarkText('https://bleutecmedia.com');
			//$pdf->showWatermarkText = true;
			//$pdf->watermark_font = 'DejaVuSansCondensed';
			//$pdf->watermarkTextAlpha = 0.1;
			
		    //Habilita debug de la generación del PDF		    
		    //$pdf->StartProgressBarOutput(2);

		    // Poner protección al PDF (no sirve para un carajo)
		    //$pdf->SetProtection(array('copy'), 'UserPassword', $p1['pdf_folio']);

		    // Generamos los Metadatos del PDF 
		    $pdf->SetTitle( mb_strtoupper( $p1['pdf_title'] ) );
		    $pdf->SetAuthor('DiáliApp');
		    $pdf->SetCreator('DiáliApp');
		    $pdf->SetSubject( mb_strtoupper( $p1['pdf_title'] ) );
		    $pdf->SetKeywords($p1['pdf_tags']);

		    // Cargamos los CSS necesarios en el Reporte. En este caso el estilo personalizado 
		    // que tendrá el reporte. Declaramos el estilo
		    $stylesheet = file_get_contents(FCPATH.'assets/css/reports.css'); // external css
			$pdf->WriteHTML($stylesheet,1);

		    // Escribimos los datos de la Vista en el archivo PDF
		    $pdf->WriteHTML($html,2); 
		    $pdf->allow_charset_conversion = true; 

		    // Guardamos el PDF (F) o lo descargamos (D), según necesitemos
		    $pdf->Output($pdfFilePath, $p1['pdf_accion']);
			
		}/* End if(pdfFilePath) */
		
		// Preferenteente se recoienda almacenar el archvi en el directorio 
		// y cargar una vista para visualizar el archivo con la ayuda de alguna
		// librería como jquery.media o algún otro
		$data['file']	= 	$p1['pdf_filename'];
		$data['path_a']	=	$p1['pdf_path_a'].$p1['pdf_filename'].'.pdf';
		$data['path_r']	=	$p1['pdf_path_r'].$p1['pdf_filename'].'.pdf';
		$data['datos']	=	$p1['datos'];
		$this->load->view('reportes/reportes_display_view',$data);

	}//End _pdf


}// End class