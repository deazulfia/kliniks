<?php $this->load->view('head'); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
	  		<div class="panel-heading">
	    		<h3 class="panel-title"><b>Daftar History Pasien</b></h3>
	  		</div>
	  			
	  			<?php echo $this->session->flashdata('pesan');?>

	  		<div id="unseen">
	    		<table class="table table-bordered table-hover table-condensed data-table order-table">
	    			<!-- <table id="DataTable" class="table table-bordered table-hover table-condensed"> -->
				<thead>
					<tr>
						<th>No. Registrasi</th>
						<th>Nama Pasien</th>
						<th>JK</th>
						<th>Umur</th>
						<th>Alamat</th>
						<th>Telp</th>
						<th>Tgl. Periksa Terakhir</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php if(empty($query)){
					echo '<tr><td colspan="6">Data tidak tersedia.</td></tr>';
					}else{
						foreach($query as $row) :
						?>
					<tr>
						<td><?php echo $row->no_reg;?></td>
						<td><?php echo $row->namalengkap;?></td>
						<td><?php echo $row->jenis_kelamin;?></td>
						<td><?php echo $row->umur;?> Th</td>
						<td><?php echo $row->alamat;?></td>
						<td><?php echo $row->telp;?></td>
						<td><?php echo $row->tanggal;?></td>
						<td><?php echo anchor('terapi/detailhistory/'.$row->id,'<i class="glyphicon glyphicon-search"></i> Detail',array('class'=>'btn btn-sm btn-info'));?></td>
					</tr>	
						<?php
						endforeach;
					}
					?>
				</tbody>				

			</table>
			<ul class="pagination pagination-large pull-right">
				<?php // echo $halaman;?>
			</ul>
			</div>
	 	</div>
	</div>
</div>
<?php $this->load->view('foot'); ?>
	</div>
</div>