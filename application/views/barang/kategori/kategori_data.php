<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<?php
$level = $this->session->userdata('ap_level');
?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='fa fa-cube fa-fw'></i> Barang <i class='fa fa-angle-right fa-fw'></i> List Kategori</h5>
			<hr />

			<div class='table-responsive'>
				<link rel="stylesheet" href="<?php echo config_item('plugin'); ?>datatables/css/dataTables.bootstrap.css"/>
				<table id="my-grid" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Kategori</th>
							<?php if($level == 'admin' OR $level == 'master' OR $level == 'spv' OR $level == 'inventory') { ?>
							<th class='no-sort'>Edit</th>
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
if($level == 'admin' OR $level == 'master' OR $level == 'spv' OR $level == 'inventory')
{
	$tambahan .= nbs(2)."<a href='".site_url('barang/tambah-kategori')."' class='btn btn-default' id='TambahKategori'><i class='fa fa-plus fa-fw'></i> Tambah Kategori</a>";
	$tambahan .= nbs(2)."<span id='Notifikasi' style='display: none;'></span>";
}
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
			"aaSorting": [[ 0, "asc" ]],
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
				url :"<?php echo site_url('barang/list-kategori-json'); ?>",
				type: "post",
				error: function(){ 
					$(".my-grid-error").html("");
					$("#my-grid").append('<tbody class="my-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#my-grid_processing").css("display","none");
				}
			}
		} );
	});
	
	$(document).on('click', '#HapusKategori', function(e){
		e.preventDefault();
		var Link = $(this).attr('href');

		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Konfirmasi');
		$('#ModalContent').html('Apakah anda yakin ingin menghapus <br /><b>'+$(this).parent().parent().find('td:nth-child(2)').html()+'</b> ?');
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='YesDeleteKategori' data-url='"+Link+"'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
		$('#ModalGue').modal('show');
	});

	$(document).on('click', '#YesDeleteKategori', function(e){
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

	$(document).on('click', '#TambahKategori, #EditKategori', function(e){
		e.preventDefault();

		$('.modal-dialog').addClass('modal-sm');
		$('.modal-dialog').removeClass('modal-lg');
		if($(this).attr('id') == 'TambahKategori')
		{
			$('#ModalHeader').html('Tambah Kategori');
		}
		if($(this).attr('id') == 'EditKategori')
		{
			$('#ModalHeader').html('Edit Kategori');
		}
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});
</script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/dataTables.bootstrap.js"></script>

<?php $this->load->view('include/footer'); ?>