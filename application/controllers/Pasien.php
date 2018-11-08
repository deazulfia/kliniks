<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pasien extends MY_Controller 
{	
	private $filename = "import_data";
	public function index()
	{
		$this->load->view('pasien/pasien_view');
	}

	public function pasien_json()
	{
		$this->load->model('M_pasien');
		$level 			= $this->session->userdata('ap_level');
		$requestData	= $_REQUEST;
		$fetch			= $this->M_pasien->fetch_data_pasien($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['id'];
			$nestedData[]	= $row['no_rm'];
			$nestedData[]	= $row['nama'];
			$nestedData[]	= $row['tempat_lahir_pasien'];
			$nestedData[]	= $row['tanggal_lahir_pasien'];
			$nestedData[]	= $row['jk_pasien'];
			$nestedData[]	= $row['umur_pasien'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/",'<br />', $row['alamat']);
			
			if($level == 'admin' || $level == 'master' || $level == 'spv' || $level == 'kasir' || $level == 'keuangan') 
			{
				$nestedData[]	= "<a href='".site_url('registrasi/daftar/'.$row['id'])."' id='AddRegist'><i class='fa fa-plus'></i> Registrasi</a>";
			}

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),  
			"recordsTotal"    => intval( $totalData ),  
			"recordsFiltered" => intval( $totalFiltered ), 
			"data"            => $data
			);

		echo json_encode($json_data);
	}

	public function form(){
		$this->load->model('m_pasien');
		$data = array();
		
		if(isset($_POST['preview'])){ 
			$upload = $this->m_pasien->upload_file($this->filename);
			
			if($upload['result'] == "success"){
				include APPPATH.'third_party/PHPExcel/PHPExcel.php';
				
				$excelreader = new PHPExcel_Reader_Excel2007();
				$loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx'); 
				$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
				
				$data['sheet'] = $sheet; 
			}else{ 
				$data['upload_error'] = $upload['error'];
			}
		}
		
		$this->load->view('penjualan/import_pelanggan', $data);
	}

	public function import(){
		$this->load->model('m_pasien');
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';
		
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx');
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
		
		$data = array();
		
		$numrow = 1;
		foreach($sheet as $row){
			if($numrow > 1){
				array_push($data, array(
					'no_rm'=>$row['A'],
					'no_ktp_pasien'=>$row['B'],
					'nama'=>$row['C'],
                    'tempat_lahir_pasien'=>$row['D'],
                    'tanggal_lahir_pasien'=>$row['E'],
					'jk_pasien'=>$row['F'],
					'umur_pasien'=>$row['G'],
                    'goldar_pasien'=>$row['H'],
                    'telp'=>$row['I'],
					'riwayat_alergi'=>$row['J'],
					'alamat'=>$row['K'],
					'waktu_input'=>date_time(),
					'tampil'=>"0",
                    'dihapus'=>"tidak",
                    
				));
			}
			
			$numrow++;
		}

		$this->m_pasien->insert_multiple($data);
		
		redirect("penjualan/pelanggan");
	}
}