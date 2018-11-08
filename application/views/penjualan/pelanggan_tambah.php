<?php echo form_open('penjualan/tambah-pelanggan', array('id' => 'FormTambahPelanggan')); ?>
<div class='form-group'>
	<label>No. KTP* </label>
	<input type='text' name='no_ktp_pasien' class='form-control'>
</div>
<div class='form-group'>
	<label>Nama*</label>
	<input type='text' name='nama' class='form-control'>
</div>
<div class='form-group'>
	<label>Tempat Lahir</label>
	<input type='text' name='tempat_lahir_pasien' class='form-control'>
</div>
<div class='form-group'>
	<label>Tanggal Lahir</label>
	<input type='date' name='tanggal_lahir_pasien' class='form-control'>
</div>
<div class='form-group'>
	<label>Jenis Kelamin</label>
	<select class="form-control" name="jk_pasien">
		<option value="">Select Option</option>
		<option value="L">Laki-laki</option>
		<option value="P">Perempuan</option>
	</select>
</div>
<!-- <div class='form-group'>
	<label>Umur Pasien</label>
	<input type='text' name='umur_pasien' class='form-control'>
</div> -->
<div class='form-group'>
	<label>Alamat*</label>
	<textarea name='alamat' class='form-control' style='resize:vertical;'></textarea>
</div>
<div class='form-group'>
	<label>Nomor Telepon / Handphone*</label>
	<input type='text' name='telepon' class='form-control'>
</div>
<div class='form-group'>
	<label>Golonagn Darah</label>
	<select class="form-control" name="goldar_pasien">
		<option value="">Select Option</option>
		<option value="1">A</option>
		<option value="2">B</option>
		<option value="3">O</option>
		<option value="4">AB</option>
	</select>
</div>
<div class='form-group'>
	<label>Riwayat Alergi</label>
	<input type='text' name='riwayat_alergi' class='form-control'>
</div>
<div class='form-group'>
	<label>Email</label>
	<input type='text' name='email' class='form-control'>
</div>
<div class='form-group'>
	<label>Nama Perusahaan</label>
	<input type='text' name='nama_perusahaan' class='form-control'>
</div>
<div class='form-group'>
	<label>Info Tambahan Lainnya</label>
	<textarea name='info' class='form-control' style='resize:vertical;'></textarea>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function TambahPelanggan()
{
	$.ajax({
		url: $('#FormTambahPelanggan').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormTambahPelanggan').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1)
			{ 
				$('#FormTambahPelanggan').each(function(){
					this.reset();
				});

				if(document.getElementById('PelangganArea') != null)
				{
					$('#ResponseInput').html('');

					$('.modal-dialog').removeClass('modal-lg');
					$('.modal-dialog').addClass('modal-sm');
					$('#ModalHeader').html('Berhasil');
					$('#ModalContent').html(json.pesan);
					$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Okay</button>");
					$('#ModalGue').modal('show');

					$('#id').append("<option value='"+json.id+"' selected>"+json.nama+"</option>");
					$('#telp_pelanggan').html(json.telepon);
					$('#alamat_pelanggan').html(json.alamat);
					$('#info_tambahan_pelanggan').html(json.info);
				}
				else
				{
					$('#ResponseInput').html(json.pesan);
					setTimeout(function(){ 
				   		$('#ResponseInput').html('');
				    }, 3000);
					$('#my-grid').DataTable().ajax.reload( null, false );
				}
			}
			else 
			{
				$('#ResponseInput').html(json.pesan);
			}
		},
		error:function(e){
			console.log(e);
		}
	});
}

$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanTambahPelanggan'>Simpan Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormTambahPelanggan").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanTambahPelanggan').click(function(e){
		e.preventDefault();
		TambahPelanggan();
	});

	$('#FormTambahPelanggan').submit(function(e){
		e.preventDefault();
		TambahPelanggan();
	});
});
</script>