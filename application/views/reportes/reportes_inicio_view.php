<?php defined('BASEPATH') OR exit('No direct script access allowed');

switch ($opc) {
  case 1: // MODAL PARA EDITAR UN INTERCAMBIO
    ?>
	<div class="modal-header">
		<h4 class="modal-title"><i class="fas fa-edit"></i>&nbsp;EDITAR INTERCAMBIO</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col">
					<?php 
					if(isset($inter) && $inter){

						// Select peso
						$peso_inicial[''] = 'Seleccione Peso Inicial';
						$peso_inicial[200]     =  200;
						$peso_inicial[500]     =  500;
						for ($i = 2205; $i <= 2225; $i+=5){
							$peso_inicial[$i]     =   $i;
						}

						// Peso final
						$peso_final = array(
							'name'          => 	'peso_final',
							'id'            => 	'peso_final',
							'type'        	=>	'number',
							'tabindex'      =>  '1',
							'class'         =>  'form-control validate[required]',
							'data-inputmask'=>  "'alias': 'integer'",
							'placeholder'   =>  'Peso Final',
							'value'         => 	$inter->in_peso_final,
							'onclick'      	=> 	'this.select();'
						);
						
						echo form_open('reportes/fix','name="edit_inter" id="edit_inter" class="form-horizontal"');
						echo form_hidden('id',2);
						echo form_hidden('interid',$inter->interid);
						?>
						<p><i class="far fa-calendar-alt"></i>&nbsp;<b>FECHA</b>: <?= $inter-> 	in_dia  ?>,&nbsp;<?= $inter->sol_color . ' '. $inter->sol_concentra?></p>
						<ul>
							<li><b>Sale Inicio</b>:&nbsp;<?= date('H:i:s',$inter->in_hora_sale_inicio) ?></li>
							<li><b>Sale Fin</b>:&nbsp;<?= date('H:i:s',$inter->in_hora_sale_termina) ?></li>
							<li><b>Entra Inicio</b>:&nbsp;<?= date('H:i:s',$inter->in_hora_entra_inicio) ?></li>
							<li><b>Entra Fin</b>:&nbsp;<?= date('H:i:s',$inter->in_hora_entra_termina) ?></li>
						</ul>
						
						<div class="row">
							<div class="col-md-6">
								<label for="peso_inicial">&nbsp;Peso Inicial:</label><br>
								<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-weight"></i></span>
								</div>
									<?php echo form_dropdown('peso_inicial',$peso_inicial,$inter->in_peso_inicial,'id="peso_inicial" tabindex=1 class="form-control validate[required]"'); ?>
								</div><!-- ./input-group -->
							</div><!-- ./col-md-6 -->
							<div class="col-md-6">
								<label for="peso_final">&nbsp;Peso Final:</label><br>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-weight"></i></span>
									</div>
									<?php echo form_input($peso_final); ?>
								</div><!-- ./input-group -->
							</div><!-- ./col-md-6 -->
						</div><!-- ./row -->

						<?php echo form_close() ?>
						<script type="text/javascript">
							$(function(){
								// $(":input").inputmask();
								$("#edit_inter").validationEngine('attach',{promptPosition : "bottomLeft", scroll: true }, {focusFirstField : true });

								// fix double submit
								$("#savedata").on('click', function (event) {  
										event.preventDefault();
										var el = $(this);
										el.prop('disabled', true);
										setTimeout(function() {
											$('#edit_inter').submit();
										}, 200);

									setTimeout(function(){el.prop('disabled', false); }, 2000);
								});

								var options = { 
									target:         '#div_oculto',   
									beforeSubmit:   showRequest, 
									success:        showResponse,
									dataType:       'html',
									timeout:        3000 
								};

								$('#edit_inter').ajaxForm(options); 
							}); // function

							function showRequest(formData, jqForm, options) { 
								var queryString = $.param(formData); 
								$('#modal-lg').modal('hide');
								// deshabilitammos submit
								$("#savedata").prop('disabled', true);
							} 

							function showResponse(responseText, statusText, xhr, $form){ 
								$('#modal-lg').modal('hide');
								var tableinter = $('#intercambios').DataTable();

								if(responseText == 1){
									fn_success();
									tableinter.draw();
								}else{
									fn_error();
								}//enf if(responseText)
								$("#savedata").prop('disabled', false);
							}

						</script>
						<?php
					}else{
						?><p class="text-danger"><i class="fas fa-exclamation-circle"></i>&nbsp;No hay datos del Intercambio.</p><?php
					}
					?>
			
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<?php 
		if(isset($inter) && $inter){
			?><button type="button" id="savedata" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;Guardar</button><?php
		}
		?>
		<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-window-close"></i>&nbsp;Cerrar</button>
	</div>
	<?php
    break;

 case 2: // MODAL PARA AGREGAR INTERCAMBIO EN DIA
	?>
	<div class="modal-header">
		<h4 class="modal-title"><i class="fas fa-plus-circle"></i>&nbsp;AGREGAR INTERCAMBIO</h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col">
				<?php 
				$pasa 	=	FALSE;
				if(isset($desde) && isset($hasta) && $desde == $hasta){
					$pasa 	=	TRUE;
				}

				if($pasa){

					// Horas
					$horas 			=	array(
						'0'		=> 	'09',
						'1'		=>	'13',
						'2'		=>	'17',
						'3'		=>	'21'
					);

					echo form_open('reportes/fix','name="add_inter" id="add_inter" class="form-horizontal"');
					echo form_hidden('id',4);
					echo form_hidden('fecha',$desde);
					?>
					<p class="lead"><i class="fas fa-syringe"></i>&nbsp;Intercambios del día: <?= $desde ?></p>
					
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
								</tr>
							</thead>
							<tbody>
								<?php 
								if(isset($inters) && $inters){
									foreach ($inters as $k => $row) {
										//
										$hora 	=	date('H',$row->in_hora_sale_inicio);
										if(in_array($hora,$horas)){
											// Obtenemos key
											$key = array_search($hora,$horas);
											
											// Quitamos
											unset($horas[$key]);
		
										}
	
										?>
										<tr>
											<td class="text-center"><?= $k + 1 ?></td>
											<td class="text-center"><?= $row->in_dia ?></td>
											<td class="text-center"><?= date('H:i:s',$row->in_hora_sale_inicio) ?></td>
											<td class="text-center"><?= date('H:i:s',$row->in_hora_sale_termina) ?></td>
											<td class="text-center"><?= date('H:i:s',$row->in_hora_entra_inicio) ?></td>
											<td class="text-center"><?= date('H:i:s',$row->in_hora_entra_termina) ?></td>
										</tr>
										<?php
									}
								}
								
								?>
							</tbody>
						</table>
					</div><!-- ./table-responsive -->
					<p class="lead"><i class="fas fa-exclamation-circle"></i>&nbsp;Faltantes</p>
					<?php 
					if(count($horas) > 0){
						?>
						<div class="text-center"><?php
							foreach ($horas as $key => $row) {
								?>
								<a href="javascript: void(0)" onclick="fn_inter('<?= $key + 1 ?>')" class="btn bg-olive"><i class="fas fa-plus-circle"></i>&nbsp;<?= $row . '&nbsp;hrs' ?></a>
								<?php
							}
							?></div><?php
						}else{
							?><p class="text-success"><i class="fas fa-check-circle"></i>&nbsp;Ya están agregados todos.</p><?php
						}
						?>
					
					<?php echo form_close(); ?>
					<script type="text/javascript">
						$(function(){

						}); // function

						function fn_inter(num){
							var dia 	= 	'<?= $desde ?>';
							var tableinter = $('#intercambios').DataTable();
							$.ajax({
								url: 'reportes/fix',
								cache: false,
								type: 'post',
								dataType: 'html',
								data:{id:4,item1: num, item2: dia,'csrf_token': csrf_token},
								beforeSend: function(request){
									$("#div_oculto").spin(opts);
								},
								error:function(){ 
									fn_error();
									$('#div_oculto').spin(false);
								},
								success: function(html) { 

									if(html == 1){
										$('#modal-lg').modal('hide');
										tableinter.draw();
										fn_success();
										fn_add_dia();
									}else{
										fn_error();
									}

									$('#div_oculto').empty().html(html).fadeIn("fast");
									$('#div_oculto').spin(false);
								}
							});
						}
					</script>
					<?php
				}else{
					?><p class="text-danger"><i class="fas fa-exclamation-circle"></i>&nbsp;No hay datos de fechas.</p><?php
				}
				?>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-window-close"></i>&nbsp;Cerrar</button>
	</div>
	<?php
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
    	<div class="col-md-5">

    	</div><!-- ./col-md-5 -->
    	<div class="col-md-4">
    		<div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
            </div>
             <?php echo form_input($fechas); ?>
           </div><!-- ./input-group -->
    	</div><!-- ./col-md-4 -->

        <div class="col-md-3">
			<a href="javascript: void(0);" onclick="fn_add_dia()" class="btn bg-olive"><i class="fas fa-plus-circle"></i>&nbsp;Registrar</a>
            <a href="javascript: void(0);" onclick="fn_reporte()" class="btn btn-primary"><i class="fas fa-file-pdf"></i>&nbsp;Reporte</a>
        </div><!-- ./col-md-3 -->
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
		        
		        $.ajax({
					url: "<?php echo base_url('reportes/fix'); ?>",
					cache: true,
					type: 'get',
					dataType: 'html',
					data:{id:1,item1:interid,'csrf_token': csrf_token },
					beforeSend: function(){
						$("#div_oculto").spin(opts);
					},
					error:function(){ 
						fn_error();
						$('#div_oculto').spin(false);
					},
					success: function(html) {
						$('#div_oculto').spin(false);
						$('#carga-modal-content').empty().html(html).fadeIn("fast");
						$('#modal-lg').removeData('bs.modal').modal({ keyboard: false, backdrop: 'static' }).modal('show');
					},
					timeout: 8000
				});
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

		function fn_add_dia(){
    	    let rango  =   $("#reportrangee").val();

    	    if(rango != ""){
                $.ajax({
					url: "<?php echo base_url('reportes/fix'); ?>",
					cache: true,
					type: 'get',
					dataType: 'html',
					data:{id:3,item1:rango,'csrf_token': csrf_token },
					beforeSend: function(){
						$("#div_oculto").spin(opts);
					},
					error:function(){ 
						fn_error();
						$('#div_oculto').spin(false);
					},
					success: function(html) {
						$('#div_oculto').spin(false);
						$('#carga-modal-content').empty().html(html).fadeIn("fast");
						$('#modal-lg').removeData('bs.modal').modal({ keyboard: false, backdrop: 'static' }).modal('show');
					},
					timeout: 8000
				});
            }else{
				fn_error('Seleccione fechas...');
			}
        }
    </script>
    <?php
    break;
}