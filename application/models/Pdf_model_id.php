<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf_model_id extends CI_Model
{
	var $table = 'resep';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
    }
    
    public function tampil($id_rekam_medis)
	{
		$this->db->select('r.id_resep, r.nama_obat, r.jumlah_obat, r.keterangan, r.tanggal, r.waktu,
                            p.no_rm, p.nama, p.tempat_lahir_pasien, p.tanggal_lahir_pasien, p.jk_pasien, p.umur_pasien, p.goldar_pasien, p.riwayat_alergi, 
							m.id_rekam_medis, m.diagnosa, m.saran_tindakan,
							s.id_pendaftaran, s.keluhan');
        $this->db->from('resep r');
        $this->db->join('pasien p', 'p.id = r.id', 'LEFT');
        $this->db->join('rekam_medis m', 'm.id_rekam_medis = r.id_rekam_medis', 'LEFT');
        $this->db->join('pendaftaran s', 's.id_pendaftaran = r.id_pendaftaran', 'LEFT');
		// $this->db->where('r.id_resep');
		$this->db->where('m.id_rekam_medis',$id_rekam_medis);
		$query=$this->db->get();
		return $query->row();
    }
    
	public function get_by_id($id_rekam_medis)
	{
		$this->db->from($this->table);
		$this->db->where('id_rekam_medis',$id_rekam_medis);
		$query = $this->db->get();
		return $query->row();
	}

}
