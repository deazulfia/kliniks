<?php
class Rekam_medis extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('m_rekam_medis');
		$this->load->model('m_terapi');
	}

	function index(){
		$data['query'] = $this->m_rekam_medis->tampil_rekam_medis();

		$this->load->view('rekam_medis/rekam_medis_view', $data);
		
    }
    
    function rm_pasien($pasien_id){
		$data['query'] = $this->m_rekam_medis->tampil_rekam_medis($pasien_id);

		$this->load->view('rekam_medis/rekam_medis_view', $data);
	}

	function resep($noreg, $pasien){
		$data['pasien'] = $this->m_terapi->ambil_data_pasien($pasien,$noreg);
		$data['tindakan'] = $this->m_terapi->tampil_tindakan($noreg);
		$data['diagnosa'] = $this->m_terapi->tampil_diagnosa($noreg);
		$data['obat'] = $this->m_terapi->tampil_obat($noreg);

		$this->load->view('head');
		$this->load->view('resep/cetak_resep', $data);
		$this->load->view('foot');
	}
//end of class
}
