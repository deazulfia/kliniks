<?php
if( ! empty($master->id))
{
	echo "
		<table class='info_pelanggan'>
			<tr>
				<td>Nama Pelanggan</td>
				<td>:</td>
				<td>".$master->nama_pasien."</td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<td>".preg_replace("/\r\n|\r|\n/",'<br />', $master->alamat_pelanggan)."</td>
			</tr>
			<tr>
				<td>Telp. / HP</td>
				<td>:</td>
				<td>".$master->telp_pelanggan."</td>
			</tr>
			<tr>
				<td>Informasi Tambahan</td>
				<td>:</td>
				<td>".preg_replace("/\r\n|\r|\n/",'<br />', $master->info_pelanggan)."</td>
			</tr>	
		</table>
		<hr />
	";
}
else
{
	echo "Pelanggan : Umum";
}
?>

<input type="hidden" id="nomor_nota" value="<?php echo html_escape($master->nomor_nota); ?>">
<input type="hidden" id="tanggal" value="<?php echo $master->tanggal; ?>">
<input type="hidden" id="id_kasir" value="<?php echo $master->id_kasir; ?>">
<input type="hidden" id="id_dokter" value="<?php echo $master->id_dokter; ?>">
<input type="hidden" id="id" value="<?php echo $master->id; ?>">
<input type="hidden" id="UangCash" value="<?php echo $master->bayar; ?>">
<input type="hidden" id="catatan" value="<?php echo html_escape($master->catatan); ?>">
<input type="hidden" id="TotalBayarHidden" value="<?php echo $master->grand_total; ?>">

<table id="my-grid" class="table tabel-transaksi" style='margin-bottom: 0px; margin-top: 10px;'>
	<thead>
		<tr>
			<th>#</th>
			<th>Kode Obat</th>
			<th>Nama Obat</th>
			<th>Harga Satuan</th>
			<th>Jumlah Beli</th>
			<th>Sub Total</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no 			= 1;
	foreach($detail->result() as $d)
	{
		echo "
			<tr>
				<td>".$no."</td>
				<td>".$d->kode_obat." <input type='hidden' name='kode_obat[]' value='".html_escape($d->kode_obat)."'></td>
				<td>".$d->nama_obat."</td>
				<td>".$d->harga_satuan." <input type='hidden' name='harga_satuan[]' value='".$d->harga_satuan_asli."'></td>
				<td>".$d->jumlah_beli." <input type='hidden' name='jumlah_beli[]' value='".$d->jumlah_beli."'></td>
				<td>".$d->sub_total." <input type='hidden' name='sub_total[]' value='".$d->sub_total_asli."'></td>
			</tr>
		";

		$no++;
	}
	?>
	<thead>
		<tr>
			<th>#</th>
			<th>Kode Tindakan</th>
			<th>Nama Tindakan</th>
			<th>Harga Satuan</th>
			<th>Jumlah Beli</th>
			<th>Sub Total</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no 			= 1;
	foreach($tindakan->result() as $dt)
	{
		echo "
			<tr>
				<td>".$no."</td>
				<td>".$dt->kode_tindakan." <input type='hidden' name='kode_obat[]' value='".html_escape($d->kode_obat)."'></td>
				<td>".$dt->nama_tindakan."</td>
				<td>".$dt->harga_satuan." <input type='hidden' name='harga_satuan[]' value='".$d->harga_satuan_asli."'></td>
				<td>".$dt->jumlah_beli." <input type='hidden' name='jumlah_beli[]' value='".$d->jumlah_beli."'></td>
				<td>".$dt->sub_total." <input type='hidden' name='sub_total[]' value='".$d->sub_total_asli."'></td>
			</tr>
		";

		$no++;
	}

	echo "
		<tr style='background:#E26868;'>
			<td colspan='5' style='text-align:right;'><b>Grand Total</b></td>
			<td><b>Rp. ".str_replace(',', '.', number_format($master->grand_total))."</b></td>
		</tr>
		<tr>
			<td colspan='5' style='text-align:right; border:0px;'>Bayar</td>
			<td style='border:0px;'>Rp. ".str_replace(',', '.', number_format($master->bayar))."</td>
		</tr>
		<tr>
			<td colspan='5' style='text-align:right; border:0px;'>Kembali</td>
			<td style='border:0px;'>Rp. ".str_replace(',', '.', number_format(($master->bayar - $master->grand_total)))."</td>
		</tr>
	";
	?>
	</tbody>
</table>

<script>
$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='Cetaks'><i class='fa fa-print'></i> Cetak</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$('button#Cetaks').click(function(){
		var FormData = "nomor_nota="+encodeURI($('#nomor_nota').val());
		FormData += "&tanggal="+encodeURI($('#tanggal').val());
		FormData += "&id_kasir="+$('#id_kasir').val();
		FormData += "&id_dokter="+$('#id_dokter').val();
		FormData += "&id="+$('#id').val();
		FormData += "&" + $('.tabel-transaksi tbody input').serialize();
		FormData += "&cash="+$('#UangCash').val();
		FormData += "&catatan="+encodeURI($('#catatan').val());
		FormData += "&grand_total="+$('#TotalBayarHidden').val();
		var url = "<?php echo site_url('penjualan/cetakpdf/'); ?>" +"/"+ $('#nomor_nota').val();
		
		window.open(url ,'_blank');
	});
});
</script>