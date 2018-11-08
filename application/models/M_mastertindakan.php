<?php
class M_mastertindakan extends CI_Model{

	function __construct(){
		parent::__construct();
	}

	function simpan($data){
		$this->db->insert('master_tindakan', $data);
	}

	function tampil_mastertindakan($num='', $offset=''){
		$this->db->select(array(
			'tindakan_id',
			'kode_tindakan',
			'nama_tindakan',
			'biaya',
			), FALSE);
		
		$this->db->order_by('kode_tindakan', 'DESC');
		if ($num!='' && $offset!='') {
			$query = $this->db->get('master_tindakan',$num, $offset);
		} else{
			$query = $this->db->get('master_tindakan');
		}

		return $query->result();
	}

	function update_mastertindakan($data, $tindakan_id){
		$this->db->where('tindakan_id', $tindakan_id);
		$this->db->update('master_tindakan', $data);
	}

	function ambil_mastertindakan($id){
		$query = $this->db->get_where('master_tindakan', array('tindakan_id'=>$id));

		return $query->row();
	}

	function hapus_mastertindakan($tindakan_id){
		$this->db->where('tindakan_id', $tindakan_id);
		$this->db->delete('master_tindakan');
	}

	function cetak_mastertindakan(){

		$this->db->select('*');

		$query = $this->db->get('master_tindakan');
		return $query->result();

	}

	//datatables serverside mulai dari sini

	public function get_items()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));


		$query = $this->db->get('master_tindakan');


		$data = [];


		foreach($query->result() as $r) {
			$data[] = array(
				$r->kode_tindakan,
				$r->nama_tindakan,
				$r->biaya,
				'<a href="'.site_url().'/master_tindakan/ubah/'.$r->tindakan_id.'" class="btn btn-sm btn-info" title="Ubah Data"><i class="glyphicon glyphicon-pencil"></i></a>
				<a href="'.site_url().'/master_tindakan/hapus/'.$r->tindakan_id.'" class="btn btn-sm btn-danger" title="Ubah Data" onclick="return confirm(\'Yakin mau hapus data ini?\')"><i class="glyphicon glyphicon-trash"></i></a>',
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