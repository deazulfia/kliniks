<?php
class M_resep extends CI_Model 
{

	function fetch_data_resep($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`tgl_reg`, 
				a.`no_reg`, 
				a.`keluhan`,
                b.`no_rm`,
				b.`nama`,
				b.`id`
			FROM 
				`registrasi` AS a 
				LEFT JOIN `pasien` AS b ON a.`pasien_id` = b.`id`
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`status` = '1' 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`tgl_reg` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`no_reg` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`keluhan` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR b.`no_rm` LIKE '%".$this->db->escape_like_str($like_value)."%'  
				OR b.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR b.`id` LIKE '%".$this->db->escape_like_str($like_value)."%' 
		    ";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`tgl_reg`',
			2 => 'a.`no_reg`',
			3 => 'a.`keluhan`',
			4 => 'b.`no_rm`',
			5 => 'b.`nama`',
			6 => 'b.`id`'
		);
		
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}
}