<?php echo form_open('dokter/edit-dokter/'.$dokter->id_dokter, array('id' => 'FormEditDokter')); ?>
<div class='form-group'>
    <label>SIP</label>
    <?php
	echo form_input(array(
		'name' => 'sip', 
		'class' => 'form-control',
		'value' => $dokter->sip
	));
	?>
</div>
<div class='form-group'>
    <label>Nama Dokter</label>
    <?php
	echo form_input(array(
		'name' => 'nama_dokter', 
		'class' => 'form-control',
		'value' => $dokter->nama_dokter
	));
	?>
</div>
<div class='form-group'>
    <label>Spesialis</label>
    <?php
	echo form_input(array(
		'name' => 'spesialis', 
		'class' => 'form-control',
		'value' => $dokter->spesialis
	));
	?>
</div>
<div class='form-group'>
	<label>Active</label>
	<?php
	echo form_input(array(
		'name' => 'active', 
		'class' => 'form-control',
		'value' => $dokter->active
	));
	?>
	<select class="form-control" name="active">
		<option value="">Select Option</option>
		<option value="1">Tidak AKtif</option>
		<option value="2">Aktif</option>
	</select>
</div>
<!-- <div class='form-group'>
    <label>Active</label>
    <?php
	echo form_input(array(
		'name' => 'active', 
		'class' => 'form-control',
		'value' => $dokter->active
	));
	?>
</div> -->
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function EditDokter()
{
	$.ajax({
		url: $('#FormEditDokter').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormEditDokter').serialize(),
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
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanEditDokter'>Update Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormEditDokter").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanEditDokter').click(function(e){
		e.preventDefault();
		EditDokter();
	});

	$('#FormEditDokter').submit(function(e){
		e.preventDefault();
		EditDokter();
	});
});
</script>