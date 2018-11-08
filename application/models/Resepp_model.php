<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resepp_model extends CI_Model
{
    var $table = 'resep';
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function tampil()
	{
		$this->db->select('r.no_reg, r.pasien_id, r.resep, r.tanggal_periksa,
                            p.id, p.no_rm, p.nama, p.tempat_lahir_pasien, p.tanggal_lahir_pasien, p.jk_pasien, p.umur_pasien, p.goldar_pasien, p.riwayat_alergi,
                            o.nama_obat');
        $this->db->from('resep r');
        $this->db->join('pasien p', 'p.id = r.pasien_id', 'LEFT');
        $this->db->join('obat o', 'o.id_obat = r.pasien_id', 'LEFT');
        // $this->db->join('dokter d', 'd.id_dokter = r.id_dokter', 'LEFT');
        // $this->db->join('rekam_medis m', 'm.id_rekam_medis = r.id_rekam_medis', 'LEFT');
        // $this->db->where('r.id_resep');
		$query=$this->db->get();
		return $query->result();
    }

    public function get_by_id($id_resep)
	{
		$this->db->from($this->table);
		$this->db->where('id_resep',$id_resep);
		$query = $this->db->get();
		return $query->row();
    }
    
    public function tambah_resep($data){
       $this->db->insert('resep', $data);
       $id = $this->db->insert_id();
       return (isset($id)) ? $id : FALSE;
   }

   public function tambah_pasien($data){
       $this->db->insert('pasien', $data);
       $id = $this->db->insert_id();
       return (isset($id)) ? $id : FALSE;
   }

   public function tambah_keluhan($data){
       $this->db->insert('rekam_medis', $data);
       $id = $this->db->insert_id();
       return (isset($id)) ? $id : FALSE;
   }

}