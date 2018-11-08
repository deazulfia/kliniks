<?php echo form_open('pendaftaran/edit-pendaftaran/'.$pendaftaran->id_pendaftaran, array('id' => 'FormEditPendaftaran')); ?>
<div class='form-group'>
	<label> No Pendaftaran </label>
	<?php
	echo form_input(array(
		'name' => 'no_pendaftaran', 
		'class' => 'form-control',
		'value' => $pendaftaran->no_pendaftaran
	));
	?>
</div>
<div class='form-group'>
	<label> keluhan </label>
	<?php
	echo form_input(array(
		'name' => 'keluhan', 
		'class' => 'form-control',
		'value' => $pendaftaran->keluhan
	));
	?>
</div>
<div class='form-group'>
	<label> ID Pasien </label>
	<?php
	echo form_input(array(
		'name' => 'no_rm', 
		'class' => 'form-control',
		'value' => $pendaftaran->id
	));
	?>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function EditPendaftaran()
{
	$.ajax({
		url: $('#FormEditPendaftaran').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormEditPendaftaran').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1){ 
				$('#ResponseInput').html(json.pesan);
				setTimeout(function(){ 
			   		$('#ResponseInput').html('');
			    }, 3000);
				$('#my-grid').DataTable().ajax.reload( null, false );
			}
			else {
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}

$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanEditPendaftaran'>Update Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormEditPendaftaran").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanEditPendaftaran').click(function(e){
		e.preventDefault();
		EditPendaftaran();
	});

	$('#FormEditPendaftaran').submit(function(e){
		e.preventDefault();
		EditPendaftaran();
	});
});
</script>