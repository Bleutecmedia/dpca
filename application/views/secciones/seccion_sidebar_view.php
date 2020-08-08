<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
				<base href="<?php echo base_url(); ?>" />
				<!-- Main Sidebar Container -->
  				<aside class="main-sidebar sidebar-dark-primary elevation-4">
	    			<!-- Brand Logo -->
				    <a href="<?php echo base_url(); ?>" class="brand-link logo-switch brand-link">
						<img src="<?php echo base_url('assets/img/logos/social.png'); ?>" alt="Logo" class="brand-image-xl logo-xs">
						<img src="<?php echo base_url('assets/img/logos/logo_header.png'); ?>" alt="Logo" class="brand-image-xs logo-xl" style="left: 12px">
					</a>

    				<!-- Sidebar -->
    				<div class="sidebar">
						<!-- Sidebar user panel (optional) -->
						<?php 
		    			if( $this->ion_auth->logged_in() ){
		    				?>
		    				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
	    						<div class="image">
	      							<img src="<?php echo base_url('assets/img/avatar/male/avatar13.png'); ?>" class="img-circle elevation-2" alt="User Image">
	    						</div>
	    						<div class="info">
	      							<a href="javascript: void(0);" onclick="fn_cargar_ajax_g('perfil','load_content',0)" class="d-block"><?php echo $user->first_name.' '.$user->last_name; ?></a>
								</div>
							</div>
						<?php
						}
						?>
					 	<!-- Sidebar Menu -->
			          	<nav class="mt-2">
			          		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				              	<li class="nav-item">
					                <a href="javascript: void(0);" onclick="openmodal('<?php echo base_url(); ?>assets/docs/ayuda/site/index.html')" class="nav-link">
				                      	<i class="fas fa-question-circle"></i>
				                      	<p>Manual de Ayuda</p>
				                    </a>
				              	</li>
			          		</ul>

			          		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				              <!-- Add icons to the links using the .nav-icon class
				                   with font-awesome or any other icon font library -->
				              <li class="nav-item has-treeview menu-open">
				                <a href="javascript: void(0);" class="nav-link active">
				                  <i class="fas fa-gavel"></i>
				                  <p>
				                    Legal
				                    <i class="right fas fa-angle-left"></i>
				                  </p>
				                </a>
				                <ul class="nav nav-treeview">
				                  	<li class="nav-item">
					                	<a href="javascript: void(0);" onclick="fn_cargar_ajax_g('<?php echo base_url(); ?>legal/licencia','load_content',0)" class="nav-link">
					                  		<i class="fas fa-key"></i>
					                  		<p><?php echo "Licencia"; ?></p>
					                	</a>
					              	</li>
					              	<li class="nav-item">
					                	<a href="javascript: void(0);" onclick="fn_cargar_ajax_g('<?php echo base_url(); ?>legal/tos','load_content',0)" class="nav-link">
					                  		<i class="fas fa-user-lock"></i>
					                  		<p><?php echo "Términos y Condiciones"; ?></p>
					                	</a>
					              	</li>
					              	<li class="nav-item">
					                	<a href="javascript: void(0);" onclick="fn_cargar_ajax_g('<?php echo base_url(); ?>legal/privacidad','load_content',0)" class="nav-link">
					                  		<i class="fas fa-user-shield"></i>
					                  		<p><?php echo "Privacidad"; ?></p>
					                	</a>
					              	</li>
				                </ul>
				              </li>					              
				            </ul>
				            
				            <?php 
				            if( $this->ion_auth->logged_in() ){
				            	?>
				            	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
					              <!-- Add icons to the links using the .nav-icon class
					              with font-awesome or any other icon font library -->

					              <li class="nav-item">
					                <a href="javascript: void(0);" onclick="fn_cargar_ajax_g('<?php echo base_url(); ?>ajustes','load_content',0)" class="nav-link">
				                      <i class="fas fa-cog"></i>
				                      <p><?php echo lang('label_ajustes'); ?></p>
				                    </a>
					              </li>
					            </ul>
				            	<?php
				            }
				            ?>
			          	</nav><!-- /.sidebar-menu -->

				    </div><!-- /.sidebar -->
			  	</aside>