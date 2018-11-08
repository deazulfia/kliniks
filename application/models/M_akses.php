<?php
class M_akses extends CI_Model 
{
	function get_all()
	{
		return $this->db
			->where('id_akses !=', 1)
			->order_by('level_akses', 'asc')
			->get('pj_akses');
	}
}