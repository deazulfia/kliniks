<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends CI_Controller {
	public function __construct()
	{	
        parent::__construct();
        $this->load->library('pdf');
        $this->load->model('Pdf_model');
        $this->load->model('Pdf_model_id');
    }
        
	public function cetak_laporan()
	{
            
        $data = $this->Pdf_model->tampil();
        $datar =  array (      
            'data' => $data,);
        $this->load->view('admin/cetak_laporan', $datar);
    }	
    
    public function index()
    {
        $data['resep']=$this->Pdf_model_id->tampil();
        $this->load->view('admin/cetak_laporan_id',$data);
    }

    public function resep($id)
    {
        $data  =   $this->Pdf_model_id->tampil($id);
        $datas =  array (
            'data'   => $data,);
        $this->load->view('admin/cetak_laporan_id', $datas);
    }
}