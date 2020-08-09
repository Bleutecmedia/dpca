<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
			$csrf_token = $this->security->get_csrf_hash(); 
			?>			
			<div id="div_oculto" style="display: none;"></div>

			<!-- ./MODAL -->
			<div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg">

              		<div class="modal-content">
                  		<div id="carga-modal-content"></div><!-- ./carga-contenido -->

                  	</div><!-- /.modal-content -->

                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
			<!-- ./MODAL -->

		</div><!-- ./wrapper -->
		<!-- REQUIRED SCRIPTS -->
		<script type="text/javascript">
			var csrf_token 	= "<?php echo $csrf_token; ?>";
		</script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/admin-lte/3.0.5/js/adminlte.min.js"></script>
		<script type="text/javascript" src="//cdn.jsdelivr.net/npm/sweetalert2@9"></script>
		<script type="text/javascript" src="//cdn.jsdelivr.net/npm/sweetalert2@9.15.3/dist/sweetalert2.all.min.js"></script>
		<script type="text/javascript" src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
		<script type="text/javascript" src="//cdn.datatables.net/v/bs4/dt-1.10.18/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.5.0/r-2.2.2/rg-1.1.0/rr-1.2.4/sc-2.0.0/sl-1.3.0/datatables.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-es.min.js"></script>
    	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.min.js"></script>
    	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/easy-autocomplete/1.3.5/jquery.easy-autocomplete.min.js"></script>
    	<script type="text/javascript" src="//hayageek.github.io/jQuery-Upload-File/4.0.10/jquery.uploadfile.min.js"></script>
    	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.media.js'); ?>"></script>
    	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/noty@3.2.0-beta/lib/noty.min.js"></script>
    	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.js"></script>
	    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.spin.js'); ?>"></script>
    	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/@mojs/core"></script>
    	<script type="text/javascript" src="<?php echo base_url('assets/js/demo.js'); ?>"></script>
    	<script type="text/javascript" src="<?php echo base_url('assets/js/custom.js'); ?>"></script>
    	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment-with-locales.min.js"></script>
    	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    </body>
</html>