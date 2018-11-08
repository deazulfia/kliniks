<?php echo form_open('user/tambah', array('id' => 'FormTambahUser')); ?>
<div class='form-group'>
	<label>Username Login</label>
	<input type='text' name='username' class='form-control'>
</div>
<div class='form-group'>
	<label>Password Login</label>
	<input type='password' name='password' class='form-control'>
</div>

<hr />

<div class='form-group'>
	<label>Nama Lengkap</label>
	<input type='text' name='nama' class='form-control'>
</div>
<div class='form-group'>
	<label>Akses</label>
	<select name='id_akses' class='form-control'>
	<?php
	foreach($akses->result() as $a)
	{
		echo "<option value='".$a->id_akses."'>".$a->level_akses."</option>";
	}
	?>
	</select>
</div>
<div class='form-group'>
	<label>Status</label>
	<select name='status' class='form-control'>
		<option value="Aktif">Aktif</option>
		<option value="Non Aktif">Non Aktif</option>
	</select>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function TambahUser()
{
	$.ajax({
		url: $('#FormTambahUser').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormTambahUser').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1){ 
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Sukses !');
				$('#ModalContent').html(json.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal'>Ok</button>");
				$('#ModalGue').modal('show');
				$('#my-grid').DataTable().ajax.reload( null, false );
			}
			else {
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}

$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanTambahUser'>Simpan Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormTambahUser").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanTambahUser').click(function(e){
		e.preventDefault();
		TambahUser();
	});

	$('#FormTambahUser').submit(function(e){
		e.preventDefault();
		TambahUser();
	});
});
</script>