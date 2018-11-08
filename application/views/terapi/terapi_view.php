<?php $this->load->view('head'); ?>
<div class="container">
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><a href="<?php echo base_url("pasien"); ?>">Back</a></h3>
			</div>
			<div class="panel-heading">
				<h3 class="panel-title"><b>Daftar Antrian Pasien</b></h3>
			</div>
			<div class="panel-body">
				<?php echo $this->session->flashdata('pesan');?>
			<div id="unseen">
				<table class="table table-bordered table-hover table-condensed">
				<thead>
					<tr>
						<th>No. Urut</th>
						<th>No. Registrasi</th>
						<th>No. RM</th>
						<th>Nama Pasien</th>
						<th>Alamat</th>
						<th>Umur</th>
						<th>Keluhan</th>
						
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php if(empty($query)){
					echo '<tr><td colspan="6">Data tidak tersedia.</td></tr>';
					}else{
						$no = 1;
						foreach($query as $row) :
							// echo json_encode($row, true);
						?>
					<tr>
						<td><span class="label label-danger"><?php echo $no;?></span></td>
						<td><?php echo $row->no_reg;?></td>
						<td><?php echo $row->no_rm;?></td>
						<td><?php echo $row->nama;?></td>
						<td><?php echo $row->alamat;?></td>
						<td><?php echo $row->umur_pasien;?> Th</td>	
						<td><?php echo $row->keluhan;?></td>	
						<td><?php echo anchor('terapi/periksa/'.$row->no_reg.'/'.$row->id,'
							<i class="glyphicon glyphicon-search"></i> Mulai Periksa',array(
							'class'=>'btn btn-sm btn-success'
						));?></td>
						
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
	<?php $this->load->view('foot'); ?>
</div>
</div>
