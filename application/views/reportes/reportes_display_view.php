<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row mt-4">
	<div class="col-xs-12 col-sm-12 col-md-12">
		<a class="media" href="<?php echo $path_r; ?>"></a>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		$('a.media').media({width:'100%', height:600 });
	});
</script>