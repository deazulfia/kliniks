<?php 

class M_registrasi extends CI_Model{

	function __construct(){
		parent::__construct();
	}


	function kode(){
		$this->db->select("RIGHT(no_reg,6) as kode", FALSE);
		$this->db->order_by('no_reg','DESC');
		$this->db->limit(1);

		$query = $this->db->get('registrasi');

		if($query->num_rows() <> 0){
			$data = $query->row();
			$kode = intval($data->kode) + 1;
		}else{
			$kode = 1;
		}


		$kodemax = str_pad($kode, 6, 0, STR_PAD_LEFT);
		$bln = date('m');
		$thn = date('Y');
		$kodejadi = "REG".$kodemax;

		return $kodejadi;
	}

	function getcount_pendaftaran(){
        $sql = $this->db->query('SELECT COUNT(*) as no_reg FROM registrasi');
        return $sql->row();
	}


	function simpan_data($data){
		$this->db->insert('registrasi', $data);
	}

	function max_noreg(){
		$this->db->select_max('no_reg');
		$this->db->from('registrasi');
		$query=$this->db->get();
		return $query->result_array();
	}


	function tampil_registrasi(){
		$this->db->select('*');
		$this->db->join('pasien','pasien.id = registrasi.pasien_id','left');
		$this->db->where('registrasi.status',0);
		$this->db->order_by('registrasi.id','ASC');

		$query = $this->db->get('registrasi');

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