<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url();?>assets/assets/favicon/apple-icon-57x57.png">
<title>Data Rekam Medik</title>
<style type="text/css">

.style2 {
	font-size: 14px;
	font-family: "Courier New", Courier, monospace;
	font-weight: bold;
}
.style14 {font-family: "Courier New", Courier, monospace; font-size: 13px; }
.style15 {font-size: 12px}

tr th{
  font-family: "Courier New", Courier, monospace; font-size: 13px; font-weight: bold; 

}

tr td{
  font-family: "Courier New", Courier, monospace; font-size: 12px; 

}
.baru{
  margin-left:100px;
  width:100px;
  height:100px;
}
</style>
</head>

<body onload="window.print()"><br><br>
    <table width="700" border="0" cellspacing="0" cellpadding="2" align="center">
      <tr>
      
        <?php echo "<b><center>RESEP OBAT KLINIK</center></b>

        <center>KLINIK GET MEDIK<br> Cyber 1 Building 5th Floors <br> Jl. Kuningan Barat No.8, Kuningan Barat <br> Mampang Prapatan, Jakarta selatan 12710 <br>Telp. 021-5269588 ext.222 </center>";?><hr><vr>
        <!-- <td style="border-bottom:solid 1px #000000"><span class="style2"> -->
        <!-- <img class="baru" src="<?php echo base_url();?>assets/images/icon.png"> -->
        <br />
      <br />  
        </span></td>
      </tr>
    </table><br />

    <table width="700" border="0" cellspacing="0" cellpadding="2" align="center">
      <tr>
        <td width="53"><span class="style14">NO. </span></td>
        <td width="164"><span class="style14">: <?php echo $pasien->no_reg;?></span></td>
      <td width="21"><span class="style15"></span></td>
        <td width="91"><span class="style14">Nama Pasien </span></td>
        <td width="151"><span class="style14">: <?php echo $pasien->nama;?> </span></td>
      </tr>
      <tr>
        <td><span class="style14">Tanggal</span></td>
        <td><span class="style14">: <?php echo date('d-m-Y');?> </span></td>
      <td><span class="style15"></span></td>
        <td><span class="style14">Jam</span></td>
        <td><span class="style14">: <?php echo date('H:i:s');?></span></td>
      </tr>
      
    </table><br/><br/>

    <table width="700" border="0" cellspacing="0" cellpadding="2" align="center">
        <?php 
        $no = 1;
          foreach($diagnosa as $rowdiagnosa):
          ?>
      <tr>
        <td width="95"><span class="style14">Tekanan Darah </span></td>
        <td width="164"><span class="style14">: <?php echo $rowdiagnosa->tekanandarah;?></span></td>
      </tr>
      <tr>
        <td width="95"><span class="style14">Suhu Badan </span></td>
        <td width="164"><span class="style14">: <?php echo $rowdiagnosa->suhu;?></span></td>
      </tr>
      <tr>
        <td width="95"><span class="style14">Denyut Nadi </span></td>
        <td width="164"><span class="style14">: <?php echo $rowdiagnosa->denyutnadi;?></span></td>
      </tr>
      <tr>
        <td width="95"><span class="style14">Diagnosa </span></td>
        <td width="164"><span class="style14">: <?php echo $rowdiagnosa->diagnosa;?></span></td>
      </tr>
      <tr>
        <td width="95"><span class="style14">Saran Tindakan </span></td>
        <td width="164"><span class="style14">: <?php echo $rowdiagnosa->sarantindakan;?></span></td>
      </tr>
      

      <?php
            $no++;
          endforeach;
      ?>
      
    </table><br/><br/><br/><br/>




    <table width="700" border="0" cellspacing="0" cellpadding="3" align="center">
      <tr><th colspan="2" align="left">Data Resep</th></tr>
      <tr>
        <td style="border-top:1px solid #000;border-bottom:1px solid #000;">No.</td>
        <td style="border-top:1px solid #000;border-bottom:1px solid #000;">Resep</td>
        <td style="border-top:1px solid #000;border-bottom:1px solid #000;">Jumlah Obat</td>
        <td style="border-top:1px solid #000;border-bottom:1px solid #000;">keterangan Obat</td>
      </tr>
      <?php 
        if(empty($obat)){
          echo '<tr><th colspan="2">Data tidak tersedia.</th></tr>';
        }else{
          $no = 1;
          foreach($obat as $rowresep):
            ?>
            <tr>
              <td><?php echo $no;?></td>
              <td><?php echo $rowresep->nama_obat;?></td>
              <td><?php echo $rowresep->jumlahobat;?></td>
              <td><?php echo $rowresep->keteranganobat;?></td>
            </tr>
            <?php
            $no++;
          endforeach;
        }
      ?>
    </table>
    <br>


    <table width="700" border="0" cellspacing="0" cellpadding="3" align="center">
      <tr><th colspan="2" align="left">Data Tindakan</th></tr>
      <tr>
        <td style="border-top:1px solid #000;border-bottom:1px solid #000;">No.</td>
        <td style="border-top:1px solid #000;border-bottom:1px solid #000;">Tindakan</td>
        <!-- <td align="right" style="border-top:1px solid #000;border-bottom:1px solid #000;">Biaya(Rp)</td> -->
      </tr>
      <?php 
      $sum = 0;
        if(empty($tindakan)){
          echo '<tr><th colspan="2">Data tidak tersedia.</th></tr>';
        }else{
          $no = 1;
          
          foreach($tindakan as $rowtindakan):
            ?>
            <tr>
              <td><?php echo $no;?></td>
              <td><?php echo $rowtindakan->nama_tindakan;?></td>
              <!-- <td align="right"><?php echo number_format($rowtindakan->biaya,2,',','.');?></td> -->
            </tr>
            <?php
            $sum += $rowtindakan->biaya;
            $no++;
          endforeach;
        }
      ?>
    </table>
    <br>

    <table width="700" border="0" cellspacing="0" cellpadding="2" align="center">
      <tr>
        <td width="1200">&nbsp;</td><br><br><br>
        <!-- <td width="164" class="style14">Hormat Kami </td> -->
        <br>
        <br>
        <br>
        <br>
      </tr>
    </table>
    <script type="text/javascript">
    document.onkeydown = function(e){
        if (e.keyCode==27){//--ESC--
          setTimeout('self.location.href = "<?php echo site_url();?>/terapi"',0);
          }
        else if (e.keyCode==13){//--Tombol ENTER--
          window.print();
          }
    }</script>
</body>
</html>
