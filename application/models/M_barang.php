<?php
class M_barang extends CI_Model 
{
	function fetch_data_barang($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_obat`, 
				a.`kode_obat`, 
				a.`nama_obat`,
				IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) AS total_stok,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				b.`kategori`,
				IF(c.`merk` IS NULL, '-', c.`merk` ) AS merk 
			FROM 
				`obat` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
				LEFT JOIN `pj_merk_barang` AS c ON a.`id_merk_barang` = c.`id_merk_barang` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak' 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`kode_obat` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`nama_obat` LIKE '%".$this->db->escape_like_str($like_value)."%'
				OR IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`keterangan` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR b.`kategori` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR c.`merk` LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`kode_obat`',
			2 => 'a.`nama_obat`',
			3 => 'b.`kategori`',
			4 => 'c.`merk`',
			5 => 'a.`total_stok`',
			6 => '`harga`',
			7 => 'a.`keterangan`'
		);
		
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function hapus_barang($id_obat)
	{
		$dt['dihapus'] = 'ya';
		return $this->db
				->where('id_obat', $id_obat)
				->update('obat', $dt);
	}

	function tambah_baru($kode, $nama, $id_kategori_barang, $id_merk_barang, $stok, $harga, $keterangan)
	{
		$dt = array(
			'kode_obat' => $kode,
			'nama_obat' => $nama,
			'total_stok' => $stok,
			'harga' => $harga,
			'id_kategori_barang' => $id_kategori_barang,
			'id_merk_barang' => (empty($id_merk_barang)) ? NULL : $id_merk_barang,
			'keterangan' => $keterangan,
			'dihapus' => 'tidak'
		);

		return $this->db->insert('obat', $dt);
	}

	function cek_kode($kode)
	{
		return $this->db
			->select('id_obat')
			->where('kode_obat', $kode)
			->where('dihapus', 'tidak')
			->limit(1)
			->get('obat');
	}

	function get_baris($id_obat)
	{
		return $this->db
			->select('id_obat, kode_obat, nama_obat, total_stok, harga, id_kategori_barang, id_merk_barang, keterangan')
			->where('id_obat', $id_obat)
			->limit(1)
			->get('obat');
	}

	function update_barang($id_obat, $kode_obat, $nama, $id_kategori_barang, $id_merk_barang, $harga, $keterangan)
	{
		$dt = array(
			'kode_obat' => $kode_obat,
			'nama_obat' => $nama,
			'harga' => $harga,
			'id_kategori_barang' => $id_kategori_barang,
			'id_merk_barang' => (empty($id_merk_barang)) ? NULL : $id_merk_barang,
			'keterangan' => $keterangan
		);

		return $this->db
			->where('id_obat', $id_obat)
			->update('obat', $dt);
	}

	function cari_kode($keyword, $registered)
	{
		$not_in = '';

		$koma = explode(',', $registered);
		if(count($koma) > 1)
		{
			$not_in .= " AND `kode_obat` NOT IN (";
			foreach($koma as $k)
			{
				$not_in .= " '".$k."', ";
			}
			$not_in = rtrim(trim($not_in), ',');
			$not_in = $not_in.")";
		}
		if(count($koma) == 1)
		{
			$not_in .= " AND `kode_obat` != '".$registered."' ";
		}

		$sql = "
			SELECT 
				`kode_obat`, `nama_obat`, `harga` 
			FROM 
				`obat` 
			WHERE 
				`dihapus` = 'tidak' 
				AND `total_stok` > 0 
				AND ( 
					`kode_obat` LIKE '%".$this->db->escape_like_str($keyword)."%' 
					OR `nama_obat` LIKE '%".$this->db->escape_like_str($keyword)."%' 
				) 
				".$not_in." 
		";

		return $this->db->query($sql);
	}

	function get_stok($kode)
	{
		return $this->db
			->select('nama_obat, total_stok')
			->where('kode_obat', $kode)
			->limit(1)
			->get('obat');
	}

	function get_id($kode_obat)
	{
		return $this->db
			->select('id_obat, nama_obat')
			->where('kode_obat', $kode_obat)
			->limit(1)
			->get('obat');
	}

	function update_stok($id_obat, $jumlahobat)
	{
		$sql = "
			UPDATE `obat` SET `total_stok` = `total_stok` - ".$jumlahobat." WHERE `id_obat` = '".$id_obat."'
		";

		return $this->db->query($sql);
	}

	function update_stok_obat($id_obat, $jumlah_beli)
	{
		$sql = "
			UPDATE `obat` SET `total_stok` = `total_stok` + ".$jumlah_beli." WHERE `id_obat` = '".$id_obat."'
		";

		return $this->db->query($sql);
	}

	function update_stoks($obat, $jumlah_beli)
	{
		$sql = "
			UPDATE `obat` SET `total_stok` = `total_stok` - ".$jumlah_beli." WHERE `id_obat` = '".$obat."'
		";

		return $this->db->query($sql);
	}

	function update_stokst($obat, $jumlah_beli)
	{
		$sql = "
			UPDATE `obat` SET `total_stok` = `total_stok` + ".$jumlah_beli." WHERE `id_obat` = '".$obat."'
		";

		return $this->db->query($sql);
	}

	function tambah_stok_obat($id_obat, $total_stok, $nama_admin)
	{
		$dt = array(
			'obat' => $id_obat,
			'total_stok' => $total_stok,
			'user' => $nama_admin,
			'tanggal' => date('Y-m-d H:i:s')
		);

		return $this->db->insert('barang_masuk', $dt);
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
		$this->db->insert_batch('obat', $data);
	}

	public function get_stok_by_id($id_obat){
        $this->db->select('total_stok, id_obat');
        $this->db->where('id_obat', $id_obat);
        $result = $this->db->get('obat');
        return $result->row();
    }

   public function addstokbyid($id_obat, $plus){
        $sql    = 'select (total_stok + ?) as total from obat where id_obat = ?';
        $query_total = $this->db->query($sql, array($plus,$id_obat));
        $total  = $query_total->row()->total;
        $sql    = 'update obat set total_stok= ? where id_obat = ?'; 
        
        $this->db->query($sql, array($total,$id_obat));
    }
}