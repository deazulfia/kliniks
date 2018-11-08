<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dokter extends MY_Controller 
{
	public function list_dokter()
	{
		$this->load->view('dokter/dokter_data');
	}

	public function list_dokter_json()
	{
		$this->load->model('M_dokter');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->M_dokter->fetch_data_dokter($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['sip'];
			$nestedData[]	= $row['nama_dokter'];
			$nestedData[]	= $row['spesialis'];
			$nestedData[]	= $row['active'];

			if($level == 'admin' OR $level == 'master' OR $level == 'spv')
			{
				$nestedData[]	= "<a href='".site_url('dokter/edit-dokter/'.$row['id_dokter'])."' id='EditDokter'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='".site_url('dokter/hapus-dokter/'.$row['id_dokter'])."' id='HapusDokter'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function tambah_dokter()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'master' OR $level == 'spv')
		{
			if($_POST)
			{
				$this->load->library('form_validation');				
				$this->form_validation->set_rules('sip','SIP','trim|required|max_length[40]');				
				$this->form_validation->set_rules('nama_dokter','Nama Dokter','trim|required|max_length[255]');				
				$this->form_validation->set_rules('spesialis','Spesialis','trim|required|max_length[255]');				
				
				$this->form_validation->set_message('required','%s harus diisi !');
				$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');

				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('M_dokter');
					$sip 	= $this->input->post('sip');
					$nama_dokter 	= $this->input->post('nama_dokter');
					$spesialis 	= $this->input->post('spesialis');
					$active 	= $this->input->post('active');

					$insert = $this->M_dokter->tambah_dokter($sip, $nama_dokter, $spesialis, $active);
					if($insert)
					{
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>".$nama_dokter."</b> berhasil ditambahkan.</div>"
						));
					}
					else
					{
						$this->query_error();
					}
				}
				else
				{
					$this->input_error();
				}
			}
			else
			{
				$this->load->view('dokter/dokter_tambah');
			}
		}
	}

	public function hapus_dokter($id_dokter)
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'master' OR $level == 'spv')
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('M_dokter');
				$hapus = $this->M_dokter->hapus_dokter($id_dokter);
				if($hapus)
				{
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Data berhasil dihapus !</font>
					"));
				}
				else
				{
					echo json_encode(array(
						"pesan" => "<font color='red'><i class='fa fa-warning'></i> Terjadi kesalahan, coba lagi !</font>
					"));
				}
			}
		}
	}

	public function edit_dokter($id_dokter = NULL)
	{
		if( ! empty($id_dokter))
		{
			$level = $this->session->userdata('ap_level');
			if($level == 'admin' OR $level == 'master' OR $level == 'spv')
			{
				if($this->input->is_ajax_request())
				{
					$this->load->model('M_dokter');
					
					if($_POST)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('sip','SIP','trim|required|max_length[40]');				
						$this->form_validation->set_rules('nama_dokter','Nama Dokter','trim|required|max_length[255]');				
						$this->form_validation->set_rules('spesialis','Spesialis','trim|required|max_length[255]');				
						
						$this->form_validation->set_message('required','%s harus diisi !');
						$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');

						if($this->form_validation->run() == TRUE)
						{
							$sip 	= $this->input->post('sip');
							$nama_dokter 	= $this->input->post('nama_dokter');
							$spesialis 	= $this->input->post('spesialis');
							$active 	= $this->input->post('active');
							
							
							$insert = $this->M_dokter->update_dokter($id_dokter, $sip, $nama_dokter, $spesialis, $active);
							if($insert)
							{
								echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Data berhasil diupdate.</div>"
								));
							}
							else
							{
								$this->query_error();
							}
						}
						else
						{
							$this->input_error();
						}
					}
					else
					{
						$dt['dokter'] = $this->M_dokter->get_baris($id_dokter)->row();
						$this->load->view('dokter/dokter_edit', $dt);
					}
				}
			}
		}
	}
}