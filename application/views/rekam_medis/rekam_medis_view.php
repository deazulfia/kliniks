<?php $this->load->view('head'); ?>
<div class="container">
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
		  <!-- <div class="panel-heading">
			<h3 class="panel-title"><a href="<?php echo base_url();?>/terapi/periksa/<?php echo $row->no_reg;?>"><b>Back</b></a></h3>
		  </div> -->
		  <div class="panel-heading">
			<h3 class="panel-title"><b>Rekam Medis Pasien</b></h3>
		  </div>
		  <div class="panel-body">
			  <?php echo $this->session->flashdata('pesan');?>
		  <div id="unseen">
			<table class="table table-bordered table-hover table-condensed">
			<thead>
				<tr>
					<th>No. Urut</th>
					<th>No. Registrasi</th>
					<th>Nama Pasien</th>
					<th>Tekanan Darah</th>
					<th>Suhu Badan</th>
                    <th>Denyut Nadi</th>
                    <th>Diagnosa</th>
                    <th>Saran Tindakan</th>
                    <th>Tanggal Periksa</th>
					<th>Resep Pasien</th>
                    <!-- <th>Nama Obat</th> -->
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
					<td><?php echo $row->nama;?></td>
					<td><?php echo $row->tekanandarah;?></td>
					<td><?php echo $row->suhu;?></td>
					<td><?php echo $row->denyutnadi;?></td>
					<td><?php echo $row->diagnosa;?> </td>	
					<td><?php echo $row->sarantindakan;?></td>
                    <td><?php echo $row->tanggal_periksa;?></td>
					<td><?php echo anchor('rekam_medis/resep/'.$row->no_reg.'/'.$row->id,'
						<i class="glyphicon glyphicon-print"></i> Resep',array(
						'class'=>'btn btn-sm btn-success'
					));?></td>
                    <!-- <td><?php echo $row->nama_obat;?></td> -->
					
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
	 <?php $this->load->view('foot'); ?>
</div>
</div>

</div>
</div>
