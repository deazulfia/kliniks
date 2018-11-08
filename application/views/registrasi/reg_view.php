<?php $this->load->view('head'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
			<div class="panel-heading">
	    		<h3 class="panel-title"><a href="<?php echo base_url();?>pasien/index/"><b>Home</b></a></h3>
	  		</div>
			<center>
			<div class="panel-heading">
	    		<h3 class="panel-title"><b>Daftar Registrasi Pasien</b></h3>
	  		</div>
			</center>
	  		<div class="panel-body">
		  		<?php echo anchor('pasien','<i class="glyphicon glyphicon-plus"></i> Registrasi Baru',array('class'=>'btn btn-warning btn-md'));?>
	  			<hr>
	  			<?php echo $this->session->flashdata('pesan');?>
	  		<div id="unseen">
	    		<table class="table table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th>No. Urut</th>
						<th>No. Registrasi</th>
						<th>No. RM</th>
						<th>Nama Pasien</th>
						<th>Tanggal Lahir</th>
						<th>Alamat</th>
						<th>Keluhan</th>
					</tr>
				</thead>
				<tbody>
				<?php if(empty($query)){
					echo '<tr><td colspan="6">Data tidak tersedia.</td></tr>';
					}else{
						$no = 1;
						foreach($query as $row) :
						?>
					<tr>
						<td><span class="label label-danger"><?php echo $no;?></span></td>
						<td><?php echo $row->no_reg;?></td>
						<td><?php echo $row->no_rm;?></td>
						<td><?php echo $row->nama;?></td>
						<td><?php echo $row->tanggal_lahir_pasien;?></td>
						<td><?php echo $row->alamat;?></td>
						<td><?php echo $row->keluhan;?></td>
						
					</tr>	
						<?php
						$no++;
						endforeach;
					}
					?>
				</tbody>
			</table>
			</div>
	 	</div>
	</div>
</div>
<?php $this->load->view('foot'); ?>

	</div>
</div>