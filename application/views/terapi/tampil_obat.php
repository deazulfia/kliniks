<script type="text/javascript">
	function hapus(noreg, pasien_id, obat, tanggal_periksa){
		if(confirm('Yakin mau menghapus data ini?')){
			$(document).ready(function(){
				$.ajax({
					url : '<?php echo site_url();?>/terapi/hapusobat/'+noreg+'/'+pasien_id+'/'+ obat+'/'+tanggal_periksa,
					beforeSend:function(){
						$('#dataobat').html('<img src="<?php echo base_url();?>assets/img/loading-gede.gif">');
						$('#dataobat').fadeIn(2500);
					},
					success:function(){
						$("#dataobat").load("<?php echo site_url(); ?>/terapi/tampilobat/"+noreg);
						$("#notif").html('Data berhasil dihapus');                  
						$("#notif").fadeIn(2500);
						$("#notif").fadeOut(2500);
					}
				});
			});
		}
	}

</script>
<table class="table table-striped">
<?php
if(empty($query)){
	echo '<tr class="danger"><th>Data tidak tersedia</th></tr>';
}else{
	
	foreach($query as $row):
		?>
		
		<tr>
			<td><?php echo $row->kode_obat;?> - <?php echo $row->nama_obat;?> - <?php echo $row->jumlahobat;?> pcs - <?php echo $row->keteranganobat;?></td>
			<!-- <td>
				<a href="#" onclick="hapus('<?php echo $row->no_reg;?>','<?php echo $row->pasien_id;?>','<?php echo $row->obat ?>','<?php echo $row->tanggal_periksa ?>')" title="Hapus Data Diagnosa" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
			</td> -->
		</tr>
		<?php
	endforeach;
}
?>
</table>