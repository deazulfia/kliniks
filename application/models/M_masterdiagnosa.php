<?php
class M_masterdiagnosa extends CI_Model{

	function __construct(){
		parent::__construct();
	}

	function simpan($data){
		$this->db->insert('master_diagnosa', $data);
	}

	function tampil_masterdiagnosa($num='', $offset=''){
		$this->db->select(array(
			'diagnosa_id',
			'kode_icd',
			'nama_penyakit',
		), FALSE);
		
		$this->db->order_by('kode_icd', 'DESC');
		if ($num!='' && $offset!='') {
			$query = $this->db->get('master_diagnosa',$num, $offset);
		} else{
			$query = $this->db->get('master_diagnosa');
		}
		return $query->result();
	}

	function update_masterdiagnosa($data, $diagnosa_id){
		$this->db->where('diagnosa_id', $diagnosa_id);
		$this->db->update('master_diagnosa', $data);
	}

	function ambil_masterdiagnosa($diagnosa_id){
		$query = $this->db->get_where('master_diagnosa', array('diagnosa_id'=>$diagnosa_id));

		return $query->row();
	}

	function hapus_masterdiagnosa($diagnosa_id){
		$this->db->where('diagnosa_id', $diagnosa_id);
		$this->db->delete('master_diagnosa');
	}

	function cetak_masterdiagnosa(){
		$this->db->select('*');
		$query = $this->db->get('master_diagnosa');
		return $query->result();
	}

	function cari_diagnosa($keyword = '')
	{
		$this->db->select(array(
			'diagnosa_id',
			'kode_icd',
			'nama_penyakit',
		), FALSE);
		
		$this->db->like('kode_icd', $keyword);
		$this->db->or_like('nama_penyakit', $keyword);
		$this->db->order_by('kode_icd', 'DESC');
		$query = $this->db->get('master_diagnosa');
		return $query->result();
	}

//datatables serverside mulai dari sini

	public function get_items()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));


		$query = $this->db->get('master_diagnosa');


		$data = [];


		foreach($query->result() as $r) {
			$data[] = array(
				$r->kode_icd,
				$r->nama_penyakit,
				'<a href="'.site_url().'/master_diagnosa/ubah/'.$r->diagnosa_id.'" class="btn btn-sm btn-info" title="Ubah Data"><i class="glyphicon glyphicon-pencil"></i></a>
				<a href="'.site_url().'/master_diagnosa/hapus/'.$r->diagnosa_id.'" class="btn btn-sm btn-danger" title="Ubah Data" onclick="return confirm(\'Yakin mau hapus data ini?\')"><i class="glyphicon glyphicon-trash"></i></a>',
			);
		}


		$result = array(
			"draw" => $draw,
			"recordsTotal" => $query->num_rows(),
			"recordsFiltered" => $query->num_rows(),
			"data" => $data
		);


		echo json_encode($result);
		exit();
	}


}