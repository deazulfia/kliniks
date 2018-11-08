<div class="container">
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h3 class="panel-title"><b>Resep Pasien</b></h3>
		  </div>
		  <div class="panel-body">
			  <?php echo $this->session->flashdata('pesan');?>
		  <div id="unseen">
			<table class="table table-bordered table-hover table-condensed">
			<thead>
				<tr>
					<th>Resep</th>
					<th>Jumlah Obat</th>
					<th>Keterangan Obat</th>
				</tr>
			</thead>
            <tr>
      </tr>
			<tbody>
				<!-- <tr> -->
                <?php 
        if(empty($obat)){
          echo '<tr><th colspan="2">Data tidak tersedia.</th></tr>';
        }else{
          foreach($obat as $rowresep):
            ?>
            <tr>
              <td><?php echo $rowresep->nama_obat;?></td>
              <td><?php echo $rowresep->jumlahobat;?></td>
              <td><?php echo $rowresep->keteranganobat;?></td>
            </tr>
            <?php
          endforeach;
        }
      ?>
					<!-- <td><span class="label label-danger"><?php echo $no;?></span></td>
					<td><?php echo $obat->nama_obat;?></td>
					<td><?php echo $obat->jumlahobat;?></td>
					<td><?php echo $obat->keteranganobat;?></td>
					
				</tr>	 -->
			</tbody>
		</table>
		</div>
	 </div>
</div>
</div>

</div>
</div>
