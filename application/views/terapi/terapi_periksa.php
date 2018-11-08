<?php $this->load->view('head'); ?>
<div class="container">
	<div class="row">

		<div class="col-md-12 col-sm-12 col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><b>Pemeriksaan Pasien</b></h3>
				</div>
				<div class="panel-body">
					<?php echo form_open('terapi/periksa/'.$pasien->no_reg.'/'.$pasien->id,['target'=>'_blank']);?>
					<input type="hidden" id="idreg" name="noreg" value="<?php echo $pasien->no_reg;?>">
					<input type="hidden" id="pasien" value="<?php echo $pasien->id;?>">
					<table class="table table-striped">
						<tr>
							<th width="10%">No. Daftar</th>
							<th width="5%">:</th>
							<th width="55%"><?php echo $pasien->no_reg;?>
							</th>
						</tr>
						<tr>
							<th>Nama Pasien</th>
							<th>:</th>
							<th><?php echo $pasien->nama;?></th>
						</tr>
						<tr>
							<th>Umur</th>
							<th>:</th>
							<th><?php echo $pasien->umur_pasien;?> Th</th>
						</tr>
						<tr>
							<th>Alamat</th>
							<th>:</th>
							<th><?php echo $pasien->alamat;?></th>
						</tr>
						<tr>
							<th>Keluhan</th>
							<th>:</th>
							<th>
								<?php echo $pasien->keluhan;?>
							</th>
						</tr>
						<tr>
							<th>Rekam Medis Pasien</th>
							<th>:</th>
							<th>
								<a href="<?php echo base_url();?>rekam_medis/rm_pasien/<?php echo $pasien->id;?>">Rekam Medis</a>
							</th>
						</tr>
					</table>
					<h4>Data Medik Pasien</h4>
					<hr>
					<div id="notif" class="alert alert-danger" style="display:none;"></div>
					<div role="tabpanel">
						<ul class="nav nav-tabs" role="tablist">
							<li role="periksa" class="active">
								<a href="#diagnosa" aria-controls="diagnosa" role="tab" data-toggle="tab">Rekam Medis Pasien</a>
							</li>
							<li role="periksa">
								<a href="#obat" aria-controls="obat" role="tab" data-toggle="tab">Resep Obat</a>
							</li>
							<li role="periksa">
								<a href="#tindakan" aria-controls="tindakan" role="tab" data-toggle="tab">Tindakan</a>
							</li>
							<li role="periksa">
								<a href="#tindakan_obat" aria-controls="tindakan_obat" role="tab" data-toggle="tab">Alat Yang Digunakan</a>
							</li>
						</ul>
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane" id="obat">
								<table class="table">
									<tr>
										<th colspan="2">Input resep</th>
									</tr>
									<tr>
										<th>
											<select name="obat" id="formobat" class="form-control select2">
												<?php foreach ($list_obat as $item):?>
													<option value="<?=$item->id_obat ?>">
														<?= $item->nama_obat ?>
													</option>
												<?php endforeach ?>
											</select>
										</th>
									</tr>
									<tr>
										<th> <input type="text" id="jumlahobat" name="jumlah_obat" placeholder="Jumlah Obat" class="form-control"> </th>
									</tr>
									<tr>
										<th><input type="text" id="keteranganobat" name="keterangan_obat" placeholder="Keterangan Obat" class="form-control"> </th>
									</tr>
									<!-- <tr>
										<input id="gender" name="gender" type="radio" class="" <?php if($pasien=='0') echo "checked='checked'"; ?> value="0" <?php echo $this->form_validation->set_radio('gender', 0); ?> />
										<label for="gender" class="">Male</label>
									</tr> -->
									<tr>
										<th><?php echo form_submit(array('type'=>'button','id'=>'simpanobat','value'=>'Tambah','class'=>'btn btn-info'));?></th>
									</tr>
								</table>
								<div id="dataobat"></div>
							</div>
							<div role="tabpanel" class="tab-pane active" id="diagnosa">
								<table class="table">
									<tr>
										<th colspan="2">Input Rekam Medis</th>
									</tr>
									<tr>
										<th> <input type="text" name="tekanandarah" id="tekanandarah" placeholder="Tekanan Darah Pasien" class="form-control"> </th>
									</tr>
									<tr>
										<th> <input type="text" name="suhu" id="suhu" placeholder="Suhu Badan Pasien" class="form-control"> </th>
									</tr>
									<tr>
										<th> <input type="text" name="denyutnadi" id="denyutnadi" placeholder="Denyut Nadi Pasien" class="form-control"> </th>
									</tr>
									<tr>
										<th> <input type="text" name="diagnosa" id="formdiagnosa" placeholder="Diagnosa Pasien" class="form-control"> </th>
									</tr>
									<tr>
										<th> <input type="text" name="sarantindakan" id="sarantindakan" placeholder="Saran tindakan" class="form-control"> </th>
									</tr>
									<tr>
										<th><?php echo form_submit(array('type'=>'button','id'=>'simpandiagnosa','value'=>'Tambah','class'=>'btn btn-info'));?></th>
									</tr>
								</table>
								<div id="datadiagnosa"></div>
							</div>
							<div role="tabpanel" class="tab-pane" id="tindakan">
								<table class="table">
									<tr>
										<th colspan="2">Input Tindakan</th>
									</tr>
									<tr>
										<th><?php 
											// echo form_input(array('id'=>'formtindakan','class'=>'form-control'));
											?>
											<select name="obat[]" id="formtindakan" class="form-control select2">
												<?php foreach ($list_tindakan as $item):?>
													<option value="<?=$item->tindakan_id ?>">
														<?= $item->nama_tindakan ?>
													</option>
												<?php endforeach ?>
										</th>
											<th><?php echo form_submit(array('type'=>'button','id'=>'simpantindakan','value'=>'Tambah','class'=>'btn btn-info'));?></th>
									</tr>
								</table>
								<div id="datatindakan"></div>
							</div>
							<div role="tabpanel" class="tab-pane" id="tindakan_obat">
								<table class="table">
									<tr>
										<th colspan="2">Input Barang Yang Digunakan</th>
									</tr>
									<tr>
										<th>
											<select name="obat" id="formtindakanobat" class="form-control select2">
												<?php foreach ($list_obat as $item):?>
													<option value="<?=$item->id_obat ?>">
														<?= $item->id_obat ?> - 
														<?= $item->nama_obat ?>
													</option>
												<?php endforeach ?>
											</select>
										</th>
									</tr>
									<tr>
										<td><input type="radio" id="reused" name="keterangan" value="reused">Re Used </td>
										<td><input type="radio" id="new" name="keterangan" value="new">New</td>
										<td><textarea name="jumlah" id="jumlah" rows="5" cols="40" class="form-control"></textarea>
										</td>
									</tr>
									<!-- <tr>
										<th> <input type="text" id="jumlah" name="jumlah" placeholder="Jumlah" class="form-control"> </th>
									</tr> -->
									<tr>
										<th><?php echo form_submit(array('type'=>'button','id'=>'updateobat','value'=>'Tambah','class'=>'btn btn-info'));?></th>
									</tr>
								</table>
								<div id="datatindakanobat"></div>
							</div>
						</div>
						<div class="well">
							<?php
								echo form_submit(array('name'=>'submit','id'=>'submit','class'=>'btn btn-success','value'=>'Selesai Pemeriksaan',))
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('foot'); ?>
<?php ob_start(); ?>
<script type="text/javascript">

	$(document).ready(function(){

		$('#simpanobat').click(function(){
			var obat = $('#formobat').val();
			var pasien = $('#pasien').val();
			var noreg = $('#idreg').val();
			var jumlahobat = $('#jumlahobat').val();
			var keteranganobat = $('#keteranganobat').val();

			if(obat == ""){
				$.ajax({
					success:function(html){
						$('#notif').html('Silahkan input data resep terlebih dahulu');
						$('#notif').fadeIn(1000);
						$('#notif').fadeOut(2500);
						$('#formobat').focus();
					}
				});
			}else{
				$.ajax({
					url : '<?php echo site_url();?>/terapi/tambahobat',
					type : 'POST',
					data : 'jumlahobat='+jumlahobat+'&keteranganobat='+keteranganobat+'&obat='+obat+'&noreg='+noreg+'&pasien='+pasien,
					beforeSend : function(htmzl){
						$('#dataobat').html('<center><img src="<?php echo base_url();?>assets/img/loading-gede.gif"></center>');
						$('#dataobat').fadeIn(2000);
					},
					success:function(data){
						$('#dataobat').load('<?php echo site_url();?>/terapi/tampilobat/'+noreg);
						$('#formobat').val('');
						// console.log (data);
					}
				});
			}
		});

		$(document).ready(function() {
			$('input[name="keterangan"]').click(function() 
			{
				var value = $(this).val();
				if( value == "reused"){
					$('#jumlah').hide();
				}else{
					$('#jumlah').show();
			}
			});
		});

		$('#updateobat').click(function(){
			var obat = $('#formtindakanobat').val();
			var pasien = $('#pasien').val();
			var noreg = $('#idreg').val();
			var jumlah = $('#jumlah').val();

			if(tindakan_obat == ""){
				$.ajax({
					success:function(html){
						$('#notif').html('Silahkan input data resep terlebih dahulu');
						$('#notif').fadeIn(1000);
						$('#notif').fadeOut(2500);
						$('#formobat').focus();
					}
				});
			}else{
				$.ajax({
					url : '<?php echo site_url();?>/terapi/tambahtindakanobat',
					type : 'POST',
					data : 'jumlah='+jumlah+'&obat='+obat+'&noreg='+noreg+'&pasien='+pasien,
					beforeSend : function(htmzl){
						$('#datatindakanobat').html('<center><img src="<?php echo base_url();?>assets/img/loading-gede.gif"></center>');
						$('#datatindakanobat').fadeIn(2000);
					},
					success:function(data){
						$('#datatindakanobat').load('<?php echo site_url();?>/terapi/tampiltindakanobat/'+noreg);
						$('#formtindakobat').val('');
						// console.log (data);
					}
				});
			}
		});

		$('#simpandiagnosa').click(function(){
			var diagnosa = $('#formdiagnosa').val();
			var pasien = $('#pasien').val();
			var noreg = $('#idreg').val();
			var tekanandarah = $('#tekanandarah').val();
			var suhu = $('#suhu').val();
			var denyutnadi = $('#denyutnadi').val();
			var sarantindakan = $('#sarantindakan').val();

			if(diagnosa == ""){
				$.ajax({
					success:function(html){
						$('#notif').html('Silahkan input data diagnosa terlebih dahulu');
						$('#notif').fadeIn(1000);
						$('#notif').fadeOut(2500);
						$('#formdiagnosa').focus();
					}
				});
			}else{
				$.ajax({
					url : '<?php echo site_url();?>/terapi/tambahdiagnosa',
					type : 'POST',
					data : 'diagnosa='+diagnosa+'&noreg='+noreg+'&pasien='+pasien+'&tekanandarah='+tekanandarah+'&suhu='+suhu+'&denyutnadi='+denyutnadi+'&sarantindakan='+sarantindakan,
					beforeSend : function(html){
						$('#datadiagnosa').html('<center><img src="<?php echo base_url();?>assets/img/loading-gede.gif"></center>');
						$('#datadiagnosa').fadeIn(2000);
					},
					success:function(){
						$('#datadiagnosa').load('<?php echo site_url();?>/terapi/tampildiagnosa/'+noreg);
						$('#formdiagnosa').val('');
					}
				});
			}
		});

		$('#simpantindakan').click(function(){
			var obat = $('#formtindakan').val();
			var pasien = $('#pasien').val();
			var noreg = $('#idreg').val();

			if(tindakan == ""){
				$.ajax({
					success:function(html){
						$('#notif').html('Silahkan input data tindakan terlebih dahulu');
						$('#notif').fadeIn(1000);
						$('#notif').fadeOut(2500);
						$('#formtindakan').focus();
					}
				});
			}else{
				$.ajax({
					url : '<?php echo site_url();?>/terapi/tambahtindakan',
					type : 'POST',
					data : 'obat='+obat+'&noreg='+noreg+'&pasien='+pasien,
					beforeSend : function(html){
						$('#datatindakan').html('<center><img src="<?php echo base_url();?>assets/img/loading-gede.gif"></center>');
						$('#datatindakan').fadeIn(2000);
					},
					success:function(){
						$('#datatindakan').load('<?php echo site_url();?>/terapi/tampiltindakan/'+noreg);
						$('#formtindakan').val('');
					}
				});
			}
		});


		
		var options = {
			url: function(phrase) {
				return "<?php echo site_url();?>/terapi/get_diagnosa/" + phrase;
			},
			// getValue: function(element) {
			// 	return element.nama_penyakit;
			// },
			getValue : 'nama_penyakit',
			listLocation: "diagnosa",
			list: {
				maxNumberOfElements: 2,
				match: {
					enabled: true
				}
			}
		};

		// $("#formdiagnosa").easyAutocomplete(options);

	});
	$(document).on('click', '#resep', function(event) {
		event.preventDefault();
		/* Act on the event */
		var formData = new FormData($('#file_resep'));
		console.log(formData);
	});

</script>
<?php ob_end_flush(); ?>