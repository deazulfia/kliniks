<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<?php
$level = $this->session->userdata('ap_level');
?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='fa fa-shopping-cart fa-fw'></i> Penjualan <i class='fa fa-angle-right fa-fw'></i> Data Pasien</h5>
			<hr />

			<div class='table-responsive'>
				<link rel="stylesheet" href="<?php echo config_item('plugin'); ?>datatables/css/dataTables.bootstrap.css"/>
				<table id="my-grid" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>ID Pasien</th>
							<th>No RM</th>
							<th>No KTP</th>
							<th>Nama pasien</th>
							<th>Tempat Lahir</th>
							<th>Tanggal Lahir</th>
							<th>Jenis Kelamin</th>
							<th>Umur Pasien</th>
							<th>Alamat</th>
							<th>Telp. / HP</th>
							<th>Golongan Darah</th>
							<th>Riwayat Alergi</th>
							<th>Email</th>
							<th>Nama Perusahaan</th>
							<th>Info Tambahan</th>
							<th>Waktu Input</th>
							
							<?php if($level == 'admin' OR $level == 'master' OR $level == 'spv' OR $level == 'kasir' OR $level == 'keuangan') { ?>
							<th class='no-sort'>Edit</th>
							<?php } ?>

							<?php if($level == 'admin' OR $level == 'master' OR $level == 'spv') { ?>
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
$tambahan = '';
if($level == 'admin' OR $level == 'master' OR $level == 'spv' OR $level == 'kasir' OR $level == 'keuangan')
{
	$tambahan .= nbs(2)."<a href='".site_url('penjualan/tambah-pelanggan')."' class='btn btn-default' id='TambahPelanggan'><i class='fa fa-plus fa-fw'></i> Tambah</a>";
	$tambahan .= nbs(2)."<span id='Notifikasi' style='display: none;'></span>";
}
?>


<script type="text/javascript" language="javascript" >
	$(document).ready(function() {
		var dataTable = $('#my-grid').DataTable( {
			"serverSide": true,
			"stateSave" : false,
			"bAutoWidth": true,
			"scrollX": true,
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
			"aaSorting": [[ 0, "desc" ]],
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
				url :"<?php echo site_url('penjualan/pelanggan-json'); ?>",
				type: "post",
				error: function(){ 
					$(".my-grid-error").html("");
					$("#my-grid").append('<tbody class="my-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#my-grid_processing").css("display","none");
				}
			}
		} );
	});
	
	$(document).on('click', '#HapusPelanggan', function(e){
		e.preventDefault();
		var Link = $(this).attr('href');

		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Konfirmasi');
		$('#ModalContent').html('Apakah anda yakin ingin menghapus data dengan id<br /><b>'+$(this).parent().parent().find('td:nth-child(2)').html()+'</b> ?');
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='YesDeletePelanggan' data-url='"+Link+"'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
		$('#ModalGue').modal('show');
	});

	$(document).on('click', '#YesDeletePelanggan', function(e){
		e.preventDefault();
		$('#ModalGue').modal('hide');

		$.ajax({
			url: $(this).data('url'),
			type: "POST",
			cache: false,
			dataType:'json',
			success: function(data){
				$('#Notifikasi').html(data.pesan);
				$("#Notifikasi").fadeIn('fast').show().delay(3000).fadeOut('fast');
				$('#my-grid').DataTable().ajax.reload( null, false );
			}
		});
	});
	
	$(document).on('click', '#TambahPelanggan, #EditPelanggan', function(e){
		e.preventDefault();

		$('.modal-dialog').removeClass('modal-sm');
		$('.modal-dialog').removeClass('modal-lg');
		if($(this).attr('id') == 'TambahPelanggan')
		{
			$('#ModalHeader').html('Tambah Pelanggan');
		}
		if($(this).attr('id') == 'EditPelanggan')
		{
			$('#ModalHeader').html('Edit Pelanggan');
		}
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});
</script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/dataTables.bootstrap.js"></script>

<?php $this->load->view('include/footer'); ?>