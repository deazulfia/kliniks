<!DOCTYPE HTML>
<html>
<head>
 
  <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/css/datepicker3.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet">

<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.8.3.js"></script>
<script type="text/javascript" async="" src="<?php echo base_url();?>assets/js/script.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/plugin/bootstrap-filestyle-1.2.1/src/bootstrap-filestyle.js">"></script>
<script type="text/javascript">

  $(":file").filestyle('ButtoText', 'Pilih');  

</script>

</head>
<body>
<div class="container">
<form action="<?= site_url() ?>/terapi/uploadgambar/" class="form-horizontal" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<div class="col-md-8">
			<input type="hidden" name="noreg" value="<?= $item['noreg'] ?>">
			<input type="hidden" name="idpasien" value="<?= $item['idpasien'] ?>">
			<input type="file" class="filestyle" name="resep">
		</div>
		<div class="col-md-4">
			<button type="submit" class="btn btn-primary">Upload</button>
		</div>
	</div>
</form>

<?php if ($query): ?>

<img src="<?php echo base_url();?>assets/img/resep/<?php echo $query->resep; ?>" alt="" width="256" height="auto"/>
	
<?php endif ?>
</div>
</body>
</html>