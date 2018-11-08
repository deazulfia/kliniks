<?php echo form_open('barang/tambah-tindakan', array('id' => 'FormTambahTindakan')); ?>
<div class='form-group'>
    <label> Kode Tindakan </label>
	<input type='text' name='kode_tindakan' class='form-control'>
</div>
<div class='form-group'>
    <label> Nama Tindakan </label>
	<input type='text' name='nama_tindakan' class='form-control'>
</div>
<div class='form-group'>
    <label> Biaya Tindakan </label>
	<input type='text' name='biaya' class='form-control'>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function TambahTindakan()
{
	$.ajax({
		url: $('#FormTambahTindakan').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormTambahTindakan').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1){ 
				$('#ResponseInput').html(json.pesan);
				setTimeout(function(){ 
			   		$('#ResponseInput').html('');
			    }, 3000);
				$('#my-grid').DataTable().ajax.reload( null, false );

				$('#FormTambahTindakan').each(function(){
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
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanTambahTindakan'>Simpan Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormTambahTindakan").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanTambahTindakan').click(function(e){
		e.preventDefault();
		TambahTindakan();
	});

	$('#FormTambahTindakan').submit(function(e){
		e.preventDefault();
		TambahTindakan();
	});
});
</script>