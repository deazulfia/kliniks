<script type="text/javascript">
	function hapus(noreg, pasien_id, obat, tanggal){
		if(confirm('Yakin mau menghapus data ini?')){
			$(document).ready(function(){
				$.ajax({
					url : '<?php echo site_url();?>/terapi/hapustindakanobat/'+noreg+'/'+pasien_id+'/'+ obat+'/'+tanggal,
					beforeSend:function(){
						$('#datatindakanobat').html('<img src="<?php echo base_url();?>assets/img/loading-gede.gif">');
						$('#datatindakanobat').fadeIn(2500);
					},
					success:function(){
						$("#datatindakanobat").load("<?php echo site_url(); ?>/terapi/tampiltindakanobat/"+noreg);
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
			<td><?php echo $row->kode_obat;?> - <?php echo $row->nama_obat;?> - <?php echo $row->jumlah;?></td>
			<!-- <td>
				<a href="#" onclick="hapus('<?php echo $row->no_reg;?>','<?php echo $row->pasien_id;?>','<?php echo $row->obat ?>','<?php echo $row->tanggal ?>')" title="Hapus Data Diagnosa" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
			</td> -->
		</tr>
		
		<!-- <tr>
			<th><?php echo form_submit(array('type'=>'button','id'=>'updateobat','value'=>'Tambah','class'=>'btn btn-info'));?></th>
		</tr> -->
		<?php
	endforeach;
	
}

?>

<script type="text/javascript">

	$(document).ready(function() {
		$('input[name="keterangan"]').click(function() 
		{
			var value = $(this).val();
			if( value == "reused")
			{
			$('#jumlah').hide();
			}
			else{
			$('#jumlah').show();
		}
		});
	});
</script>
</table>