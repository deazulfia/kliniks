<?php echo form_open('user/ubah-password', array('id' => 'FormUbahPass')); ?>
<div class='form-group'>
	<label>Password Lama</label>
	<input type='password' name='pass_old' class='form-control' autofocus="autofocus">
</div>
<div class='form-group'>
	<label>Password Baru</label>
	<input type='password' name='pass_new' class='form-control'>
</div>
<div class='form-group'>
	<label>Ulangi Password Baru</label>
	<input type='password' name='pass_new_confirm' class='form-control'>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanUbahPass'>Ubah Password</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$('#SimpanUbahPass').click(function(){
		$.ajax({
			url: $('#FormUbahPass').attr('action'),
			type: "POST",
			cache: false,
			data: $('#FormUbahPass').serialize(),
			dataType:'json',
			success: function(json){
				if(json.status == 1){ 
					$('#FormUbahPass').each(function(){
						this.reset();
					});

					$('#ResponseInput').html(json.pesan);
					setTimeout(function(){ 
				   		$('#ResponseInput').html('');
				    }, 3000);
				}
				else {
					$('#ResponseInput').html(json.pesan);
				}
			}
		});
	});
});
</script>