<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12">
		<div class="mb-2 text-center"><a href="javascript: void(0);" onclick="fn_cargar_ajax_g('torneos','load_content',0)" class="btn bg-olive"><i class="fas fa-trophy"></i>&nbsp;Volver al Torneo</a></div>
		<a class="media" href="<?php echo $path_r; ?>"></a> 
	</div>
</div>

<script type="text/javascript">
	$(function(){
		$('a.media').media({width:'100%', height:600 });
	});
</script>