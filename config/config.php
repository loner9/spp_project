<?php
//set default timezone
date_default_timezone_set("ASIA/JAKARTA");

//konneksi ke database
// $con = new PDO("mysql:host=localhost;dbname=spp","root","");
$connect = new PDO("mysql:host=localhost;dbname=spp","root","");

function get_total_records($connect, $table_name)
{
	$query = "SELECT * FROM $table_name";
	$statement = $connect->prepare($query);
	$statement->execute();
	return $statement->rowCount();
}

function load_grade_list($connect)
{
	$query = "
	SELECT * FROM kelas ORDER BY nama_kelas ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["id_kelas"].'">'.$row["nama_kelas"].'</option>';
	}
	return $output;
}

function load_paym_list($connect)
{
	$query = "
	SELECT * FROM spp ORDER BY id_spp ASC
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["id_spp"].'">'.$row["tahun"].'</option>';
	}
	return $output;
}

function Get_student_name($connect, $student_id)
{
	$query = "
	SELECT nama FROM siswa 
	WHERE nisn = '".$student_id."'
	";

	$statement = $connect->prepare($query);

	$statement->execute();

	$result = $statement->fetchAll();

	foreach($result as $row)
	{
		return $row["nama"];
	}
}

function Get_student_grade_name($connect, $student_id)
{
	$query = "
	SELECT kelas.nama_kelas FROM siswa 
	INNER JOIN kelas 
	ON kelas.id_kelas = siswa.id_kelas 
	WHERE siswa.nisn = '".$student_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row['nama_kelas'];
	}
}

function Get_student_staff_name($connect, $student_id)
{
	$query = "
	SELECT * FROM pembayaran INNER JOIN petugas ON 
	petugas.id_petugas = pembayaran.id_petugas WHERE nisn = '".$student_id."' ";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row["username"];
	}
}

function Get_grade_name($connect, $id_kelas)
{
	$query = "
	SELECT nama_kelas FROM kelas 
	WHERE id_kelas = '".$id_kelas."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row["nama_kelas"];
	}
}

function Get_added_amount($connect, $student_id, $paym_id)
{
	$query = "
	SELECT SUM(jumlah_bayar) as dibayar FROM pembayaran 
	WHERE nisn = '".$student_id."' AND id_spp = '".$paym_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row["dibayar"];
	}
}

function Get_student_dependent($connect,$paym_id){
	$query = "
	SELECT nominal FROM spp 
	WHERE id_spp = '".$paym_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row["nominal"];
	}
}

function Get_student_dependent_year($connect,$paym_id){
	$query = "
	SELECT tahun FROM spp 
	WHERE id_spp = '".$paym_id."'
	";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		return $row["tahun"];
	}
}