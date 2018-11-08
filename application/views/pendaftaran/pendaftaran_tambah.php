<link rel="stylesheet" href="<?php echo base_url().'assets/auto/css/jquery-ui.css'?>">

<?php echo form_open('pendaftaran/tambah-pendaftaran', array('id' => 'FormTambahPendaftaran')); ?>
<div class='form-group'>
	<label> Keluhan </label>
	<input type='text' name='keluhan' class='form-control'>
</div>
<div class='form-group'>
	<label> ID Pasien </label>
	<input type='text' name='id' class='form-control'>
</div><br>
<div class='form-group'>
	<label> Nama Pasien </label>
	<input type='text' name='title' class='form-control' id='title'>
</div><br>
<div class='form-group'>
	<label> Tanggal Lahir Pasien </label>
	<textarea name="description" class="form-control"></textarea>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script src="<?php echo base_url().'assets/auto/js/jquery-3.3.1.js'?>" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/auto/js/bootstrap.js'?>" type="text/javascript"></script>
<script src="<?php echo base_url().'assets/auto/js/jquery-ui.js'?>" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){

		$('#title').autocomplete({
			source: "<?php echo site_url('blog/get_autocomplete');?>",
	
			select: function (event, ui) {
				$('[name="title"]').val(ui.item.label); 
				$('[name="description"]').val(ui.item.description); 
			}
		});

	});
</script>
<script>
	function TambahPendaftaran()
	{
		$.ajax({
			url: $('#FormTambahPendaftaran').attr('action'),
			type: "POST",
			cache: false,
			data: $('#FormTambahPendaftaran').serialize(),
			dataType:'json',
			success: function(json){
				if(json.status == 1){ 
					$('#ResponseInput').html(json.pesan);
					setTimeout(function(){ 
						$('#ResponseInput').html('');
					}, 3000);
					$('#my-grid').DataTable().ajax.reload( null, false );

					$('#FormTambahPendaftaran').each(function(){
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
		var Tombol = "<button type='button' class='btn btn-primary' id='SimpanTambahPendaftaran'>Simpan Data</button>";
		Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
		$('#ModalFooter').html(Tombol);

		$("#FormTambahPendaftaran").find('input[type=text],textarea,select').filter(':visible:first').focus();

		$('#SimpanTambahPendaftaran').click(function(e){
			e.preventDefault();
			TambahPendaftaran();
		});

		$('#FormTambahPendaftaran').submit(function(e){
			e.preventDefault();
			TambahPendaftaran();
		});
	});
</script>