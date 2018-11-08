<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Klinik GM</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>assets/css/colors.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sweetalert.css"/>

	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/plugins/buttons/spin.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/plugins/buttons/ladda.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/core/app.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/pages/components_modals.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/pages/components_buttons.js"></script>



	<!-- /theme JS files -->

    <style>
        .sidebar-user{
            height: 92px;
        }
    </style>

</head>
<body>
    <!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="#"><p> KLINIK Get Medik </p></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>

			<!-- <p class="navbar-text"><span class="label bg-success">Online</span></p> -->

			<ul class="nav navbar-nav navbar-right">
                <li><a href="<?php echo site_url('secure/logout'); ?>"><i class="icon-switch2"></i> Logout</a></li>

			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main">
				<div class="sidebar-content">

					<!-- User menu -->
					<div class="sidebar-user">
						<div class="category-content">
							<div class="media">
                                <!-- <a href="#" class="media-left"><img src="<?php echo base_url();?>assets/images/icon.png" class="img-sm" alt=""></a> -->
                                <div class="media-body">
									<!-- <span class="media-heading text-semibold">KLINIK GET MEDIK</span> -->
								</div>
							</div>
						</div>
					</div>
					<!-- /user menu -->


					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">

								<!-- Main -->
								<li><a href="<?php echo base_url();?>terapi/index"><i class="icon-people"></i> <span>Daftar Pasien</span></a></li>
                                <li><a href="<?php echo base_url();?>resepp/index"><i class="icon-list-unordered"></i> <span>Data Resep</span></a></li>
								<!-- <li><a href="<?php echo base_url();?>Dokter/resep/index"><i class="icon-clipboard2"></i> <span>Resep</span></a></li> -->
                                </ul>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
						</div>

						<div class="heading-elements">
							<div class="heading-btn-group">
							</div>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<li><a href="<?php echo base_url();?>"><i class="icon-home2 position-left"></i> Home</a></li>
							<li class="active">Data Pasien</li>
						</ul>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
                    <div class="panel panel-flat">
						<div class="panel-heading">
                            <h5 class="panel-title">Data Pasien</h5>
                            <br />
                            <br />
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                		<li><a data-action="close"></a></li>
			                	</ul>
		                	</div>
						</div>
                        </center>
                        <div class="alert alert-success" role="alert" id="pesan"></div>
                            <table id="pasien" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID Pendaftaran</th>
                                        <th>Keluhan</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>ID Pasien</th>
                                        <th>Nama Pasien</th>
                                        <th style="width:25px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($pendaftaran as $p){?>
                                        <tr>
                                            <td><?php echo $p->id_pendaftaran;?></td>
                                            <td><?php echo $p->keluhan;?></td>
                                            <td><?php echo $p->tanggal_pendaftaran;?></td>
                                            <td><?php echo $p->waktu_pendaftaran;?></td>
                                            <td><?php echo $p->id;?></td>
                                            <td><?php echo $p->nama;?></td>
                                            <td>
                                                <a class="btn btn-lg btn-success big-btn apple-btn" href="<?php echo base_url();?>Resepp/resep/<?php echo $p->id;?>">
									                <img src="<?php echo base_url();?>assets/images/h.png" width="18%" height="2%">
								                </a>
                                                <!-- <button type="button" class="btn btn-info btn-icon btn-rounded" href="<?php echo base_url();?>dokter/Resepp/index/" onclick="update_pasien(<?php echo $pasien->id;?>)"><i class="glyphicon glyphicon-pencil"></i></button> -->
                                            </td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="footer text-muted">
                        &copy; 2018. Klinik GM
                    </div>
			    </div>
			<!-- /main content -->
		</div>
		<!-- /page content -->
	</div>
    <!-- /page container -->
    
    <script type="text/javascript">
        $(document).ready( function () {
            $('#pasien').DataTable({
                "scrollX": true,
                "order": [[ 0, "desc" ]]
            });            

        });
        
        var save_method; //for save method string
        var table;
        $('#pesan').hide();

        function add_pasien(){
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.error_msg').hide();    
        }

        function update_pasien(id){
            $('.error_msg').hide();
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals

            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('dokter/Pasien/ajax_edit/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    $('[name="id"]').val(data.id);
                    $('[name="nama"]').val(data.nama);
                    $('[name="tempat_lahir_pasien"]').val(data.tempat_lahir_pasien);
                    $('[name="tanggal_lahir_pasien"]').val(data.tanggal_lahir_pasien);
                    $('[name="jk_pasien"]').val(data.jk_pasien);
                    $('[name="umur_pasien"]').val(data.umur_pasien);
                    $('[name="goldar_pasien"]').val(data.goldar_pasien);
                    $('[name="riwayat_alergi"]').val(data.riwayat_alergi);
                    $('[name="sip"]').val(data.sip);
                    $('[name="keluhan"]').val(data.keluhan);
                    $('[name="diagnosa"]').val(data.diagnosa);
                    $('[name="saran_tindakan"]').val(data.saran_tindakan);
                    $('[name="nama_obat"]').val(data.nama_obat);
                    $('[name="jumlah_obat"]').val(data.jumlah_obat);
                    $('[name="keterangan"]').val(data.keterangan);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit Pasien'); // Set title to Bootstrap modal title

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
        }
    
        function save(){
            var data = $("#form").serialize();

            var url;
            if(save_method == 'add'){
                url = "<?php echo base_url();?>dokter/pasien/pasien_add";
            }else{
                url = "<?php echo base_url();?>dokter/pasien/pasien_update";
            }

       // ajax adding data to database
            $.ajax({
                url : url,
                type: "POST",
                data: data,
                dataType: "JSON",
                success: function(data)
                {
                    if(data.status == "TRUE"){
                        $('#modal_form').modal('hide');
                        $('#pesan').empty();
                        $('#pesan').show();
                        $('#pesan').append("<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>SUCCESS <strong>"+data.pesan+"</strong>");
                        $('#pesan').fadeOut(3000);
                        location.reload();
                    }else{
                        $('.error_msg').show();
                        $('.error_msg').html(data.msg);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error adding / update data');
                }
            });
        }
    
        function delete_pasien(id){
            swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            
            function(){
                swal("Deleted!", "Your imaginary file has been deleted.", "success");
                $.ajax({
                    url : "<?php echo base_url();?>dokter/pasien/pasien_delete/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data){        
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });
            });
        }
    </script>


  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h5 class="modal-title">Data User</h5>
          </div>

          <form id="form" action="#" method="post" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
              <div class="error_msg alert alert-danger alert-dismissable" style="text-align: center">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <?php echo validation_errors(); ?>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                      <div class="row">
                          <div class="col-sm-9">
                              <label>ID RM</label>
                              <input name="id" placeholder="Id RM" class="form-control" type="text" disabled>
                          </div>
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="row">
                          <div class="col-sm-4">
                              <label>Nama Pasien</label>
                              <input name="nama" placeholder="Nama pasien" class="form-control" type="text" disabled>
                          </div>
                          <div class="col-sm-4">
                              <label>Jenis Kelamin</label>
                              <input name="Jk_pasien" placeholder="Jenis Kelamin" class="form-control" type="date" disabled>
                          </div>
                      </div>
                  </div>
                  
                  <div class="form-group">
                      <div class="row">
                          <div class="col-sm-4">
                              <label>Tempat Lahir</label>
                              <input name="tempat_lahir_pasien" placeholder="Tempat Lahir" class="form-control" type="text" disabled>
                          </div>
                          <div class="col-sm-4">
                              <label>Tanggal Lahir</label>
                              <input name="tanggal_lahir_pasien" placeholder="Tanggal Lahir" class="form-control" type="date" disabled>
                          </div>
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="row">
                          <div class="col-sm-4">
                              <label>Umur Pasien</label>
                              <input name="umur_pasien" placeholder="Umur Pasien" class="form-control" type="text" disabled>
                          </div>
                          <div class="col-sm-4">
                              <label>Golongan Darah</label>
                              <input name="goldar_pasien" placeholder="Golongan Darah" class="form-control" type="text" disabled>
                          </div>
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="row">
                          <div class="col-sm-4">
                              <label>Riwayat Alergi</label>
                              <input name="riwayat_alergi" placeholder="Riwayat Alergi" class="form-control" type="text" disabled>
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="row">
                          <div class="col-sm-4">
                              <label>SIP</label>
                              <input name="sip" placeholder="Riwayat Alergi" class="form-control" type="text" >
                          </div>
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="row">
                          <div class="col-sm-4">
                              <label>Keluhan</label>
                              <input name="keluhan" placeholder="Riwayat Alergi" class="form-control" type="text" >
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="row">
                          <div class="col-sm-4">
                              <label>Diagnosa</label>
                              <input name="diagnosa" placeholder="Riwayat Alergi" class="form-control" type="text" >
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="row">
                          <div class="col-sm-4">
                              <label>Saran dan Tindakan</label>
                              <input name="saran_tindakan" placeholder="Riwayat Alergi" class="form-control" type="text" >
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="row">
                          <div class="col-sm-4">
                              <label>Nama Obat</label>
                              <input name="nama_obat" placeholder="Riwayat Alergi" class="form-control" type="text" >
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="row">
                          <div class="col-sm-4">
                              <label>Jumlah Obat</label>
                              <input name="jumlah_obat" placeholder="Riwayat Alergi" class="form-control" type="text" >
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="row">
                          <div class="col-sm-4">
                              <label>Obat Yang Dibeli di Luar</label>
                              <input name="keterangan" placeholder="Riwayat Alergi" class="form-control" type="text" >
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
          </form>
      </div>
  </div>
</div><!-- /.modal -->
</body>
</html>
