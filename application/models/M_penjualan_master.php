<?php
class M_penjualan_master extends CI_Model
{
	function insert_master($nomor_nota, $tanggal, $id_kasir, $id_dokter, $id, $bayar, $grand_total, $catatan)
	{
		$dt = array(
			'nomor_nota' => $nomor_nota,
			'tanggal' => $tanggal,
			'grand_total' => $grand_total,
			'bayar' => $bayar,
			'keterangan_lain' => $catatan,
			'id' => (empty($id)) ? NULL : $id,
			'id_user' => $id_kasir,
			'id_dokter' => $id_dokter,
		);

		return $this->db->insert('pj_penjualan_master', $dt);
	}

	function get_id($nomor_nota)
	{
		return $this->db
			->select('id_penjualan_m')
			->where('nomor_nota', $nomor_nota)
			->limit(1)
			->get('pj_penjualan_master');
	}

	function getDetailPenjualan($idNota){
		$data  = $this->db->query("select * from pj_penjualan_master where nomor_nota ='".$idNota."'");
		return $data->row();
	}

	function getDetailPasien($idNota){
		$data  = $this->db->query("select * from pj_penjualan_master left join pasien on pj_penjualan_master.id = pasien.id where nomor_nota ='".$idNota."'");
		return $data->row();
	}

	function getDetailDokter($idNota){
		$data  = $this->db->query("select * from pj_penjualan_master left join dokter on pj_penjualan_master.id_dokter = dokter.id_dokter where nomor_nota ='".$idNota."'");
		return $data->row();
	}

	function getDetailKasir($idNota){
		$data  = $this->db->query("select * from pj_penjualan_master left join pj_user on pj_penjualan_master.id_user = pj_user.id_user where nomor_nota ='".$idNota."'");
		return $data->row();
	}


	function fetch_data_penjualan($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_penjualan_m`, 
				a.`nomor_nota` AS nomor_nota, 
				DATE_FORMAT(a.`tanggal`, '%d %b %Y - %H:%i:%s') AS tanggal,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`grand_total`, 0),',','.') ) AS grand_total,
				IF(b.`nama` IS NULL, 'Umum', b.`nama`) AS nama_pasien,
				c.`nama` AS kasir,
				a.`keterangan_lain` AS keterangan   
			FROM 
				`pj_penjualan_master` AS a 
				LEFT JOIN `pasien` AS b ON a.`id` = b.`id` 
				LEFT JOIN `pj_user` AS c ON a.`id_user` = c.`id_user` 
				, (SELECT @row := 0) r WHERE 1=1 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`nomor_nota` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR DATE_FORMAT(a.`tanggal`, '%d %b %Y - %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`grand_total`, 0),',','.') ) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR IF(b.`nama` IS NULL, 'Umum', b.`nama`) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR c.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`keterangan_lain` LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`tanggal`',
			2 => 'nomor_nota',
			3 => 'a.`grand_total`',
			4 => 'nama_pasien',
			5 => 'keterangan',
			6 => 'kasir'
		);

		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function get_baris($id_penjualan)
	{
		$sql = "
			SELECT 
				a.`nomor_nota`, 
				a.`grand_total`,
				a.`tanggal`,
				a.`bayar`,
				a.`id_user` AS id_kasir,
				a.`id_dokter`,
				a.`id`,
				a.`keterangan_lain` AS catatan,
				b.`nama` AS nama_pasien,
				b.`alamat` AS alamat_pelanggan,
				b.`telp` AS telp_pelanggan,
				b.`info_tambahan` AS info_pelanggan 
			FROM 
				`pj_penjualan_master` AS a 
				LEFT JOIN `pasien` AS b ON a.`id` = b.`id` 
			WHERE 
				a.`id_penjualan_m` = '".$id_penjualan."' 
			LIMIT 1
		";
		return $this->db->query($sql);
	}

	function hapus_transaksi($id_penjualan, $reverse_stok)
	{
		if($reverse_stok == 'yes'){
			$loop = $this->db
				->select('id_obat, jumlah_beli')
				->where('id_penjualan_m', $id_penjualan)
				->get('pj_penjualan_detail');

			foreach($loop->result() as $b)
			{
				$sql = "
					UPDATE `obat` SET `total_stok` = `total_stok` + ".$b->jumlah_beli." 
					WHERE `id_obat` = '".$b->id_obat."' 
				";

				$this->db->query($sql);
			}
		}

		$this->db->where('id_penjualan_m', $id_penjualan)->delete('pj_penjualan_detail');
		return $this->db
			->where('id_penjualan_m', $id_penjualan)
			->delete('pj_penjualan_master');
	}

	function laporan_penjualan($from, $to)
	{
		$sql = "
			SELECT 
				DISTINCT(SUBSTR(a.`tanggal`, 1, 10)) AS tanggal,
				(
					SELECT 
						SUM(b.`grand_total`) 
					FROM 
						`pj_penjualan_master` AS b 
					WHERE 
						SUBSTR(b.`tanggal`, 1, 10) = SUBSTR(a.`tanggal`, 1, 10) 
					LIMIT 1
				) AS total_penjualan 
			FROM 
				`pj_penjualan_master` AS a 
			WHERE 
				SUBSTR(a.`tanggal`, 1, 10) >= '".$from."' 
				AND SUBSTR(a.`tanggal`, 1, 10) <= '".$to."' 
			ORDER BY 
				a.`tanggal` ASC
		";

		return $this->db->query($sql);
	}

	function laporan_penjualan_obat($from, $to)
	{
		$sql = "
			SELECT a.`obat`, a.`jumlahobat`, SUBSTR(a.`tanggal_periksa`, 1, 10) AS tanggal_periksa,
					b. `nama_obat`,
					c. `nama`
			FROM 
				`resep` AS a 
				LEFT JOIN `obat` AS b ON a.`obat` = b.`id_obat`
				LEFT JOIN `pasien` AS c ON a.`pasien_id` = c.`id`
				
			WHERE 
				SUBSTR(a.`tanggal_periksa`, 1, 10) >= '".$from."' 
				AND SUBSTR(a.`tanggal_periksa`, 1, 10) <= '".$to."' 
			ORDER BY 
				a.`tanggal_periksa` ASC
		";

		return $this->db->query($sql);
	}

	function laporan_penjualan_obat_masuk($from, $to)
	{
		$sql = "
			SELECT a.`obat`, a.`total_stok`, SUBSTR(a.`tanggal`, 1, 10) AS tanggal,
					b. `nama_obat`,
					c. `nama`
			FROM 
				`barang_masuk` AS a 
				LEFT JOIN `obat` AS b ON a.`obat` = b.`id_obat`
				LEFT JOIN `pj_user` AS c ON a.`user` = c.`id_user`
			WHERE 
				SUBSTR(a.`tanggal`, 1, 10) >= '".$from."' 
				AND SUBSTR(a.`tanggal`, 1, 10) <= '".$to."' 
			ORDER BY 
				a.`tanggal` ASC
		";

		return $this->db->query($sql);
	}

	function cek_nota_validasi($nota)
	{
		return $this->db->select('nomor_nota')->where('nomor_nota', $nota)->limit(1)->get('pj_penjualan_master');
	}
}