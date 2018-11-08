<?php 

class M_pasien extends CI_Model{

	function __construct(){
		parent::__construct();
	}

	function fetch_data_pasien($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id`,
				a. `no_rm`,
				a.`no_ktp_pasien`, 
				a.`nama`,
				a.`tempat_lahir_pasien`,
				DATE_FORMAT(a.`tanggal_lahir_pasien`, '%d %b %Y') AS tanggal_lahir_pasien,
				a.`jk_pasien`,
				a.`umur_pasien`,
				a.`alamat`,
				a.`telp`,
				a.`goldar_pasien`,
				a.`riwayat_alergi`,
				a.`email`,
				a.`nama_perusahaan`,
				a.`info_tambahan`,
				DATE_FORMAT(a.`waktu_input`, '%d %b %Y - %H:%i:%s') AS waktu_input 
			FROM 
				`pasien` AS a 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak' 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`no_rm` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`no_ktp_pasien` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`tempat_lahir_pasien` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR DATE_FORMAT(a.`tanggal_lahir_pasien`, '%d %b %Y ') LIKE '%".$this->db->escape_like_str($like_value)."%'  
				OR a.`jk_pasien` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`umur_pasien` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`alamat` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`telp` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`goldar_pasien` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`riwayat_alergi` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`email` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`nama_perusahaan` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR a.`info_tambahan` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR DATE_FORMAT(a.`waktu_input`, '%d %b %Y - %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`no_rm`',
			2 => 'a.`no_ktp_pasien`',
			3 => 'a.`nama`',
			4 => 'a.`tempat_lahir_pasien`',
			5 => 'a.`tanggal_lahir_pasien`',
			6 => 'a.`jk_pasien`',
			7 => 'a.`umur_pasien`',
			8 => 'a.`alamat`',
			9 => 'a.`telp`',
			10 => 'a.`goldar_pasien`',
			11 => 'a.`riwayat_alergi`',
			12 => 'a.`email`',
			13 => 'a.`nama_perusahaan`',
			14 => 'a.`info_tambahan`',
			15 => 'a.`waktu_input`'
		);

		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function tampil_pasien($num, $offset){
		$this->db->select(array(
			'id',
			'no_rm',
			'nama',
			'tanggal_lahir_pasien',
			'umur_pasien',
			'alamat'
			), FALSE);
		$this->db->where('tampil', 0);
		$this->db->where('dihapus', 'tidak');
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get('pasien',$num, $offset);

		return $query->result();
	}

	public function upload_file($filename){
		$this->load->library('upload'); 
		
		$config['upload_path'] = './excel/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size']	= '2048';
		$config['overwrite'] = true;
		$config['file_name'] = $filename;
	
		$this->upload->initialize($config);
		if($this->upload->do_upload('file')){

			$return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
			return $return;
		}else{

			$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
			return $return;
		}
	}
	
	public function insert_multiple($data){
		$this->db->insert_batch('pasien', $data);
	}

	function search($keyword)
    {
        $this->db->or_like('id',$keyword);
        $this->db->or_like('nama',$keyword);
        $this->db->or_like('alamat',$keyword);                         
        $this->db->or_like('tanggal_lahir_pasien',$keyword);
        $query =  $this->db->get('pasien');
        return $query->result();
    }

	function cetak_pasien(){

		$this->db->select('*');

		$query = $this->db->get('pasien');
		return $query->result();

	}


	function simpan_pasien($data){
		$this->db->insert('pasien', $data);
	}


	function ambil_pasien($id){
		$query = $this->db->get_where('pasien', array('id'=>$id));

		return $query->row();
	}


	function update_pasien($data, $id){
		$this->db->where('id', $id);
		$this->db->update('pasien', $data);
	}

//end of class	
}