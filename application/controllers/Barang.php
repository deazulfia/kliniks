<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Barang extends MY_Controller 
{	
	private $filename = "import_data";
	public function index()
	{
		$this->load->view('barang/barang_data');
	}

	public function barang_json()
	{
		$this->load->model('m_barang');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_barang->fetch_data_barang($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
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
			$nestedData[]	= $row['merk'];
			$nestedData[]	= ($row['total_stok'] == 'Kosong') ? "<font color='red'><b>".$row['total_stok']."</b></font>" : $row['total_stok'];
			$nestedData[]	= $row['harga'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/",'<br />', $row['keterangan']);

			if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'spv')
			{
				$nestedData[]	= "<a href='".site_url('barang/edit/'.$row['id_obat'])."' id='EditBarang'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='".site_url('barang/hapus/'.$row['id_obat'])."' id='HapusBarang'><i class='fa fa-trash-o'></i> Hapus</a>";
				$nestedData[]	= "<a href='".site_url('barang/stok/'.$row['id_obat'])."' id='AddStokBarang'><i class='fa fa-plus'></i> Add Stok</a>";
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
				$this->load->model('m_barang');
				$hapus = $this->m_barang->hapus_barang($id_obat);
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
					$this->form_validation->set_rules('kode['.$no.']','Kode obat #'.($no + 1),'trim|required|alpha_numeric|max_length[40]|callback_exist_kode[kode['.$no.']]');
					$this->form_validation->set_rules('nama['.$no.']','Nama obat #'.($no + 1),'trim|required|max_length[60]|alpha_numeric_spaces');
					$this->form_validation->set_rules('id_kategori_barang['.$no.']','Kategori #'.($no + 1),'trim|required');
					$this->form_validation->set_rules('id_merk_barang['.$no.']','Merek #'.($no + 1),'trim');
					$this->form_validation->set_rules('stok['.$no.']','Stok #'.($no + 1),'trim|required|numeric|max_length[10]|callback_cek_titik[stok['.$no.']]');
					$this->form_validation->set_rules('harga['.$no.']','Harga #'.($no + 1),'trim|required|numeric|min_length[2]|max_length[10]|callback_cek_titik[harga['.$no.']]');
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
					$this->load->model('m_barang');

					$no_array = 0;
					$inserted = 0;
					foreach($_POST['kode'] as $k)
					{
						$kode 				= $_POST['kode'][$no_array];
						$nama 				= $_POST['nama'][$no_array];
						$id_kategori_barang	= $_POST['id_kategori_barang'][$no_array];
						$id_merk_barang		= $_POST['id_merk_barang'][$no_array];
						$stok 				= $_POST['stok'][$no_array];
						$harga 				= $_POST['harga'][$no_array];
						$keterangan 		= $this->clean_tag_input($_POST['keterangan'][$no_array]);

						$insert = $this->m_barang->tambah_baru($kode, $nama, $id_kategori_barang, $id_merk_barang, $stok, $harga, $keterangan);
						if($insert){
							$inserted++;
						}
						$no_array++;
					}

					if($inserted > 0)
					{
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<i class='fa fa-check' style='color:green;'></i> Data Obat berhasil dismpan."
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
				$this->load->model('m_kategori_barang');
				$this->load->model('m_merk_barang');

				$dt['kategori'] = $this->m_kategori_barang->get_all();
				$dt['merek'] 	= $this->m_merk_barang->get_all();
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
			$kode = $this->input->post('kodenya');
			$this->load->model('m_barang');

			$cek_kode = $this->m_barang->cek_kode($kode);
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
		$this->load->model('m_barang');
		$cek_kode = $this->m_barang->cek_kode($kode);

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
			if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'spv')
			{
				if($this->input->is_ajax_request())
				{
					$this->load->model('m_barang');
					
					if($_POST)
					{
						$this->load->library('form_validation');

						$kode_obat 		= $this->input->post('kode_obat');
						$kode_obat_old	= $this->input->post('kode_obat_old');

						$callback			= '';
						if($kode_obat !== $kode_obat_old){
							$callback = "|callback_exist_kode[kode_obat]";
						}

						$this->form_validation->set_rules('kode_obat','Kode obat','trim|required|alpha_numeric|max_length[40]'.$callback);
						$this->form_validation->set_rules('nama_obat','Nama obat','trim|required|max_length[60]|alpha_numeric_spaces');
						$this->form_validation->set_rules('id_merk_barang','Merek','trim');
						$this->form_validation->set_rules('harga','Harga','trim|required|numeric|min_length[2]|max_length[10]|callback_cek_titik[harga]');
						$this->form_validation->set_rules('keterangan','Keterangan','trim|max_length[2000]');
						
						$this->form_validation->set_message('required','%s harus diisi !');
						$this->form_validation->set_message('numeric','%s harus angka !');
						$this->form_validation->set_message('exist_kode','%s sudah ada di database, pilih kode lain yang unik !');
						$this->form_validation->set_message('cek_titik','%s harus angka, tidak boleh ada titik !');
						$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');
						
						if($this->form_validation->run() == TRUE)
						{
							$kode_obat			= $this->input->post('kode_obat');
							$nama 				= $this->input->post('nama_obat');
							$id_kategori_barang	= $this->input->post('id_kategori_barang');
							$id_merk_barang		= $this->input->post('id_merk_barang');
							$harga 				= $this->input->post('harga');
							$keterangan 		= $this->clean_tag_input($this->input->post('keterangan'));

							$update = $this->m_barang->update_barang($id_obat, $kode_obat, $nama,  $id_kategori_barang, $id_merk_barang, $harga, $keterangan);
							if($update)
							{
								echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Data obat berhasil diupdate.</div>"
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
						$this->load->model('m_kategori_barang');
						$this->load->model('m_merk_barang');

						$dt['barang'] 	= $this->m_barang->get_baris($id_obat)->row();
						$dt['kategori'] = $this->m_kategori_barang->get_all();
						$dt['merek'] 	= $this->m_merk_barang->get_all();
						$this->load->view('barang/barang_edit', $dt);
					}
				}
			}
		}
	}

	public function stok($id_obat = NULL)
	{
		if( ! empty($id_obat))
		{	
			$nama_admin = $this->session->userdata('ap_id_user');
			$level = $this->session->userdata('ap_level');
			if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'spv')
			{
				if($this->input->is_ajax_request())
				{
					$this->load->model('m_barang');
					
					if($_POST)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('total_stok','Total Stok','trim|required|alpha_numeric_spaces|max_length[40]');				
						$this->form_validation->set_message('required','%s harus diisi !');
						$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');

						if($this->form_validation->run() == TRUE)
						{
							$total_stok 	= $this->input->post('total_stok');
							//
							$insert = $this->m_barang->update_stok_obat($id_obat, $total_stok);
							
							if($insert)
							{
								echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Data berhasil diupdate.</div>"
								));

								$this->m_barang->tambah_stok_obat($id_obat, $total_stok, $nama_admin);
							
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
						$dt['stok'] = $this->m_barang->get_baris($id_obat)->row();
						$this->load->view('barang/tambah_stok', $dt);
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
		$this->load->model('m_merk_barang');
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
				$this->form_validation->set_rules('merek','Merek','trim|required|max_length[40]');				
				$this->form_validation->set_message('required','%s harus diisi !');
				$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');

				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('m_merk_barang');
					$merek 	= $this->input->post('merek');
					$insert = $this->m_merk_barang->tambah_merek($merek);
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
				$this->load->model('m_merk_barang');
				$hapus = $this->m_merk_barang->hapus_merek($id_merk_barang);
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
					$this->load->model('m_merk_barang');
					
					if($_POST)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('merek','Merek','trim|required|max_length[40]');				
						$this->form_validation->set_message('required','%s harus diisi !');
						$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');

						if($this->form_validation->run() == TRUE)
						{
							$merek 	= $this->input->post('merek');
							$insert = $this->m_merk_barang->update_merek($id_merk_barang, $merek);
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
						$dt['merek'] = $this->m_merk_barang->get_baris($id_merk_barang)->row();
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
		$this->load->model('m_kategori_barang');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_kategori_barang->fetch_data_kategori($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
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
					$this->load->model('m_kategori_barang');
					$kategori 	= $this->input->post('kategori');
					$insert 	= $this->m_kategori_barang->tambah_kategori($kategori);
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
				$this->load->model('m_kategori_barang');
				$hapus = $this->m_kategori_barang->hapus_kategori($id_kategori_barang);
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
					$this->load->model('m_kategori_barang');
					
					if($_POST)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('kategori','Kategori','trim|required|max_length[40]|alpha_numeric_spaces');
						$this->form_validation->set_message('required','%s harus diisi !');
						$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');

						if($this->form_validation->run() == TRUE)
						{
							$kategori 	= $this->input->post('kategori');
							$insert 	= $this->m_kategori_barang->update_kategori($id_kategori_barang, $kategori);
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
						$dt['kategori'] = $this->m_kategori_barang->get_baris($id_kategori_barang)->row();
						$this->load->view('barang/kategori/kategori_edit', $dt);
					}
				}
			}
		}
	}

	public function list_tindakan()
	{
		$this->load->view('barang/tindakan/tindakan_data');
	}

	public function list_tindakan_json()
	{
		$this->load->model('m_tindakan');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_tindakan->fetch_data_tindakan($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['kode_tindakan'];
			$nestedData[]	= $row['nama_tindakan'];
			$nestedData[]	= $row['biaya'];

			if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'spv')
			{
				$nestedData[]	= "<a href='".site_url('barang/edit-tindakan/'.$row['tindakan_id'])."' id='EditTindakan'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='".site_url('barang/hapus-tindakan/'.$row['tindakan_id'])."' id='HapusTindakan'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function tambah_tindakan()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'spv')
		{
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('nama_tindakan','Nama Tindakan','trim|required|max_length[40]|alpha_numeric_spaces');	
				$this->form_validation->set_message('required','%s harus diisi !');
				$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');

				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('m_tindakan');
					$kode_tindakan 	= $this->input->post('kode_tindakan');
					$nama_tindakan 	= $this->input->post('nama_tindakan');
					$biaya 			= $this->input->post('biaya');
					$insert 	= $this->m_tindakan->tambah_tindakan($kode_tindakan, $nama_tindakan, $biaya);
					if($insert)
					{
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>".$nama_tindakan."</b> berhasil ditambahkan.</div>"
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
				$this->load->view('barang/tindakan/tindakan_tambah');
			}
		}
	}

	public function hapus_tindakan($tindakan_id)
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'spv')
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('m_tindakan');
				$hapus = $this->m_tindakan->hapus_tindakan($tindakan_id);
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

	public function edit_tindakan($tindakan_id = NULL)
	{
		if( ! empty($tindakan_id))
		{
			$level = $this->session->userdata('ap_level');
			if($level == 'admin' OR $level == 'inventory' OR $level == 'master' OR $level == 'spv')
			{
				if($this->input->is_ajax_request())
				{
					$this->load->model('m_tindakan');
					
					if($_POST)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nama_tindakan','Nama Tindakan','trim|required|max_length[40]|alpha_numeric_spaces');
						$this->form_validation->set_message('required','%s harus diisi !');
						$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');

						if($this->form_validation->run() == TRUE)
						{
							$kode_tindakan 	= $this->input->post('kode_tindakan');
							$nama_tindakan 	= $this->input->post('nama_tindakan');
							$biaya 	= $this->input->post('biaya');
							$insert 	= $this->m_tindakan->update_tindakan($tindakan_id, $kode_tindakan, $nama_tindakan, $biaya);
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
						$dt['tindakan'] = $this->m_tindakan->get_baris($tindakan_id)->row();
						$this->load->view('barang/tindakan/tindakan_edit', $dt);
					}
				}
			}
		}
	}
	
	public function cek_stok()
	{
		if($this->input->is_ajax_request())
		{
			$this->load->model('m_obat');
			$kode = $this->input->post('kode_obat');
			$stok = $this->input->post('stok');

			$get_stok = $this->m_obat->get_stok($kode);
			if($stok > $get_stok->row()->total_stok)
			{
				echo json_encode(array('status' => 0, 'pesan' => "Stok untuk <b>".$get_stok->row()->nama_obat."</b> saat ini hanya tersisa <b>".$get_stok->row()->total_stok."</b> !"));
			}
			else
			{
				echo json_encode(array('status' => 1));
			}
		}
	}

}