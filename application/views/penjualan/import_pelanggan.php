<html>
<head>
	<title>Klinik Get Medik</title>
	<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
	
	<script>
	$(document).ready(function(){
		$("#kosong").hide();
	});
	</script>
</head>
<body>
	<h3>Import Data Pasien</h3>
	<hr>
	
	<a href="<?php echo base_url("excel/format.xlsx"); ?>">Download Format</a>
	<br>
	<br>
	<form method="post" action="<?php echo base_url("pasien/form"); ?>" enctype="multipart/form-data">
		<input type="file" name="file">
		<input type="submit" name="preview" value="Preview">
	</form>
	
	<?php
	if(isset($_POST['preview'])){ 
		if(isset($upload_error)){ 
			echo "<div style='color: red;'>".$upload_error."</div>"; 
			die; 
		}
		
		echo "<form method='post' action='".base_url("pasien/import")."'>";

		echo "<div style='color: red;' id='kosong'>
		Semua data belum diisi, Ada <span id='jumlah_kosong'></span> data yang belum diisi.
		</div>";
		
		echo "<table border='1' cellpadding='8'>
		<tr>
			<th colspan='5'>Preview Data</th>
		</tr>
		<tr>
			<th>No rm</th>
			<th>No KTP</th>
			<th>Nama</th>
			<th>Tempat</th>
			<th>tanggal</th>
			<th>jk</th>
			<th>umur</th>
			<th>goldar</th>
			<th>telp</th>
			<th>riwayat</th>
			<th>alamat</th>
			<th>email</th>
			<th>nama perusahaan</th>
			<th>info tambahan</th>
			<th>keterangan</th>
		</tr>";
		
		$numrow = 1;
		$kosong = 0;
		
		// Lakukan perulangan dari data yang ada di excel
		// $sheet adalah variabel yang dikirim dari controller
		foreach($sheet as $row){ 
			// Ambil data pada excel sesuai Kolom
			$no_rm = $row['A']; // Ambil data NIS
			$no_ktp_pasien = $row['B']; // Ambil data nama
			$nama = $row['C']; // Ambil data jenis kelamin
			$tempat_lahir_pasien = $row['D']; // Ambil data alamat
			$tanggal_lahir_pasien = $row['E']; // Ambil data NIS
			$jk_pasien = $row['F']; // Ambil data nama
			$umur_pasien = $row['G']; // Ambil data jenis kelamin
			$goldar_pasien = $row['H']; // Ambil data alamat
			$telp = $row['I']; // Ambil data NIS
			$riwayat_alergi = $row['J']; // Ambil data nama
			$alamat = $row['K']; // Ambil data jenis kelamin
			$email_pasien = $row['L']; // Ambil data alamat
			$nama_perusahaan = $row['M']; // Ambil data NIS
			$info_tambahan = $row['N']; // Ambil data nama
			$keterangan = $row['O']; // Ambil data jenis kelamin
			
			// Cek jika semua data tidak diisi
			if(empty($no_rm) && empty($no_ktp_pasien) && empty($nama) && empty($alamat))
				continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
			
			// Cek $numrow apakah lebih dari 1
			// Artinya karena baris pertama adalah nama-nama kolom
			// Jadi dilewat saja, tidak usah diimport
			if($numrow > 1){
				// Validasi apakah semua data telah diisi
				$no_rm_td = ( ! empty($no_rm))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
				$no_ktp_pasien_td = ( ! empty($no_ktp_pasien))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
				$nama_td = ( ! empty($nama))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
				$tempat_lahir_pasien_td = ( ! empty($tempat_lahir_pasien))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
				$tanggal_lahir_pasien_td = ( ! empty($tanggal_lahir_pasien))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
				$jk_pasien_td = ( ! empty($jk_pasien))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
				$umur_pasien_td = ( ! empty($umur_pasien))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
				$goldar_pasien_td = ( ! empty($goldar_pasien))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
				$telp_td = ( ! empty($telp))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
				$riwayat_alergi_td = ( ! empty($riwayat_alergi))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
				$alamat_td = ( ! empty($alamat))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
				$email_pasien_td = ( ! empty($email_pasien))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
				$nama_perusahaan_td = ( ! empty($nama_perusahaan))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
				$info_tambahan_td = ( ! empty($info_tambahan))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
				$keterangan_td = ( ! empty($keterangan))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
				
				// Jika salah satu data ada yang kosong
				if(empty($nis) or empty($nama) or empty($jenis_kelamin) or empty($alamat)){
					$kosong++; // Tambah 1 variabel $kosong
				}
				
				echo "<tr>";
				echo "<td".$no_rm_td.">".$no_rm."</td>";
				echo "<td".$no_ktp_pasien_td.">".$no_ktp_pasien."</td>";
				echo "<td".$nama_td.">".$nama."</td>";
				echo "<td".$tempat_lahir_pasien_td.">".$tempat_lahir_pasien."</td>";
				echo "<td".$tanggal_lahir_pasien_td.">".$tanggal_lahir_pasien."</td>";
				echo "<td".$jk_pasien_td.">".$jk_pasien."</td>";
				echo "<td".$umur_pasien_td.">".$umur_pasien."</td>";
				echo "<td".$goldar_pasien_td.">".$goldar_pasien."</td>";
				echo "<td".$telp_td.">".$telp."</td>";
				echo "<td".$riwayat_alergi_td.">".$riwayat_alergi."</td>";
				echo "<td".$alamat_td.">".$alamat."</td>";
				echo "<td".$email_pasien_td.">".$email_pasien."</td>";
				echo "<td".$nama_perusahaan_td.">".$nama_perusahaan."</td>";
				echo "<td".$info_tambahan_td.">".$info_tambahan."</td>";
				echo "<td".$keterangan_td.">".$keterangan."</td>";
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
