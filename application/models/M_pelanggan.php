<?php
class M_pelanggan extends CI_Model
{
	function get_all()
	{
		return $this->db
			->select('id, no_rm, no_ktp_pasien, nama, tempat_lahir_pasien, tanggal_lahir_pasien, jk_pasien, umur_pasien, alamat, telp, goldar_pasien, riwayat_alergi, email, nama_perusahaan, info_tambahan')
			->where('dihapus', 'tidak')
			->order_by('nama','asc')
			->get('pasien');
	}

	function getcount_pasien(){
        $sql = $this->db->query('SELECT COUNT(*) as no_rm FROM pasien where dihapus = "tidak"');
        return $sql->row();
    }

	function get_baris($id)
	{
		return $this->db
			->select('id, no_rm, no_ktp_pasien, nama, tempat_lahir_pasien, tanggal_lahir_pasien, jk_pasien, umur_pasien, alamat, telp, goldar_pasien, riwayat_alergi, email, nama_perusahaan, info_tambahan')
			->where('id', $id)
			->limit(1)
			->get('pasien');
	}

	function fetch_data_pelanggan($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id`,
				a. `no_rm`,
				a.`no_ktp_pasien`, 
				a.`nama`,
				a.`tempat_lahir_pasien`,
				DATE_FORMAT(a.`tanggal_lahir_pasien`, '%d %b %Y') AS tanggal_lahir_pasien,
				a.`jk_pasien`,
				a.`umur_pasien`,
				a.`alamat`,
				a.`telp`,
				a.`goldar_pasien`,
				a.`riwayat_alergi`,
				a.`email`,
				a.`nama_perusahaan`,
				a.`info_tambahan`,
				DATE_FORMAT(a.`waktu_input`, '%d %b %Y - %H:%i:%s') AS waktu_input 
			FROM 
				`pasien` AS a 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak' 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`no_rm` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`no_ktp_pasien` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`tempat_lahir_pasien` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR DATE_FORMAT(a.`tanggal_lahir_pasien`, '%d %b %Y ') LIKE '%".$this->db->escape_like_str($like_value)."%'  
				OR a.`jk_pasien` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`umur_pasien` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`alamat` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`telp` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`goldar_pasien` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`riwayat_alergi` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`email` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`nama_perusahaan` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`info_tambahan` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR DATE_FORMAT(a.`waktu_input`, '%d %b %Y - %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`no_rm`',
			2 => 'a.`no_ktp_pasien`',
			3 => 'a.`nama`',
			4 => 'a.`tempat_lahir_pasien`',
			5 => 'a.`tanggal_lahir_pasien`',
			6 => 'a.`jk_pasien`',
			7 => 'a.`umur_pasien`',
			8 => 'a.`alamat`',
			9 => 'a.`telp`',
			10 => 'a.`goldar_pasien`',
			11 => 'a.`riwayat_alergi`',
			12 => 'a.`email`',
			13 => 'a.`nama_perusahaan`',
			14 => 'a.`info_tambahan`',
			15 => 'a.`waktu_input`'
		);

		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function tambah_pelanggan($no_rm, $no_ktp_pasien, $nama, $tempat_lahir_pasien, $tanggal_lahir_pasien, $jk_pasien, $umur_pasien, $alamat, $telepon, $goldar_pasien, $riwayat_alergi, $email, $nama_perusahaan, $info, $unique)
	{
		date_default_timezone_set("Asia/Jakarta");

		$dt = array(
			'no_rm' => $no_rm,
			'no_ktp_pasien' => $no_ktp_pasien,
			'nama' => $nama,
			'tempat_lahir_pasien' => $tempat_lahir_pasien,
			'tanggal_lahir_pasien' => $tanggal_lahir_pasien,
			'jk_pasien' => $jk_pasien,
			'umur_pasien' => $umur_pasien,
			'alamat' => $alamat,
			'telp' => $telepon,
			'goldar_pasien' => $goldar_pasien,
			'riwayat_alergi' => $riwayat_alergi,
			'email' => $email,
			'nama_perusahaan' => $nama_perusahaan,
			'info_tambahan' => $info,
			'waktu_input' => date('Y-m-d H:i:s'),
			'dihapus' => 'tidak',
			'kode_unik' => $unique
		);

		return $this->db->insert('pasien', $dt);
	}

	function update_pelanggan($id, $no_rm, $no_ktp_pasien, $nama, $tempat_lahir_pasien, $tanggal_lahir_pasien, $jk_pasien, $umur_pasien, $alamat, $telepon, $goldar_pasien, $riwayat_alergi, $email, $nama_perusahaan, $info)
	{
		$dt = array(
			'no_rm' => $no_rm,
			'no_ktp_pasien' => $no_ktp_pasien,
			'nama' => $nama,
			'tempat_lahir_pasien' => $tempat_lahir_pasien,
			'tanggal_lahir_pasien' => $tanggal_lahir_pasien,
			'jk_pasien' => $jk_pasien,
			'umur_pasien' => $umur_pasien,
			'alamat' => $alamat,
			'telp' => $telepon,
			'goldar_pasien' => $goldar_pasien,
			'riwayat_alergi' => $riwayat_alergi,
			'email' => $email,
			'nama_perusahaan' => $nama_perusahaan,
			'info_tambahan' => $info
		);

		return $this->db
			->where('id', $id)
			->update('pasien', $dt);
	}

	function hapus_pelanggan($id)
	{
		$dt = array(
			'dihapus' => 'ya'
		);

		return $this->db
			->where('id', $id)
			->update('pasien', $dt);
	}

	function get_dari_kode($kode_unik)
	{
		return $this->db
			->select('id')
			->where('kode_unik', $kode_unik)
			->limit(1)
			->get('pasien');
	}
}