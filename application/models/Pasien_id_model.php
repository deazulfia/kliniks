<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien_id_model extends CI_Model
{
	var $table = 'pendaftaran';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function get_by_id($id)
	{  
		$this->db->select('r.tanggal_pendaftaran, r.waktu_pendaftaran, r.keluhan,
                            p.id, p.nama, p.tempat_lahir_pasien, p.tanggal_lahir_pasien, p.jk_pasien, p.umur_pasien, p.goldar_pasien, p.riwayat_alergi');
		$this->db->from('pendaftaran r');
		$this->db->join('pasien p', 'p.id = r.id', 'LEFT');
		$this->db->where('p.id',$id);
		$query = $this->db->get();
		return $query->row();
	}

}
