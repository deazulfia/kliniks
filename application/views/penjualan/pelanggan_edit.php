<?php echo form_open('penjualan/pelanggan-edit/'.$pelanggan->id, array('id' => 'FormEditPelanggan')); ?>

<div class='form-group'>
	<label>No. KTP</label>
	<?php
	echo form_input(array(
		'name' => 'no_ktp_pasien', 
		'class' => 'form-control',
		'value' => $pelanggan->no_ktp_pasien
	));
	?>
</div>
<div class='form-group'>
	<label>Nama</label>
	<?php
	echo form_input(array(
		'name' => 'nama', 
		'class' => 'form-control',
		'value' => $pelanggan->nama
	));
	?>
</div>
<div class='form-group'>
	<label>Tempat Lahir</label>
	<?php
	echo form_input(array(
		'name' => 'tempat_lahir_pasien', 
		'class' => 'form-control',
		'value' => $pelanggan->tempat_lahir_pasien
	));
	?>
</div>
<div class='form-group'>
	<label>Tanggal Lahir</label>
	<?php
	echo form_input(array(
		'name' => 'tanggal_lahir_pasien', 
		'class' => 'form-control',
		'value' => $pelanggan->tanggal_lahir_pasien
	));
	?>
</div>
<div class='form-group'>
	<label>Jenis Kelamin</label>
	<?php
	echo form_input(array(
		'name' => 'jk_pasien', 
		'class' => 'form-control',
		'value' => $pelanggan->jk_pasien
	));
	?>
</div>
<!-- <div class='form-group'>
	<label>Umur Pasien</label>
	<?php
	echo form_input(array(
		'name' => 'umur_pasien', 
		'class' => 'form-control',
		'value' => $pelanggan->umur_pasien
	));
	?>
</div> -->
<div class='form-group'>
	<label>Alamat</label>
	<?php
	echo form_textarea(array(
		'name' => 'alamat', 
		'class' => 'form-control',
		'value' => $pelanggan->alamat,
		'style' => "resize:vertical",
		'rows' => 3
	));
	?>
</div>
<div class='form-group'>
	<label>Nomor Telepon / Handphone</label>
	<?php
	echo form_input(array(
		'name' => 'telepon', 
		'class' => 'form-control',
		'value' => $pelanggan->telp
	));
	?>
</div>
<div class='form-group'>
	<label>Golongan Darah</label>
	<select class="form-control" name="goldar_pasien" value="<?php echo $pelanggan->goldar_pasien;?>">
		<option value="">Select Option</option>
		<option value="1">A</option>
		<option value="2">B</option>
		<option value="3">O</option>
		<option value="4">AB</option>
	</select>
</div>
<div class='form-group'>
	<label>Riwayat alergi</label>
	<?php
	echo form_input(array(
		'name' => 'riwayat_alergi', 
		'class' => 'form-control',
		'value' => $pelanggan->riwayat_alergi
	));
	?>
</div>
<div class='form-group'>
	<label>Email</label>
	<?php
	echo form_input(array(
		'name' => 'email', 
		'class' => 'form-control',
		'value' => $pelanggan->email
	));
	?>
</div>
<div class='form-group'>
	<label>Nama Perusahaan</label>
	<?php
	echo form_input(array(
		'name' => 'nama_perusahaan', 
		'class' => 'form-control',
		'value' => $pelanggan->nama_perusahaan
	));
	?>
</div>
<div class='form-group'>
	<label>Info Tambahan Lainnya</label>
	<?php
	echo form_textarea(array(
		'name' => 'info', 
		'class' => 'form-control',
		'value' => $pelanggan->info_tambahan,
		'style' => "resize:vertical",
		'rows' => 3
	));
	?>
</div>

<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function EditPelanggan()
{
	$.ajax({
		url: $('#FormEditPelanggan').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormEditPelanggan').serialize(),
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
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanEditPelanggan'>Update Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormEditPelanggan").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanEditPelanggan').click(function(e){
		e.preventDefault();
		EditPelanggan();
	});

	$('#FormEditPelanggan').submit(function(e){
		e.preventDefault();
		EditPelanggan();
	});
});
</script>