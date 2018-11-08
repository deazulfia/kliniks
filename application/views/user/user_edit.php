<?php echo form_open('user/edit/'.$user->id_user, array('id' => 'FormEditUser')); ?>

<div class='form-group'>
	<label>Username Login</label>
	<?php 
	echo form_input(array(
		'name' => 'username',
		'class' => 'form-control',
		'value' => $user->username
	));
	echo form_hidden('username_old', $user->username);
	echo form_hidden('label', $user->label);
	?>
</div>

<?php 
if($user->label == 'admin' OR $user->label == 'master') 
{ 
	echo form_hidden('password', '');
	echo form_hidden('id_akses', $user->id_akses);
	echo form_hidden('status', $user->status);
} 
?>

<?php if($user->label !== 'admin' OR $user->label == 'master') { ?>
<div class='form-group'>
	<label>Password Login</label>
	<input type='password' name='password' class='form-control'>
	<p class='help-block'>Harap diisi jika ingin reset password</p>
</div>
<?php } ?>

<?php if($user->label !== 'admin' OR $user->label == 'master') { ?>
<hr />
<?php } ?>

<div class='form-group'>
	<label>Nama Lengkap</label>
	<?php 
	echo form_input(array(
		'name' => 'nama',
		'class' => 'form-control',
		'value' => $user->nama
	));
	?>
</div>

<?php if($user->label !== 'admin' OR $user->label == 'master') { ?>
<div class='form-group'>
	<label>Akses</label>
	<select name='id_akses' class='form-control'>
	<?php
	foreach($akses->result() as $a)
	{
		$selected = '';
		if($a->id_akses == $user->id_akses){
			$selected = 'selected';
		}
		echo "<option value='".$a->id_akses."' ".$selected.">".$a->level_akses."</option>";
	}
	?>
	</select>
</div>
<div class='form-group'>
	<label>Status</label>
	<select name='status' class='form-control'>
		<option value="Aktif" <?php if($user->status == 'Aktif') { echo 'selected'; } ?>>Aktif</option>
		<option value="Non Aktif" <?php if($user->status == 'Non Aktif') { echo 'selected'; } ?>>Non Aktif</option>
	</select>
</div>
<?php } ?>

<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanEditUser'>Update Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$('#SimpanEditUser').click(function(){
		$.ajax({
			url: $('#FormEditUser').attr('action'),
			type: "POST",
			cache: false,
			data: $('#FormEditUser').serialize(),
			dataType:'json',
			success: function(json){
				if(json.status == 1){ 
					$('#ResponseInput').html(json.pesan);
					setTimeout(function(){ 
				   		$('#ResponseInput').html('');
				    }, 3000);
					$('#my-grid').DataTable().ajax.reload( null, false );
				}
				else {
					$('#ResponseInput').html(json.pesan);
				}
			}
		});
	});
});
</script>