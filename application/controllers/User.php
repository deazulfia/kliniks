<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends MY_Controller 
{
	public function index()
	{
		$level = $this->session->userdata('ap_level');
		if($level !== 'admin' OR $level == 'master' OR $level == 'spv' )
		{
			// exit();
		// }
		// else
		// {
			$this->load->view('user/user_data');
		}
	}

	public function user_json()
	{
		$this->load->model('M_user');

		$requestData	= $_REQUEST;
		$fetch			= $this->M_user->fetch_data_user($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['username'];
			$nestedData[]	= $row['nama'];
			$nestedData[]	= $row['level_akses'];
			$nestedData[]	= $row['status'];
			$nestedData[]	= "<a href='".site_url('user/edit/'.$row['id_user'])."' id='EditUser'><i class='fa fa-pencil'></i> Edit</a>";
			
			if($row['label'] !== 'master' )
			{
				$nestedData[]	= "<a href='".site_url('user/hapus/'.$row['id_user'])."' id='HapusUser'><i class='fa fa-trash-o'></i> Hapus</a>";
			}

			if($row['label'] == 'master' )
			{
				$nestedData[]	= '';
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

	public function hapus($id_user)
	{
		$level = $this->session->userdata('ap_level');
		if($level !== 'admin' OR $level == 'master' OR $level == 'spv')
		{
		// 	exit();
		// }
		// else
		// {
			if($this->input->is_ajax_request())
			{
				$this->load->model('M_user');
				$hapus = $this->M_user->hapus_user($id_user);
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

	public function tambah()
	{
		$level = $this->session->userdata('ap_level');
		if($level !== 'admin' OR $level == 'master' OR $level == 'spv')
		{
		// 	exit();
		// }
		// else
		// {
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('username','Username','trim|required|max_length[40]|callback_exist_username[username]|alpha_numeric');
				$this->form_validation->set_rules('password','Password','trim|required|max_length[60]');
				$this->form_validation->set_rules('nama','Nama Lengkap','trim|required|max_length[50]|alpha_spaces');
				
				$this->form_validation->set_message('required','%s harus diisi !');
				$this->form_validation->set_message('exist_username','%s sudah ada di database, pilih username lain yang unik !');
				$this->form_validation->set_message('alpha_spaces', '%s harus alphabet');
				$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('M_user');

					$username 	= $this->input->post('username');
					$password 	= $this->input->post('password');
					$nama		= $this->input->post('nama');
					$id_akses	= $this->input->post('id_akses');
					$status		= $this->input->post('status');

					$insert = $this->M_user->tambah_baru($username, $password, $nama, $id_akses, $status);
					

					if($insert > 0)
					{
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<i class='fa fa-check' style='color:green;'></i> Data User berhasil dismpan."
						));
					}
					else
					{
						$this->query_error("Oops, terjadi kesalahan, coba lagi !");
					}
				}
				else
				{
					$this->input_error();
				}
			}
			else
			{
				$this->load->model('M_akses');
				$dt['akses'] 	= $this->M_akses->get_all();
				$this->load->view('user/user_tambah', $dt);
			}
		}
	}

	public function exist_username($username)
	{
		$this->load->model('M_user');
		$cek_user = $this->M_user->cek_username($username);

		if($cek_user->num_rows() > 0)
		{
			return FALSE;
		}
		return TRUE;
	}

	public function edit($id_user = NULL)
	{
		$level = $this->session->userdata('ap_level');
		if($level !== 'admin' OR $level == 'master' OR $level == 'spv')
		{
		// 	exit();
		// }
		// else
		// {
			if( ! empty($id_user))
			{
				if($this->input->is_ajax_request())
				{
					$this->load->model('M_user');
					
					if($_POST)
					{
						$this->load->library('form_validation');

						$username 		= $this->input->post('username');
						$username_old	= $this->input->post('username_old');

						$callback			= '';
						if($username !== $username_old){
							$callback = "|callback_exist_username[username]";
						}

						$this->form_validation->set_rules('username','Username','trim|required|alpha_numeric|max_length[40]'.$callback);
						$this->form_validation->set_rules('password','Password','trim|max_length[60]');
						$this->form_validation->set_rules('nama','Nama Lengkap','trim|required|max_length[50]|alpha_spaces');
						
						$this->form_validation->set_message('required','%s harus diisi !');
						$this->form_validation->set_message('exist_username','%s sudah ada di database, pilih username lain yang unik !');
						$this->form_validation->set_message('alpha_spaces', '%s harus alphabet');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if($this->form_validation->run() == TRUE)
						{
							$password 	= $this->input->post('password');
							$nama		= $this->input->post('nama');
							$id_akses	= $this->input->post('id_akses');
							$status		= $this->input->post('status');

							$update = $this->M_user->update_user($id_user, $username, $password, $nama, $id_akses, $status);
							if($update)
							{
								$label = $this->input->post('label');
								if($label == 'admin' OR $level == 'master' OR $level == 'spv')
								{
									$this->session->set_userdata('ap_nama', $nama);
								}

								echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Data user berhasil diupdate.</div>"
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
						$this->load->model('M_akses');
						$dt['user'] 	= $this->M_user->get_baris($id_user)->row();
						$dt['akses'] 	= $this->M_akses->get_all();
						$this->load->view('user/user_edit', $dt);
					}
				}
			}
		}
	}

	public function ubah_password()
	{
		if($this->input->is_ajax_request())
		{
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('pass_old','Password Lama','trim|required|max_length[60]|callback_check_pass[pass_old]');
				$this->form_validation->set_rules('pass_new','Password Baru','trim|required|max_length[60]');
				$this->form_validation->set_rules('pass_new_confirm','Ulangi Password Baru','trim|required|max_length[60]|matches[pass_new]');
				$this->form_validation->set_message('required','%s harus diisi !');
				$this->form_validation->set_message('check_pass','%s anda salah !');

				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('M_user');
					$pass_new 	= $this->input->post('pass_new');

					$update 	= $this->M_user->update_password($pass_new);
					if($update)
					{
						$this->session->set_userdata('ap_password', sha1($pass_new));

						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Password berhasil diupdate.</div>"
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
				$this->load->view('user/change_pass');
			}
		}
	}

	public function check_pass($pass)
	{
		$this->load->model('M_user');
		$cek_user = $this->M_user->cek_password($pass);

		if($cek_user->num_rows() > 0)
		{
			return TRUE;
		}
		return FALSE;
	}
}