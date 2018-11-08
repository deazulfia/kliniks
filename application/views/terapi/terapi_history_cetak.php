<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Cetak Riwayat Medik Pasien</title>
<style type="text/css">
<!--
.style2 {
  font-size: 14px;
  font-family: "Courier New", Courier, monospace;
  font-weight: bold;
}
.style14 {font-family: "Courier New", Courier, monospace; font-size: 13px; }
.style15 {font-size: 12px}
-->
tr th{
  font-family: "Courier New", Courier, monospace; font-size: 13px; font-weight: bold; 

}

tr td{
  font-family: "Courier New", Courier, monospace; font-size: 12px; 

}
</style>
</head>

<body onload="window.print()">
<br>
<table width="700" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <b><center>LAPORAN PEMERIKSAAN DOKTER</center></b>

    <center>Praktik Dokter dr. Hj. Siti Sundari, Sp.M,. M.kes <br> Jln. Soeradjitirtonegoro No.67, Bendogantungan, Klaten <br> Telp. (0272) 323210 </center>
    <td style="border-bottom:solid 1px #000000"><span class="style2">
   <br>  
    </span></td>
  </tr>
</table><br />

<table width="700" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td width="91"><span class="style14">No. Rekam Medis</span></td>
    <td width="91"><span class="style14">: NRP<?php echo $pasien->id;?></span></td>
  </tr>

  <tr>
    <td width="91"><span class="style14">Nama Pasien </span></td>
    <td width="151"><span class="style14">: <?php echo $pasien->namalengkap;?></span></td>
  </tr>

<tr>
    <td width="91"><span class="style14">Umur </span></td>
    <td width="151"><span class="style14">: <?php echo $pasien->umur;?> Th</span></td>
  </tr>

  <tr>
    <td width="91"><span class="style14">Jenis Kelamin </span></td>
    <td width="151"><span class="style14">: <?php echo $pasien->jenis_kelamin;?></span></td>
  </tr>

  <tr>
    <td width="91"><span class="style14">Alamat </span></td>
    <td width="151"><span class="style14">: <?php echo $pasien->alamat;?></span></td>
  </tr>
  
  
</table><br />
<table width="700" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr><th colspan="2" align="left">Data Keluhan</th></tr>
  <tr>
    <td style="border-top:1px solid #000;border-bottom:1px solid #000;">No.</td>
    <td style="border-top:1px solid #000;border-bottom:1px solid #000;">Tanggal</td>
    <td style="border-top:1px solid #000;border-bottom:1px solid #000;">Keluhan</td>
  </tr>

          <?php
          $no_keluhan=1;
            if(!empty($keluhan)):
          ?>
          <tr>
          <?php
          foreach($keluhan as $rowkeluhan):
                    ?>
                    <tr>
                        <td><?php echo $no_keluhan++;?></td>
                        <td><?php echo $rowkeluhan->tanggal;?></td>
                        <td><?php echo $rowkeluhan->keluhan;?></td>
                      </tr>
                    <?php
                    endforeach;
                    ?>
        <?php
          endif;
        ?>
        </table>
<br>
<table width="700" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr><th colspan="2" align="left">Data Diagnosa</th></tr>
  <tr>
    <td style="border-top:1px solid #000;border-bottom:1px solid #000;">No.</td>
    <td style="border-top:1px solid #000;border-bottom:1px solid #000;">Tanggal</td>
    <td style="border-top:1px solid #000;border-bottom:1px solid #000;">Diagnosa</td>
  </tr>
          <?php
          $no_diagnosa=1;
            if(!empty($diagnosa)):
          ?>
          <tr>
          <?php
          foreach($diagnosa as $rowdiagnosa):
                    ?>
                    <tr>
                        <td><?php echo $no_diagnosa++;?></td>
                        <td><?php echo $rowdiagnosa->tanggal;?></td>
                        <td><?php echo $rowdiagnosa->nama_penyakit;?></td>
                      </tr>
                    <?php
                    endforeach;
                    ?>
        <?php
          endif;
        ?>
        </table>
<br>

<table width="700" border="0" cellspacing="0" cellpadding="3" align="center">
  <tr><th colspan="2" align="left">Data Tindakan</th></tr>
  <tr>
    <td style="border-top:1px solid #000;border-bottom:1px solid #000;">No.</td>
    <td style="border-top:1px solid #000;border-bottom:1px solid #000;">Tanggal</td>
    <td style="border-top:1px solid #000;border-bottom:1px solid #000;">Tindakan</td>

  </tr>
        <?php
          $no_tindakan=1;
            if(!empty($tindakan)):
          ?>
          <tr>
          <?php
          foreach($tindakan as $rowtindakan):
                    ?>
                    <tr>
                        <td><?php echo $no_tindakan++;?></td>
                        <td><?php echo $rowtindakan->tanggal;?></td>
                        <td><?php echo $rowtindakan->nama_tindakan;?></td>
                      </tr>
                    <?php
                    endforeach;
                    ?>
        <?php
          endif;
        ?>
        </table>
<br>

<table width="700" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><th colspan="4" align="left">Data Resep</th></tr>
  <tr>
    <td width="13"><div align="center" class="style14" style="border-top:1px solid #000;border-bottom:1px solid #000;"></div></td>
    <!-- <td width="13"><div align="center" class="style14" style="border-top:1px solid #000;border-bottom:1px solid #000;">No</div></td>
    <td width="179"><div align="center" class="style14" style="border-top:1px solid #000;border-bottom:1px solid #000;">Item</div></td>
    <td width="96"><div align="center" class="style14" style="border-top:1px solid #000;border-bottom:1px solid #000;">Etiket </div></td>
    <td width="96"><div align="center" class="style14" style="border-top:1px solid #000;border-bottom:1px solid #000;">Jumlah</div></td> -->
     </tr>
  <!-- <?php 
  #$no = 0;
  #foreach($terapi as $rowterapi){
  #$no++;
  ?> -->
  <tr>
    <td><div align="left" class="style14">Resep dokter dapat dicetak manual</div></td>
    <!-- <td><div align="center" class="style14"><?php #echo $no;?></div></td>
    <td><div align="center" class="style14"><?php #echo $rowterapi->terapi;?></div></td>
    <td><div align="center" class="style14"><?php #echo $rowterapi->etiket;?></div></td>
    <td><div align="center" class="style14"><?php #echo $rowterapi->jml;?></div></td> -->
  </tr>
 <!--  <?php 
  // }
  ?> -->
    
</table>
<br />
<table width="700" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td width="1200">&nbsp;</td><br><br><br>
    <td width="164" class="style14">Hormat Kami </td>
  </tr>
</table>
<script type="text/javascript">
document.onkeydown = function(e){
    if (e.keyCode==27){//--ESC--
       setTimeout('self.location.href = "http://localhost/dokterci/index.php/terapi"',0);
      }
    else if (e.keyCode==13){//--Tombol ENTER--
       window.print();
      }
    }</script>
</body>
</html>
