<?php echo form_open('barang/tambah-merek', array('id' => 'FormTambahMerek')); ?>
<div class='form-group'>
	<input type='text' name='merek' class='form-control'>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function TambahMerek()
{
	$.ajax({
		url: $('#FormTambahMerek').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormTambahMerek').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1){ 
				$('#ResponseInput').html(json.pesan);
				setTimeout(function(){ 
			   		$('#ResponseInput').html('');
			    }, 3000);
				$('#my-grid').DataTable().ajax.reload( null, false );

				$('#FormTambahMerek').each(function(){
					this.reset();
				});
			}
			else {
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}

$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanTambahMerek'>Simpan Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormTambahMerek").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanTambahMerek').click(function(e){
		e.preventDefault();
		TambahMerek();
	});

	$('#FormTambahMerek').submit(function(e){
		e.preventDefault();
		TambahMerek();
	});
});
</script>