<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporan_obat_masuk extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		$level 		= $this->session->userdata('ap_level');
		$allowed	= array('admin', 'master', 'marketing', 'keuangan',  'spv');

		if( ! in_array($level, $allowed))
		{
			redirect();
		}
	}

	public function index()
	{
		$this->load->view('laporan/form_laporan_obat_masuk');//buat view 
	}

	public function penjualan_obat_masuk($from, $to)
	{
		$this->load->model('M_penjualan_master');
		$dt['penjualan'] 	= $this->M_penjualan_master->laporan_penjualan_obat_masuk($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_penjualan_obat_masuk', $dt);//buat view
	}

	public function excel($from, $to)
	{
		$this->load->model('M_penjualan_master');
		$penjualan 	= $this->M_penjualan_master->laporan_penjualan_obat_masuk($from, $to);
		if($penjualan->num_rows() > 0)
		{
			$filename = 'Laporan_Penjualan_obat_masuk_'.$from.'_'.$to;
			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment; filename=".$filename.".xls");

			echo "
				<h4>Laporan Obat Masuk Tanggal ".date('d/m/Y', strtotime($from))." - ".date('d/m/Y', strtotime($to))."</h4>
				<table border='1' width='100%'>
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal</th>
							<th>Obat</th>
							<th>Jumlah Obat</th>
							<th>Input By</th>
						</tr>
					</thead>
					<tbody>
			";

			$no = 1;
			foreach($penjualan->result() as $p)
			{
				echo "
					<tr>
						<td>".$no."</td>
						<td>".date('d F Y', strtotime($p->tanggal))."</td>
						<td>".$p->nama_obat."</td>
						<td>".$p->total_stok."</td>
						<td>".$p->nama."</td>
					</tr>
				";

				$no++;
			}

			echo "
			</tbody>
			</table>
			";
		}
	}

	public function pdf($from, $to)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(0, 8, "Laporan Obat Masuk Tanggal ".date('d/m/Y', strtotime($from))." - ".date('d/m/Y', strtotime($to)), 0, 1, 'L'); 

		$pdf->Cell(10, 7, 'No', 1, 0, 'L'); 
		$pdf->Cell(35, 7, 'Tanggal', 1, 0, 'L');
		$pdf->Cell(50, 7, 'Obat', 1, 0, 'L'); 
		$pdf->Cell(25, 7, 'Jumlah Obat', 1, 0, 'L'); 
		$pdf->Cell(50, 7, 'Input By', 1, 0, 'L'); 
		$pdf->Ln();

		$this->load->model('M_penjualan_master');
		$penjualan 	= $this->M_penjualan_master->laporan_penjualan_obat_masuk($from, $to);

		$no = 1;
		foreach($penjualan->result() as $p)
		{
			$pdf->Cell(10, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(35, 7, date('d F Y', strtotime($p->tanggal)), 1, 0, 'L');
			$pdf->Cell(50, 7, $p->nama_obat, 1, 0, 'L');
			$pdf->Cell(25, 7, $p->total_stok, 1, 0, 'L');
			$pdf->Cell(50, 7, $p->nama, 1, 0, 'L');
			$pdf->Ln();

			$no++;
		}

		// $pdf->Cell(100, 7, 'Total Seluruh Penjualan', 1, 0, 'L'); 
		// $pdf->Cell(85, 7, "Rp. ".str_replace(",", ".", number_format($resep)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}
}