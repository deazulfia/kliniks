<?php 

class M_rekam_medis extends CI_Model{

	function __construct(){
		parent::__construct();
    }
        
    function tampil_rekam_medis($pasien_id){
        $this->db->select('rekam_medis.*, pasien.*');
        $this->db->join('pasien','pasien.id = rekam_medis.pasien_id');
        $query = $this->db->get_where('rekam_medis',array('rekam_medis.pasien_id'=>$pasien_id));
    
        return $query->result();
    }

    function tampil_pemeriksaan_selesai(){
		$this->db->select('*');
		$this->db->join('pasien','pasien.id = registrasi.pasien_id','left');
		$this->db->where('registrasi.status',1);
		$this->db->where('registrasi.tgl_reg',date('Y-m-d H-i-s'));
		$this->db->order_by('registrasi.id','ASC');

		$query = $this->db->get('registrasi');

		return $query->result();
	}


//end of class
}	