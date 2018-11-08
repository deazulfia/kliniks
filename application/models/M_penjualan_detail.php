<?php
class M_penjualan_detail extends CI_Model
{
	function insert_detail($id_master, $id_obat, $jumlah_beli, $harga_satuan, $sub_total)
	{
		$dt = array(
			'id_penjualan_m' => $id_master,
			'id_obat	' => $id_obat,
			'jumlah_beli' => $jumlah_beli,
			'harga_satuan' => $harga_satuan,
			'total' => $sub_total
		);
		return $this->db->insert('pj_penjualan_detail', $dt);
	}

	function insertBatch($arr){
		return $this->db->insert_batch('pj_penjualan_detail',$arr);
	}

	function insertBatchTindakan($arr){
		return $this->db->insert_batch('pj_penjualan_detail_tindakan',$arr);
	}

	function get_detail($id_penjualan)
	{
		$sql = "
			SELECT 
				b.`kode_obat`,  
				b.`nama_obat`, 
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga_satuan`, 0),',','.') ) AS harga_satuan, 
				a.`harga_satuan` AS harga_satuan_asli, 
				a.`jumlah_beli`,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`total`, 0),',','.') ) AS sub_total,
				a.`total` AS sub_total_asli  
			FROM 
				`pj_penjualan_detail` a 
				LEFT JOIN `obat` b ON a.`id_obat` = b.`id_obat` 
			WHERE 
				a.`id_penjualan_m` = '".$id_penjualan."' 
			ORDER BY 
				a.`id_penjualan_d` ASC 
		";

		return $this->db->query($sql);
	}

	function getDetail($idPenjualan){
		$sql = "
			SELECT 
				b.`kode_obat`,  
				b.`nama_obat`, 
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga_satuan`, 0),',','.') ) AS harga_satuan, 
				a.`harga_satuan` AS harga_satuan_asli, 
				a.`jumlah_beli`,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`total`, 0),',','.') ) AS sub_total,
				a.`total` AS sub_total_asli,
				c.`merk` 
			FROM 
				`pj_penjualan_detail` a 
				LEFT JOIN `obat` b ON a.`id_obat` = b.`id_obat` 
				LEFT JOIN `pj_merk_barang` c ON b.`id_merk_barang` = c.`id_merk_barang` 
			WHERE 
				a.`id_penjualan_m` = '".$idPenjualan."' 
			ORDER BY 
				a.`id_penjualan_d` ASC 
		";

		$data  = $this->db->query($sql);
		return $data->result();
	}

	function get_detail_tindakan($id_penjualan)
	{
		$sql = "
			SELECT 
				b.`kode_tindakan`,  
				b.`nama_tindakan`, 
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga_satuan`, 0),',','.') ) AS harga_satuan, 
				a.`harga_satuan` AS harga_satuan_asli, 
				a.`jumlah_beli`,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`total`, 0),',','.') ) AS sub_total,
				a.`total` AS sub_total_asli  
			FROM 
				`pj_penjualan_detail_tindakan` a 
				LEFT JOIN `master_tindakan` b ON a.`tindakan_id` = b.`tindakan_id` 
			WHERE 
				a.`id_penjualan_m` = '".$id_penjualan."' 
			ORDER BY 
				a.`id_penjualan_dt` ASC 
		";

		return $this->db->query($sql);
	}

	function getDetailTindakan($idPenjualan){
		$sql = "
				SELECT 
				b.`kode_tindakan`,  
				b.`nama_tindakan`, 
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga_satuan`, 0),',','.') ) AS harga_satuan, 
				a.`harga_satuan` AS harga_satuan_asli, 
				a.`jumlah_beli`,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`total`, 0),',','.') ) AS sub_total,
				a.`total` AS sub_total_asli  
			FROM 
				`pj_penjualan_detail_tindakan` a 
				LEFT JOIN `master_tindakan` b ON a.`tindakan_id` = b.`tindakan_id` 
			WHERE 
				a.`id_penjualan_m` = '".$idPenjualan."' 
			ORDER BY 
				a.`id_penjualan_dt` ASC
		";

		$data  = $this->db->query($sql);
		return $data->result();
	}

}