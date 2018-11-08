<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pdf_model extends CI_Model {

	public function get_resep()
	{
		$query = $this->db->get('resep');
		return $query->result_array();
	}
	
	public function tampil()
	{
		$this->db->select('r.id_resep, r.nama_obat, r.jumlah_obat, r.keterangan, r.tanggal, r.waktu,
                            p.id, p.nama, p.tempat_lahir_pasien, p.tanggal_lahir_pasien, p.jk_pasien, p.umur_pasien, p.goldar_pasien, p.riwayat_alergi, 
                            d.sip, d.nama_dokter, d.spesialis,
                            m.id_rekam_medis, m.keluhan, m.diagnosa, m.saran_tindakan');
        $this->db->from('resep r');
        $this->db->join('pasien p', 'p.id = r.id', 'LEFT');
        $this->db->join('dokter d', 'd.id_dokter = r.id_dokter', 'LEFT');
        $this->db->join('rekam_medis m', 'm.id_rekam_medis = r.id_rekam_medis', 'LEFT');
		// $this->db->where('r.id_resep');
		// $this->db->where('m.id_rekam_medis',$id_rekam_medis);
		$query=$this->db->get();
		return $query->result();
    }
   
}
?>