<?php

//check_staff_login.php
//file ini digunkan untuk mengecek dari hasil form login

include('config.php');

//meng-ignite session
session_start();

$staff_username = '';
$staff_password = '';
$role = '';
$error_staff_username = '';
$error_staff_password = '';
$error_not_found = '';
$error = 0;

if(empty($_POST["staff_username"]))
{
	$error_staff_username = 'Username diperlukan';
	$error++;
}
else
{
	$staff_username = $_POST["staff_username"];
}

if(empty($_POST["staff_password"]))
{	
	$error_staff_password = 'Password dibutuhkan';
	$error++;
}
else
{
	$staff_password = $_POST["staff_password"];
}
//jika tidak ditemui error
if($error == 0)
{
	$query = "SELECT * FROM petugas WHERE username = '".$staff_username."'";

	$statement = $connect->prepare($query);
	if($statement->execute()){
		$total_row = $statement->rowCount();
		if($total_row > 0)
		{
			$result = $statement->fetchAll();
			foreach($result as $row)
			{
				if(password_verify($staff_password, $row["password"]))
				{
					$_SESSION["staff_id"] = $row["id_petugas"];
					$_SESSION["staff_role"] = $row["level"];
					$role = $row["level"];
				}
				else
				{
					$error_staff_password = "Password Salah";
					$error++;
				}
			}
		}
		else
		{
			$error_not_found = "Error not found";
			$error_staff_username = "Username tidak ditemukan/salah!";
			$error++;
		}
	}
}

if($error > 0)
{
	$output = array(
		'error'			=>	true,
		'error_staff_username'	=>	$error_staff_username,
		'error_staff_password'	=>	$error_staff_password,
		'error_not_found' => $error_not_found
	);
}
else
{
	$output = array(
		'success'		=>	true,
		'role' => $role
	);
}

echo json_encode($output);
