<?php

class Registrasi extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('m_registrasi','registrasi');
		$this->load->model('m_pasien','pasien');
	}


	function index(){
		$data['query'] = $this->registrasi->tampil_registrasi();

		$this->load->view('registrasi/reg_view', $data);
	}

	function daftar($pasien_id){

		
		if(!$pasien_id){
			echo 'Parameter Error';
		}else{
			if(isset($_POST['submit'])){

				$total = $this->registrasi->getcount_pendaftaran()->no_reg;
				$s = $total+1;
				$result = 'KGMRGS'.get_month_id();
				for ($i = strlen($s); $i <= 5; $i++) {
					$result .= "0";
				}

				$no_reg = $result.$s;
				$pasien_id = $pasien_id;
				$keluhan = $this->input->post('keluhan');
				$tgl = date('Y-m-d H-i-s');

				$data = array(
					'no_reg'=>$no_reg,
					'pasien_id'=>$pasien_id,
					'tgl_reg'=>$tgl,
					'status'=>"0",
					'keluhan'=>$keluhan
					);
				$this->registrasi->simpan_data($data);
				$this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-success"><b>Sukses! </b> Pasien berhasil didaftarkan.</div>');
				redirect('registrasi');
			}else{
				$data['query'] = $this->pasien->ambil_pasien($pasien_id);
				
	    		$this->load->view('registrasi/reg_daftar', $data);
			}
		}
	}
//end of class
}	