<?php
class M_dokter extends CI_Model 
{
	function get_all()
	{
		return $this->db
			->select('id_dokter, sip, nama_dokter, spesialis')
			->where('dihapus', 'tidak')
			->order_by('id_dokter', 'asc')
			->get('dokter');
	}

	function fetch_data_dokter($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				id_dokter,
				sip,
				nama_dokter,
				spesialis,
				active
			FROM 
				`dokter`, (SELECT @row := 0) r WHERE 1=1 
				AND dihapus = 'tidak' 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				sip LIKE '%".$this->db->escape_like_str($like_value)."%' 
				nama_dokter LIKE '%".$this->db->escape_like_str($like_value)."%' 
				spesialis LIKE '%".$this->db->escape_like_str($like_value)."%'
				active LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'sip',
			2 => 'nama_dokter',
			3 => 'spesialis',
			4 => 'active'
		);
		
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function tambah_dokter($sip, $nama_dokter, $spesialis, $active)
	{
		$dt = array(
			'sip' => $sip,
			'nama_dokter' => $nama_dokter,
			'spesialis' => $spesialis,
			'active' => $active,
			'dihapus' => 'tidak'
		);

		return $this->db->insert('dokter', $dt);
	}

	function hapus_dokter($id_dokter)
	{
		$dt = array(
			'dihapus' => 'ya'
		);

		return $this->db
			->where('id_dokter', $id_dokter)
			->update('dokter', $dt);
	}

	function get_baris($id_dokter)
	{
		return $this->db
			->select('id_dokter, sip, nama_dokter, spesialis, active')
			->where('id_dokter', $id_dokter)
			->limit(1)
			->get('dokter');
	}

	function update_dokter($id_dokter, $sip, $nama_dokter, $spesialis, $active)
	{
		$dt = array(
			'sip' => $sip,
			'nama_dokter' => $nama_dokter,
			'spesialis' => $spesialis,
			'active' => $active
		);

		return $this->db
			->where('id_dokter', $id_dokter)
			->update('dokter', $dt);
	}

	function list_dokter()
	{
		return $this->db
			->select('id_dokter, nama_dokter')
			->where('active', 'Aktif')
			->where('dihapus', 'tidak')
			->order_by('nama_dokter','asc')
			->get('dokter');
	}
}