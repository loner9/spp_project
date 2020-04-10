<?php

//check_stud_login.php
//file ini digunkan untuk mengecek dari hasil form login

include('config.php');

//meng-ignite session
session_start();

$stud_username = '';
$stud_unique = '';
$error_stud_username = '';
$error_stud_unique = '';
$error_not_found = '';
$error = 0;

if(empty($_POST["stud_username"]))
{
	$error_stud_username = 'Nama diperlukan';
	$error++;
}
else
{
	$stud_username = $_POST["stud_username"];
}

if(empty($_POST["stud_unique"]))
{	
	$error_stud_unique = 'Nis dibutuhkan';
	$error++;
}
else
{
	$stud_unique = $_POST["stud_unique"];
}
//jika tidak ditemui error
if($error == 0)
{
	$query = "SELECT * FROM siswa WHERE nama = '".$stud_username."'";

	$statement = $connect->prepare($query);
	if($statement->execute()){
		$total_row = $statement->rowCount();
		if($total_row > 0)
		{
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
				if($stud_unique == $row["nis"])
				{
					$_SESSION["stud_id"] = $row["nisn"];
					$_SESSION["paym_id"] = $row["id_spp"];
				}
				else
				{
					$error_stud_unique = "Nis Salah";
					$error++;
				}
			}
		}
		else
		{
			$error_not_found = "Error not found";
			$error_stud_username = "Nama tidak ditemukan/salah!";
			$error++;
		}
	}
}

if($error > 0)
{
	$output = array(
		'error'			=>	true,
		'error_stud_username'	=>	$error_stud_username,
		'error_stud_unique'	=>	$error_stud_unique,
		'error_not_found' => $error_not_found
	);
}
else
{
	$output = array(
		'success'		=>	true
	);
}

echo json_encode($output);