<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendaftaran_model extends CI_Model
{
	var $table = 'pendaftaran';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function get_all_pendaftaran()
	{
		$this->db->select('p.id_pendaftaran, p.keluhan, p.tanggal_pendaftaran, p.waktu_pendaftaran,
                            s.id, s.nama, s.tempat_lahir_pasien, s.tanggal_lahir_pasien, s.jk_pasien, s.umur_pasien, s.goldar_pasien, s.riwayat_alergi,');
        $this->db->from('pendaftaran p');
        $this->db->join('pasien s', 's.id = p.id');
        // $this->db->where('r.id_resep');
		$query=$this->db->get();
		return $query->result();
	}
	public function get_by_id($id_pendaftaran)
	{
		$this->db->from($this->table);
		$this->db->where('id_pendaftaran',$id_pendaftaran);
		$query = $this->db->get();
		return $query->row();
	}

	public function pendaftaran_add($data)
	{
		$this->db->insert($this->table, $data);
		// return $this->db->insert_id();
	}

	public function pendaftaran_update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id_pendaftaran)
	{
		$this->db->where('id_pendaftaran', $id_pendaftaran);
		$this->db->delete($this->table);
	}
}
