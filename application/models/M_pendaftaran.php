<?php
class M_pendaftaran extends CI_Model 
{
	function get_all()
	{
		return $this->db
			->select('id_pendaftaran, no_pendaftaran, keluhan, tanggal_pendaftaran, waktu_pendaftaran, id')
			->where('dihapus', 'tidak')
			->order_by('id_pendaftaran', 'desc')
			->get('pendaftaran');
	}

	function getcount_pendaftaran(){
        $sql = $this->db->query('SELECT COUNT(*) as no_pendaftaran FROM pendaftaran where dihapus = "tidak"');
        return $sql->row();
	}
	
	function search_blog($title){
		$this->db->like('nama', $title , 'both');
		$this->db->order_by('nama', 'ASC');
		$this->db->limit(10);
		return $this->db->get('pasien')->result();
	}

	function fetch_data_pendaftaran($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				id_pendaftaran, 
				no_pendaftaran,
				keluhan, 
				tanggal_pendaftaran,
				waktu_pendaftaran,
				id 
			FROM 
				`pendaftaran`, (SELECT @row := 0) r WHERE 1=1 
				AND dihapus = 'tidak' 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				no_pendaftaran LIKE '%".$this->db->escape_like_str($like_value)."%'
				keluhan LIKE '%".$this->db->escape_like_str($like_value)."%'
				tanggal_pendaftaran LIKE '%".$this->db->escape_like_str($like_value)."%'
				waktu_pendaftaran LIKE '%".$this->db->escape_like_str($like_value)."%' 
				id LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'no_pendaftaran',
			2 => 'keluhan',
			3 => 'tanggal_pendaftaran',
			4 => 'waktu_pendaftaran',
			5 => 'id'
		);
		
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function tambah_pendaftaran($no_pendaftaran, $keluhan, $tanggal_pendaftaran, $waktu_pendaftaran, $id)
	{
		$dt = array(
			'no_pendaftaran' => $no_pendaftaran,
			'keluhan' => $keluhan,
			'tanggal_pendaftaran' => date_now(),
			'waktu_pendaftaran' => time_now(),
			'id' => $id,
			'dihapus' => 'tidak'
		);

		return $this->db->insert('pendaftaran', $dt);
	}

	function hapus_pendaftaran($id_pendaftaran)
	{
		$dt = array(
			'dihapus' => 'ya'
		);

		return $this->db
			->where('id_pendaftaran', $id_pendaftaran)
			->update('pendaftaran', $dt);
	}

	function get_baris($id_pendaftaran)
	{
		return $this->db
			->select('id_pendaftaran, no_pendaftaran, keluhan, tanggal_pendaftaran, waktu_pendaftaran, id')
			->where('id_pendaftaran', $id_pendaftaran)
			->limit(1)
			->get('pendaftaran');
	}

	function update_pendaftaran($id_pendaftaran, $no_pendaftaran, $keluhan, $tanggal_pendaftaran, $waktu_pendaftaran, $id)
	{
		$dt = array(
			'no_pendaftaran' => $no_pendaftaran,
			'keluhan' => $keluhan,
			'tanggal_pendaftaran' => $tanggal_pendaftaran,
			'waktu_pendaftaran' => $waktu_pendaftaran,
			'id' => $id
		);

		return $this->db
			->where('id_pendaftaran', $id_pendaftaran)
			->update('pendaftaran', $dt);
	}
}