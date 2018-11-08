		<script src="<?php echo config_item('bootstrap'); ?>js/bootstrap.min.js"></script>
		<div class="modal" id="ModalGue" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class='fa fa-times-circle'></i></button>
						<h4 class="modal-title" id="ModalHeader"></h4>
					</div>
					<div class="modal-body" id="ModalContent"></div>
					<div class="modal-footer" id="ModalFooter"></div>
				</div>
			</div>
		</div>
		
		<script>
		$('#ModalGue').on('hide.bs.modal', function () {
		   setTimeout(function(){ 
		   		$('#ModalHeader, #ModalContent, #ModalFooter').html('');
		   }, 500);
		});
		</script>
	</body>
</html>