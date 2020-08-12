<?php defined('BASEPATH') OR exit('No direct script access allowed');

switch ($opc) {
  case 1:
    # code...
    break;
  
  default:// Vista incial
  	//Fechas
	$fechas = array(
		'name'			=> 	'reportrangee',
		'id'          	=> 	'reportrangee',
		'autofocus'   	=> 	'reportrangee',
		'placeholder' 	=> 	'Intervalo de fechas',
		'tabindex'		=>	'1',
		'class'         => 	'form-control'
	);

    ?>
    <h4><i class="fas fa-file-pdf"></i>&nbsp;Reportes de la DPCA</h4>
    <div class="row">
    	<div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">

    	</div><!-- ./col-sm-12 col-md-12 col-lg-6 col-xl-6 -->
    	<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
    		<div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
            </div>
             <?php echo form_input($fechas); ?>
           </div><!-- ./input-group -->
    	</div><!-- ./col-sm-12 col-md-12 col-lg-4 col-xl-4 -->

        <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
            <a href="javascript: void(0);" onclick="fn_reporte()" class="btn btn-block btn-primary"><i class="fas fa-file-pdf"></i>&nbsp;Reporte</a>
        </div><!-- ./col-sm-12 col-md-12 col-lg-2 col-xl-2 -->
    </div><!-- ./row -->

    <div id="get_report"></div>
    <div class="table-responsive">
    	<table class="table" id="intercambios" data-page-length='25' class="display table table-striped table-hover table-border table-condensed" cellspacing="0" width="100%">
	    	<thead>
	    		<tr>
	    			<th>#</th>
	    			<th>DIA</th>
	    			<th>SALE INICIO</th>
	    			<th>SALE FIN</th>
	    			<th>ENTRA INICIO</th>
	    			<th>ENTRA FIN</th>
	    			<th>PESO INICIO</th>
	    			<th>PESO FIN</th>
	    			<th>OPC</th>
	    		</tr>
	    	</thead>
	    </table>
    </div><!-- ./table-responsive -->
    
    <script type="text/javascript">
    	$(function(){
    		var start 	= moment().subtract(29, 'days');
			var end 	= moment();

			function cb(start, end) {
				$('#reportrangee span').html( start + ' - ' + end );
			}

			$('#reportrangee').daterangepicker({
				"startDate": start,
				"endDate": end,
				"timePicker": false,
				"timePickerSeconds": false,
				"timePickerIncrement": 1,
				"alwaysShowCalendars": true,
				"opens": "left",
					locale: {
						"format": 'YYYY-MM-DD',
						"applyLabel": "<?php echo lang("label_aplicar"); ?>",
						"cancelLabel": "<?php echo lang("label_cancelar"); ?>",
						"fromLabel": "<?php echo lang("label_desde"); ?>",
						"toLabel": "<?php echo lang("label_hasta"); ?>",
						"customRangeLabel": "<?php echo lang("label_personalizado"); ?>",
						"weekLabel": "W",
						"daysOfWeek": [
							"<?php echo lang("label_domingo_s"); ?>",
							"<?php echo lang("label_lunes_s"); ?>",
							"<?php echo lang("label_martes_s"); ?>",
							"<?php echo lang("label_miercoles_s"); ?>",
							"<?php echo lang("label_jueves_s"); ?>",
							"<?php echo lang("label_viernes_s"); ?>",
							"<?php echo lang("label_sabado_s"); ?>"
						],
						"monthNames": [
							"<?php echo lang("label_enero"); ?>",
							"<?php echo lang("label_febrero"); ?>",
							"<?php echo lang("label_marzo"); ?>",
							"<?php echo lang("label_abril"); ?>",
							"<?php echo lang("label_mayo"); ?>",
							"<?php echo lang("label_junio"); ?>",
							"<?php echo lang("label_julio"); ?>",
							"<?php echo lang("label_agosto"); ?>",
							"<?php echo lang("label_septiembre"); ?>",
							"<?php echo lang("label_octubre"); ?>",
							"<?php echo lang("label_noviembre"); ?>",
							"<?php echo lang("label_diciembre"); ?>"
						],
						"firstDay": 1
					},
					ranges: {
						'<?php echo lang("label_fecha_hoy"); ?>': [moment().startOf('day'), moment()],
						'<?php echo lang("label_fecha_ayer"); ?>': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
						'<?php echo lang("label_fecha_7dias"); ?>': [moment().subtract(6, 'days').startOf('day'), moment()],
						'<?php echo lang("label_fecha_30dias"); ?>': [moment().subtract(29, 'days').startOf('day'), moment()],
						'<?php echo lang("label_fecha_mes_actual"); ?>': [moment().startOf('month'), moment().endOf('month')],
						'<?php echo lang("label_fecha_mes_anterior"); ?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
					}
			}, cb);

			cb(start, end);

			$("#reportrangee").val('');

			var tableinter = $('#intercambios').DataTable({
				//"order": [[ 0, "desc" ]],
				responsive: true,
				language: {
						processing:     "&nbsp;<i class='fa fa-refresh fa-spin fa-2x fa-fw'></i><?php echo lang('label_dt_procesando'); ?>",
						search:         "<?php echo lang('label_dt_buscar'); ?>:",
						lengthMenu:     "<?php echo sprintf( lang('label_dt_mostrar_n'),'_MENU_'); ?>",
						info:           "<?php echo sprintf( lang('label_dt_mostrando_abn'),'_START_','_END_','_TOTAL_'); ?>",
						infoEmpty:      "<font color ='red'><?php echo lang('label_dt_no_resultado'); ?></font>",
						infoFiltered:   "<?php echo sprintf( lang('label_dt_filtrado_de'),'_MAX_'); ?>",
						infoPostFix:    "",
						loadingRecords: "<?php echo lang('label_dt_cargando'); ?>",
						zeroRecords:    "<font color ='red'><?php echo mb_strtoupper( lang('label_dt_no_registros') ); ?></font>",
						emptyTable:     "<font color ='red'><?php echo mb_strtoupper( lang('label_dt_no_elementos') ); ?></font>",
						paginate: {
								first:      "<?php echo lang('label_dt_primero'); ?>",
								previous:   "<?php echo lang('label_dt_anterior'); ?>",
								next:       "<?php echo lang('label_dt_siguiente'); ?>",
								last:       "<?php echo lang('label_dt_ultimo'); ?>"
						}
				},
					"processing": true,
					"serverSide": true,
					"scrollX": true,
					"ajax": {
							"url": "<?php echo base_url('reportes/intercambios'); ?>",
							"type": "POST",
							"data": function ( d ) {
								d.fechas 		= 	$('#reportrangee').val();
								d.csrf_token 	=	csrf_token;
							}
					},
					"deferRender": true,
					"columns": [
						{ "data": "num", "className": "text-center","searchable": false,"orderable": false },
						{ "data": "dia", "className": "text-center" },
						{ "data": "sinicio", "searchable": false,"className": "text-center" },
						{ "data": "sfin", "searchable": false,"className": "text-center" },
						{ "data": "einicio", "searchable": false,"className": "text-center" },
						{ "data": "efin", "searchable": false,"className": "text-center" },
						{ "data": "pesoinicio", "searchable": false,"className": "text-center" },
						{ "data": "pesofin", "searchable": false,"className": "text-center" },
						{ "data": "opcs", "searchable": false, "orderable": false, "className": "text-center" }
					]
			});// Datatable

			$('#intercambios tbody').on( 'click', '.detaile', function () {
		        var data 	= 	tableinter.row( $(this).parents('tr') ).data();
		        var interid =	data['interid'];
		        
		        alert('Detalles del Registro ID #' + interid)
		    });

		    $('#intercambios tbody').on( 'click', '.editable', function () {
		        var data 	= 	tableinter.row( $(this).parents('tr') ).data();
		        var interid =	data['interid'];
		        
		        alert('Edita el Registro ID #' + interid)
		    });

		    $('#intercambios tbody').on( 'click', '.deletele', function () {
		        var data 	= 	tableinter.row( $(this).parents('tr') ).data();
		        var interid =	data['interid'];
		        
		        alert('Elimina el Registro ID #' + interid)
		    });

		    $("#reportrangee").change(function(e){
		    	tableinter.draw();
		    });
    	});

    	function fn_reporte(){
    	    let rango  =   $("#reportrangee").val();

    	    if(rango != ""){
                fn_cargar_ajax_g('reportes/pdf','get_report',0,rango);
            }
        }
    </script>
    <?php
    break;
}