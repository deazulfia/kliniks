<?php echo form_open('dokter/tambah-dokter', array('id' => 'FormTambahDokter')); ?>
<div class='form-group'>
    <label> SIP </label>
	<input type='text' name='sip' class='form-control'>
</div>
<div class='form-group'>
    <label> Nama Dokter </label>
	<input type='text' name='nama_dokter' class='form-control'>
</div>
<div class='form-group'>
    <label> Spesialis </label>
	<input type='text' name='spesialis' class='form-control'>
</div>
<div class='form-group'>
	<label>Active</label>
	<select class="form-control" name="active">
		<option value="">Select Option</option>
		<option value="1">Tidak AKtif</option>
		<option value="2">Aktif</option>
	</select>
</div>
<!-- <div class='form-group'>
    <label> Active </label>
	<select class="form-control" name="active">
		<option value="">Select Option</option>
		<option value="tidak aktif">Tidak aktif</option>
		<option value="aktif">Aktif</option>
	</select>
</div> -->
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function TambahDokter()
{
	$.ajax({
		url: $('#FormTambahDokter').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormTambahDokter').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1){ 
				$('#ResponseInput').html(json.pesan);
				setTimeout(function(){ 
			   		$('#ResponseInput').html('');
			    }, 3000);
				$('#my-grid').DataTable().ajax.reload( null, false );

				$('#FormTambahDokter').each(function(){
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
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanTambahDokter'>Simpan Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormTambahDokter").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanTambahDokter').click(function(e){
		e.preventDefault();
		TambahDokter();
	});

	$('#FormTambahDokter').submit(function(e){
		e.preventDefault();
		TambahDokter();
	});
});
</script>