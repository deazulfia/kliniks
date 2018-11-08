<?php echo form_open('barang/edit-kategori/'.$kategori->id_kategori_barang, array('id' => 'FormEditkategori')); ?>
<div class='form-group'>
	<?php
	echo form_input(array(
		'name' => 'kategori', 
		'class' => 'form-control',
		'value' => $kategori->kategori
	));
	?>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function EditKategori()
{
	$.ajax({
		url: $('#FormEditkategori').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormEditkategori').serialize(),
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
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanEditKategori'>Update Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormEditkategori").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanEditKategori').click(function(e){
		e.preventDefault();
		EditKategori();
	});

	$('#FormEditkategori').submit(function(e){
		e.preventDefault();
		EditKategori();
	});
});
</script>