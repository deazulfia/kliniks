<?php $this->load->view('head'); ?>
<div class="container">
	<div class="row">

	<div class="col-md-12 col-sm-12 col-lg-12">
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><b>Detail History Pasien</b></h3>
	  </div>
	  <div class="panel-body">
		  <table class="table table-striped">
		  	<tr>
		  		<th width="10%">No. Rekam Medis</th>
		  		<th width="5%">:</th>
		  		<th width="55%">NRP<?php echo $pasien->id;?>
		  		</th>
		  	</tr>
		  	<tr>
		  		<th>Nama Pasien</th>
		  		<th>:</th>
		  		<th><?php echo $pasien->namalengkap;?></th>
		  	</tr>
		  	<tr>
		  		<th>Jenis Kelamin</th>
		  		<th>:</th>
		  		<th><?php echo $pasien->jenis_kelamin;?></th>
		  	</tr>
		  	<tr>	
		  		<th>Umur</th>
		  		<th>:</th>
		  		<th><?php echo $pasien->umur;?> Th</th>
		  	</tr>
		  	<tr>	
		  		<th>Alamat</th>
		  		<th>:</th>
		  		<th><?php echo $pasien->alamat;?></th>
		  	</tr>
		  	
		  </table>
		  <?php echo anchor('terapi/cetakhistory/'.$pasien->id,'<i class="glyphicon glyphicon-print"></i> Cetak Data', 
		  		array('class'=>'btn btn-info','target'=>'_blank'));?>
		  <hr>
		  <h4>Data Medik Pasien</h4>
		  <hr>
		  <div id="notif" class="alert alert-danger" style="display:none;"></div>
		  <div role="tabpanel">
		  	<ul class="nav nav-tabs" role="tablist">
		  		<li role="periksa" class="active">
		  			<a href="#keluhan" aria-controls="keluhan" role="tab" data-toggle="tab">Keluhan</a>
		  		</li>
		  		<li role="periksa">
		  			<a href="#diagnosa" aria-controls="diagnosa" role="tab" data-toggle="tab">Diagnosa</a>
		  		</li>
		  		<li role="periksa">
		  			<a href="#tindakan" aria-controls="tindakan" role="tab" data-toggle="tab">Tindakan</a>
		  		</li>
		  		<li role="periksa">
		  			<a href="#terapi" aria-controls="terapi" role="tab" data-toggle="tab">Resep</a>
		  		</li>
		  	</ul>
		  	<div class="tab-content">
		  		<div role="tabpanel" class="tab-pane active" id="keluhan">
		  			<table class="table">
			  			<tr>
			  				<th>Tanggal</th>
			  				<th>Keluhan</th>
			  			</tr>
			  			<?php
			  				if(empty($keluhan)){
			  					echo '<tr><th>Data tidak tersedia</th></tr>';
			  				}else{
			  					foreach($keluhan as $rowkeluhan):
			  						?>
			  						<tr>
							          <td><?php echo $rowkeluhan->tanggal;?></td>
							          <td><?php echo $rowkeluhan->keluhan;?></td>
        							</tr>
			  						<?php
			  						endforeach;
			  				}
			  			?>	
			  		</table>
		  		</div>
			  	<div role="tabpanel" class="tab-pane" id="diagnosa">
			  		<table class="table">
			  			<tr>
			  				<th>Tanggal</th>
			  				<th>Diagnosa</th>
			  			</tr>
			  			<?php
			  				if(empty($diagnosa)){
			  					echo '<tr><th>Data tidak tersedia</th></tr>';
			  				}else{
			  					foreach($diagnosa as $rowdiagnosa):
			  						?>
			  						<tr>
							          <td><?php echo $rowdiagnosa->tanggal;?></td>
							          <td><?php echo $rowdiagnosa->nama_penyakit;?></td>
        							</tr>
			  						<?php
			  						endforeach;
			  				}
			  			?>	
			  		</table>
			  		
			  	</div>
			  	<div role="tabpanel" class="tab-pane" id="tindakan">
			  		<table class="table">
			  			<tr>
			  				<th>Tanggal</th>
			  				<th>Tindakan</th>			  				
			  			</tr>
			  			<?php
			  				if(empty($tindakan)){
			  					echo '<tr><th>Data tidak tersedia</th></tr>';
			  				}else{
			  					foreach($tindakan as $rowtindakan):
			  						?>
			  						<tr>
			  						  <td><?php echo $rowtindakan->tanggal;?></td>
							          <td><?php echo $rowtindakan->nama_tindakan;?></td>							    
        							</tr>
			  						<?php
			  						endforeach;
			  				}
			  			?>	
			  		</table>		
			  	</div>
			  	<div role="tabpanel" class="tab-pane" id="terapi">
			  		<table class="table">
			  			<tr>
			  				<th>Tanggal</th>
			  				<th>Resep Dokter</th>
			  				<!-- <th>Anjuran Minum Obat (ex: 3X1)</th>
			  				<th>Jumlah</th> -->
			  			</tr>
			  			<?php
			  				if(empty($terapi)){
			  					echo '<tr><th>Data tidak tersedia</th></tr>';
			  				}else{
			  					foreach($terapi as $rowterapi):
			  						?>
			  						<tr>
			  						  <td><?php echo $rowterapi->tanggal;?></td>	
			  						  <td>
			  						  	<?php if($rowterapi->resep!=''): ?>
										<a class="fancyimg" href="<?php echo base_url();?>assets/img/resep/<?php echo $rowterapi->resep;?>"><img src="<?php echo base_url();?>assets/img/resep/<?php echo $rowterapi->resep;?>" alt="" height="50px" width="50px"/></a>
										<?php endif;?>
			  						  </td>	
							          <!-- <td><?php #echo $rowterapi->terapi;?></td>
							          <td><?php #echo $rowterapi->etiket;?></td>
							          <td><?php #echo $rowterapi->jml;?></td> -->
        							</tr>
			  						<?php
			  						endforeach;
			  				}
			  			?>	
			  		</table>
			  	</div>
		  	</div>

		  </div>		  
	  </div>
	</div>
</div>
<?php $this->load->view('foot'); ?>
	</div>
</div>