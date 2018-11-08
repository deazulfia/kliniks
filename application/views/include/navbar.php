<?php
$controller = $this->router->fetch_class();
$level = $this->session->userdata('ap_level');
?>

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<!-- <a class="navbar-brand" href="<?php echo site_url(); ?>">
				<img alt="<?php echo config_item('web_title'); ?>" src="<?php echo config_item('img'); ?>klinik.png">
			</a> -->
		</div>

		<!-- <p class="navbar-text">Anda login sebagai <?php echo $this->session->userdata('ap_level_caption'); ?></p> -->

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">

				<?php if($level == 'admin' OR $level == 'keuangan' OR $level == 'spv' OR $level == 'kasir' OR $level == 'master' OR $level == 'marketing' ) { ?>
				<li class="dropdown <?php if($controller == 'penjualan') { echo 'active'; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class='fa fa-shopping-cart fa-fw'></i> Transaksi & Data Pasien <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<!-- <?php if($level !== 'keuangan' OR $level !== 'marketing' OR $level == 'kasir' OR $level == 'master' ){ ?>
						<li><a href="<?php echo site_url('penjualan/transaksi'); ?>">Transaksi</a></li>
						<?php } ?> -->
						<li><a href="<?php echo site_url('penjualan/history'); ?>">History Transaksi</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo site_url('penjualan/pelanggan'); ?>">Data Pasien</a></li>
					</ul>
				</li>
				<?php } ?>
				
				<?php if($level == 'admin' OR $level == 'keuangan' OR $level == 'spv' OR $level == 'master' OR $level == 'dokter' OR $level == 'marketing' OR $level == 'inventory') { ?>
				<li class="dropdown <?php if($controller == 'barang') { echo 'active'; } ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class='fa fa-cube fa-fw'></i> Data Obat <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('barang'); ?>">Data Obat</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo site_url('barang/list-merek'); ?>">Data List Satuan</a></li>
						<li><a href="<?php echo site_url('barang/list-kategori'); ?>">Data List Kategori</a></li>
						<li><a href="<?php echo site_url('barang/list-tindakan'); ?>">Data List Tindakan</a></li>
					</ul>
				</li>
				<?php } ?>

				<?php if($level == 'admin' OR $level == 'master') { ?>
					<li <?php if($controller == 'dokter') { echo "class='active'"; } ?>><a href="<?php echo site_url('dokter/list-dokter'); ?>"><i class='fa fa-user-md fa-fw'></i> Data Dokter</a></li>
				<?php } ?>

				<?php if($level == 'admin' OR $level == 'master' OR $level == 'spv' OR $level == 'master' OR $level == 'kasir') { ?>
					<li <?php if($controller == 'pasien') { echo "class='active'"; } ?>><a href="<?php echo site_url('pasien/index'); ?>"><i class='fa fa-file-text-o fa-fw'></i> Pendaftaran</a></li>
				<?php } ?>

				<!-- <?php if($level == 'admin' OR $level == 'master') { ?>
					<li <?php if($controller == 'resep_admin') { echo "class='active'"; } ?>><a href="<?php echo site_url('resep_admin'); ?>"><i class='fa fa-users fa-fw'></i> Resep Admin</a></li>
				<?php } ?> -->
	
				<!-- <?php if($level == 'dokter' OR $level == 'master') { ?>
					<li <?php if($controller == 'pasien_daftar') { echo "class='active'"; } ?>><a href="<?php echo site_url('pasien_daftar/index'); ?>"><i class='fa fa-file-text-o fa-fw'></i> Daftar Pasien Datang</a></li>
				<?php } ?> -->

				<?php if($level == 'admin' OR $level == 'master' OR $level == 'keuangan' OR $level == 'marketing' OR $level == 'spv' OR $level == 'keuangan') { ?>
				<li <?php if($controller == 'laporan') { echo "class='active'"; } ?>><a href="<?php echo site_url('laporan'); ?>"><i class='fa fa-file-text-o fa-fw'></i> Laporan Penjualan</a></li>
				<?php } ?>

				<?php if($level == 'admin' OR $level == 'master' OR $level == 'keuangan' OR $level == 'marketing' OR $level == 'spv' OR $level == 'keuangan') { ?>
				<li <?php if($controller == 'laporan_obat') { echo "class='active'"; } ?>><a href="<?php echo site_url('laporan_obat'); ?>"><i class='fa fa-file-text-o fa-fw'></i> Laporan Obat Keluar</a></li>
				<?php } ?>

				<?php if($level == 'admin' OR $level == 'master' OR $level == 'keuangan' OR $level == 'marketing' OR $level == 'spv' OR $level == 'keuangan') { ?>
				<li <?php if($controller == 'laporan_obat_masuk') { echo "class='active'"; } ?>><a href="<?php echo site_url('laporan_obat_masuk'); ?>"><i class='fa fa-file-text-o fa-fw'></i> Laporan Obat Masuk</a></li>
				<?php } ?>

				<?php if($level == 'admin' OR $level == 'master') { ?>
				<li <?php if($controller == 'user') { echo "class='active'"; } ?>><a href="<?php echo site_url('user'); ?>"><i class='fa fa-users fa-fw'></i> List User</a></li>
				<?php } ?>

				<?php if($level == 'dokter' OR $level == 'master' ) { ?>
				<li <?php if($controller == 'terapi') { echo "class='active'"; } ?>><a href="<?php echo site_url('terapi/index'); ?>"><i class='fa fa-users fa-fw'></i>Daftar Pasien</a></li>
				<?php } ?>

				<?php if($level == 'dokter' OR $level == 'master' OR $level == 'kasir' OR $level == 'spv' OR $level == 'master') { ?>
					<li <?php if($controller == 'resepp') { echo "class='active'"; } ?>><a href="<?php echo site_url('resepp'); ?>"><i class='fa fa-archive fa-fw'></i> Resep</a></li>
				<?php } ?>

				<!-- <?php if($level == 'dokter' OR $level == 'master') { ?>
				<li <?php if($controller == 'help') { echo "class='active'"; } ?>><a href="<?php echo site_url('help/doctor'); ?>"><i class='fa fa-help fa-fw'></i>Help</a></li>
				<?php } ?> -->
				
				<!-- <?php if($level == 'admin') { ?>
				<li <?php if($controller == 'beranda') { echo "class='active'"; } ?>><a href="<?php echo site_url('beranda'); ?>"><i class='fa fa-users fa-fw'></i> Beranda</a></li>
				<?php } ?> -->
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class='fa fa-user fa-fw'></i> <?php echo $this->session->userdata('ap_nama'); ?> <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('user/ubah-password'); ?>" id='GantiPass'>Ubah Password</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo site_url('secure/logout'); ?>"><i class='fa fa-sign-out fa-fw'></i> Log Out</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>

<script>
$(document).on('click', '#GantiPass', function(e){
	e.preventDefault();

	$('.modal-dialog').removeClass('modal-lg');
	$('.modal-dialog').addClass('modal-sm');
	$('#ModalHeader').html('Ubah Password');
	$('#ModalContent').load($(this).attr('href'));
	$('#ModalGue').modal('show');
});
</script>