<?php echo form_open('barang/stok/'.$stok->id_obat, array('id' => 'FormAddStokBarang')); ?>
<div class="form-horizontal">
	<div class="form-group">
		<label class="col-sm-3 control-label">Stok Sebelumnya</label>
		<div class="col-sm-8">
			<?php 
			echo form_input(array(
				'class' => 'form-control',
				'value' => $stok->total_stok
			));
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Tambah Jumlah Stok</label>
		<div class="col-sm-8">
			<?php 
			echo form_input(array(
				'name' => 'total_stok',
				'class' => 'form-control',
			));
			?>
		</div>
	</div>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanAddStokBarang'>Update Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);
	
	$('#SimpanAddStokBarang').click(function(){
		$.ajax({
			url: $('#FormAddStokBarang').attr('action'),
			type: "POST",
			cache: false,
			data: $('#FormAddStokBarang').serialize(),
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
	});
});
</script>