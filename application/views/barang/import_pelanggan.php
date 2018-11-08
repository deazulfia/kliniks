<html>
<head>
	<title>Form Import</title>
	
	<!-- Load File jquery.min.js yang ada difolder js -->
	<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
	
	<script>
	$(document).ready(function(){
		// Sembunyikan alert validasi kosong
		$("#kosong").hide();
	});
	</script>
</head>
<body>
	<h3>Import Data Pasien</h3>
	<hr>
	
	<a href="<?php echo base_url("excel/format-barang.xlsx"); ?>">Download Format</a>
	<br>
	<br>
	
	<!-- Buat sebuah tag form dan arahkan action nya ke controller ini lagi -->
	<form method="post" action="<?php echo base_url("barang/form"); ?>" enctype="multipart/form-data">
		<!-- 
		-- Buat sebuah input type file
		-- class pull-left berfungsi agar file input berada di sebelah kiri
		-->
		<input type="file" name="file">
		
		<!--
		-- BUat sebuah tombol submit untuk melakukan preview terlebih dahulu data yang akan di import
		-->
		<input type="submit" name="preview" value="Preview">
	</form>
	
	<?php
	if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form 
		if(isset($upload_error)){ // Jika proses upload gagal
			echo "<div style='color: red;'>".$upload_error."</div>"; // Muncul pesan error upload
			die; // stop skrip
		}
		
		// Buat sebuah tag form untuk proses import data ke database
		echo "<form method='post' action='".base_url("barang/import")."'>";
		
		// Buat sebuah div untuk alert validasi kosong
		echo "<div style='color: red;' id='kosong'>
		Semua data belum diisi, Ada <span id='jumlah_kosong'></span> data yang belum diisi.
		</div>";
		
		echo "<table border='1' cellpadding='8'>
		<tr>
			<th colspan='5'>Preview Data</th>
		</tr>
		<tr>
			<th>Kode obat</th>
			<th>Nama obat</th>
			<th>Total Stok</th>
			<th>Harga</th>
			<th>Id Kategori</th>
			<th>Id Satuan</th>
			<th>dihapus</th>
		</tr>";
		
		$numrow = 1;
		$kosong = 0;
		
		// Lakukan perulangan dari data yang ada di excel
		// $sheet adalah variabel yang dikirim dari controller
		foreach($sheet as $row){ 
			// Ambil data pada excel sesuai Kolom
			// $nis = $row['A']; // Ambil data NIS
			// $nama = $row['B']; // Ambil data nama
			// $jenis_kelamin = $row['C']; // Ambil data jenis kelamin
			// $alamat = $row['D']; // Ambil data alamat
			$no_rm = $row['A'];
			$no_ktp_pasien = $row['B'];
			$nama = $row['C'];
			$tempat_lahir_pasien = $row['D'];
			$tanggal_lahir_pasien = $row['E'];
			$jk_pasien = $row['F'];
			$umur_pasien = $row['G'];
			$goldar_pasien = $row['H'];
			$telp = $row['I'];
			$riwayat_alergi = $row['J'];
			$alamat = $row['K'];
			$tampil = $row['L'];
			$dihapus = $row['M'];
			
			// Cek jika semua data tidak diisi
			if(empty($no_rm) && empty($nama) && empty($jenis_kelamin) && empty($alamat))
				continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
			
			// Cek $numrow apakah lebih dari 1
			// Artinya karena baris pertama adalah nama-nama kolom
			// Jadi dilewat saja, tidak usah diimport
			if($numrow > 1){
				// Validasi apakah semua data telah diisi
				$no_rm = ( ! empty($no_rm))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
				$no_ktp_pasien = ( ! empty($no_ktp_pasien))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
				$nama = ( ! empty($nama))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
				$tempat_lahir_pasien = ( ! empty($tempat_lahir_pasien))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
				$tanggal_lahir_pasien = ( ! empty($tanggal_lahir_pasien))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
				$jk_pasien = ( ! empty($jk_pasien))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
				$umur_pasien = ( ! empty($umur_pasien))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
				$goldar_pasien = ( ! empty($goldar_pasien))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
				$telp = ( ! empty($telp))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
				$riwayat_alergi = ( ! empty($riwayat_alergi))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
				$alamat = ( ! empty($alamat))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
				// $tampil = ( ! empty($tampil))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
				// $dihapus = ( ! empty($dihapus))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
				
				// Jika salah satu data ada yang kosong
				if(empty($no_rm) or empty($nama) or empty($jenis_kelamin) or empty($alamat)){
					$kosong++; // Tambah 1 variabel $kosong
				}
				
				echo "<tr>";
				echo "<td".$no_rm.">".$no_rm."</td>";
				echo "<td".$no_ktp_pasien.">".$no_ktp_pasien."</td>";
				echo "<td".$nama.">".$nama."</td>";
				echo "<td".$tempat_lahir_pasien.">".$tempat_lahir_pasien."</td>";
				echo "<td".$tanggal_lahir_pasien.">".$tanggal_lahir_pasien."</td>";
				echo "<td".$jk_pasien.">".$jk_pasien."</td>";
				echo "<td".$umur_pasien.">".$umur_pasien."</td>";
				echo "<td".$goldar_pasien.">".$goldar_pasien."</td>";
				echo "<td".$telp.">".$telp."</td>";
				echo "<td".$riwayat_alergi.">".$riwayat_alergi."</td>";
				echo "<td".$alamat.">".$alamat."</td>";
				echo "<td".$tampil.">".$tampil."</td>";
				echo "<td".$dihapus.">".$dihapus."</td>";
				echo "</tr>";
			}
			
			$numrow++; // Tambah 1 setiap kali looping
		}
		
		echo "</table>";
		
		// Cek apakah variabel kosong lebih dari 1
		// Jika lebih dari 1, berarti ada data yang masih kosong
		if($kosong > 1){
		?>	
			<script>
			$(document).ready(function(){
				// Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
				$("#jumlah_kosong").html('<?php echo $kosong; ?>');
				
				$("#kosong").show(); // Munculkan alert validasi kosong
			});
			</script>
		<?php
		}else{ // Jika semua data sudah diisi
			echo "<hr>";
			
			// Buat sebuah tombol untuk mengimport data ke database
			echo "<button type='submit' name='import'>Import</button>";
			echo "<a href='".base_url("penjualan/pelanggan")."'>Cancel</a>";
		}
		
		echo "</form>";
	}
	?>
</body>
</html>
