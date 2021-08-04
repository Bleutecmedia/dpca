<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Reportes extends CI_Controller {

	public function __construct(){
		parent::__construct();

		// Cargamos el Modelo
		$this->load->model('data_model');
		$this->load->model('dpca_model');
		$this->load->model('reportes_model');
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


	/**
	*	Función para mostrar la tabla
	*/
	public function intercambios(){
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

        // Recibimos los datos desde $_GET
		$search 	=	$this->input->post('search');
		$order 		=	$this->input->post('order');

		// Capturamos ID del Usuario
		$userid 	=	$this->session->userdata('user_id');

		//Procesamos el intervalo de fechas del tipo '2017-11-14 - 2017-11-14' a '2017-11-14' y '2017-11-14'
		//Lo anterior, con la ayuda de la función substr — Devuelve parte de una cadena
    	$fechas 		=	$this->input->post('fechas');//'2017-11-14 - 2017-11-14'
    	$fecha_desde 	=	human_to_unix(trim(substr($fechas,0,11)) . ' 00:00:00');// Retorna: '2017-04-24'
    	$fecha_hasta	=	human_to_unix(trim(substr($fechas,-11)) . ' 23:59:59');//Retorna: '2017-09-28'

    	$sql_user 		=	"users.id = ".$userid." AND intercambios.in_status = 2 ";

		$sql_fecha =	"";// Fecha de Salida del Producto
		if(isset($fechas) && $fechas != ""){
			$sql_fecha = " AND intercambios.in_fecha BETWEEN '" . $fecha_desde ."' AND '" . $fecha_hasta ."'";
		}

		// Definimos las variables para constgruir las consultas
		$termino 	=	trim($search['value']);		// Término de búsqueda
		$columna 	=	$order['0']['column']; 	// 0,1,2 según la columna
		$desc_asc 	=	$order['0']['dir'];		// ASC o DESC

		//Hacemos Switch con $columna para convertir los numeros de columna, por el nombre
		// de la columna en la tabal de la base de datos para realizar la consulta de Ordenado
		switch ($columna) {

			case 1:
				$campo 	=	"intercambios.in_fecha";
				break;

			case 2:
				$campo 	=	"intercambios.in_hora_sale_inicio";
				break;

			case 3:
				$campo 	=	"intercambios.in_hora_sale_termina";
				break;

			case 4:
				$campo 	=	"intercambios.in_hora_entra_inicio";
				break;

			case 5:
				$campo 	=	"intercambios.in_hora_entra_termina";
				break;

			case 6:
				$campo 	=	"intercambios.in_peso_inicial";
				break;

			case 7:
				$campo 	=	"intercambios.in_peso_final";
				break;

			default:
				$campo 	=	"";
				break;
		}

		// Creamos la cadena de la consulta
		$sql 	= 	$sql_user.$sql_fecha;
		if(isset($termino) && $termino){
			$sql 	= 	$sql.' AND ( intercambios.in_fecha LIKE "%'.$termino.'%")';
		}

		// Creamos el array para ejecutar la consulta:
		$c1 	=	array(
			'start'		=>	$this->input->post('start'),
			'length'	=>	$this->input->post('length'),
			'search'	=>	$search,
			'sql'		=>	$sql,
			'orderby' 	=>	$campo,
			'ordertype' =>	$desc_asc
		);

		// Lamamos la función del modelo para obtener los datos con el Limit
		$c1['ban']			=	1;
		$result  			=	$this->reportes_model->m_intercambios(1,$c1);

		// Lamamos la función para Obtener el TOTAL de registros de la BD
		$c1['ban']			=	2;
		$result_total  		=	$this->reportes_model->m_intercambios(1,$c1);

		// Lamamos la función para Obtener el TOTAL DE DATOS FILTRADOS SIN EL LIMIT
		$c1['ban']			=	3;
		$result_filtered  	=	$this->reportes_model->m_intercambios(1,$c1);

		$res['recordsFiltered']	= 	$result_filtered;
		$res['recordsTotal']	= 	$result_total;
		
		//Acondionamos los datos que se deben mostrar en las Columnas de la Tabla con 'datatables'
		$res1 =	array();
		if($result){
			foreach ($result as $k => $row){

				// Generamos las opciones generales para cara registro de la tabla
				$opcs 	=	'';
				$opcs 	=	$opcs.'&nbsp;<a href="javascript: void(0);" title="Eliminar" class="deletele btn btn-sm bg-maroon"><i class="fas fa-trash-alt"></i></a>';
				$opcs 	=	$opcs.'&nbsp;<a href="javascript: void(0);" title="Editar" class="editable btn btn-sm bg-olive"><i class="fas fa-edit"></i></a>';
				$opcs 	=	$opcs.'&nbsp;<a href="javascript: void(0);" title="Detalles" class="detaile btn btn-sm bg-navy"><i class="fas fa-bars"></i></a>';

				// Generamos el arreglo que pasaremos a la vista para generar la tabla
				$res1[$k]['interid'] 		=	$row->interid;
				$res1[$k]['userid'] 		=	$row->userid;
				$res1[$k]['num'] 			=	$k + 1;
				$res1[$k]['dia'] 			=	date('Y-m-d',$row->in_fecha);
				$res1[$k]['sinicio'] 		=	date('H:i:s',$row->in_hora_sale_inicio);
				$res1[$k]['sfin'] 			=	date('H:i:s',$row->in_hora_sale_termina);
				$res1[$k]['einicio'] 		=	date('H:i:s',$row->in_hora_entra_inicio);
				$res1[$k]['efin'] 			=	date('H:i:s',$row->in_hora_entra_termina);
				$res1[$k]['pesoinicio'] 	= 	number_nice($row->in_peso_inicial); // Nombre del Proveedor
				$res1[$k]['pesofin'] 		= 	number_nice($row->in_peso_final); // Costo total del Embarque
				$res1[$k]['opcs'] 			=	$opcs;
			}//End foreach
		}//End if($result)
		
		$res['data']	=	$res1;

		echo json_encode($res);

	}// End intercambios()

	/**
	 * Función del controlador para adecuar o editar intercambios con errores
	 */
	public function fix(){
		// Comprobamos usuario logueado o no es el Administrador
        if (!$this->ion_auth->logged_in()){
            header('Location: '.base_url('auth/login'), true, 302);
            exit;
        }
        
        // Para evitar el acceso directo que no sea via ajax 
        if ( !$this->input->is_ajax_request() ) {
            header('Location: '.base_url(), true, 302);
            exit;
        }

        // Recibimos bandera
        $ban    =   $this->input->get_post('id');

		// Decidimsoa que hacer
		switch ($ban) {
			case 1: // MUESTRA MODAL PARA EDITAR UN INTERCAMBIO
				// Capturamos ID de intercambio
				$c1['interid']	=	$this->input->get('item1');

				// Obtenemos datos del intercambio
				$c1['ban']		=	6;
				$data['inter']	=	$this->reportes_model->m_intercambios(1,$c1);

				// Cargamos la vista
				$data['opc']	=	1;
				$this->load->view('reportes/reportes_inicio_view',$data);

				break;

			case 2: // GUARDAR CAMBIOS EN INTERCAMBIO

				// Saneamos los envíos por $_POST
				$this->input->post(NULL, TRUE);  // returns all POST items with XSS filter  

				// Procedemos a validar los campos desde el lado del servidor, enviados por el formulario desde $_POST
				$this->load->library('form_validation');// Cargamos la librería para Validaciones de CodeIgnite

				// Cargamos el modelo
				$this->load->model('data_model');

				// Creamos las reglas de validación comunes para las 2 acciones (guardar nuevo ó editar existente)
				$this->form_validation->set_rules('interid','Intercambio', 'trim|required|numeric|is_natural_no_zero');
				$this->form_validation->set_rules('peso_inicial','Incial', 'trim|required|numeric');
				$this->form_validation->set_rules('peso_final','Final', 'trim|required|numeric');

				// Corremos la validación y comprobamos si pasa o no
				if ($this->form_validation->run() == FALSE){// No pasa la validación, manda error
					echo "<div class='alert alert-error'>".validation_errors()."</div>";
				}else{

					// Creamos el array
					$datos 		=	array(
						'ban'				=>	1, 
						'interid'			=>	$this->input->post('interid'),
						'in_peso_inicial'	=>	$this->input->post('peso_inicial'),
						'in_peso_final'		=>	$this->input->post('peso_final')
					);
					
					// Llamamos la función del Modelo que guarda los datos de un nievo registro o cambia los datos de uno existente:
					$res 	=	$this->reportes_model->m_intercambios(2,$datos);
					
					// Procesamos la respuesta de la consulta
					echo $res ? 1 : 0;
					
				}//End validate ok";
				break;

			case 3: // MODAL PARA AGREGAR DIA
				//Procesamos el intervalo de fechas del tipo '2017-11-14 - 2017-11-14' a '2017-11-14' y '2017-11-14'
				//Lo anterior, con la ayuda de la función substr — Devuelve parte de una cadena
				$fechas 		=	$this->input->get('item1');//'2017-11-14 - 2017-11-14'
				//$fecha_desde 	=	human_to_unix(trim(substr($fechas,0,11)) . ' 00:00:00');
				//$fecha_hasta	=	human_to_unix(trim(substr($fechas,-11)) . ' 23:59:59');

				$desde 	=	trim(substr($fechas,0,11));
				$hasta	=	trim(substr($fechas,-11));

				// Obtenemos los intercambios de esos dias
				$c1['sql']		=	"in_dia BETWEEN '" . $desde . "' AND '".$hasta."'";

				$c1['ban']		=	7;
				$data['inters']	=	$this->reportes_model->m_intercambios(1,$c1);

				// Pasamos a la vista
				$data['fechas']	=	$fechas;
				$data['desde']	=	$desde;
				$data['hasta']	=	$hasta;

				// Cargamos la vista
				$data['opc']	=	2;
				$this->load->view('reportes/reportes_inicio_view',$data);

				break;

			case 4: // AGREGAR INTERCAMBIO FALTANTE
				// Recibimos
				$total 		=	$this->input->post('item1');
				$dia 		= 	$this->input->post('item2');

				// Si todavía se puede abrir intercambio
				// Obtenemos el Siguiente ID 
				$c1['campo']	=	"interid";
				$c1['tabla']	=	"intercambios";

				$interid 		=	$this->data_model->m_get_last_id($c1) + 1;// ID del próximo Carnicero

				// Generamos los pesos de las soluciones
				$pesos_i 			=	[2205,2210,2210,2215,2215,2215,2220,2225];
				$pesos_f 			=	[2260,2310,2320,2360,2400,2420,2430,2440];

				// Generamos las horas
				$horas 			=	array(
					'0'		=> 	'09',
					'1'		=>	'13',
					'2'		=>	'17',
					'3'		=>	'21'
				);

				// Generamos hora inicial
				$inicio 	=	$dia . ' '.$horas[$total - 1] . ':' . str_pad(mt_rand(0,10), 2, "0", STR_PAD_LEFT) . ':' . str_pad(mt_rand(0,59), 2, "0", STR_PAD_LEFT);
				
				// Pasamos a unix
				$sale_inicio 	=	human_to_unix($inicio); // de 0 a 10 minutos desde la hora
				$sale_termina 	=	$sale_inicio + ( mt_rand(28,39) * 60 ); // de 28 a 39 minutos
				$entra_inicio 	=	$sale_termina + mt_rand(20,60); // de 20 a 60 segundos despues
				$entra_termina 	=	$entra_inicio + + ( mt_rand(10,16) * 60 ); // de 10 a 16 minutos 

				// Creamos array para abrir nuevo Intercambio
				$intercambio 	=	array(
					'ban'					=>	1,
					'interid'				=>	$interid,
					'in_solid'				=>	2, // 1.5%
					'in_fecha'				=>	$sale_inicio,
					'in_dia'				=>	$dia,
					'in_userid'				=>	$this->session->userdata('user_id'),
					'in_peso_inicial'		=> 	$pesos_i[array_rand($pesos_i)],
					'in_peso_final'			=> 	$pesos_f[array_rand($pesos_f)],
					'in_hora_sale_inicio'	=>  $sale_inicio,
					'in_hora_sale_termina'	=>  $sale_termina,
					'in_hora_entra_inicio'	=>  $entra_inicio,
					'in_hora_entra_termina'	=> 	$entra_termina,
					'in_status'				=>	2
				);
				
				// Llamamos la función del Modelo que abre el intercambio
				$res 	=	$this->dpca_model->m_intercambios(2,$intercambio);

				// Procesamos la respuesta de la consulta
				echo $res ? 1 : 0;

				break;
			
			default:
				# code...
				break;
		}
	}// End fix

    /**
     * Función del Controlador para generar el Reporte en PDF
     */
    public function pdf(){
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
        $conf 		    =	$this->ajustes_model->m_app(); //Configuración del Sitio

        // Capturamos ID del Usuario
        $userid 	    =	$this->session->userdata('user_id');

        //Procesamos el intervalo de fechas del tipo '2017-11-14 - 2017-11-14' a '2017-11-14' y '2017-11-14'
        //Lo anterior, con la ayuda de la función substr — Devuelve parte de una cadena
        $fechas 		=	$this->input->get('item1');//'2017-11-14 - 2017-11-14'
        $fecha_desde 	=	human_to_unix(trim(substr($fechas,0,11)) . ' 00:00:00');// Retorna: '2017-04-24'
        $fecha_hasta	=	human_to_unix(trim(substr($fechas,-11)) . ' 23:59:59');//Retorna: '2017-09-28'

        $sql_user 		=	"users.id = ".$userid." AND intercambios.in_status = 2 ";

        $sql_fecha =	"";// Fecha de Salida del Producto
        if(isset($fechas) && $fechas != ""){
            $sql_fecha = " AND intercambios.in_fecha BETWEEN '" . $fecha_desde ."' AND '" . $fecha_hasta ."'";
        }

        // Creamos la cadena de consulta
        $c1['sql']      =   $sql_user.$sql_fecha;

        // Obtenemos todos los registros disponibles
        $c1['ban']      =   4;
        $intercambios   =   $this->reportes_model->m_intercambios(1,$c1);

        // OBTENEMOS EL ULTIMO REGISTRO DEL DIA ANTERIOR PARA EL CALCULO DE LAS DIFERENCIAS DE PESOS
        $f_desde =  $fecha_desde - 86400;
        $f_hasta =  $fecha_hasta - 86400;

        // Modificamos la consulta de fechas
        $sql_fecha = " AND intercambios.in_fecha BETWEEN '" . $f_desde ."' AND '" . $f_hasta ."'";

        // Creamos la cadena de consulta
        $c1['sql']      =   $sql_user.$sql_fecha;

        // Obtenemos el ultimo registro
        $c1['ban']      =   5;
        $data['ultimo'] =   $this->reportes_model->m_intercambios(1,$c1);

        // Pasamos a la vista
        $data['intercambios']   =   $intercambios;
        $data['fechas']         =   $fechas;
        $data['conf']           =   $conf;

        // Path del reporte PDF
        $relative  =    FCPATH."assets/uploads/reportes/";
        $absolute  =    base_url('assets/uploads/reportes/');

        // Si no existe el directorio, lo creamos
        // Verificaos existencia del directorio, si no existe lo creamos
        if ( file_exists($relative) == FALSE ){
            // Si no existe la carpeta, la creamos
            if(!mkdir($relative, 0777, true)) {
                // Si falla al crear la carpeta, mandamos mensaje
                die('Fallo al crear las carpetas...');
            }
        }

        // Creamos el array para llamar la función que crea el PDF
        $data_pdf 	=	array(
            'pdf_filename'	=> 	$fechas,
            'pdf_folio'		=>	str_gen(10),
            'pdf_title'		=>  "",
            'pdf_depto'		=> 	"",
            'pdf_process'	=> "",
            'pdf_path_r'	=> 	$absolute,
            'pdf_path_a'	=> 	$relative,
            'pdf_template'	=>	"reportes/reportes_templates_view",
            'pdf_data'		=>	$data,
            'pdf_tags'		=>	'dpca',
            'accion'		=>	'F' ///Guardamos el PDF (F) o lo descargamos (D)
        );

        //Llamamos la funcion que genera los PDF
        $this->_pdf($data_pdf);

    }


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
	    if( read_file($pdfFilePath) == TRUE ){ //Si existe el archivo, y se indicó que se debe volver a crear...
			chmod($pdfFilePath, 0777);
			unlink($pdfFilePath);
		}

		// Cargamos la Vista que contiene el HTML para renderizar el PDF, mandándole los datos (array $data() )
		$html = $this->load->view($p1['pdf_template'],$p1,true);
		
		//Verificamos si el archivo existe, para evitar volver a crearlo y gastar recursos 
		if (file_exists($pdfFilePath) == FALSE){

			//Datos a mostrar en el Header del documento
			/*
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
				      'content' 	=> 	'',
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
				      'content' 	=> 	'',
				      'font-size' 	=> 	8,
				      'font-style' 	=> 	'B',
				      'color'		=>	'#1c5d79'
				    ),
				    'line' => 1,
			  ),
			  'even'  => array ()
			);
			*/

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
		    // $pdf->SetHeader($header);
		    //  $pdf->SetFooter($footer);

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
		    $pdf->Output($pdfFilePath, $p1['accion']);
			
		}/* End if(pdfFilePath) */
		
		// Preferenteente se recoienda almacenar el archvi en el directorio 
		// y cargar una vista para visualizar el archivo con la ayuda de alguna
		// librería como jquery.media o algún otro
		$data['file']	= 	$p1['pdf_filename'];
		$data['path_a']	=	$p1['pdf_path_a'].$p1['pdf_filename'].'.pdf';
		$data['path_r']	=	$p1['pdf_path_r'].$p1['pdf_filename'].'.pdf';
		$data['datos']	=	$p1['pdf_data'];
		$this->load->view('reportes/reportes_display_view',$data);

	}//End _pdf


}// End class