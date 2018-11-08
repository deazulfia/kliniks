<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Resepp extends MY_Controller 
{	
	public function index()
	{
		$this->load->view('dokter/data_resep');
	}

	public function resep_json()
	{
		$this->load->model('m_resep');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_resep->fetch_data_resep($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			// $nestedData[]	= $row['nomor'];
			// $nestedData[]	= $row['id'];
			$nestedData[]	= $row['tgl_reg'];
			$nestedData[]	= $row['no_reg'];
			$nestedData[]	= $row['keluhan'];
			$nestedData[]	= $row['no_rm'];
			$nestedData[]	= $row['nama'];
			
			if($level == 'admin' OR $level == 'inventory' OR $level == 'kasir' OR $level == 'master' OR $level == 'spv')
			{
				$nestedData[]	= "<a href='".site_url('penjualan/transaksi/'.$row['id']."/".$row['no_reg'])."'><i class='fa fa-money'></i> Transaksi</a>";
			}

			// if($level == 'master' OR $level == 'dokter')
			// {
			// 	$nestedData[]	= "<a href='".site_url('terapi/cetak/'.$row['id']."/".$row['no_reg'])."'><i class='fa fa-money'></i> Transaksi</a>";
			// }
		
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
}