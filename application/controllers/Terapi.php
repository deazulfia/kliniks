<?php

class Terapi extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('m_terapi','terapi');
		$this->load->model('m_registrasi', 'registrasi');
		$this->load->model('m_pasien', 'pasien');
		$this->load->model('m_obat', 'obat');
		$this->load->model('m_masterdiagnosa', 'diagnosa');
		$this->load->model('m_mastertindakan', 'tindakan');
		$this->load->model('m_barang');
	}


	function index(){
		$data['query'] = $this->registrasi->tampil_registrasi();

		$this->load->view('terapi/terapi_view', $data);
	}

	function periksa($noreg, $nomerekammedis){

		if(isset($_POST['submit'])){

			$data = array('status'=>1);
			$array =[
				'no_reg'=>$this->input->post('noreg'),
				'tanggal_periksa'=>date('Y-m-d H-i-s'),
			];

			$this->terapi->amburadul_data('diperiksa_oleh',$array);

			$this->terapi->selesai_periksa($data, $noreg);
			redirect('resepp');

		}
		$data['pasien'] = $this->terapi->ambil_data_pasien($nomerekammedis,$noreg);
		$data['list_tindakan'] = $this->tindakan->tampil_mastertindakan();
		$data['list_obat'] = $this->obat->tampil_obat();

		// $this->load->view('head');
		$this->load->view('terapi/terapi_periksa', $data);
		// $this->load->view('foot');


	}


	function cetak($noreg, $pasien){
		$data['pasien'] = $this->terapi->ambil_data_pasien($pasien,$noreg);
		$data['tindakan'] = $this->terapi->tampil_tindakan($noreg);
		$data['diagnosa'] = $this->terapi->tampil_diagnosa($noreg);
		$data['obat'] = $this->terapi->tampil_obat($noreg);
		$data['terapi'] = $this->terapi->tampil_terapi($noreg);

		$this->load->view('terapi/cetak_terapi', $data);
	}

	function history(){
		$get = $this->db->get('registrasi');

		$config['base_url'] = site_url().'/pasien/history';
		$config['per_page'] = 20;
		$config['total_rows'] = $get->num_rows();
		$config['next_page'] = '&raquo;';
		$config['prev_page'] = '&laquo;';
		$config['first_page'] = 'Awal';
		$config['last_page'] = 'Akhir';

		$this->pagination->initialize($config);

		$data['halaman'] = $this->pagination->create_links();
		$data['query'] = $this->terapi->tampil_history($config['per_page'], $this->uri->segment(3));

		// $this->load->view('head');
		$this->load->view('terapi/terapi_history_view', $data);
		// $this->load->view('foot');
	}



	function detailhistory($pasien){
		$data['pasien'] = $this->terapi->ambil_data_pasien($pasien,null);
		$data['keluhan'] = $this->terapi->tampil_history_keluhan($pasien);
		$data['diagnosa'] = $this->terapi->tampil_history_diagnosa($pasien);
		$data['obat'] = $this->terapi->tampil_history_obat($pasien);
		$data['tindakan'] = $this->terapi->tampil_history_tindakan($pasien);
		$data['terapi'] = $this->terapi->tampil_history_terapi($pasien);

		// $this->load->view('head');
		$this->load->view('terapi/terapi_history_detail', $data);
		// $this->load->view('foot');
	}


	function cetakhistory($pasien){


		$data['pasien'] = $this->terapi->ambil_data_pasien($pasien);
		$data['keluhan'] = $this->terapi->tampil_history_keluhan($pasien);
		$data['diagnosa'] = $this->terapi->tampil_history_diagnosa($pasien);
		$data['obat'] = $this->terapi->tampil_history_obat($pasien);
		$data['tindakan'] = $this->terapi->tampil_history_tindakan($pasien);
		$data['terapi'] = $this->terapi->tampil_history_terapi($pasien);

		//$this->load->view('head');
		$this->load->view('terapi/terapi_history_cetak', $data);
    	//$this->load->view('foot');
	}


	/**
	* =================================
	* @@ Function simpan diagnosa jquery
	*
	**/
	function tambahdiagnosa(){
		
			$data = array(
				'no_reg'=>$this->input->post('noreg'),
				'pasien_id'=>$this->input->post('pasien'),
				'tekanandarah'=>$this->input->post('tekanandarah'),
				'suhu'=>$this->input->post('suhu'),
				'denyutnadi'=>$this->input->post('denyutnadi'),
				'diagnosa'=>$this->input->post('diagnosa'),
				'sarantindakan'=>$this->input->post('sarantindakan'),
				'tanggal_periksa'=>date('Y-m-d H-i-s'),
			);

			$this->terapi->amburadul_data('rekam_medis',$data);

	}

	function tambahrekammedis(){
		

		$data = array(
			'no_reg'=>$this->input->post('noreg'),
			'pasien_id'=>$this->input->post('pasien'),
			'tekanandarah'=>$this->input->post('tekanandarah'),
			'suhu'=>$this->input->post('suhhu'),
			'denyutnadi'=>$this->input->post('denyutnadi'),
			'diagnosa'=>$this->input->post('diagnosa'),
			'sarantindakan'=>$this->input->post('sarantindakan'),
			'tanggal_periksa'=>date('Y-m-d H-i-s'),
		);

		$this->terapi->amburadul_data('rekam_medis',$data);

}


	function tampildiagnosa($noreg){
		$data['query'] = $this->terapi->tampil_diagnosa($noreg);

		$this->load->view('terapi/tampil_diagnosa', $data);
	}

	function tampilrekammedis($noreg){
		$data['query'] = $this->terapi->tampil_rekammedis($noreg);

		$this->load->view('terapi/tampil_rekammedis', $data);
	}


	function hapusdiagnosa($noreg, $pasien_id, $tekanandarah, $suhu, $denyutnadi, $diagnosa, $sarantindakan, $tanggal_periksa)
	{
		$this->terapi->hapus_diagnosa($noreg, $pasien_id, $tekanandarah, $suhu, $denyutnadi, $diagnosa, $sarantindakan, $tanggal_periksa);
	}


	/**
	* =================================
	* @@ Function simpan obat jquery
	*
	**/
	function tambahobat(){
		

		$data = array(
			'no_reg'=>$this->input->post('noreg'),
			'pasien_id'=>$this->input->post('pasien'),
			'obat'=>$this->input->post('obat'),
			'jumlahobat'=>$this->input->post('jumlahobat'),
			'keteranganobat'=>$this->input->post('keteranganobat'),
			'tanggal_periksa'=>date('Y-m-d H-i-s'),
		);

		$datas = $this->terapi->amburadul_data('resep',$data);
		// echo json_encode ($data);
	}

	function tambahtindakanobat(){
		$jumlah = $this->input->post('jumlah');
		$obat = $this->input->post('obat');
		$data = array(
			'no_reg'=>$this->input->post('noreg'),
			'pasien_id'=>$this->input->post('pasien'),
			'obat'=> $obat,
			'jumlah'=> $jumlah,
			'tanggal'=>date('Y-m-d H-i-s'),
		);

		$datas = $this->terapi->amburadul_data('tindakan_obat',$data);

		if($jumlah !="" && $jumlah !=NULL){
			$this->m_barang->update_stoks($obat, $jumlah);
		}else{
			$this->query_error();
		}
	}

	function update_tindakan($id_obat = NULL){

		$jumlah 	= $this->input->post('jumlah');

		$this->m_barang->update_stok($id_obat, $jumlah);
	}


	function tampilobat($noreg){
		$data['query'] = $this->terapi->tampil_obat($noreg);

		$this->load->view('terapi/tampil_obat', $data);
	}

	function tampiltindakanobat($noreg){
		$data['query'] = $this->terapi->tampil_tindakanobat($noreg);

		$this->load->view('terapi/tampil_tindakanobat', $data);
	}



	function hapusobat($noreg, $pasien_id, $obat, $tanggal_periksa)
	{
		$this->terapi->hapus_obat($noreg, $pasien_id, $obat, $tanggal_periksa);
	}

	function hapustindakanobat($noreg, $pasien_id, $obat, $jumlahobat, $tanggal)
	{
		$this->terapi->hapus_tindakanobat($noreg, $pasien_id, $obat, $jumlahobat, $tanggal);
	}



	/**
	* =================================
	* @@ Function simpan tindakan jquery
	*
	**/
	function tambahtindakan(){

		$data = array(
			'no_reg'=>$this->input->post('noreg'),
			'pasien_id'=>$this->input->post('pasien'),
			'obat'=>$this->input->post('obat'),
			'jumlahobat'=>"1",
			'keteranganobat'=>"x",
			'tanggal_periksa'=>date('Y-m-d H-i-s'),
		);

		$this->terapi->amburadul_data('tindakan_medis',$data);
	}


	function tampiltindakan($noreg){
		$data['query'] = $this->terapi->tampil_tindakan($noreg);

		$this->load->view('terapi/tampil_tindakan', $data);
	}


	function hapustindakan($noreg, $pasien_id, $obat, $tanggal_periksa){
		$this->terapi->hapus_tindakan($noreg, $pasien_id, $obat, $tanggal_periksa);
	}


	/**
	* =================================
	* @@ Function simpan terapi jquery
	*
	**/
	function tambahterapi(){
		die('die');
		$obat = $this->input->post('obat');
		$etiket = $this->input->post('etiket');
		$jml = $this->input->post('jml');
		$noreg = $this->input->post('noreg');
		$pasien = $this->input->post('pasien');
		$tgl = date('Y-m-d H-i-s');

    //disini upload file
            $this->load->library('upload'); //panggil libary upload

            $extension = pathinfo($_FILES['resep']['name'], PATHINFO_EXTENSION);
            

            $namafile                = "file_" . $nama.'_'.time().'.'.$extension; //nama file + fungsi time
            $config['upload_path']   = FCPATH.'assets/img/resep'; //Folder untuk menyimpan hasil upload
            $config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf'; //type yang dapat diakses bisa anda sesuaikan
            $config['max_size']      = '3072'; //maksimum besar file 3M
            $config['max_width']     = '5000'; //lebar maksimum 5000 px
            $config['max_height']    = '5000'; //tinggi maksimu 5000 px
            $config['file_name']     = $namafile; //nama yang terupload nantinya

            $this->upload->initialize($config); //initialisasi upload dari array config
            $file_image_poto = $this->upload->data();
            $this->upload->do_upload('resep');

		$data = array(
			'no_reg'=>$noreg,
			'no_rm'=>$pasien,
			'terapi'=>$obat,
			'etiket'=>$etiket,
			'jml'=>$jml,
			'tgl'=>$tgl,
			'resep'=>$file_image_poto['file_name']
		);

		$this->terapi->simpan_data('terapi',$data);
	}


	function tampilterapi($noreg){
		$data['query'] = $this->terapi->tampil_terapi($noreg);

		$this->load->view('terapi/tampil_terapi', $data);
	}


	function hapusterapi($id){
		$this->terapi->hapus_terapi($id);
	}

	function get_diagnosa($keyword = '')
	{
		$data['diagnosa'] = $this->diagnosa->cari_diagnosa($keyword);
		echo json_encode($data);
		// echo "<pre>";
		// print_r($x);
		// echo "</pre>";
	}


	 public function uploadgambar(){

        //disini upload file
			$this->load->library('upload'); //panggil libary upload

			$extension = pathinfo($_FILES['resep']['name'], PATHINFO_EXTENSION);

            $namafile                = "file" .'_'.time().'.'.$extension; //nama file + fungsi time
            $config['upload_path']   = FCPATH.'assets/img/resep/'; //Folder untuk menyimpan hasil upload
            $config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf'; //type yang dapat diakses bisa anda sesuaikan
            $config['file_name']     = $namafile; //nama yang terupload nantinya

            $this->upload->initialize($config); //initialisasi upload dari array config
            $file_image_poto = $this->upload->data();

            $this->upload->do_upload('resep');

            $data = array(
            	'resep'=>$file_image_poto['file_name'],
            	'no_reg'=>$this->input->post('noreg'),
            	'no_rm'=>$this->input->post('idpasien'),
            	'tgl'=> date('Y-m-d H-i-s'),
            	);

            $this->terapi->simpan_resep($data);

            redirect('frame_resep/index/'.$this->input->post('noreg').'/'.$this->input->post('idpasien'), 'refresh');

    }
 

//end of class
}
