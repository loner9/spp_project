<?php

//profile.php
//view dan aksi dalam setting

include('header.php');
//variable
$staff_name = '';
$staff_username = '';
$staff_password = '';
$error_staff_name = '';
$error_staff_username = '';
$error = 0;
$success = '';

if(isset($_POST["button_action"]))
{
	//prompt untuk mengisi field
	if(empty($_POST["staff_name"]))
	{
		$error_staff_name = "Nama Petugas Dibutuhkan";
		$error++;
	}
	else
	{
		$staff_name = $_POST["staff_name"];
    }
    if(empty($_POST["staff_username"]))
	{
		$error_staff_name = "Username Dibutuhkan";
		$error++;
	}
	else
	{
		$staff_username = $_POST["staff_username"];
	}
	if(!empty($_POST["staff_password"]))
	{
		$staff_password = $_POST["staff_password"];
	}
	//jika tidak ada error
	if($error == 0)
	{
		if($staff_password != '')
		{
			$data = array(
				':staff_name'			=>	$staff_name,
				':staff_username'		=>	$staff_username,
				':staff_password'		=>	password_hash($staff_password, PASSWORD_DEFAULT),
				':staff_id'			=>	$_SESSION["staff_id"]
			);
			$query = "
			UPDATE petugas 
		      SET nama_petugas = :staff_name, 
		      username = :staff_username, 
			  password = :staff_password
		      WHERE id_petugas = :staff_id
			";
		}
		else
		{
			$data = array(
				':staff_name'			=>	$staff_name,
				':staff_username'		=>	$staff_username,
				':staff_id'			=>	$_SESSION["staff_id"]
			);
			$query = "
			UPDATE petugas 
			SET nama_petugas = :staff_name, 
			username = :staff_username 
			WHERE id_petugas = :staff_id
			";
		}

		$statement = $connect->prepare($query);
		if($statement->execute($data))
		{
			$success = '<div class="alert alert-success">Detail Profile Berhasil Diupdate</div>';
		}
	}
}

//tampilkan data petugas
$query = "
SELECT * FROM petugas 
WHERE id_petugas = '".$_SESSION["staff_id"]."'
";

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

?>

<div class="container" style="margin-top:30px">
  <span><?php echo $success; ?></span>
  <div class="card">
    <form method="post" id="profile_form" enctype="multipart/form-data">
		<div class="card-header">
			<div class="row">
				<div class="col-md-9">Profile</div>
				<div class="col-md-3" align="right">
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="form-group">
				<div class="row">
					<label class="col-md-4 text-right">Nama Petugas <span class="text-danger">*</span></label>
					<div class="col-md-8">
						<input type="text" name="staff_name" id="staff_name" class="form-control" />
						<span class="text-danger"><?php echo $error_staff_name; ?></span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label class="col-md-4 text-right">Username <span class="text-danger">*</span></label>
					<div class="col-md-8">
						<input name="staff_username" id="staff_username" class="form-control"></input>
						<span class="text-danger"><?php echo $error_staff_username; ?></span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label class="col-md-4 text-right">Password <span class="text-danger">*</span></label>
					<div class="col-md-8">
						<input type="password" name="staff_password" id="staff_password" class="form-control" placeholder="Kosongkan untuk tidak mengganti" />
						<span class="text-danger"></span>
					</div>
				</div>
			</div>
			<!-- <div class="form-group">
				<div class="row">
					<label class="col-md-4 text-right">Kualifikasi <span class="text-danger">*</span></label>
					<div class="col-md-8">
						<input type="text" name="staff_qualification" id="staff_qualification" class="form-control" />
						<span class="text-danger"><?php echo $error_staff_qualification; ?></span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label class="col-md-4 text-right">Kelas <span class="text-danger">*</span></label>
					<div class="col-md-8">
						<select name="staff_grade_id" id="staff_grade_id" class="form-control">
                			<option value="">Pilih Kelas</option>
                			<?php
                			echo load_grade_list($connect);
                			?>
                		</select>
						<span class="text-danger"><?php echo $error_staff_grade_id; ?></span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label class="col-md-4 text-right">Tanggal bergabung <span class="text-danger">*</span></label>
					<div class="col-md-8">
						<input type="text" name="staff_doj" id="staff_doj" class="form-control" readonly />
						<span class="text-danger"><?php echo $error_staff_doj; ?></span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label class="col-md-4 text-right">Foto <span class="text-danger">*</span></label>
					<div class="col-md-8">
						<input type="file" name="staff_image" id="staff_image" />
						<span class="text-muted">Only .jpg and .png allowed</span><br />
						<span id="error_staff_image" class="text-danger"><?php echo $error_staff_image; ?></span>
					</div>
				</div>
			</div> -->
		</div>
		<!-- where the magic happen -->
		<div class="card-footer" align="center">
			<!-- <input type="hidden" name="hidden_staff_image" id="hidden_staff_image" />
			<input type="hidden" name="staff_id" id="staff_id" /> -->
			<input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Save" />
		</div>     
    </form>
  </div>
</div>
<br />
<br />
</body>
</html>

<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="css/datepicker.css" />

<style>
    .datepicker
    {
      z-index: 1600 !important; /* has to be larger than 1050 */
    }
</style>

<script>
$(document).ready(function(){
	
<?php
foreach($result as $row)
{
?>
$('#staff_name').val("<?php echo $row["nama_petugas"]; ?>");
$('#staff_username').val("<?php echo $row["username"]; ?>");
<?php
}
?>

});
</script>