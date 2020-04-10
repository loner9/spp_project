<?php

//petugas_action.php
//file ini digunakan untuk seluruh aksi di kelas.php

include('../config/config.php');

session_start();

if (isset($_POST["action"])) {
	if ($_POST["action"] == "fetch") {
		$query = "SELECT * FROM petugas WHERE level = 'petugas'";

		// if (isset($_POST["search"]["value"])) {
		// 	$query .= '
        //     WHERE nama_petugas LIKE "%' . $_POST["search"]["value"] . '%"
        //     OR username LIKE "%' . $_POST["search"]["value"] . '%" 
		// 	';
		// }

		if(isset($_POST["order"]))
		{
			$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query .= 'ORDER BY username ASC ';
		}
		if($_POST["length"] != -1)
		{
			$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$search = "('^(?:(?!Admin).)*$\r?\n?', true, false)";
		$data = array();
		$filtered_rows = $statement->rowCount();
		foreach ($result as $row) {
			$sub_array = array();
            $sub_array[] = $row["username"];
			$sub_array[] = $row["nama_petugas"];
			$sub_array[] = '<button type="button" name="edit_staff" class="btn btn-primary btn-sm edit_staff" id="' . $row["id_petugas"] . '">Edit</button>';
			$sub_array[] = '<button type="button" name="delete_staff" class="btn btn-danger btn-sm delete_staff" id="' . $row["id_petugas"] . '">Delete</button>';
			$data[] = $sub_array;
		}
		// "search"				=> ('^(?:(?!Admin).)*$\r?\n?', true, false),
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	get_total_records($connect, 'petugas'),
			"data"				=>	$data
		);

		echo json_encode($output);
	}

	if ($_POST["action"] == 'Add' || $_POST["action"] == "Edit") {
		$staff_name = '';
        $staff_user = '';
        $staff_pass = '';
        $staff_level = 'petugas';
		$error_staff_name = '';
        $error_staff_user = '';
        $error_staff_pass = '';
		$error = 0;
		if (empty($_POST["staff_name"])) {
			$error_staff_name = 'Nama Petugas diperlukan';
			$error++;
		} else {
			$staff_name = $_POST["staff_name"];
		}
		if (empty($_POST["staff_user"])) {
			$error_staff_user = 'Nama User diperlukan';
			$error++;
		} else {
			$staff_user = $_POST["staff_user"];
        }
        if (empty($_POST["staff_pass"])) {
			$error_staff_pass = 'Password diperlukan';
			$error++;
		} else {
			$staff_pass = $_POST["staff_pass"];
		}
		if ($error > 0) {
			$output = array(
				'error'							=>	true,
				'error_staff_name'              =>  $error_staff_name,
                'error_staff_user'				=>	$error_staff_user,
                'error_staff_pass'				=>	$error_staff_pass
			);
		} else {
			if ($_POST["action"] == "Add") {
				$data = array(
					':staff_name'				=>	$staff_name,
                    ':staff_user'				=>	$staff_user,
                    ':staff_pass'				=>  password_hash($staff_pass, PASSWORD_DEFAULT),
                    ':staff_level'				=>	$staff_level
				);
				$query = "INSERT INTO petugas 
				(username,password,nama_petugas,level) 
				SELECT * FROM (SELECT :staff_user, :staff_pass ,:staff_name ,:staff_level) as temp 
				WHERE NOT EXISTS (
					SELECT username FROM petugas WHERE username = :staff_user
				) LIMIT 1
				";
				$statement = $connect->prepare($query);
				if ($statement->execute($data)) {
					if ($statement->rowCount() > 0) {
						$output = array(
							'success'		=>	'Data Berhasil ditambahkan',
						);
					} else {
						$output = array(
							'error'					=>	true,
							'error_staff_user'		=>	'Username Sudah Digunakan'
						);
					}
				}
			}
			if ($_POST["action"] == "Edit") {
				$data = array(
					':staff_name'				=>	$staff_name,
                    ':staff_user'				=>	$staff_user,
                    ':staff_pass'				=>  password_hash($staff_pass, PASSWORD_DEFAULT),
					':staff_id'				=>	$_POST["staff_id"]
				);
				$query = "UPDATE petugas SET nama_petugas = :staff_name, 
				username = :staff_user, password = :staff_pass 
				WHERE id_petugas = :staff_id
				";
				$statement = $connect->prepare($query);
				if ($statement->execute($data)) {
					$output = array(
						'success'		=>	'Data Edited Successfully',
					);
				}
			}
		}
		// jika error, periksa query
		echo json_encode($output);
	}

	if ($_POST["action"] == "edit_fetch") {
		$query = "
		SELECT * FROM petugas WHERE id_petugas = '" . $_POST["staff_id"] . "'
		";
		$statement = $connect->prepare($query);
		if ($statement->execute()) {
			$result = $statement->fetchAll();
			foreach ($result as $row) {
                $output["staff_name"] = $row["nama_petugas"];
                $output["staff_user"] = $row["username"];
				$output["staff_pass"] = '';
				$output["staff_id"] = $row["id_petugas"];
			}
			echo json_encode($output);
		}
	}
	if ($_POST["action"] == "delete") {
		$query = "
		DELETE FROM petugas 
		WHERE id_petugas = '" . $_POST["staff_id"] . "'
		";
		$statement = $connect->prepare($query);
		if ($statement->execute()) {
			echo 'Data Delete Successfully';
		}
	}
}
