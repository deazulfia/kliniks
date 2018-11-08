<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<?php
$level = $this->session->userdata('ap_level');
?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='fa fa-shopping-cart fa-fw'></i> Penjualan <i class='fa fa-angle-right fa-fw'></i> History Penjualan</h5>
			<hr />

			<div class='table-responsive'>
				<link rel="stylesheet" href="<?php echo config_item('plugin'); ?>datatables/css/dataTables.bootstrap.css"/>
				<table id="my-grid" class="table table-striped table-bordered">
					<thead>
						<tr>
							<!-- <th>#</th> -->
							<th>Tanggal</th>
							<th>Nomor Nota</th>
							<th>Grand Total</th>
							<th>Pasien</th>
							<th>Keterangan</th>
							<th>Kasir</th>
							<?php if($level == 'admin' OR $level == 'spv' OR $level == 'master') { ?>
							<th class='no-sort'>Hapus</th>
							<?php } ?>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
<p class='footer'><?php echo config_item('web_footer'); ?></p>

<?php
$tambahan = nbs(2)."<span id='Notifikasi' style='display: none;'></span>";
?>

<script type="text/javascript" language="javascript" >
	$(document).ready(function() {
		var dataTable = $('#my-grid').DataTable( {
			"serverSide": true,
			"stateSave" : false,
			"bAutoWidth": true,
			"oLanguage": {
				"sSearch": "<i class='fa fa-search fa-fw'></i> Pencarian : ",
				"sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per Halaman <?php echo $tambahan; ?>",
				"sInfo": "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
				"sInfoFiltered": "(difilter dari _MAX_ total data)", 
				"sZeroRecords": "Pencarian tidak ditemukan", 
				"sEmptyTable": "Data kosong", 
				"sLoadingRecords": "Harap Tunggu...", 
				"oPaginate": {
					"sPrevious": "Prev",
					"sNext": "Next"
				}
			},
			"aaSorting": [[ 1, "desc" ]],
			"columnDefs": [ 
				{
					"targets": 'no-sort',
					"orderable": false,
				}
	        ],
			"sPaginationType": "simple_numbers", 
			"iDisplayLength": 10,
			"aLengthMenu": [[10, 20, 50, 100, 150], [10, 20, 50, 100, 150]],
			"ajax":{
				url :"<?php echo site_url('penjualan/history-json'); ?>",
				type: "post",
				error: function(){ 
					$(".my-grid-error").html("");
					$("#my-grid").append('<tbody class="my-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#my-grid_processing").css("display","none");
				}
			}
		} );
	});
	
	$(document).on('click', '#HapusTransaksi', function(e){
		e.preventDefault();
		var Link = $(this).attr('href');
		var Check = "<br /><hr style='margin:10px 0px 8px 0px;' /><div class='checkbox'><label><input type='checkbox' name='reverse_stok' value='yes' id='reverse_stok'> Kembalikan stok Obat</label></div>";
		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Konfirmasi');
		$('#ModalContent').html('Apakah anda yakin ingin menghapus transaksi <b>'+$(this).parent().parent().find('td:nth-child(3)').text()+'</b> ?' + Check);
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='YesDelete' data-url='"+Link+"' autofocus>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
		$('#ModalGue').modal('show');
	});

	$(document).on('click', '#YesDelete', function(e){
		e.preventDefault();
		$('#ModalGue').modal('hide');

		var reverse_stok = 'no';
		if($('#reverse_stok').prop('checked')){
			var reverse_stok = 'yes';
		}

		$.ajax({
			url: $(this).data('url'),
			type: "POST",
			cache: false,
			data: "reverse_stok="+reverse_stok,
			dataType:'json',
			success: function(data){
				$('#Notifikasi').html(data.pesan);
				$("#Notifikasi").fadeIn('fast').show().delay(3000).fadeOut('fast');
				$('#my-grid').DataTable().ajax.reload( null, false );
			}
		});
	});

	$(document).on('click', '#LihatDetailTransaksi', function(e){
		e.preventDefault();
		var CaptionHeader = 'Transaksi Nomor Nota ' + $(this).text();
		$('.modal-dialog').removeClass('modal-sm');
		$('.modal-dialog').addClass('modal-lg');
		$('#ModalHeader').html(CaptionHeader);
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal'>Tutup</button>");
		$('#ModalGue').modal('show');
	});
</script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/dataTables.bootstrap.js"></script>

<?php $this->load->view('include/footer'); ?>