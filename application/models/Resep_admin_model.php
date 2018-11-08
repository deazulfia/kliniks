<?php
class Resep_admin_model extends CI_Model 
{
	function get_all()
	{
		return $this->db
			->select('id_resep, nama_obat, tanggal, waktu')
			->where('dihapus', 'tidak')
			->order_by('tanggal', 'desc')
			->get('resep');
	}

	function fetch_data_resep_admin($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				id_resep, 
				nama_obat,
				tanggal,
				waktu 
			FROM 
				`resep`, (SELECT @row := 0) r WHERE 1=1 
				AND dihapus = 'tidak' 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				nama_obat LIKE '%".$this->db->escape_like_str($like_value)."%'
				tanggal LIKE '%".$this->db->escape_like_str($like_value)."%' 
				waktu LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'nama_obat',
			2 => 'tanggal',
			3 => 'waktu'
		);
		
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function get_baris($id_resep)
	{
		return $this->db
			->select('id_resep, nama_obat, tanggal, waktu')
			->where('id_resep', $id_resep)
			->limit(1)
			->get('resep');
	}

}