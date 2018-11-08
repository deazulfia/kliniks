<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien_daftar_model extends CI_Model
{
	var $table = 'pasien';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function get_all_pasien()
	{
		$this->db->from('pasien');
		$query=$this->db->get();
		return $query->result();
	}
	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	public function pasien_add($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function pasien_update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}


}
