<?php

class master_diagnosa extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('m_masterdiagnosa','master_diagnosa');

	}

    function get_items(){
        
        return $this->master_diagnosa->get_items();
    }

	function index($id=null){

		$get = $this->db->get('master_diagnosa');

		$config['base_url'] = site_url().'/diagnosa/index';

		$config['total_rows'] = $get->num_rows();
		$config['per_page'] = 10;
		$config['next_page'] = '&raquo;';
		$config['prev_page'] = '&laquo;';
		$config['first_page'] = 'Awal';
		$config['last_page'] = 'Akhir';

		$this->pagination->initialize($config);

		//$data['query'] = $this->master_diagnosa->tampil_masterdiagnosa($config['per_page'],$id );
		$this->uri->segment(3);

		//$data['halaman'] = $this->pagination->create_links();
		// $this->load->view('head');
		$this->load->view('master/diagnosa/index');
		// $this->load->view('foot');
	}

	function tambah_diagnosa(){
		if(isset($_POST['submit'])){
			

            $data = array(
            	'kode_icd'=>$this->input->post('kode_icd'),
            	'nama_penyakit'=>$this->input->post('nama_penyakit'),
            	);

            $this->master_diagnosa->simpan($data);
            $this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-success"><b>Sukses! </b> Data berhasil disimpan.</div>');
            redirect('master_diagnosa');

        }else{
        	$this->load->view('head');
        	$this->load->view('master/diagnosa/tambah_diagnosa');
        	$this->load->view('foot');
        }
    }

    function ubah($id=null){
    	if(!$id){
    		echo 'Parameter Error. Hubungi Administrator Program.';
    	}else{
    		if(isset($_POST['submit'])){
    			

    			$data = array(
    				'kode_icd'=>$this->input->post('kode_icd'),
    				'nama_penyakit'=>$this->input->post('nama_penyakit'),
    				);

    			$this->master_diagnosa->update_masterdiagnosa($data, $id);
    			$this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-success"><b>Sukses! </b> Data berhasil diubah.</div>');
    			redirect('master_diagnosa');

    		}else{
    			$data['query'] = $this->master_diagnosa->ambil_masterdiagnosa($id);

    			$this->load->view('head');
    			$this->load->view('master/diagnosa/diagnosa_edit', $data);
    			$this->load->view('foot');
    		}
    	}
    }

    function hapus($id=null){
    	if(!$id){
    		echo 'Parameter Error';
    	}else{

    		$this->master_diagnosa->hapus_masterdiagnosa($id);
    		$this->session->set_flashdata('pesan', '<div id="pesan" class="alert alert-success"><b>Sukses! </b> Data berhasil hapus.</div>');
    		redirect('master_diagnosa');
    	}
    }

    function cetak(){
		$data['cetak'] = $this->master_diagnosa->cetak_masterdiagnosa();

		$this->load->view('master/diagnosa/diagnosa_cetak', $data);

	}

//end of class	
}