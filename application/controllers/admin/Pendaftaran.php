<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pendaftaran extends MY_Controller 
{
	public function list_pendaftaran()
	{
		$this->load->view('pendaftaran/pendaftaran_data');
	}

	public function list_pendaftaran_json()
	{
		$this->load->model('M_pendaftaran');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->M_pendaftaran->fetch_data_pendaftaran($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['keluhan'];
			$nestedData[]	= $row['tanggal_pendafatran'];
			$nestedData[]	= $row['waktu_pendaftaran'];
			$nestedData[]	= $row['id'];

			if($level == 'admin' OR $level == 'kasir' OR $level == 'master' OR $level == 'spv')
			{
				$nestedData[]	= "<a href='".site_url('pendaftaran/edit-pendaftaran/'.$row['id_pendaftaran'])."' id='EditPendaftaran'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='".site_url('pendaftaran/hapus-pendaftaran/'.$row['id_pendaftaran'])."' id='HapusPendaftaran'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function tambah_pendaftaran()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'kasir' OR $level == 'master' OR $level == 'spv')
		{
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('no_pendaftaran','No Pendaftaran','trim|required');
				$this->form_validation->set_rules('keluhan','Keluhan','trim|required|max_length[255]');	
				$this->form_validation->set_rules('id','ID Pasien','trim|required|max_length[255]|alpha_numeric_spaces');					
				
				$this->form_validation->set_message('required','%s harus diisi !');
				$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');

				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('M_pendaftaran');
					$no_pendaftaran 	= $this->input->post('no_pendaftaran');
					$keluhan 	= $this->input->post('keluhan');
					$tanggal_pendaftaran 	= $this->input->post('tanggal_pendaftaran');
					$waktu_pendaftaran 	= $this->input->post('waktu_pendaftaran');
					$id 	= $this->input->post('id');

					$insert = $this->M_pendaftaran->tambah_pendaftaran($no_pendaftaran, $keluhan, $tanggal_pendaftaran, $waktu_pendaftaran, $id);
					if($insert)
					{
						echo json_encode(array(
							'status' => 0,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>".$keluhan."</b> berhasil ditambahkan.</div>"
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
				$this->load->view('pendaftaran/pendaftaran_tambah');
			}
		}
	}

	public function hapus_pendaftaran($id_pendaftaran)
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'kasir' OR $level == 'master' OR $level == 'spv')
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('M_pendaftaran');
				$hapus = $this->M_pendaftaran->hapus_pendaftaran($id_pendaftaran);
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

	public function edit_pendaftaran($id_pendaftaran = NULL)
	{
		if( ! empty($id_pendaftaran))
		{
			$level = $this->session->userdata('ap_level');
			if($level == 'admin' OR $level == 'kasir' OR $level == 'master' OR $level == 'spv')
			{
				if($this->input->is_ajax_request())
				{
					$this->load->model('M_pendaftaran');
					
					if($_POST)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('keluhan','keluhan','trim|required|max_length[255]');				
						$this->form_validation->set_rules('id','ID Pasien','trim|required|max_length[40]|alpha_numeric_spaces');				
						
						$this->form_validation->set_message('required','%s harus diisi !');
						$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');

						if($this->form_validation->run() == TRUE)
						{
							$no_pendaftaran 	= $this->input->post('no_pendafatran');
							$keluhan 	= $this->input->post('keluhan');
							$tanggal_pendaftaran 	= $this->input->post('tanggal_pendaftaran');
							$waktu_pendaftaran 	= $this->input->post('waktu_pendaftaran');
							$id 	= $this->input->post('id');

							$insert = $this->M_pendaftaran->update_pendaftaran($id_pendaftaran, $no_pendaftaran, $keluhan, $tanggal_pendaftaran, $waktu_pendaftaran, $id);
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
						$dt['pendafataran'] = $this->M_pendaftaran->get_baris($id_pendafatran)->row();
						$this->load->view('pendaftaran/pendaftaran_edit', $dt);
					}
				}
			}
		}
	}
}