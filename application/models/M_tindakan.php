<?php
class M_tindakan extends CI_Model 
{
	function get_all()
	{
		return $this->db
			->select('tindakan_id, kode_tindakan, nama_tindakan, biaya')
			->where('dihapus', 'tidak')
			->order_by('nama_tindakan', 'DESC')
			->get('master_tindakan');
	}

	function fetch_data_tindakan($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				tindakan_id, 
				kode_tindakan,
				nama_tindakan,
				biaya  
			FROM 
				`master_tindakan`, (SELECT @row := 0) r WHERE 1=1
				AND dihapus = 'tidak' 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				kode_tindakan LIKE '%".$this->db->escape_like_str($like_value)."%' 
				nama_tindakan LIKE '%".$this->db->escape_like_str($like_value)."%' 
				biaya LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'kode_tindakan',
			2 => 'nama_tindakan',
			3 => 'biaya'

		);
		
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function tambah_tindakan($kode_tindakan, $nama_tindakan, $biaya)
	{
		$dt = array(
			'kode_tindakan' => $kode_tindakan,
			'nama_tindakan' => $nama_tindakan,
			'biaya' => $biaya,
			'dihapus' => 'tidak'
		);

		return $this->db->insert('master_tindakan', $dt);
	}

	function hapus_tindakan($tindakan_id)
	{
		$dt = array(
			'dihapus' => 'ya'
		);

		return $this->db
			->where('tindakan_id', $tindakan_id)
			->update('master_tindakan', $dt);
	}

	function get_baris($tindakan_id)
	{
		return $this->db
			->select('tindakan_id, kode_tindakan, nama_tindakan, biaya')
			->where('tindakan_id', $tindakan_id)
			->limit(1)
			->get('master_tindakan');
	}

	function update_tindakan($tindakan_id, $kode_tindakan, $nama_tindakan, $biaya)
	{
		$dt = array(
			'kode_tindakan' => $kode_tindakan,
			'nama_tindakan' => $nama_tindakan,
			'biaya' => $biaya
		);

		return $this->db
			->where('tindakan_id', $tindakan_id)
			->update('master_tindakan', $dt);
	}

	function get_id($kode_tindakan)
	{
		$sql = "select tindakan_id, nama_tindakan from master_tindakan where kode_tindakan='". $kode_tindakan ."' limit 1";
		$data = $this->db->query($sql);

		return $data->row() ;
	}
}