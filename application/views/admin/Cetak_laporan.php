<?php
			$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
			$pdf->SetTitle('Data Resep');
			$pdf->SetHeaderMargin(5);
			$pdf->SetTopMargin(5);
			$pdf->setFooterMargin(0);
			$pdf->SetAutoPageBreak(true);
			$pdf->SetAuthor('KlinikGetMedik');
			$pdf->SetDisplayMode('real', 'default');
			$pdf->AddPage();
			$i=0;
			$html='<h3>Data Pasien Klinik</h3>
					<table cellspacing="1" bgcolor="#666666" cellpadding="1">
						<tr bgcolor="#ffffff">
							<th width="7%" 	align="center">No</th>
							<th width="12%" align="center">No. RM</th>
							<th width="11%" align="center">ID Pasien</th>
							<th width="15%" align="center">Nama Pasien</th>
							<th width="14%" align="center">Nama Obat</th>
							<th width="13%" align="center">Keluhan</th>
							<th width="14%" align="center">Diagnosa</th>
							<th width="14%" align="center">Saran Dan Tindakan</th>
						</tr>';
			foreach ($data as $r) 
				{
					$i++;
					$html.='<tr bgcolor="#ffffff">
							<td align="center">'.$i.'</td>
							<td align="center">'.$r->id_rekam_medis.'</td>
							<td align="center">'.$r->id.'</td>
							<td align="center">'.$r->nama.'</td>
							<td align="center">'.$r->nama_obat.'</td>
							<td align="center">'.$r->keluhan.'</td>
							<td align="center">'.$r->diagnosa.'</td>
							<td align="center">'.$r->saran_tindakan.'</td>
						</tr>';
				}
			$html.='</table>';
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->Output('Report_resep.pdf', 'I');
?>
