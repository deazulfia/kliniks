<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<style>
.footer {
	margin-bottom: 22px;
}
.panel-primary .form-group {
	margin-bottom: 10px;
}
.form-control {
	border-radius: 0px;
	box-shadow: none;
}
.error_validasi { margin-top: 0px; }
</style>

<?php
$level 		= $this->session->userdata('ap_level');
$readonly	= '';
$disabled	= '';
if($level !== 'admin')
{
	$readonly	= 'readonly';
	// $disabled	= 'disabled';
}
?>

<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">

			<div class='row'>
				<div class='col-sm-3'>
					<div class="panel panel-primary">
						<div class="panel-heading"><i class='fa fa-file-text-o fa-fw'></i> Informasi Nota</div>
						<div class="panel-body">

							<div class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-4 control-label">No. Nota</label>
									<div class="col-sm-8">
										<input type='text' name='nomor_nota' class='form-control input-sm' id='nomor_nota' value="<?php echo strtoupper(uniqid()).$this->session->userdata('ap_id_user'); ?>" <?php echo $readonly; ?>>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Tanggal</label>
									<div class="col-sm-8">
										<input type='text' name='tanggal' class='form-control input-sm' id='tanggal' value="<?php echo date('Y-m-d H:i:s'); ?>" <?php echo $disabled; ?>>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Kasir</label>
									<div class="col-sm-8">
										<select name='id_kasir' id='id_kasir' class='form-control input-sm' <?php echo $disabled; ?>>
											<?php
											if($kasirnya->num_rows() > 0)
											{
												foreach($kasirnya->result() as $k)
												{
													$selected = '';
													if($k->id_user == $this->session->userdata('ap_id_user')){
														$selected = 'selected';
													}

													echo "<option value='".$k->id_user."' ".$selected.">".$k->nama."</option>";
												}
											}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Dokter</label>
									<div class="col-sm-8">
										<select name='id_dokter' id='id_dokter' class='form-control input-sm' <?php echo $disabled; ?>>
											<?php
											if($dokternya->num_rows() > 0)
											{
												foreach($dokternya->result() as $d)
												{
													$selected = '';
													if($d->id_dokter == $this->session->userdata('ap_nama')){
														$selected = 'selected';
													}

													echo "<option value='".$d->id_dokter."' ".$selected.">".$d->nama_dokter."</option>";
												}
											}
											?>
										</select>
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="panel panel-primary" id='PelangganArea'>
						<div class="panel-heading"><i class='fa fa-user'></i> Informasi Pasien</div>
						<div class="panel-body">
							<div class="form-horizontal">
								<div class="form-group">
									<div class="col-sm-8">
										<input type='hidden' name='id' class='form-control input-sm' id='id' value="<?php echo $pelanggan->id ?>" <?php echo $readonly; ?>>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">No. RM</label>
									<div class="col-sm-8">
										<input type='text' name='no_rm' class='form-control input-sm' id='no_rm' value="<?php echo $pelanggan->no_rm ?>" <?php echo $readonly; ?>>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Nama Pasien</label>
									<div class="col-sm-8">
										<input type='text' name='nama' class='form-control input-sm' id='nama' value="<?php echo $pelanggan->nama ?>" <?php echo $readonly; ?>>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Alamat</label>
									<div class="col-sm-8">
										<input type='text' name='alamat_pasien' class='form-control input-sm' id='alamat_pasien' value="<?php echo $pelanggan->alamat ?>" <?php echo $readonly; ?>>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Tanggal Lahir </label>
									<div class="col-sm-8">
										<input type='text' name='tanggal_lahir_pasien' class='form-control input-sm' id='tanggal_lahir_pasien' value="<?php echo $pelanggan->tanggal_lahir_pasien ?>" <?php echo $readonly; ?>>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class='col-sm-9'>
					<h5 class='judul-transaksi'>
						<i class='fa fa-shopping-cart fa-fw'></i> Penjualan <i class='fa fa-angle-right fa-fw'></i> Transaksi
						<!-- <a href="<?php echo site_url('penjualan/transaksi'); ?>" class='pull-right'><i class='fa fa-refresh fa-fw'></i> Refresh Halaman</a> -->
					</h5>
					<table class='table table-bordered' id='TabelTransaksi'>
						<thead>
							<tr>
								<th style='width:35px;'>#</th>
								<th style='width:210px;'>Kode obat</th>
								<th>Nama obat</th>
								<th style='width:120px;'>Harga</th>
								<th style='width:75px;'>Qty</th>
								<th style='width:125px;'>Sub Total</th>
								<th style='width:40px;'></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>

					<div class='alert alert-info TotalBayar'>
						<button id='BarisBaru' class='btn btn-default pull-left'><i class='fa fa-plus fa-fw'></i> Baris Baru</button>
						<h2>Total : <span id='TotalBayar'>Rp. 0</span></h2>
						<input type="hidden" id='TotalBayarHidden'>
					</div>

					<div class='row'>
						<div class='col-sm-7'>
							<textarea name='catatan' id='catatan' value='<?php echo $o->kode_obat ?>'class='form-control' rows='2' placeholder="Catatan Transaksi (Jika Ada)" style='resize: vertical; width:83%;'></textarea>
						</div>
						<div class='col-sm-5'>
							<div class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-6 control-label">Bayar</label>
									<div class="col-sm-6">
										<input type='text' name='cash' id='UangCash' class='form-control' onkeypress='return check_int(event)'>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-6 control-label">Kembali</label>
									<div class="col-sm-6">
										<input type='text' id='UangKembali' class='form-control' disabled>
									</div>
								</div>
								<div class='row'>
									<div class='col-sm-6' style='padding-right: 0px;'>
										<!-- <button type='button' class='btn btn-warning btn-block' id='CetakStruk'>
											<i class='fa fa-print'></i> Print
										</button> -->
									</div>
									<div class='col-sm-6'>
										<button type='button' class='btn btn-primary btn-block' id='Simpann'>
											<i class='fa fa-floppy-o'></i> Simpan 
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<br />
				</div>
			</div>

		</div>
	</div>
</div>

<p class='footer'><?php echo config_item('web_footer'); ?></p>

<link rel="stylesheet" type="text/css" href="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.css"/>
<script src="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.js"></script>
<script>
$('#tanggal').datetimepicker({
	lang:'en',
	timepicker:true,
	format:'Y-m-d H:i:s'
});

$(document).ready(function(){

	for(B=1; B<=1; B++){
		BarisBaru();
	}

	$('#id').change(function(){
		if($(this).val() !== '')
		{
			$.ajax({
				url: "<?php echo site_url('penjualan/ajax-pelanggan'); ?>",
				type: "POST",
				cache: false,
				data: "id="+$(this).val(),
				dataType:'json',
				success: function(json){
					$('#telp_pasien').html(json.telp);
					$('#alamat_pasien').html(json.alamat);
					$('#info_tambahan_pasien').html(json.info_tambahan);
				}
			});
		}
		else
		{
			$('#telp_pasien').html('<small><i>Tidak ada</i></small>');
			$('#alamat_pasien').html('<small><i>Tidak ada</i></small>');
			$('#info_tambahan_pasien').html('<small><i>Tidak ada</i></small>');
		}
	});

	$('#BarisBaru').click(function(){
		BarisBaru();
	});

	$("#TabelTransaksi tbody").find('input[type=text],textarea,select').filter(':visible:first').focus();
	// BarisBaru();
});

function BarisBaru()
{
	<?php 
        foreach($obat as $o):
    ?>
	var Nomor = $('#TabelTransaksi tbody tr').length + 1;
	var Baris = "<tr>";
		Baris += "<td>"+Nomor+"</td>";
		Baris += "<td>";
			Baris += "<input type='text' value='<?php echo $o->kode_obat ?>' class='form-control' name='kode_obat[]' id='pencarian_kode' placeholder='Ketik Kode / Nama Obat'>";
			// Baris += "<div id='hasil_pencarian'></div>";
		Baris += "</td>";
		Baris += "<td>";
			Baris += "<input type='text' value='<?php echo $o->nama_obat ?>' class='form-control' name='nama_obat[]'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td>";
			Baris += "<input type='text' value='<?php echo $o->harga ?>' class='form-control' name='harga_satuan[]'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td><input type='text' value='<?php echo $o->jumlahobat ?>' class='form-control' class='form-control' id='jumlah_beli' name='jumlah_beli[]' onkeypress='return check_int(event)'></td>";
		Baris += "<td>";
			Baris += "<input type='hidden' name='sub_total[]'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td><button class='btn btn-default' id='HapusBaris'><i class='fa fa-trash' style='color:red;'></i></button></td>";
		Baris += "</tr>";
	
	$('#TabelTransaksi tbody').append(Baris);
	
	$('#TabelTransaksi tbody tr').each(function(){
		$(this).find('td:nth-child(2) input').focus();
	});
	<?php
        endforeach;
    ?>
	<?php 
        foreach($tindakan as $t):
    ?>
	var Nomor = $('#TabelTransaksi tbody tr').length + 1;
	var Baris = "<tr>";
		Baris += "<td>"+Nomor+"</td>";
		Baris += "<td>";
			Baris += "<input type='text' value='<?php echo $t->kode_tindakan ?>' class='form-control' name='kode_tindakan[]' id='pencarian_kode' placeholder='Ketik Kode / Nama Obat'>";
			Baris += "<div id='hasil_pencarian'></div>";
		Baris += "</td>";
		Baris += "<td>";
			Baris += "<input type='text' value='<?php echo $t->nama_tindakan ?>' class='form-control' name='nama_tindakan[]'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td>";
			Baris += "<input type='text' value='<?php echo $t->biaya ?>' class='form-control' name='biaya[]'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td><input type='text' value='<?php echo $t->jumlahobat ?>' class='form-control' class='form-control' id='jumlah_beli' name='jumlah_beli[]' onkeypress='return check_int(event)'></td>";
		Baris += "<td>";
			Baris += "<input type='hidden' value='<?php echo $t->biaya ?>' name='subtotal[]'>";
			Baris += "<span>Rp. <?php echo $t->biaya ?></span>";
		Baris += "</td>";
		Baris += "<td><button class='btn btn-default' id='HapusBaris'><i class='fa fa-trash' style='color:red;'></i></button></td>";
		Baris += "</tr>";
	
	$('#TabelTransaksi tbody').append(Baris);
	
	$('#TabelTransaksi tbody tr').each(function(){
		$(this).find('td:nth-child(2) input').focus();
	});
	<?php
        endforeach;
    ?>
	
	$('input[name^="jumlah_beli"]').each(function(){
		var e = $.Event('keyup');
		$(this).trigger(e);
	});
	
	HitungTotalBayar();
}


$(document).on('click', '#HapusBaris', function(e){
	e.preventDefault();
	$(this).parent().parent().remove();

	var Nomor = 1;
	$('#TabelTransaksi tbody tr').each(function(){
		$(this).find('td:nth-child(1)').html(Nomor);
		Nomor++;
	});

	HitungTotalBayar();
});


function AutoCompleteGue(Lebar, KataKunci, Indexnya){
	$('div#hasil_pencarian').hide();
	var Lebar = Lebar + 25;

	var Registered = '';
	$('#TabelTransaksi tbody tr').each(function(){
		if(Indexnya !== $(this).index())
		{
			if($(this).find('td:nth-child(2) input').val() !== '')
			{
				Registered += $(this).find('td:nth-child(2) input').val() + ',';
			}
		}
	});

	if(Registered !== ''){
		Registered = Registered.replace(/,\s*$/,"");
	}

	$.ajax({
		url: "<?php echo site_url('penjualan/ajax-kode'); ?>",
		type: "POST",
		cache: false,
		data:'keyword=' + KataKunci + '&registered=' + Registered,
		dataType:'json',
		success: function(json){
			if(json.status == 1)
			{
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').css({ 'width' : Lebar+'px' });
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').show('fast');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').html(json.datanya);
			}
			if(json.status == 0)
			{
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').prop('disabled', true).val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(0);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html('');
			}
		}
	});

	HitungTotalBayar();
}

$(document).on('keyup', '#pencarian_kode', function(e){
	if($(this).val() !== '')
	{
		var charCode = e.which || e.keyCode;
		if(charCode == 40)
		{
			if($('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').length > 0)
			{
				var Selanjutnya = $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').next();
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').removeClass('autocomplete_active');

				Selanjutnya.addClass('autocomplete_active');
			}
			else
			{
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li:first').addClass('autocomplete_active');
			}
		} 
		else if(charCode == 38)
		{
			if($('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').length > 0)
			{
				var Sebelumnya = $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').prev();
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').removeClass('autocomplete_active');
			
				Sebelumnya.addClass('autocomplete_active');
			}
			else
			{
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li:first').addClass('autocomplete_active');
			}
		}
		else if(charCode == 13)
		{
			var Field = $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)');
			var Kodenya = Field.find('div#hasil_pencarian li.autocomplete_active span#kodenya').html();
			var nya = Field.find('div#hasil_pencarian li.autocomplete_active span#nya').html();
			var Harganya = Field.find('div#hasil_pencarian li.autocomplete_active span#harganya').html();
			
			Field.find('div#hasil_pencarian').hide();
			Field.find('input').val(Kodenya);

			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(3)').html(nya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(4) input').val(Harganya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(4) span').html(to_rupiah(Harganya));
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(5) input').removeAttr('disabled').val(1);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(6) input').val(Harganya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(6) span').html(to_rupiah(Harganya));
			
			var IndexIni = $(this).parent().parent().index() + 1;
			var TotalIndex = $('#TabelTransaksi tbody tr').length;
			if(IndexIni == TotalIndex){
				BarisBaru();

				$('html, body').animate({ scrollTop: $(document).height() }, 0);
			}
			else {
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(5) input').focus();
			}
		}
		else 
		{
			AutoCompleteGue($(this).width(), $(this).val(), $(this).parent().parent().index());
		}
	}
	else
	{
		$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian').hide();
	}

	HitungTotalBayar();
});

$(document).on('click', '#daftar-autocomplete li', function(){
	$(this).parent().parent().parent().find('input').val($(this).find('span#kodenya').html());
	
	var Indexnya = $(this).parent().parent().parent().parent().index();
	var Namanya = $(this).find('span#nya').html();
	var Harganya = $(this).find('span#harganya').html();

	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html(Namanya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(Harganya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) span').html(to_rupiah(Harganya));
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').removeAttr('disabled').val(1);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(Harganya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(to_rupiah(Harganya));

	var IndexIni = Indexnya + 1;
	var TotalIndex = $('#TabelTransaksi tbody tr').length;
	if(IndexIni == TotalIndex){
		BarisBaru();
		$('html, body').animate({ scrollTop: $(document).height() }, 0);
	}
	else {
		$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').focus();
	}

	HitungTotalBayar();
});

$(document).on('keyup', '#jumlah_beli', function(){
	// console.log("Masuk");
	var Indexnya = $(this).parent().parent().index();
	var Harga = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val();
	var JumlahBeli = $(this).val();
	var Kodenya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2) input').val();

	$.ajax({
		url: "<?php echo site_url('barang/cek-stok'); ?>",
		type: "POST",
		cache: false,
		data: "kode_obat="+encodeURI(Kodenya)+"&stok="+JumlahBeli,
		dataType:'json',
		success: function(data){
			// console.log (data);
			if(data.status == 1)
			{
				var SubTotal = parseInt(Harga) * parseInt(JumlahBeli);
				if(SubTotal > 0){
					var SubTotalVal = SubTotal;
					SubTotal = to_rupiah(SubTotal);
				} else {
					SubTotal = '';
					var SubTotalVal = 0;
				}

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(SubTotalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(SubTotal);
				HitungTotalBayar();
			}
			if(data.status == 0)
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok, Saya Mengerti</button>");
				$('#ModalGue').modal('show');

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').val('1');
			}
		}
	});
});

$(document).on('keyup', '#jumlah_belii', function(){
	// console.log("Masuk");
	var Indexnya = $(this).parent().parent().index();
	var Harga = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val();
	var JumlahBeli = $(this).val();
	var Kodenya = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2) input').val();

	$.ajax({
		url: "<?php echo site_url('barang/cek-stok'); ?>",
		type: "POST",
		cache: false,
		data: "kode_tindakan="+encodeURI(Kodenya)+"&stok="+JumlahBeli,
		dataType:'json',
		success: function(data){
			if(data.status == 1)
			{
				var SubTotal = parseInt(Harga) * parseInt(JumlahBeli);
				if(SubTotal > 0){
					var SubTotalVal = SubTotal;
					SubTotal = to_rupiah(SubTotal);
				} else {
					SubTotal = '';
					var SubTotalVal = 0;
				}

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(SubTotalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(SubTotal);
				HitungTotalBayar();
			}
			if(data.status == 0)
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok, Saya Mengerti</button>");
				$('#ModalGue').modal('show');

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').val('1');
			}
		}
	});
});


$(document).on('keydown', '#jumlah_beli', function(e){
	var charCode = e.which || e.keyCode;
	if(charCode == 9){
		var Indexnya = $(this).parent().parent().index() + 1;
		var TotalIndex = $('#TabelTransaksi tbody tr').length;
		if(Indexnya == TotalIndex){
			BarisBaru();
			return false;
		}
	}

	HitungTotalBayar();
});

$(document).on('keyup', '#UangCash', function(){
	HitungTotalKembalian();
});

function HitungTotalBayar()
{
	var Total = 0;
	$('#TabelTransaksi tbody tr').each(function(){
		if($(this).find('td:nth-child(6) input').val() > 0)
		{
			var SubTotal = $(this).find('td:nth-child(6) input').val();
			Total = parseInt(Total) + parseInt(SubTotal);
		}
	});

	$('#TotalBayar').html(to_rupiah(Total));
	$('#TotalBayarHidden').val(Total);

	$('#UangCash').val('');
	$('#UangKembali').val('');
}

function HitungTotalKembalian()
{
	var Cash = $('#UangCash').val();
	var TotalBayar = $('#TotalBayarHidden').val();

	if(parseInt(Cash) >= parseInt(TotalBayar)){
		var Selisih = parseInt(Cash) - parseInt(TotalBayar);
		$('#UangKembali').val(to_rupiah(Selisih));
	} else {
		$('#UangKembali').val('');
	}
}

function to_rupiah(angka){
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
        rev2  += rev[i];
        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
            rev2 += '.';
        }
    }
    return 'Rp. ' + rev2.split('').reverse().join('');
}

function check_int(evt) {
	var charCode = ( evt.which ) ? evt.which : event.keyCode;
	return ( charCode >= 48 && charCode <= 57 || charCode == 8 );
}

$(document).on('keydown', 'body', function(e){
	var charCode = ( e.which ) ? e.which : event.keyCode;

	if(charCode == 118) //F7
	{
		BarisBaru();
		return false;
	}

	if(charCode == 119) //F8
	{
		$('#UangCash').focus();
		return false;
	}

	if(charCode == 120) //F9
	{
		CetakStruk();
		return false;
	}

	if(charCode == 121) //F10
	{
		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Konfirmasi');
		$('#ModalContent').html("Apakah anda yakin ingin menyimpan transaksi ini ?");
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='SimpanTransaksi'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
		$('#ModalGue').modal('show');

		setTimeout(function(){ 
	   		$('button#SimpanTransaksi').focus();
	    }, 500);

		return false;
	}
});

$(document).on('click', '#Simpann', function(){
	$('.modal-dialog').removeClass('modal-lg');
	$('.modal-dialog').addClass('modal-sm');
	$('#ModalHeader').html('Konfirmasi');
	$('#ModalContent').html("Apakah anda yakin ingin menyimpan transaksi ini ?");
	$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='SimpanTransaksi'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
	$('#ModalGue').modal('show');

	setTimeout(function(){ 
   		$('button#SimpanTransaksi').focus();
    }, 500);
});

$(document).on('click', 'button#SimpanTransaksi', function(){
	SimpanTransaksi();
});

$(document).on('click', 'button#CetakStruk', function(){
	CetakStruk();
});

function SimpanTransaksi()
{
	var FormData = "nomor_nota="+encodeURI($('#nomor_nota').val());
	FormData += "&tanggal="+encodeURI($('#tanggal').val());
	FormData += "&id_kasir="+$('#id_kasir').val();
	FormData += "&id_dokter="+$('#id_dokter').val();
	FormData += "&id="+$('#id').val();
	FormData += "&" + $('#TabelTransaksi tbody input').serialize();
	FormData += "&cash="+$('#UangCash').val();
	FormData += "&catatan="+encodeURI($('#catatan').val());
	FormData += "&grand_total="+$('#TotalBayarHidden').val();

	$.ajax({
		url: "<?php echo site_url('penjualan/transaksi') . '/' . $auth['id'] . '/' . $auth['no_reg']; ?>",
		type: "POST",
		cache: false,
		data: FormData,
		dataType:'json',
		success: function(data){
			// console.log(data);
			if(data.status == 1)
			{
				alert(data.pesan);
				window.location.href="<?php echo site_url('penjualan/history'); ?>"; 
			}
			else 
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
				$('#ModalGue').modal('show');
			}	
		}
	});
}

$(document).on('click', '#TambahPelanggan', function(e){
	e.preventDefault();

	$('.modal-dialog').removeClass('modal-sm');
	$('.modal-dialog').removeClass('modal-lg');
	$('#ModalHeader').html('Tambah Pelanggan');
	$('#ModalContent').load($(this).attr('href'));
	$('#ModalGue').modal('show');
});

function CetakStruk()
{
	if($('#TotalBayarHidden').val() > 0)
	{
		if($('#UangCash').val() !== '')
		{
			var FormData = "nomor_nota="+encodeURI($('#nomor_nota').val());
			FormData += "&tanggal="+encodeURI($('#tanggal').val());
			FormData += "&id_kasir="+$('#id_kasir').val();
			FormData += "&id_dokter="+$('#id_dokter').val();
			FormData += "&id="+$('#id').val();
			FormData += "&" + $('#TabelTransaksi tbody input').serialize();
			FormData += "&cash="+$('#UangCash').val();
			FormData += "&catatan="+encodeURI($('#catatan').val());
			FormData += "&grand_total="+$('#TotalBayarHidden').val();

			window.open("<?php echo site_url('penjualan/transaksi-cetak/?'); ?>" + FormData,'_blank');
		}
		else
		{
			$('.modal-dialog').removeClass('modal-lg');
			$('.modal-dialog').addClass('modal-sm');
			$('#ModalHeader').html('Oops !');
			$('#ModalContent').html('Harap masukan Total Bayar');
			$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
			$('#ModalGue').modal('show');
		}
	}
	else
	{
		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Oops !');
		$('#ModalContent').html('Harap pilih  terlebih dahulu');
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
		$('#ModalGue').modal('show');

	}
}
</script>

<?php $this->load->view('include/footer'); ?>