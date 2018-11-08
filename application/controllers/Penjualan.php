<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Penjualan extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('ap_level') == 'inventory'){
			redirect();
		}
	}

	public function index()
	{
		$this->transaksi();
	}

	public function transaksi($id = NULL, $noreg = NULL)
	{
		$this->load->model('M_penjualan_detail');
		$this->load->model('M_obat');
		$this->load->model('M_penjualan_master');
		$this->load->model('M_tindakan');

		if( ! empty($id))
		{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'kasir' OR $level == 'spv' OR $level == 'master')
		{
			if($_POST)
			{
		
				if( ! empty($_POST['kode_obat']))
				{
					$total = 0;
					foreach($_POST['kode_obat'] as $k)
					{
						if( ! empty($k)){ $total++; }
					}

					if($total > 0)
					{

						$this->load->library('form_validation');
						$this->form_validation->set_rules('nomor_nota','Nomor Nota','trim|required|max_length[40]|alpha_numeric|callback_cek_nota[nomor_nota]');
						$this->form_validation->set_rules('tanggal','Tanggal','trim|required');
						
						$this->form_validation->set_rules('cash','Total Bayar', 'trim|numeric|required|max_length[17]');
						$this->form_validation->set_rules('catatan','Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nota', '%s sudah ada');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						
						if($this->form_validation->run() == TRUE)
						{
							$nomor_nota 	= $this->input->post('nomor_nota');
							$tanggal		= $this->input->post('tanggal');
							$id_kasir		= $this->input->post('id_kasir');
							$id_dokter		= $this->input->post('id_dokter');
							$id				= $this->input->post('id');
							$bayar			= $this->input->post('cash');
							$grand_total	= $this->input->post('grand_total');
							$catatan		= $this->clean_tag_input($this->input->post('catatan'));

							if($bayar < $grand_total)
							{
								$this->query_error("Cash Kurang");
							}
							else
							{
								
								$master = $this->M_penjualan_master->insert_master($nomor_nota, $tanggal, $id_kasir, $id_dokter, $id, $bayar, $grand_total, $catatan);
								if($master)
								{
									$id_master 	= $this->M_penjualan_master->get_id($nomor_nota)->row()->id_penjualan_m;
									

									$no_array	= 0;
									$insert_data = array();
									$update_data = array();
									$inserted	= 0;
									$inputTindakan = array();
									
									foreach($_POST['kode_obat'] as $k)
									{
										
										if( !is_null($k) || !empty($k))
										{
											$jumlahobat 	= $_POST['jumlah_beli'][$no_array];
											$harga 			= $_POST['harga_satuan'][$no_array];
											$sub_total 		= $_POST['sub_total'][$no_array];
											$obat			= $this->M_obat->get_id($k)->row();
											
											if( !is_null($obat))
											{
												$dInsert = array(
													'id_penjualan_m' => $id_master,
													'id_obat	' =>  $obat->id_obat,
													'jumlah_beli' => $jumlahobat,
													'harga_satuan' => $harga,
													'total' => $sub_total
												);
												array_push($insert_data,$dInsert);
												$dUpdate = array(
													'id_obat' => $obat->id_obat,
													'jml'	=> $jumlahobat
												);
												array_push($update_data,$dUpdate);
											}
										}
										$no_array++;
									}

									$no_array = 0;
									foreach($_POST['kode_tindakan'] as $kt)
									{
										if( !is_null($kt) || !empty($kt))
										{
											// $jumlahobat 	= $_POST['jumlah_beli'][$no_array];
											$harga 			= $_POST['biaya'][$no_array];
											$sub_total 		= $_POST['biaya'][$no_array];
											$tindakan  		= $this->M_tindakan->get_id($kt);
											if( !is_null($tindakan))
											{
												$dtInsert = array(
													'id_penjualan_m' => $id_master,
													'tindakan_id' =>  $tindakan->tindakan_id,
													'jumlah_beli' => "1",
													'harga_satuan' => $harga,
													'total' => $sub_total
												);
												array_push($inputTindakan,$dtInsert);
											}
										}
										$no_array++;
									}

									// Lakukan pengecekan Berdasarkan Stock
									// Looping berdasarkan kode obat
									$obatError = "";
									$valStokObat = true;
									foreach ($update_data as $u ) {
										if ($this->M_obat->checkStock($u['id_obat'],$u['jml']) == 1){
											$valStokObat = true;
										}else{
											$obatError  = $u['id_obat'];
											$valStokObat = false;
											break;
										}
									}
									if ($valStokObat == false){
										echo json_encode(array('status' => 0, 'pesan' => "Transaksi gagal stok obat " . $obatError . " habis"));
									}else{
										$this->M_penjualan_detail->insertbatch($insert_data);
										$this->M_penjualan_detail->insertBatchTindakan($inputTindakan);
										foreach ($update_data as $u ) {
											$this->M_obat->update_stok($u['id_obat'], $u['jml']);
										}
										echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));
									}
									
								}
								else
								{
									$this->query_error();
								}
							}
						}
						else
						{
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ","</font><br />")));
						}
					}
					else
					{
						$this->query_error("Harap masukan minimal 1 kode obat !");
					}
				}
				else
				{
					$this->query_error("Harap masukan minimal 1 kode obat !");
				}
			}
			else
			{
				$this->load->model('M_user');
				$this->load->model('M_dokter');
				$this->load->model('M_pelanggan');
				$this->load->model('M_terapi');

				$dt['kasirnya'] = $this->M_user->list_kasir();
				$dt['dokternya'] = $this->M_dokter->list_dokter();
				$dt['pelanggan'] = $this->M_pelanggan->get_baris($id)->row();
				$dt['tindakan'] = $this->M_terapi->tampil_tindakan($noreg);
				$dt['diagnosa'] = $this->M_terapi->tampil_diagnosa($noreg);
				$dt['obat'] = $this->M_terapi->tampil_obat($noreg);
				$dt['auth'] =   array('id' =>$id ,'no_reg'=>$noreg );
				$this->load->view('penjualan/transaksi', $dt);
				// var_dump($dt['tindakan']);
			}
		}
	}
	}

	public function cek_nota($nota)
	{
		$this->load->model('M_penjualan_master');
		$cek = $this->M_penjualan_master->cek_nota_validasi($nota);

		if($cek->num_rows() > 0)
		{
			return FALSE;
		}
		return TRUE;
	}

	public function ajax_pelanggan()
	{
		if($this->input->is_ajax_request())
		{
			$id = $this->input->post('id');
			$this->load->model('M_pelanggan');

			$data = $this->M_pelanggan->get_baris($id)->row();
			$json['telp']			= ( ! empty($data->telp)) ? $data->telp : "<small><i>Tidak ada</i></small>";
			$json['alamat']			= ( ! empty($data->alamat)) ? preg_replace("/\r\n|\r|\n/",'<br />', $data->alamat) : "<small><i>Tidak ada</i></small>";
			$json['info_tambahan']	= ( ! empty($data->info_tambahan)) ? preg_replace("/\r\n|\r|\n/",'<br />', $data->info_tambahan) : "<small><i>Tidak ada</i></small>";
			echo json_encode($json);
		}
	}

	public function ajax_kode()
	{
		if($this->input->is_ajax_request())
		{
			$keyword 	= $this->input->post('keyword');
			$registered	= $this->input->post('registered');

			$this->load->model('M_obat');

			$obat = $this->M_obat->cari_kode($keyword, $registered);

			if($obat->num_rows() > 0)
			{
				$json['status'] 	= 1;
				$json['datanya'] 	= "<ul id='daftar-autocomplete'>";
				foreach($obat->result() as $b)
				{
					$json['datanya'] .= "
						<li>
							<b>Kode</b> : 
							<span id='kodenya'>".$b->kode_obat."</span> <br />
							<span id='barangnya'>".$b->nama_obat."</span>
							<span id='harganya' style='display:none;'>".$b->harga."</span>
						</li>
					";
				}
				$json['datanya'] .= "</ul>";
			}
			else
			{
				$json['status'] 	= 0;
			}

			echo json_encode($json);
		}
	}

	public function cek_kode_barang($kode)
	{
		$this->load->model('M_obat');
		$cek_kode = $this->M_obat->cek_kode($kode);

		if($cek_kode->num_rows() > 0)
		{
			return TRUE;
		}
		return FALSE;
	}

	public function cek_nol($qty)
	{
		if($qty > 0){
			return TRUE;
		}
		return FALSE;
	}

	public function history()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'master' OR $level == 'spv' OR $level == 'kasir' OR $level == 'keuangan' OR $level == 'marketing')
		{
			$this->load->view('penjualan/transaksi_history');
		}
	}

	public function history_json()
	{
		$this->load->model('M_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->M_penjualan_master->fetch_data_penjualan($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			// $nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['tanggal'];
			$nestedData[]	= "<a href='".site_url('penjualan/detail-transaksi/'.$row['id_penjualan_m'])."' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> ".$row['nomor_nota']."</a>";
			$nestedData[]	= $row['grand_total'];
			$nestedData[]	= $row['nama_pasien'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/",'<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];
		
			if($level == 'admin' OR $level == 'spv' OR $level == 'master' OR $level == 'keuangan')
			{
				$nestedData[]	= "<a href='".site_url('penjualan/hapus-transaksi/'.$row['id_penjualan_m'])."' id='HapusTransaksi'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function detail_transaksi($id_penjualan)
	{
		if($this->input->is_ajax_request())
		{
			$this->load->model('M_penjualan_detail');
			$this->load->model('M_penjualan_master');

			$dt['detail'] = $this->M_penjualan_detail->get_detail($id_penjualan);
			$dt['tindakan'] = $this->M_penjualan_detail->get_detail_tindakan($id_penjualan);
			$dt['master'] = $this->M_penjualan_master->get_baris($id_penjualan)->row();
			
			$this->load->view('penjualan/transaksi_history_detail', $dt);
			// var_dump($dt['detail']);
		}
	}

	public function hapus_transaksi($id_penjualan)
	{
		if($this->input->is_ajax_request())
		{
			$level 	= $this->session->userdata('ap_level');
			if($level == 'admin' OR $level == 'spv' OR $level == 'master')
			{
				$reverse_stok = $this->input->post('reverse_stok');

				$this->load->model('M_penjualan_master');

				$nota 	= $this->M_penjualan_master->get_baris($id_penjualan)->row()->nomor_nota;
				$hapus 	= $this->M_penjualan_master->hapus_transaksi($id_penjualan, $reverse_stok);
				if($hapus)
				{
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Transaksi <b>".$nota."</b> berhasil dihapus !</font>
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

	public function pelanggan()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'spv' OR $level == 'master' OR $level == 'kasir' OR $level == 'keuangan' OR $level == 'marketing')
		{
			$this->load->view('penjualan/pelanggan_data');
		}
	}

	public function pelanggan_json()
	{
		$this->load->model('M_pelanggan');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->M_pelanggan->fetch_data_pelanggan($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
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
			$nestedData[]	= $row['no_ktp_pasien'];
			$nestedData[]	= $row['nama'];
			$nestedData[]	= $row['tempat_lahir_pasien'];
			$nestedData[]	= $row['tanggal_lahir_pasien'];
			$nestedData[]	= $row['jk_pasien'];
			$nestedData[]	= $row['umur_pasien'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/",'<br />', $row['alamat']);
			$nestedData[]	= $row['telp'];
			$nestedData[]	= $row['goldar_pasien'];
			$nestedData[]	= $row['riwayat_alergi'];
			$nestedData[]	= $row['email'];
			$nestedData[]	= $row['nama_perusahaan'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/",'<br />', $row['info_tambahan']);
			$nestedData[]	= $row['waktu_input'];
			
			if($level == 'admin' OR $level == 'master' OR $level == 'spv' OR $level == 'kasir' OR $level == 'keuangan') 
			{
				$nestedData[]	= "<a href='".site_url('penjualan/pelanggan-edit/'.$row['id'])."' id='EditPelanggan'><i class='fa fa-pencil'></i> Edit</a>";
			}

			if($level == 'admin' OR $level == 'master' OR $level == 'spv') 
			{
				$nestedData[]	= "<a href='".site_url('penjualan/pelanggan-hapus/'.$row['id'])."' id='HapusPelanggan'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function tambah_pelanggan()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'master' OR $level == 'spv' OR $level == 'kasir' )
		{
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('no_ktp_pasien','No Ktp pasien','trim|required|numeric|max_length[16]');
				$this->form_validation->set_rules('nama','Nama','trim|required|alpha_spaces|max_length[40]');
				$this->form_validation->set_rules('alamat','Alamat','trim|required|max_length[1000]');
				$this->form_validation->set_rules('telepon','Telepon / Handphone','trim|required|numeric|max_length[13]');
				$this->form_validation->set_rules('info','Info Tambahan Lainnya','trim|max_length[1000]');

				$this->form_validation->set_message('alpha_spaces','%s harus alphabet !');
				$this->form_validation->set_message('numeric','%s harus angka !');
				$this->form_validation->set_message('required','%s harus diisi !');

				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('M_pelanggan');
					$jk_pasien 		= $this->input->post('jk_pasien');
					$total = $this->M_pelanggan->getcount_pasien()->no_rm;
					$s = $total+1;
					$result = 'KGM'.$jk_pasien.get_month_id();
					for ($i = strlen($s); $i <= 5; $i++) {
						$result .= "0";
					}
					$no_rm				= $result.$s;
					$no_ktp_pasien		= $this->input->post('no_ktp_pasien');
					$nama 				= $this->input->post('nama');
					$tempat_lahir_pasien 		= $this->input->post('tempat_lahir_pasien');
					$tanggal_lahir_pasien 		= $this->input->post('tanggal_lahir_pasien');
					$biday = new DateTime($tanggal_lahir_pasien);
					$today = new DateTime();
					$diff = $today->diff($biday);
					$umur_pasien 		= $diff->y;
					$alamat 	= $this->clean_tag_input($this->input->post('alamat'));
					$telepon 	= $this->input->post('telepon');
					$goldar_pasien 	= $this->input->post('goldar_pasien');
					$riwayat_alergi 	= $this->input->post('riwayat_alergi');
					$email 	= $this->input->post('email');
					$nama_perusahaan 	= $this->input->post('nama_perusahaan');
					$info 		= $this->clean_tag_input($this->input->post('info'));

					$unique		= time().$this->session->userdata('ap_id_user');
					$insert 	= $this->M_pelanggan->tambah_pelanggan($no_rm, $no_ktp_pasien, $nama, $tempat_lahir_pasien, $tanggal_lahir_pasien, $jk_pasien, $umur_pasien, $alamat, $telepon, $goldar_pasien, $riwayat_alergi, $email, $nama_perusahaan, $info, $unique);
					if($insert)
					{
						$id = $this->M_pelanggan->get_dari_kode($unique)->row()->id;
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>".$nama."</b> berhasil ditambahkan sebagai pelanggan.</div>",
							'id' => $id,
							'no_rm' => $no_rm,
							'no_ktp_pasien' => $no_ktp_pasien,
							'nama' => $nama,
							'tempat_lahir_pasien' => $tempat_lahir_pasien,
							'tanggal_lahir_pasien' => $tanggal_lahir_pasien,
							'jk_pasien' => $jk_pasien,
							'umur_pasien' => $umur_pasien,
							'alamat' => preg_replace("/\r\n|\r|\n/",'<br />', $alamat),
							'telepon' => $telepon,
							'goldar_pasien' => $goldar_pasien,
							'riwayat_alergi' => $riwayat_alergi,
							'email' => $email,
							'nama_perusahaan' => $nama_perusahaan,
							'info' => (empty($info)) ? "<small><i>Tidak ada</i></small>" : preg_replace("/\r\n|\r|\n/",'<br />', $info)						
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
				$this->load->view('penjualan/pelanggan_tambah');
			}
		}
	}

	public function pelanggan_edit($id = NULL)
	{
		if( ! empty($id))
		{
			$level = $this->session->userdata('ap_level');
			if($level == 'admin' OR $level == 'master' OR $level == 'spv' OR $level == 'kasir' )
			{
				if($this->input->is_ajax_request())
				{
					$this->load->model('M_pelanggan');
					
					if($_POST)
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nama','Nama','trim|required|alpha_spaces|max_length[40]');
						$this->form_validation->set_rules('alamat','Alamat','trim|required|max_length[1000]');
						$this->form_validation->set_rules('telepon','Telepon / Handphone','trim|required|numeric|max_length[13]');
						$this->form_validation->set_rules('info','Info Tambahan Lainnya','trim|max_length[1000]');

						$this->form_validation->set_message('alpha_spaces','%s harus alphabet !');
						$this->form_validation->set_message('numeric','%s harus angka !');
						$this->form_validation->set_message('required','%s harus diisi !');

						if($this->form_validation->run() == TRUE)
						{
							$jk_pasien 		= $this->input->post('jk_pasien');
							$total = $this->M_pelanggan->getcount_pasien()->no_rm;
							$s = $total+1;
							$result = 'KGM'.$jk_pasien.get_month_id();
							for ($i = strlen($s); $i <= 5; $i++) {
								$result .= "0";
							}
							$no_rm				= $result.$s;
							$no_ktp_pasien		= $this->input->post('no_ktp_pasien');
							$nama 				= $this->input->post('nama');
							$tempat_lahir_pasien 		= $this->input->post('tempat_lahir_pasien');
							$tanggal_lahir_pasien 		= $this->input->post('tanggal_lahir_pasien');
							$biday = new DateTime($tanggal_lahir_pasien);
							$today = new DateTime();
							$diff = $today->diff($biday);
							$umur_pasien 		= $diff->y;
							$jk_pasien 				= $this->input->post('jk_pasien');
							$alamat 				= $this->clean_tag_input($this->input->post('alamat'));
							$telepon 				= $this->input->post('telepon');
							$goldar_pasien 			= $this->input->post('goldar_pasien');
							$riwayat_alergi 		= $this->input->post('riwayat_alergi');
							$email 					= $this->input->post('email');
							$nama_perusahaan 		= $this->input->post('nama_perusahaan');
							$info 					= $this->clean_tag_input($this->input->post('info'));

							$update 	= $this->M_pelanggan->update_pelanggan($id, $no_rm, $no_ktp_pasien, $nama, $tempat_lahir_pasien, $tanggal_lahir_pasien, $jk_pasien, $umur_pasien, $alamat, $telepon, $goldar_pasien, $riwayat_alergi, $email, $nama_perusahaan, $info);
							if($update)
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
						$dt['pelanggan'] = $this->M_pelanggan->get_baris($id)->row();
						$this->load->view('penjualan/pelanggan_edit', $dt);
					}
				}
			}
		}
	}

	public function pelanggan_hapus($id)
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'master' OR $level == 'spv')
		{
			if($this->input->is_ajax_request())
			{
				$this->load->model('M_pelanggan');
				$hapus = $this->M_pelanggan->hapus_pelanggan($id);
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

	public function cetakpdf($idNota = null){
		$this->load->model('M_penjualan_master');
		$this->load->model('M_penjualan_detail');
		if (!is_null($idNota)){
			$iMaster = $this->M_penjualan_master->getDetailPenjualan($idNota);
			$pDetail = $this->M_penjualan_master->getDetailPasien($idNota);
			$dDetail = $this->M_penjualan_master->getDetailDokter($idNota);
			$kDetail = $this->M_penjualan_master->getDetailKasir($idNota);
			$iDetail = $this->M_penjualan_detail->getDetail($iMaster->id_penjualan_m);
			$tDetail = $this->M_penjualan_detail->getDetailTindakan($iMaster->id_penjualan_m);
			// echo json_encode($iMaster);
		}

		$this->load->library('cfpdf');		
		$pdf = new FPDF('P','mm','A4');
		$pdf->AddPage();
		$pdf->Cell(130, 5, '', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(10, 5, '', 0, 0, 'L');
		$pdf->image('assets/images/icon.png');
		$pdf->SetFont('times','',13);

		$pdf->Text(45,18,'Klinik Get Medik',0);
		$pdf->Text(45,23,'Cyber 1 Building 5th Floors',0);
		$pdf->Text(45,28,'Jl. Kuningan Barat No.8, Kuningan Barat ',0);
		$pdf->Text(45,33,'Mampang Prapatan, Jakarta selatan 12710',0);
		$pdf->Text(45,38,'Telp. 021-5269588 ext.222',0);

		$pdf->Line(13,40,195,40);
		$pdf->Ln();

		$pdf->SetFont('times','',15);
		// $pdf->Cell(130, 5, '', 0, 0, 'L');
		// $pdf->Ln();
		$pdf->Cell(190, 5, 'INVOICE', 0, 0, 'C');
		$pdf->Ln();

		$pdf->Line(10,8,10,288);// garis vertikal kanan
		$pdf->Line(200,288,200,8);// garis vertikal kiri
		$pdf->Line(10,8,200,8);// garis horzontal atas
		$pdf->Line(10,288,200,288);// garis horizontal bawah
		$pdf->SetFont('times','',12);
		$pdf->Ln();
		$pdf->Cell(5, 5, '', 0, 0, 'L');
		$pdf->Cell(25, 5, 'No. Invoice', 0, 0, 'L'); 
		$pdf->Cell(3, 5, ':', 0, 0, 'L');
		$pdf->Cell(105, 5, $idNota, 0, 0, 'L');
		$pdf->Cell(45, 5, date('d-M-Y H:i:s', strtotime($iMaster->tanggal)), 0, 0, 'R');
		$pdf->Ln();

		$pdf->Cell(5, 5, '', 0, 0, 'L');
		$pdf->Cell(25, 5, 'No RM', 0, 0, 'L'); 
		$pdf->Cell(3, 5, ':', 0, 0, 'L');
		$pdf->Cell(85, 5, 'RM'.$pDetail->no_rm, 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(5, 5, '', 0, 0, 'L');
		$pdf->Cell(25, 5, 'Name', 0, 0, 'L'); 
		$pdf->Cell(3, 5, ':', 0, 0, 'L');
		$pdf->Cell(85, 5, $pDetail->nama, 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(5, 5, '', 0, 0, 'L');
		$pdf->Cell(25, 5, 'Address', 0, 0, 'L');
		$pdf->Cell(3, 5, ':', 0, 0, 'L'); 
		$pdf->Cell(85, 5, $pDetail->alamat, 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(5, 5, '', 0, 0, 'L');
		$pdf->Cell(25, 5, 'Doctor', 0, 0, 'L'); 
		$pdf->Cell(3, 5, ':', 0, 0, 'L');
		$pdf->Cell(85, 5, "Dr. ".$dDetail->nama_dokter, 0, 0, 'L');
		$pdf->Ln();
		$pdf->Ln();

		$pdf->SetFont('times','',11);
		$pdf->Line(13,80,195,80);
		$pdf->Cell(5, 5, '', 0, 0, 'L');
		$pdf->Cell(20, 5, 'CONSULTATION AND VISIT', 0, 0, 'L');

		$pdf->SetFont('times','',11);
		// $pdf->Line(13,98,195,98);
		$pdf->Cell(130, 5, '', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(7, 5, '', 0, 0, 'L');
		$pdf->Cell(10, 5, '', 0, 0, 'L');
		$pdf->Cell(60, 5, 'Name', 0, 0, 'L');
		$pdf->Cell(15, 5, 'Qty', 0, 0, 'L');
		$pdf->Cell(30, 5, 'Amount', 0, 0, 'L');
		$pdf->Cell(33, 5, '', 0, 0, 'L');
		$pdf->Cell(35, 5, 'Sub Total', 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(5, 5, '', 0, 0, 'C');
		$pdf->Cell(130, 5, '---------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		
		$no = 0;
		foreach($tDetail as $dt)
		{
	
			$pdf->Cell(7, 5, '', 0, 0, 'C');
			$pdf->Cell(10, 5, '', 0, 0, 'L');
			$pdf->Cell(60, 5, $dt->nama_tindakan, 0, 0, 'L');
			$pdf->Cell(15, 5, $dt->jumlah_beli, 0, 0, 'L');
			$pdf->Cell(30, 5, $dt->harga_satuan, 0, 0, 'L');
			$pdf->Cell(35, 5, '', 0, 0, 'L');
			$pdf->Cell(35, 5, $dt->sub_total, 0, 0, 'L');
			$pdf->Ln();

			$no++;
		}

		$pdf->Cell(5, 5, '', 0, 0, 'C');
		$pdf->Cell(130, 5, '---------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(5, 5, '', 0, 0, 'C');
		$pdf->Ln();

		$pdf->SetFont('times','',11);
		// $pdf->Line(13,98,195,98);
		$pdf->Cell(5, 5, '', 0, 0, 'L');
		$pdf->Cell(20, 5, 'DRUGS', 0, 0, 'L' );

		$pdf->SetFont('times','',11);
		// $pdf->Line(13,98,195,98);
		$pdf->Cell(130, 5, '', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(7, 5, '', 0, 0, 'L');
		$pdf->Cell(10, 5, '', 0, 0, 'L');
		$pdf->Cell(60, 5, 'Name', 0, 0, 'L');
		$pdf->Cell(15, 5, 'Qty', 0, 0, 'L');
		$pdf->Cell(30, 5, 'Amount', 0, 0, 'L');
		$pdf->Cell(33, 5, 'UOM', 0, 0, 'L');
		$pdf->Cell(35, 5, 'Sub Total', 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(5, 5, '', 0, 0, 'C');
		$pdf->Cell(130, 5, '---------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		
		$no = 0;
		foreach($iDetail as $d)
		{
	
			$pdf->Cell(7, 5, '', 0, 0, 'C');
			$pdf->Cell(10, 5, '', 0, 0, 'L');
			$pdf->Cell(60, 5, $d->nama_obat, 0, 0, 'L');
			$pdf->Cell(15, 5, $d->jumlah_beli, 0, 0, 'L');
			$pdf->Cell(30, 5, $d->harga_satuan, 0, 0, 'L');
			$pdf->Cell(35, 5, $d->merk, 0, 0, 'L');
			$pdf->Cell(35, 5, $d->sub_total, 0, 0, 'L');
			$pdf->Ln();

			$no++;
		}

		$pdf->Cell(5, 5, '', 0, 0, 'C');
		$pdf->Cell(130, 5, '---------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(5, 5, '', 0, 0, 'C');
		$pdf->Ln();
		
		
		$pdf->Cell(147, 5, 'Total', 0, 0, 'R');
		$pdf->Cell(10, 5, '', 0, 0, 'R');
		$pdf->Cell(15, 5, $iMaster->grand_total, 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(147, 5, 'Payment', 0, 0, 'R');
		$pdf->Cell(10, 5, '', 0, 0, 'R');
		$pdf->Cell(25, 5, $iMaster->bayar, 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(147, 5, 'Change', 0, 0, 'R');
		$pdf->Cell(10, 5, '', 0, 0, 'R');
		$pdf->Cell(25, 5, str_replace(',', '.', number_format(($iMaster->bayar - $iMaster->grand_total))), 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(5, 5, '', 0, 0, 'C');
		$pdf->Cell(130, 5, '---------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(7, 5, '', 0, 0, 'C');
		$pdf->Cell(25, 5, 'Note : ', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(7, 5, '', 0, 0, 'C');
		$pdf->Cell(130, 5, (($iMaster->keterangan_lain == '') ? 'Tidak Ada' : $iMaster->keterangan_lain), 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(5, 5, '', 0, 0, 'C');
		$pdf->Cell(130, 5, '---------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		
		$pdf->SetFont('times','',12);
		$pdf->Text(165,230,'Cashier',0);
		$pdf->Ln();
		$pdf->Text(162,265,$kDetail->nama,0);
		$pdf->Ln();
		$pdf->Line(13,282,195,282);
		$pdf->Cell(130, 5, '', 0, 0, 'L');
		$pdf->Ln();
		$pdf->SetFont('times','',8);
		$pdf->Cell(5, 5, '', 0, 0, 'C');
		$pdf->Text(13,286,'Invoice ini merupakan bukti pembayaran yang sah ',0);
		// $pdf->Cell(260, 5, "Harga obat obat sudah termasuk pajak 10% ", 0, 0, 'C');

		$pdf->Line(13,270,125,270);//kotak bawah
		$pdf->Line(13,252,125,252);//kotak atas
		$pdf->Line(125,252,125,270);//kotak kiri
		$pdf->Line(13,252,13,270);//kotak kanan
		$pdf->SetFont('times','',10);
		$pdf->Text(14,256,'PT. Layanan Medik Indonesia. NPWP : 747896014132000 ',0);
		$pdf->Text(14,260,'Invoice ini berlaku sebagai faktur pajak sesuai dengan peraturan ',0);
		$pdf->Text(14,264,'Harga Obat sudah termasuk pajak penambahan nilai ',0);
		$pdf->Text(14,268,'Reservasi rawat jalan Call Center 021-5269588 (Senin - Jumat 09.00 - 18.00) ',0);
		

		$pdf->Output();
	}
}