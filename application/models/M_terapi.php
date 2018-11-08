<?php 

class M_terapi extends CI_Model{

	function __construct(){
		parent::__construct();
	}

	function ambil_data_pasien($pasien,$noreg=null){
		$this->db->select(array(
			'registrasi.no_reg',
			'registrasi.keluhan',
			'pasien.*'));
		$this->db->join('pasien','pasien.id = registrasi.pasien_id','LEFT');
		$this->db->where('registrasi.pasien_id',$pasien);
		
		if(!is_null($noreg)){
			$this->db->where('registrasi.no_reg',$noreg);
		}
		$query = $this->db->get('registrasi');

		return $query->row();
	}

	function jupuk_pasien(){
		$this->db->query('select a.id, a.nama, a.umur, a.alamat, a.telp, b.no_reg 
			from pasien a inner join registrasi b 
			on a.id=b.pasien_id where b.no_reg=REG000002');
	}

	function tampil_history($num, $offset){
		$this->db->select(array(
			'registrasi.no_reg',
			'registrasi.keluhan',
			"DATE_FORMAT(tgl_reg,'%d-%m-%Y %H:%M:%S') as tanggal",
			'pasien.*'));
		$this->db->join('pasien','pasien.id = registrasi.pasien_id','LEFT');
		$this->db->where('tampil',1);
		$this->db->order_by('registrasi.id','DESC');

		$query = $this->db->get('registrasi', $num, $offset);

		return $query->result();
	}


	function simpan_data($table, $data){
		$this->db->insert($table, $data);
	}

	function amburadul_data($table,$data){

    // $this->db->where($data);
    // $res1 = $this->db->get($table)->row();

    // if(empty($res1)){
    	$this->db->insert($table, $data);
	// }else{
	// 	return false;
	// }
	}


function tampil_history_keluhan($pasien){
	$this->db->select(array(
		"DATE_FORMAT(registrasi.tgl_reg, '%d-%m-%Y %H:%M:%S') as tanggal",
		'registrasi.keluhan'
	), FALSE);
	$this->db->order_by('registrasi.id','DESC');
	$query = $this->db->get_where('registrasi', array('registrasi.pasien_id'=>$pasien));

	return $query->result();
}


function tampil_diagnosa($noreg){
	$this->db->select('rekam_medis.*');
	$query = $this->db->get_where('rekam_medis', array('no_reg'=>$noreg));

	return $query->result();
}

function tampil_rekammedis($noreg){
	$this->db->select('rekam_medis.*');
	$query = $this->db->get_where('rekam_medis', array('no_reg'=>$noreg));

	return $query->result();
}

function tampil_obat($noreg){
	$this->db->select('resep.*,obat.*');
	$this->db->join('obat','obat.id_obat = resep.obat');
	$query = $this->db->get_where('resep', array('no_reg'=>$noreg));

	return $query->result();
}

function tampil_tindakanobat($noreg){
	$this->db->select('tindakan_obat.*,obat.*');
	$this->db->join('obat','obat.id_obat = tindakan_obat.obat');
	$query = $this->db->get_where('tindakan_obat', array('no_reg'=>$noreg));

	return $query->result();
}

function tampil_history_diagnosa($pasien){
	// print_r($pasien);
	// exit();
	$this->db->select(array(
		"DATE_FORMAT(registrasi.tgl_reg, '%d-%m-%Y %H:%M:%S') as tanggal",
		'diagnosa.*,master_diagnosa.nama_penyakit'
	), FALSE);
	$this->db->join('registrasi','registrasi.no_reg = diagnosa.no_reg');
	$this->db->join('master_diagnosa','master_diagnosa.diagnosa_id = diagnosa.diagnosa');
	$query = $this->db->get_where('diagnosa', array('diagnosa.pasien_id'=>$pasien));

	return $query->result();
}


function tampil_tindakan($noreg){
	$this->db->select('tindakan_medis.*,master_tindakan.*');
	$this->db->join('master_tindakan','master_tindakan.tindakan_id = tindakan_medis.obat');
	$query = $this->db->get_where('tindakan_medis',array('no_reg'=>$noreg));

	return $query->result();
}


function tampil_history_tindakan($pasien){
	$this->db->select(array(
		"DATE_FORMAT(registrasi.tgl_reg, '%d-%m-%Y %H:%M:%S') as tanggal",
		'tindakan.*, master_tindakan.nama_tindakan'
	),FALSE);
	$this->db->join('registrasi','registrasi.no_reg = tindakan.no_reg');
	$this->db->join('master_tindakan','master_tindakan.tindakan_id = tindakan.tindakan');
	$query = $this->db->get_where('tindakan', array('tindakan.pasien_id'=>$pasien));

	return $query->result();
}


function tampil_terapi($noreg){
	$this->db->order_by('id','DESC');
	$query = $this->db->get_where('terapi', array('no_reg'=>$noreg));
	return $query->result();
}

// function dokter($noreg){
// $query = $this->db->query("SELECT id_user,nama FROM `diperiksa_oleh` join users on diperiksa_oleh.id_user = users.id WHERE no_reg =".$noreg." and tanggal_periksa = '".date('Y-m-d')."'
// ");
// // var_dump($noreg);die;
//  return $query->row();
// }


function tampil_history_terapi($pasien){
	$this->db->select(array(
		"DATE_FORMAT(registrasi.tgl_reg, '%d-%m-%Y %H:%M:%S') as tanggal",
		'terapi.*'
	),FALSE);
	$this->db->join('registrasi','registrasi.no_reg = terapi.no_reg');
	$this->db->order_by('terapi.id','DESC');
	$query = $this->db->get_where('terapi', array('terapi.no_rm'=>$pasien));

	return $query->result();
}


function hapus_diagnosa($noreg, $pasien_id, $tekanandarah, $suhu, $denyutnadi, $diagnosa, $sarantindakan, $tanggal_periksa){
	$this->db->where('no_reg', $noreg);
	$this->db->where('pasien_id', $pasien_id);
	$this->db->where('tekanandarah', $tekanandarah);
	$this->db->where('suhu', $suhu);
	$this->db->where('denyutnadi', $denyutnadi);
	$this->db->where('diagnosa', $diagnosa);
	$this->db->where('sarantindakan', $sarantindakan);
	$this->db->where('tanggal_periksa', $tanggal_periksa);
	$this->db->delete('rekam_medis');
}

function hapus_obat($noreg, $pasien_id, $obat, $tanggal_periksa){
	$this->db->where('no_reg', $noreg);
	$this->db->where('pasien_id', $pasien_id);
	$this->db->where('obat', $obat);
	$this->db->where('tanggal_periksa', $tanggal_periksa);
	$this->db->delete('resep');
}

function hapus_tindakanobat($noreg, $pasien_id, $obat, $tanggal){
	$this->db->where('no_reg', $noreg);
	$this->db->where('pasien_id', $pasien_id);
	$this->db->where('obat', $obat);
	$this->db->where('tanggal', $tanggal);
	$this->db->delete('tindakan_obat');
}


function hapus_tindakan($noreg, $pasien_id, $obat, $tanggal_periksa){
	$this->db->where('no_reg', $noreg);
	$this->db->where('pasien_id', $pasien_id);
	$this->db->where('obat', $obat);
	$this->db->where('tanggal_periksa', $tanggal_periksa);
	$this->db->delete('tindakan_medis');
}

function hapus_terapi($id){
	$this->db->where('id', $id);
	$this->db->delete('terapi');
}

function update_stok($id_obat, $jumlah_beli)
{
	$sql = "
		UPDATE `obat` SET `total_stok` = `total_stok` - ".$jumlah_beli." WHERE `id_obat` = '".$id_obat."'
	";

	return $this->db->query($sql);
}


function selesai_periksa($data, $noreg){
	$this->db->where('no_reg', $noreg);
	$this->db->update('registrasi', $data);
}

function simpan_resep($data){
		$this->db->insert('terapi', $data);
}

function tampil_resep($noreg,$idpasien){
	 $query = $this->db->order_by('id', 'DESC')->limit('1')->get_where('terapi', array(
	 	'no_reg' => $noreg,
	 	'no_rm'=>$idpasien,
	 	'tgl'=>date('Y-m-d H-i-s'),
	 ));
return $query->row();
}

//end of class
}	