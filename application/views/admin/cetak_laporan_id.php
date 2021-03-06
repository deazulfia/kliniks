<?php
require_once('application/libraries/tcpdf/config/tcpdf_config.php');

			$pdf = new Pdf('PDF_PAGE_ORIENTATION', 'PDF_UNIT', 'PDF_PAGE_FORMAT', true, 'UTF-8', false);
			$pdf->SetTitle('Daftar Resep');
			$pdf->SetHeaderData("icon.png", 20, 'KLINIK GET MEDIK', "Cyber 1 Building 5th floors \nJl. Kuningan Barat No.8, Kuningan Barat, \nMampang Prapatan Jakarta Selatan 12710 \nTelp.021 - 5269588 ext.222", array(0,0,0),array(0,0,128));
			$pdf->setFooterData(array(255,64,0), array(0,64,128));
			
			$pdf->SetTopMargin(30);
			$pdf->setFooterMargin(20);
			$pdf->SetAutoPageBreak(true);
			$pdf->SetAuthor('Author');
			$pdf->SetDisplayMode('real', 'default');
			$pdf->AddPage();
			// set default header data
			
			// set margins
			$pdf->SetMargins(10, 500, 10); // kiri, atas, kanan
			$pdf->SetHeaderMargin(30); // mengatur jarak antara header dan top margin
			$pdf->SetFooterMargin(10); //  mengatur jarak minimum antara footer dan bottom margin
			$i=0;
			$html='<h3 align="center">Resep Pasien</h3>
					
					<table>
						<tr bgcolor="#ffffff">
							<th colspan="2" align="left"></th> <th colspan="2" align="right">'.$data->tanggal.'</th>
						</tr>
						<br><br>
						<tr><th></th></tr>
						<tr bgcolor="#ffffff">
							<th colspan="2" align="left">No RM : 	'.$data->no_rm.'</th> 
						</tr>
						<tr bgcolor="#ffffff">
							<th colspan="2" align="left">Nama Pasien : 	'.$data->nama.'</th>
						</tr>
						<tr bgcolor="#ffffff">
							<th colspan="2" align="left">TTL Lahir Pasien : 	'.$data->tempat_lahir_pasien.' , '.$data->tanggal_lahir_pasien.'</th>
						</tr>
						<tr bgcolor="#ffffff">
							<th colspan="2" align="left">Jenis Kelamin Pasien : 	'.$data->jk_pasien.'</th>
						</tr>
						<tr bgcolor="#ffffff">
							<th colspan="2" align="left">Umur Pasien : 	'.$data->umur_pasien.'</th>
						</tr>
						<tr><th></th></tr>
						<tr><th></th></tr>
						<hr />
						<tr><th></th></tr>
						<tr bgcolor="#ffffff">
							<th colspan="2" align="left">R/  	 	'.$data->nama_obat.'</th>
						</tr>
						<tr bgcolor="#ffffff">
							<th colspan="2" align="left">  	 	'.$data->jumlah_obat.' pcs</th>
						</tr>
						<tr bgcolor="#ffffff">
							<th colspan="2" align="left"> 	 	'.$data->keterangan.'</th>
						</tr>

						
							
						
						
						';	
						// }
			$html.='</table>';

			

			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('Report_resep_id.pdf', 'I');

			
?>
