<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Pasien_daftar extends CI_Controller {
	 	public function __construct(){
	 		parent::__construct();
			$this->load->helper('url');
	 		$this->load->model('Pendaftaran_model');
	 	}
		public function index(){
			$data['pendaftaran']=$this->Pendaftaran_model->get_all_pendaftaran();
			$this->load->view('pasien/data_pasien',$data);
		}

}
