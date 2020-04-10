<?php

//kelas_action.php
//file ini digunakan untuk seluruh aksi di kelas.php

include('../config/config.php');

session_start();

if (isset($_POST["action"])) {
	if ($_POST["action"] == "fetch") {
		$query = "
		SELECT * FROM kelas 
		";

		if (isset($_POST["search"]["value"])) {
			$query .= '
            WHERE nama_kelas LIKE "%' . $_POST["search"]["value"] . '%"
            OR kompetensi_keahlian LIKE "%' . $_POST["search"]["value"] . '%" 
			';
		}

		if (isset($_POST["order"])) {
			$query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
		} else {
			$query .= '
			ORDER BY kompetensi_keahlian ASC ';
		}
		if ($_POST["length"] != -1) {
			$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$data = array();
		$filtered_rows = $statement->rowCount();
		foreach ($result as $row) {
			$sub_array = array();
			$sub_array[] = $row["nama_kelas"];
			$sub_array[] = $row["kompetensi_keahlian"];
			$sub_array[] = '<button type="button" name="edit_grade" class="btn btn-primary btn-sm edit_grade" id="' . $row["id_kelas"] . '">Edit</button>';
			$sub_array[] = '<button type="button" name="delete_grade" class="btn btn-danger btn-sm delete_grade" id="' . $row["id_kelas"] . '">Delete</button>';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"		=> 	$filtered_rows,
			"recordsFiltered"	=>	get_total_records($connect, 'kelas'),
			"data"				=>	$data
		);

		echo json_encode($output);
	}

	if ($_POST["action"] == 'Add' || $_POST["action"] == "Edit") {
		$grade_name = '';
		$grade_major = '';
		$error_grade_name = '';
		$error_grade_major = '';
		$error = 0;
		if (empty($_POST["grade_name"])) {
			$error_grade_name = 'Nama Kelas diperlukan';
			$error++;
		} else {
			$grade_name = $_POST["grade_name"];
		}
		if (empty($_POST["grade_major"])) {
			$error_grade_major = 'Kompetensi diperlukan';
			$error++;
		} else {
			$grade_major = $_POST["grade_major"];
		}
		if ($error > 0) {
			$output = array(
				'error'							=>	true,
				'error_grade_name'              =>  $error_grade_name,
				'error_grade_major'				=>	$error_grade_major
			);
		} else {
			if ($_POST["action"] == "Add") {
				$data = array(
					':grade_name'				=>	$grade_name,
					':grade_major'				=>	$grade_major
				);
				$query = "
				INSERT INTO kelas 
				(nama_kelas, kompetensi_keahlian) 
				SELECT * FROM (SELECT :grade_name, :grade_major) as temp 
				WHERE NOT EXISTS (
					SELECT nama_kelas FROM kelas WHERE nama_kelas = :grade_name
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
							'error_grade_name'		=>	'Kelas Sudah Ada'
						);
					}
				}
			}
			if ($_POST["action"] == "Edit") {
				$data = array(
					':grade_name'				=>	$grade_name,
					':grade_major'				=>	$grade_major,
					':grade_id'				=>	$_POST["grade_id"]
				);
				$query = "UPDATE kelas SET nama_kelas = :grade_name, 
				kompetensi_keahlian = :grade_major 
				WHERE id_kelas = :grade_id
				";
				$statement = $connect->prepare($query);
				if ($statement->execute($data)) {
					$output = array(
						'success'		=>	'Data Edited Successfully',
					);
				}
			}
		}
		// hmm
		echo json_encode($output);
	}

	if ($_POST["action"] == "edit_fetch") {
		$query = "
		SELECT * FROM kelas WHERE id_kelas = '" . $_POST["grade_id"] . "'
		";
		$statement = $connect->prepare($query);
		if ($statement->execute()) {
			$result = $statement->fetchAll();
			foreach ($result as $row) {
				$output["grade_name"] = $row["nama_kelas"];
				$output["grade_major"] = $row["kompetensi_keahlian"];
				$output["grade_id"] = $row["id_kelas"];
			}
			echo json_encode($output);
		}
	}
	if ($_POST["action"] == "delete") {
		$query = "
		DELETE FROM kelas 
		WHERE id_kelas = '" . $_POST["grade_id"] . "'
		";
		$statement = $connect->prepare($query);
		if ($statement->execute()) {
			echo 'Data Delete Successfully';
		}
	}
}
