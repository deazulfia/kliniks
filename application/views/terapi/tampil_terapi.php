<script type="text/javascript">
	function hapus(id, noreg){
		if(confirm('Yakin mau menghapus data ini?')){
			$(document).ready(function(){
				$.ajax({
					url : '<?php echo site_url();?>/terapi/hapusterapi/'+id,
					beforeSend:function(){
						$('#dataterapi').html('<center><img src="<?php echo base_url();?>assets/img/loading-gede.gif"></center>');
						$('#dataterapi').fadeIn(2500);
					},
					success:function(){
						$("#dataterapi").load("<?php echo site_url(); ?>/terapi/tampilterapi/"+noreg);
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
			<td><?php echo $row->terapi;?></td>
			<td><?php echo $row->etiket;?></td>
			<td><?php echo $row->jml;?></td>
			<!-- <td>
				<a href="#" onclick="hapus('<?php echo $row->id;?>','<?php echo $row->no_reg;?>')" title="Hapus Data Diagnosa" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
			</td> -->
		</tr>
		<?php
	endforeach;
}
?>
</table>