<?php echo form_open('barang/edit-tindakan/'.$tindakan->tindakan_id, array('id' => 'FormEditTindakan')); ?>
<div class='form-group'>
    <label> Kode Tindakan </label>
	<?php
	echo form_input(array(
		'name' => 'kode_tindakan', 
		'class' => 'form-control',
		'value' => $tindakan->kode_tindakan
	));
	?>
</div>
<div class='form-group'>
    <label> Nama Tindakan </label>
	<?php
	echo form_input(array(
		'name' => 'nama_tindakan', 
		'class' => 'form-control',
		'value' => $tindakan->nama_tindakan
	));
	?>
</div>
<div class='form-group'>
    <label> Biaya Tindakan </label>
	<?php
	echo form_input(array(
		'name' => 'biaya', 
		'class' => 'form-control',
		'value' => $tindakan->biaya
	));
	?>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function EditTindakan()
{
	$.ajax({
		url: $('#FormEditTindakan').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormEditTindakan').serialize(),
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
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanEditTindakan'>Update Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormEditTindakan").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanEditTindakan').click(function(e){
		e.preventDefault();
		EditTindakan();
	});

	$('#FormEditTindakan').submit(function(e){
		e.preventDefault();
		EditTindakan();
	});
});
</script>