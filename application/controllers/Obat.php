<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Obat extends MY_Controller 
{
	public function index()
	{
		$this->load->view('barang/barang_data');
	}

	public function barang_json()
	{
		$this->load->model('M_obat');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->M_obat->fetch_data_obat($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['kode_obat'];
			$nestedData[]	= $row['nama_obat'];
			$nestedData[]	= $row['kategori'];
			$nestedData[]	= $row['size'];
			$nestedData[]	= $row['merk'];
			$nestedData[]	= ($row['total_stok'] == 'Kosong') ? "<font color='red'><b>".$row['total_stok']."</b></font>" : $row['total_stok'];
			$nestedData[]	= $row['harga'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/",'<br />', $row['keterangan']);

			if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'spv')
			{
				$nestedData[]	= "<a href='".site_url('barang/edit/'.$row['id_obat'])."' id='EditObat'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='".site_url('barang/hapus/'.$row['id_obat'])."' id='HapusObat'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function hapus($id_obat)
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'spv')
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('M_obat');
				$hapus = $this->M_obat->hapus_barang($id_obat);
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
		if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'spv')
		{
			if($_POST)
			{
				$this->load->library('form_validation');

				$no = 0;
				foreach($_POST['kode'] as $kode)
				{
					$this->form_validation->set_rules('kode['.$no.']','Kode Obat #'.($no + 1),'trim|required|alpha_numeric|max_length[40]|callback_exist_kode[kode['.$no.']]');
					$this->form_validation->set_rules('nama_obat['.$no.']','Nama Obat #'.($no + 1),'trim|required|max_length[60]|alpha_numeric_spaces');
					$this->form_validation->set_rules('id_kategori_barang['.$no.']','Kategori #'.($no + 1),'trim|required');
					$this->form_validation->set_rules('size['.$no.']','Size Barang #'.($no + 1),'trim|required|max_length[60]|alpha_numeric_spaces');
					$this->form_validation->set_rules('id_merk_barang['.$no.']','Merek #'.($no + 1),'trim');
					$this->form_validation->set_rules('stok['.$no.']','Stok #'.($no + 1),'trim|required|numeric|max_length[10]|callback_cek_titik[stok['.$no.']]');
					$this->form_validation->set_rules('harga['.$no.']','Harga #'.($no + 1),'trim|required|numeric|min_length[4]|max_length[10]|callback_cek_titik[harga['.$no.']]');
					$this->form_validation->set_rules('keterangan['.$no.']','Keterangan #'.($no + 1),'trim|max_length[2000]');
					$no++;
				}
				
				$this->form_validation->set_message('required','%s harus diisi !');
				$this->form_validation->set_message('numeric','%s harus angka !');
				$this->form_validation->set_message('exist_kode','%s sudah ada di database, pilih kode lain yang unik !');
				$this->form_validation->set_message('cek_titik','%s harus angka, tidak boleh ada titik !');
				$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');
				$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');
				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('M_obat');

					$no_array = 0;
					$inserted = 0;
					foreach($_POST['kode'] as $k)
					{
						$kode 				= $_POST['kode'][$no_array];
						$nama 				= $_POST['nama'][$no_array];
						$id_kategori_barang	= $_POST['id_kategori_barang'][$no_array];
						$size 				= $_POST['size'][$no_array];
						$id_merk_barang		= $_POST['id_merk_barang'][$no_array];
						$stok 				= $_POST['stok'][$no_array];
						$harga 				= $_POST['harga'][$no_array];
						$keterangan 		= $this->clean_tag_input($_POST['keterangan'][$no_array]);

						$insert = $this->M_barang->tambah_baru($kode, $nama, $id_kategori_barang,$size , $id_merk_barang, $stok, $harga, $keterangan);
						if($insert){
							$inserted++;
						}
						$no_array++;
					}

					if($inserted > 0)
					{
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<i class='fa fa-check' style='color:green;'></i> Data obat berhasil dismpan."
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
				$this->load->model('M_kategori_barang');
				$this->load->model('M_merk_barang');

				$dt['kategori'] = $this->M_kategori_barang->get_all();
				$dt['merek'] 	= $this->M_merk_barang->get_all();
				$this->load->view('barang/barang_tambah', $dt);
			}
		}
		else
		{
			exit();
		}
	}

	public function ajax_cek_kode()
	{
		if($this->input->is_ajax_request())
		{
			$kode_obat = $this->input->post('kodenya');
			$this->load->model('M_obat');

			$cek_kode = $this->M_obat->cek_kode($kode);
			if($cek_kode->num_rows() > 0)
			{
				echo json_encode(array(
					'status' => 0,
					'pesan' => "<font color='red'>Kode sudah ada</font>"
				));
			}
			else
			{
				echo json_encode(array(
					'status' => 1,
					'pesan' => ''
				));
			}
		}
	}

	public function exist_kode($kode)
	{
		$this->load->model('M_obat');
		$cek_kode = $this->M_obat->cek_kode($kode);

		if($cek_kode->num_rows() > 0)
		{
			return FALSE;
		}
		return TRUE;
	}

	public function cek_titik($angka)
	{
		$pecah = explode('.', $angka);
		if(count($pecah) > 1){
			return FALSE;
		}
		return TRUE;
	}

	public function edit($id_obat = NULL)
	{
		if( ! empty($id_obat))
		{
			$level = $this->session->userdata('ap_level');
			if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'keuangan' OR $level == 'spv')
			{
				if($this->input->is_ajax_request())
				{
					$this->load->model('M_obat');
					
					if($_POST)
					{
						$this->load->library('form_validation');

						$kode_obat 		= $this->input->post('kode_obat');
						$kode_obat_old	= $this->input->post('kode_obat_old');

						$callback			= '';
						if($kode_obat !== $kode_obat_old){
							$callback = "|callback_exist_kode[kode_obat]";
						}

						$this->form_validation->set_rules('kode_obat','Kode Obat','trim|required|alpha_numeric|max_length[40]'.$callback);
						$this->form_validation->set_rules('nama_obat','Nama Obat','trim|required|max_length[60]|alpha_numeric_spaces');
						$this->form_validation->set_rules('id_kategori_barang','Kategori','trim|required');
						$this->form_validation->set_rules('id_merk_barang','Merek','trim');
						$this->form_validation->set_rules('total_stok','Stok','trim|required|numeric|max_length[10]|callback_cek_titik[total_stok]');
						$this->form_validation->set_rules('harga','Harga','trim|required|numeric|min_length[4]|max_length[10]|callback_cek_titik[harga]');
						$this->form_validation->set_rules('keterangan','Keterangan','trim|max_length[2000]');
						
						$this->form_validation->set_message('required','%s harus diisi !');
						$this->form_validation->set_message('numeric','%s harus angka !');
						$this->form_validation->set_message('exist_kode','%s sudah ada di database, pilih kode lain yang unik !');
						$this->form_validation->set_message('cek_titik','%s harus angka, tidak boleh ada titik !');
						$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');
						
						if($this->form_validation->run() == TRUE)
						{
							$nama 				= $this->input->post('nama_obat');
							$id_kategori_barang	= $this->input->post('id_kategori_barang');
							$id_merk_barang		= $this->input->post('id_merk_barang');
							$size				= $this->input->post('size');
							$stok 				= $this->input->post('total_stok');
							$harga 				= $this->input->post('harga');
							$keterangan 		= $this->clean_tag_input($this->input->post('keterangan'));

							$update = $this->M_obat->update_barang($id_obat, $kode_obat, $nama,  $id_kategori_barang, $size, $id_merk_barang, $stok, $harga, $keterangan);
							if($update)
							{
								echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Data Obat berhasil diupdate.</div>"
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
						$this->load->model('M_kategori_barang');
						$this->load->model('M_merk_barang');

						$dt['barang'] 	= $this->M_barang->get_baris($id_obat)->row();
						$dt['kategori'] = $this->M_kategori_barang->get_all();
						$dt['merek'] 	= $this->M_merk_barang->get_all();
						$this->load->view('barang/barang_edit', $dt);
					}
				}
			}
		}
	}

	public function list_merek()
	{
		$this->load->view('barang/merek/merek_data');
	}

	public function list_merek_json()
	{
		$this->load->model('M_merk_barang');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_merk_barang->fetch_data_merek($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['merk'];

			if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'spv')
			{
				$nestedData[]	= "<a href='".site_url('barang/edit-merek/'.$row['id_merk_barang'])."' id='EditMerek'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='".site_url('barang/hapus-merek/'.$row['id_merk_barang'])."' id='HapusMerek'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function tambah_merek()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'spv')
		{
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('merek','Merek','trim|required|max_length[40]|alpha_numeric_spaces');				
				$this->form_validation->set_message('required','%s harus diisi !');
				$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');

				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('M_merk_barang');
					$merek 	= $this->input->post('merek');
					$insert = $this->M_merk_barang->tambah_merek($merek);
					if($insert)
					{
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>".$merek."</b> berhasil ditambahkan.</div>"
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
				$this->load->view('barang/merek/merek_tambah');
			}
		}
	}

	public function hapus_merek($id_merk_barang)
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'spv')
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('M_merk_barang');
				$hapus = $this->M_merk_barang->hapus_merek($id_merk_barang);
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

	public function edit_merek($id_merk_barang = NULL)
	{
		if( ! empty($id_merk_barang))
		{
			$level = $this->session->userdata('ap_level');
			if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'spv')
			{
				if($this->input->is_ajax_request())
				{
					$this->load->model('M_merk_barang');
					
					if($_POST)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('merek','Merek','trim|required|max_length[40]|alpha_numeric_spaces');				
						$this->form_validation->set_message('required','%s harus diisi !');
						$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');

						if($this->form_validation->run() == TRUE)
						{
							$merek 	= $this->input->post('merek');
							$insert = $this->M_merk_barang->update_merek($id_merk_barang, $merek);
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
						$dt['merek'] = $this->M_merk_barang->get_baris($id_merk_barang)->row();
						$this->load->view('barang/merek/merek_edit', $dt);
					}
				}
			}
		}
	}

	public function list_kategori()
	{
		$this->load->view('barang/kategori/kategori_data');
	}

	public function list_kategori_json()
	{
		$this->load->model('M_kategori_barang');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->M_kategori_barang->fetch_data_kategori($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['kategori'];

			if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'spv')
			{
				$nestedData[]	= "<a href='".site_url('barang/edit-kategori/'.$row['id_kategori_barang'])."' id='EditKategori'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='".site_url('barang/hapus-kategori/'.$row['id_kategori_barang'])."' id='HapusKategori'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function tambah_kategori()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'spv')
		{
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('kategori','Kategori','trim|required|max_length[40]|alpha_numeric_spaces');				
				$this->form_validation->set_message('required','%s harus diisi !');
				$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');

				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('M_kategori_barang');
					$kategori 	= $this->input->post('kategori');
					$insert 	= $this->M_kategori_barang->tambah_kategori($kategori);
					if($insert)
					{
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>".$kategori."</b> berhasil ditambahkan.</div>"
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
				$this->load->view('barang/kategori/kategori_tambah');
			}
		}
	}

	public function hapus_kategori($id_kategori_barang)
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'spv')
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('M_kategori_barang');
				$hapus = $this->M_kategori_barang->hapus_kategori($id_kategori_barang);
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

	public function edit_kategori($id_kategori_barang = NULL)
	{
		if( ! empty($id_kategori_barang))
		{
			$level = $this->session->userdata('ap_level');
			if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'spv')
			{
				if($this->input->is_ajax_request())
				{
					$this->load->model('M_kategori_barang');
					
					if($_POST)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('kategori','Kategori','trim|required|max_length[40]|alpha_numeric_spaces');				
						$this->form_validation->set_message('required','%s harus diisi !');
						$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');

						if($this->form_validation->run() == TRUE)
						{
							$kategori 	= $this->input->post('kategori');
							$insert 	= $this->M_kategori_barang->update_kategori($id_kategori_barang, $kategori);
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
						$dt['kategori'] = $this->M_kategori_barang->get_baris($id_kategori_barang)->row();
						$this->load->view('barang/kategori/kategori_edit', $dt);
					}
				}
			}
		}
	}

	public function cek_stok()
	{
		if($this->input->is_ajax_request())
		{
			$this->load->model('M_barang');
			$kode = $this->input->post('kode_barang');
			$stok = $this->input->post('stok');

			$get_stok = $this->M_barang->get_stok($kode);
			if($stok > $get_stok->row()->total_stok)
			{
				echo json_encode(array('status' => 0, 'pesan' => "Stok untuk <b>".$get_stok->row()->nama_barang."</b> saat ini hanya tersisa <b>".$get_stok->row()->total_stok."</b> !"));
			}
			else
			{
				echo json_encode(array('status' => 1));
			}
		}
	}
}