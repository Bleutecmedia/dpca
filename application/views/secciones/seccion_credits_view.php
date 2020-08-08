<?php defined('BASEPATH') OR exit('No direct script access allowed');  
    $fromYear = 2020; 
    $thisYear = (int)date('Y'); 
?>
<!-- Main Footer -->
<footer class="main-footer text-sm">
	<!-- To the right -->
	<div class="float-right d-none d-sm-inline">
  		<i class="fas fa-code-branch"></i>&nbsp;<?php echo lang('label_app_shorname'); ?> v<?= $this->config->item('app_version') ?>
	</div>
	<!-- Default to the left -->
	<strong>Copyright &copy; <?php echo $fromYear . (($fromYear != $thisYear) ? ' - ' . $thisYear : ''); ?> <a href="<?php echo lang('label_app_website_url'); ?>" target="_blank"><?php echo lang('label_app_website_name'); ?></a></strong>&nbsp;-&nbsp;<?php echo lang('label_app_copyright'); ?>.
</footer>
