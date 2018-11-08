<!DOCTYPE html>
<html lang="en">
<head>
	<title>KLINIK GET MEDIK</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<!-- <link rel="icon" type="image/png" href="<?php echo base_url();?>assets/form/images/icons/favicon.ico"/> -->
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/form/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/form/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/form/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/form/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/form/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/form/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/form/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/form/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/form/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/form/css/main.css">
<!--===============================================================================================-->
</head>
<body>
  	<nav class="navbar navbar-default navbar-fixed-top">
    	<div class="container">
      		<div class="navbar-header">
        		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
        		</button>
        			<a class="navbar-brand" href="<?php echo base_url();?>terapi/index"><img src="<?php echo base_url();?>assets/images/back.png"></a>
				</div>
			</div>
		</div>	
  	</nav>
	<div class="container-contact100">
		<div class="wrap-contact100">
			<form action="<?php echo base_url(). 'Resepp/proses_input'; ?>" method="post" class="contact100-form validate-form">
				<div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
							<div class="wrap-input100 validate-input" data-validate="Name is required">
								<input class="input100" name="nama" id="nama" value="<?php echo $pasien->nama ?>" disabled>
								<label class="label-input100" for="name">
									<span class="lnr lnr-user"></span>
								</label>
							</div>
						</div>
						<div class="col-sm-6">
        					<div class="wrap-input100 validate-input" data-validate="Name is required">
								<input class="input100" name="jk_pasien" value="<?php echo $pasien->jk_pasien ?>" id="jk_pasien" disabled>
								<label class="label-input100" for="name">
									<span class="lnr lnr-users"></span>
								</label>
        					</div>
						</div>
					</div>
				</div>
				<div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
							<div class="wrap-input100 validate-input" data-validate="Name is required">
								<input class="input100" name="tempat_lahir_pasien" id="tempat_lahir_pasien" value="<?php echo $pasien->tempat_lahir_pasien ?>" disabled>
								<label class="label-input100" for="name">
									<span class="lnr lnr-map-marker"></span>
								</label>
							</div>
						</div>
						<div class="col-sm-6">
        					<div class="wrap-input100 validate-input" data-validate="Name is required">
								<input class="input100" name="tanggal_lahir_pasien" id="tanggal_lahir_pasien" value="<?php echo $pasien->tanggal_lahir_pasien ?>" disabled>
								<label class="label-input100" for="name">
									<span class="lnr lnr-calendar-full"></span>
								</label>
        					</div>
						</div>
					</div>
				</div>
				<div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
							<div class="wrap-input100 validate-input" data-validate="Name is required">
								<input class="input100" name="umur_pasien" id="umur_pasien" value="<?php echo $pasien->umur_pasien ?>" disabled>
								<label class="label-input100" for="name">
									<span class="lnr lnr-pencil"></span>
								</label>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="wrap-input100 validate-input" data-validate="Name is required">
								<input class="input100" name="goldar_pasien" id="goldar_pasien" value="<?php echo $pasien->goldar_pasien ?>" disabled>
								<label class="label-input100" for="name">
									<span class="lnr lnr-drop"></span>
								</label>
							</div>
						</div>
					</div>
				</div>
        		<div class="wrap-input100 validate-input" data-validate="Name is required">
					<input class="input100" name="nama" id="nama" value="<?php echo $pasien->keluhan ?>" disabled>
					<label class="label-input100" for="name">
						<span class="lnr lnr-inbox"></span>
					</label>
        		</div>

				<div class="wrap-input100 validate-input" data-validate = "Phone is required">
					<input class="input100" name="tekanan_darah" placeholder="Tekanan Darah" id="tekanan_darah">
        		</div>

				<div class="wrap-input100 validate-input" data-validate = "Phone is required">
					<input class="input100" name="suhu" placeholder="Suhu" id="suhu">
        		</div>

				<div class="wrap-input100 validate-input" data-validate = "Phone is required">
					<input class="input100" name="denyut_nadi" placeholder="Denyut Nadi" id="denyut_nadi">
        		</div>

        		<div class="wrap-input100 validate-input" data-validate = "Phone is required">
					<textarea class="input100" name="nama_obat" class="form-control" placeholder="Nama obat" id="nama_obat">R/</textarea>
        		</div>

				<div class="form-group">
            		<label for="jumlah_obat">Isi Berita</label>
					<textarea id="ckeditor" name="berita" class="form-control" required></textarea><br/>
         		</div>

       			<div class="wrap-input100 validate-input" data-validate = "Phone is required">
					<input class="input100" name="diagnosa" placeholder="Diagnosa" id="diagnosa">
        		</div>
        
        		<div class="wrap-input100 validate-input" data-validate = "Phone is required">
					<input class="input100" name="saran_tindakan" id="saran_tindakan" placeholder="Saran dan Tindakan">
        		</div>
				<input type="hidden" name="id_resep">
				<input type="hidden" name="id_rekam_medis">
				<input type="hidden" name="id" value="<?php echo $pasien->id;?>">

				<div class="container-contact100-form-btn">
					<div class="wrap-contact100-form-btn">
						<div class="contact100-form-bgbtn"></div>
						<button type="submit" class="contact100-form-btn">
							Buat Resep
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>



	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
	<script src="<?php echo base_url();?>assets/form/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url();?>assets/form/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url();?>assets/form/vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo base_url();?>assets/form/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url();?>assets/form/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url();?>assets/form/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?php echo base_url();?>assets/form/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url();?>assets/form/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url();?>assets/form/js/main.js"></script>
</body>
</html>
