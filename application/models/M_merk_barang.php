<?php
class M_merk_barang extends CI_Model 
{
	function get_all()
	{
		return $this->db
			->select('id_merk_barang, merk')
			->where('dihapus', 'tidak')
			->order_by('merk', 'asc')
			->get('pj_merk_barang');
	}


	function fetch_data_merek($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				id_merk_barang, 
				merk 
			FROM 
				`pj_merk_barang`, (SELECT @row := 0) r WHERE 1=1 
				AND dihapus = 'tidak' 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				merk LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'merk'
		);
		
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function tambah_merek($merek)
	{
		$dt = array(
			'merk' => $merek,
			'dihapus' => 'tidak'
		);

		return $this->db->insert('pj_merk_barang', $dt);
	}

	function hapus_merek($id_merk_barang)
	{
		$dt = array(
			'dihapus' => 'ya'
		);

		return $this->db
			->where('id_merk_barang', $id_merk_barang)
			->update('pj_merk_barang', $dt);
	}

	function get_baris($id_merk_barang)
	{
		return $this->db
			->select('id_merk_barang, merk')
			->where('id_merk_barang', $id_merk_barang)
			->limit(1)
			->get('pj_merk_barang');
	}

	function update_merek($id_merk_barang, $merek)
	{
		$dt = array(
			'merk' => $merek
		);

		return $this->db
			->where('id_merk_barang', $id_merk_barang)
			->update('pj_merk_barang', $dt);
	}
}