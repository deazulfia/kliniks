<?php $this->load->view('head'); ?>
<div class="container">
	<div class="row">

		<div class="col-md-12 col-sm-12 col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><a href="<?php echo base_url();?>pasien/index"><b>Back</b></a></h3>
				</div>
				<center>
				<div class="panel-heading">
					<h3 class="panel-title"><b>Registrasi Pasien</b></h3>
				</div>
				</center>
				<div class="panel-body">
					<?php echo form_open('registrasi/daftar/'.$query->id);?>
					<table class="table table-striped">
							<tr>
								<th>Nama Pasien</th>
								<th>:</th>
								<th><?php echo $query->nama;?></th>
							</tr>
							<tr>	
								<th>Umur</th>
								<th>:</th>
								<th><?php echo $query->tanggal_lahir_pasien;?> Th</th>
							</tr>
							<tr>	
								<th>Alamat</th>
								<th>:</th>
								<th><?php echo $query->alamat;?></th>
							</tr>
							<tr>	
								<th>Keluhan</th>
								<th>:</th>
								<th>
									<?php echo form_textarea(array(
										'name'=>'keluhan', 
										'class'=>'form-control',
										'id'=>'keluhan',
										'required'=>'required',
										'rows'=>'5'));?>
									</th>
								</tr>
								<tr>
									<th colspan="3">
										<?php echo form_submit(array(
											'name'=>'submit',
											'id'=>'submit',
											'value'=>'Daftarkan Pasien',
											'class'=>'btn btn-success'
											));?>
										</th>
									</tr>

								</table>
							</div>
						</div>
					</div>

				</div>
			</div>
			<?php $this->load->view('foot'); ?>